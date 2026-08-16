<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Pages\EditOperationCost;
use App\Models\OperationCost;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class EditOperationCostTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $cost = OperationCost::factory()->create();

        $response = $this->get(route('operation-cost.edit', $cost));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_edit_page(): void
    {
        $this->authenticateAs();
        $cost = OperationCost::factory()->create();

        $response = $this->get(route('operation-cost.edit', $cost));
        $response->assertOk();
    }

    public function test_can_update_operation_cost(): void
    {
        $this->authenticateAs();
        $cost = OperationCost::factory()->create([
            'cost_name' => 'Old Cost',
        ]);

        Livewire::test(EditOperationCost::class, ['cost' => $cost])
            ->set('form.cost_name', 'Updated Cost')
            ->set('form.cost_description', $cost->cost_description)
            ->set('form.cost_nominal', (string) $cost->cost_nominal)
            ->call('update')
            ->assertDispatched('edit-operation-cost');

        $this->assertDatabaseHas('operation_costs', [
            'id' => $cost->id,
            'cost_name' => 'Updated Cost',
        ]);
    }
}
