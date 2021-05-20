<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;

class LabelControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    /**
     * Test of labels index.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    /**
     * Test of labels create.
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.create'));
        $response->assertOk();
    }

    /**
     * Test of labels store.
     *
     * @return void
     */
    public function testStore()
    {
        $data = Label::factory()
            ->make()
            ->only(['name', 'description']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store', $data));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $data);
    }

    /**
     * Test of labels edit.
     *
     * @return void
     */
    public function testEdit()
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', ['label' => $label]));
        $response->assertOk();
    }

    /**
     * Test of labels update.
     *
     * @return void
     */
    public function testUpdate()
    {
        $label = Label::factory()->create();
        $data = Label::factory()->make()
            ->only(['name', 'description']);

        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', ['label' => $label]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $data);
    }

    /**
     * Test of labels delete.
     *
     * @return void
     */
    public function testDelete()
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', ['label' => $label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }
}
