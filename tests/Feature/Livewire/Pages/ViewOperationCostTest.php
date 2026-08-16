<?php

namespace Tests\Feature\Livewire\Pages;

use App\Models\OperationCost;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ViewOperationCostTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $cost = OperationCost::factory()->create();

        $response = $this->get(route('operation-cost.view', $cost));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_operation_cost_details(): void
    {
        $this->authenticateAs();
        $cost = OperationCost::factory()->create([
            'cost_name' => 'Test Cost',
        ]);

        $response = $this->get(route('operation-cost.view', $cost));
        $response->assertOk();
    }
}
