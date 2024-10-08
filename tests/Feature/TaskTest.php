<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $taskData = [
            'user_id' => $user->id,
            'title' => 'New test task',
            'description' => 'Description of new test task',
            'due_date' => now()->addDays(7)->toDateTimeString(),
            'priority' => 3
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/task/task_store', $taskData);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Task has been created']);

        $this->assertDatabaseHas('tasks', [
            'user_id' => $taskData['user_id'],
            'title' => 'New Test Task',
            'description' => 'Description of new test task',
            'due_date' => $taskData['due_date'],
            'priority' => 3,
        ]);
    }

    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $taskUpdate = [
            'title' => 'Update task title',
            'description' => 'Description of update task title',
            'due_date' => now()->addDays(5)->toDateTimeString(),
            'priority' => 2,
        ];

        $response = $this->actingAs($user, 'api')->putJson("/api/task/task_update/{$task->id}", $taskUpdate);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task updated successfully']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Update task title',
            'priority' => 2,
        ]);
    }

    public function test_user_can_show_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $taskData = $task->toArray();
        $taskData['due_date'] = $task->due_date->format('Y-m-d H:i:s');

        $response = $this->actingAs($user, 'api')->getJson("/api/task/task_show/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(
                $taskData,
            );
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->deleteJson("/api/task/task_destroy/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);

            $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }
}
