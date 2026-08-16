<?php

namespace Tests\Feature\Livewire\Pages;

use App\Enums\StatusOrder;
use App\Livewire\Pages\Order;
use App\Models\Order as OrderModel;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class OrderTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('order'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_orders_list(): void
    {
        $this->authenticateAs();
        OrderModel::factory()->count(3)->create([
            'status_order' => StatusOrder::CLOSED,
        ]);

        Livewire::test(Order::class)
            ->assertViewHas('orders');
    }

    public function test_lists_orders_paginated(): void
    {
        $this->authenticateAs();
        OrderModel::factory()->count(15)->create([
            'status_order' => StatusOrder::CLOSED,
        ]);

        $component = Livewire::test(Order::class);
        $this->assertCount(10, $component->viewData('orders'));
    }
}
