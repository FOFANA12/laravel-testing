<?php

namespace Tests\Unit;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_create_todo()
    {
        // Create a todo
        $todo = Todo::factory([
            'title' => 'Test Todo Title',
            'description' => 'Test Todo Description',
            'completed' => false
        ])
        ->create();

        $data = [
            'title' => 'Test Todo Title',
            'description' => 'Test Todo Description',
            'completed' => false,
        ];

        // Assert
        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertEquals($data['title'], $todo->title);
        $this->assertEquals($data['description'], $todo->description);
        $this->assertEquals($data['completed'], $todo->completed);

    }

    public function test_can_update_todo()
    {
        // Create a todo
        $todo = Todo::factory()->create();

        $data = [
            'title' => 'Updated Test Todo Title',
            'description' => 'Updated Test Todo Description',
            'completed' => true,
        ];

        // Update todo
        $updatedTodo = $todo->fill($data);
        $updatedTodo->save();

        // Assert
        $this->assertEquals($data['title'], $updatedTodo->title);
        $this->assertEquals($data['description'], $updatedTodo->description);
        $this->assertEquals($data['completed'], $updatedTodo->completed);
    }

    public function test_can_delete_todo()
    {
        // Create a todo
        $todo = Todo::factory()->create();

        // Delete todo
        $todo->delete();

        // Assert
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}
