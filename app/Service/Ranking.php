<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class Ranking
{
    protected $key = 'ranking:users';

    public function updateScore(int $userId, float $score): void
    {
        Redis::zAdd($this->key, $score, $userId);
    }

    public function incrementScore(int $userId, float $value): void
    {
        Redis::zIncrBy($this->key, $value, $userId);
    }

    public function decrementScore(int $userId, float $decrement): void
    {
        Redis::zIncrBy($this->key, -$decrement, $userId);
    }

    public function getTopUsers(int $count = 5): Collection
    {
        $results = Redis::zRevRange($this->key, 0, $count - 1, ['withscores' => true]);
        
        $userIds = array_keys($results);
        if (empty($userIds)) {
            return collect([]);
        }

        $users = User::whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        return collect($results)->map(function ($score, $userId) use ($users) {
            $user = $users->get((int)$userId);
            
            if ($user) {
                $user->setAttribute('score', (float)$score);
            }

            return $user;
        })->filter()->values();
    }

    public function getUserRank(int $userId): ?int
    {
        $rank = Redis::zRevRank($this->key, $userId);
        return $rank !== null ? $rank + 1 : null;
    }

    public function getUserScore(int $userId): ?float
    {
        $score = Redis::zScore($this->key, $userId);
        return (float)$score ?: null;
    }
    
    public function removeUser(int $userId): void
    {
        Redis::zRem($this->key, $userId);
    }
}
