<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Pages\CreateOperationCost;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CreateOperationCostTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('operation-cost.create'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_create_operation_cost_page(): void
    {
        $this->authenticateAs();

        $response = $this->get(route('operation-cost.create'));
        $response->assertOk();
    }

    public function test_can_create_operation_cost_with_valid_data(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateOperationCost::class)
            ->set('form.cost_name', 'Electricity Bill')
            ->set('form.cost_description', 'Monthly electricity')
            ->set('form.cost_nominal', '1500000')
            ->call('store')
            ->assertDispatched('create-operation-cost');

        $this->assertDatabaseHas('operation_costs', [
            'cost_name' => 'Electricity Bill',
            'cost_nominal' => 1500000,
        ]);
    }

    public function test_validation_rules_are_enforced(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateOperationCost::class)
            ->set('form.cost_name', '')
            ->set('form.cost_description', '')
            ->set('form.cost_nominal', '')
            ->call('store')
            ->assertHasErrors([
                'form.cost_name',
                'form.cost_description',
                'form.cost_nominal',
            ]);
    }
}
