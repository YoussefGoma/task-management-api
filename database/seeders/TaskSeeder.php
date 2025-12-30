<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users if they don't exist
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        // Create various tasks for each user
        foreach ($users as $user) {
            // Create 5 pending tasks
            Task::factory()
                ->count(5)
                ->pending()
                ->forUser($user)
                ->create();

            // Create 4 in-progress tasks
            Task::factory()
                ->count(4)
                ->inProgress()
                ->forUser($user)
                ->create();

            // Create 2 completed tasks
            Task::factory()
                ->count(2)
                ->completed()
                ->forUser($user)
                ->create();

            // Create 5 overdue tasks
            Task::factory()
                ->count(5)
                ->overdue()
                ->forUser($user)
                ->create();

            // Create 3 high priority tasks
            Task::factory()
                ->count(3)
                ->highPriority()
                ->forUser($user)
                ->create();

            // Create 2 low priority tasks
            Task::factory()
                ->count(2)
                ->lowPriority()
                ->forUser($user)
                ->create();
        }

        $this->command->info('Tasks seeded successfully!');
    }
}
