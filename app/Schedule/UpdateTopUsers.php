<?php

namespace App\Schedule;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UpdateTopUsers
{
    public function __invoke()
    {
        $users = User::getTopUsers();
        Cache::put('top_users', $users, now()->addMinutes(10));
    }
}
