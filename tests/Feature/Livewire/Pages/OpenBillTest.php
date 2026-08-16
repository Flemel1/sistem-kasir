<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Pages\OpenBill;
use App\Models\OpenOrder;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class OpenBillTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('open-bill'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_open_bills(): void
    {
        $this->authenticateAs();
        OpenOrder::create([
            'customer_name' => 'Open Bill',
            'ordered_items' => [['product_name' => 'Test', 'amount' => 1, 'price' => 10000]],
            'grand_total' => 10000,
            'doned_at' => null,
        ]);

        Livewire::test(OpenBill::class)
            ->assertViewHas('orders');
    }

    public function test_only_shows_unfinished_open_bills(): void
    {
        $this->authenticateAs();

        OpenOrder::create([
            'customer_name' => 'Active',
            'ordered_items' => [['product_name' => 'A', 'amount' => 1, 'price' => 10000]],
            'grand_total' => 10000,
            'doned_at' => null,
        ]);

        OpenOrder::create([
            'customer_name' => 'Done',
            'ordered_items' => [['product_name' => 'B', 'amount' => 1, 'price' => 10000]],
            'grand_total' => 10000,
            'doned_at' => now(),
        ]);

        $component = Livewire::test(OpenBill::class);
        $orders = $component->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('Active', $orders->first()->customer_name);
    }
}
