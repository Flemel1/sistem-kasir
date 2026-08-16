<?php

namespace Tests\Feature\Livewire\Components;

use App\Livewire\Components\ModalCreateOrder;
use App\Models\OpenOrder;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ModalCreateOrderTest extends TestCase
{
    use AuthenticateAs;

    public function test_can_open_modal(): void
    {
        $this->authenticateAs();

        Livewire::test(ModalCreateOrder::class)
            ->assertOk();
    }

    public function test_submit_dispatches_create_order_event(): void
    {
        $this->authenticateAs();

        Livewire::test(ModalCreateOrder::class)
            ->set('form.customer_name', 'Test')
            ->set('form.cash_money', '50000')
            ->set('form.status_order', 'closed')
            ->call('save')
            ->assertDispatched('create-order');
    }

    public function test_validation_rules_are_enforced(): void
    {
        $this->authenticateAs();

        Livewire::test(ModalCreateOrder::class)
            ->set('form.customer_name', '')
            ->set('form.cash_money', '')
            ->call('save')
            ->assertHasErrors([
                'form.customer_name',
                'form.cash_money',
            ]);
    }

    public function test_can_close_modal(): void
    {
        $this->authenticateAs();

        Livewire::test(ModalCreateOrder::class)
            ->call('close')
            ->assertDispatched('close-create-order-modal');
    }

    public function test_can_prefill_from_open_bill(): void
    {
        $this->authenticateAs();

        $openOrder = OpenOrder::create([
            'customer_name' => 'Existing Customer',
            'ordered_items' => [['product_name' => 'Coffee', 'amount' => 1, 'price' => 25000]],
            'grand_total' => 25000,
            'doned_at' => null,
        ]);

        $response = $this->get(route('order.create', ['open_bill_id' => $openOrder->id]));
        $response->assertOk();
    }
}
