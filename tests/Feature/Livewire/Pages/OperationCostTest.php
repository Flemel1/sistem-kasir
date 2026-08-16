<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Pages\OperationCost;
use App\Models\OperationCost as OperationCostModel;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class OperationCostTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('operation-cost'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_operation_cost_list(): void
    {
        $this->authenticateAs();
        OperationCostModel::factory()->count(3)->create();

        Livewire::test(OperationCost::class)
            ->assertViewHas('costs');
    }
}
