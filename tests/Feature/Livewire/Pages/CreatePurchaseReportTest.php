<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Pages\CreatePurchaseReport;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CreatePurchaseReportTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('purchase.create'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_create_purchase_page(): void
    {
        $this->authenticateAs();

        $response = $this->get(route('purchase.create'));
        $response->assertOk();
    }

    public function test_can_create_purchase_with_valid_data(): void
    {
        $this->authenticateAs();

        Livewire::test(CreatePurchaseReport::class)
            ->set('form.purchase_item_name', 'Coffee Beans 1kg')
            ->set('form.purchase_amount', '5')
            ->set('form.purchase_money', '250000')
            ->call('store')
            ->assertDispatched('create-purchase');

        $this->assertDatabaseHas('purchases', [
            'purchase_item_name' => 'Coffee Beans 1kg',
            'purchase_amount' => 5,
            'purchase_money' => 250000,
        ]);
    }

    public function test_validation_rules_are_enforced(): void
    {
        $this->authenticateAs();

        Livewire::test(CreatePurchaseReport::class)
            ->set('form.purchase_item_name', '')
            ->set('form.purchase_amount', '')
            ->set('form.purchase_money', '')
            ->call('store')
            ->assertHasErrors([
                'form.purchase_item_name',
                'form.purchase_amount',
                'form.purchase_money',
            ]);
    }
}
