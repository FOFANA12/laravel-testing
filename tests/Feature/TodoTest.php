<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_can_get_todos()
    {

        // Create a todo
        Todo::factory(10)->create();

        // Api call
        $response = $this->get('/api/todos');

         $response->assertStatus(200);
         $response->assertJsonCount(10, 'todos');
    }

    public function test_can_create_todo()
    {
        // Todo data
        $data = [
            'title' => 'Test Todo Title',
            'description' => 'Test Todo Description',
            'completed' => false,
        ];

        // Api call
        $response = $this->post('/api/todos', $data);
        $createdTodo = $response->json('todo');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'todo' => ['id', 'title', 'description', 'completed', 'created_at', 'updated_at'],
        ]);
        $this->assertDatabaseHas('todos', $data);
        $this->assertEquals($data['title'], $createdTodo['title']);
        $this->assertEquals($data['description'], $createdTodo['description']);
        $this->assertEquals($data['completed'], $createdTodo['completed']);
    }

    public function test_can_show_todo()
    {

        // Create a todo
        $todo = Todo::factory()->create();

        // Api call
        $response = $this->get("/api/todos/{$todo->id}");

         $response->assertStatus(200);
         $response->assertJsonStructure([
            'todo' => ['id', 'title', 'description', 'completed', 'created_at', 'updated_at'],
        ]);
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

        // Api call
        $response = $this->put('/api/todos/' . $todo->id, $data);
        $createdTodo = $response->json('todo');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
             'todo' => ['id', 'title', 'description', 'completed', 'created_at', 'updated_at'],
        ]);
        $this->assertDatabaseHas('todos', $data);
        $this->assertEquals($data['title'], $createdTodo['title']);
        $this->assertEquals($data['description'], $createdTodo['description']);
        $this->assertEquals($data['completed'], $createdTodo['completed']);
    }

    public function test_can_delete_todo()
    {

        // Create a todo
        $todo = Todo::factory()->create();

        // Api call
        $response = $this->delete('/api/todos/' . $todo->id);

         $response->assertStatus(200);
         $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}
