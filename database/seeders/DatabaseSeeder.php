<?php

namespace Database\Seeders;

use App\Models\User;
use App\Service\Ranking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(55)->create();

        User::factory()->create([
            'name' => 'Test User1',
            'email' => 'test@test.com',
        ]);

        User::factory()->create([
            'name' => 'Test User2',
            'email' => 'test@test2.com',
        ]);

        User::factory()->create([
            'name' => 'Test User3',
            'email' => 'test@test3.com',
        ]);

        $users = User::all();
        $rank = new Ranking();
        foreach ($users as $user) {
            $rank->updateScore($user->id, fake()->numberBetween(0, 100));
        }
    }
}
