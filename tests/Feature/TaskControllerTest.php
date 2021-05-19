<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Label;
use App\Models\TaskStatus;

class TaskControllerTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        TaskStatus::factory()->create();
    }
    /**
     * Test of tasks index.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    /**
     * Test of tasks show.
     *
     * @return void
     */
    public function testShow()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', ['task' => $task]));
        $response->assertOk();
    }

    /**
     * Test of tasks create.
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    /**
     * Test of tasks store.
     *
     * @return void
     */
    public function testStore()
    {
        $task = Task::factory()
            ->make()
            ->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $label = Label::factory()->create();

        $data = array_merge($task, ['labels' => [$label->id]]);

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', array_merge($task, ['created_by_id' => $this->user->id]));
    }

    /**
     * Test of tasks edit.
     *
     * @return void
     */
    public function testEdit()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('tasks.edit', ['task' => $task]));
        $response->assertOk();
    }

    /**
     * Test of tasks update.
     *
     * @return void
     */
    public function testUpdate()
    {
        $oldTask = Task::factory()->create();
        $label = Label::factory()->create();
        $newTask = Task::factory()
            ->make()
            ->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $data = array_merge($newTask, ['labels' => [$label->id]]);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', ['task' => $oldTask]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $newTask);
        $this->assertDatabaseHas('label_task', ['label_id' => $label->id, 'task_id' => $oldTask->id]);
    }

    /**
     * Test of tasks delete.
     *
     * @return void
     */
    public function testDelete()
    {
        $task = Task::factory()->create();
        $user = $task->creator;

        $response = $this->actingAs($user)
            ->delete(route('tasks.destroy', ['task' => $task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
