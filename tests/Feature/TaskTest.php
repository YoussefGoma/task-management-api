<?php

namespace Tests\Feature;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test filtering tasks by status.
     */
    public function test_user_can_filter_tasks_by_status(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create 3 tasks with different statuses
        Task::factory()->forUser($user)->create(['status' => TaskStatus::PENDING]);
        Task::factory()->forUser($user)->create(['status' => TaskStatus::PENDING]);
        Task::factory()->forUser($user)->create(['status' => TaskStatus::COMPLETED]);

        // Filter by pending
        $response = $this->getJson('/api/tasks?status=pending');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
            
        // Filter by completed
        $response = $this->getJson('/api/tasks?status=completed');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    /**
     * Test creating a task with valid data.
     */
    public function test_user_can_create_task_with_valid_data(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $taskData = [
            'name' => 'New Test Task',
            'description' => 'Test Description',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'New Test Task')
            ->assertJsonPath('data.status', 'Pending')
            ->assertJsonPath('data.priority', 'High');

        $this->assertDatabaseHas('tasks', [
            'name' => 'New Test Task',
            'user_id' => $user->id,
        ]);
    }
}
