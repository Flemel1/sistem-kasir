<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Dashboard;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shift;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class DashboardTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_dashboard(): void
    {
        $this->authenticateAs();

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_dashboard_shows_revenue_data(): void
    {
        $this->authenticateAs();

        ProductCategory::factory()->create();
        $product = Product::factory()->create();
        $order = Order::factory()->create([
            'total_payment' => 100000,
            'cash_money' => 100000,
            'change_money' => 0,
        ]);
        OrderDetail::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'amount' => 2,
        ]);

        Livewire::test(Dashboard::class)
            ->assertSet('timeFrame', 'weekly')
            ->assertSee('100.000');
    }

    public function test_dashboard_loads_shifts(): void
    {
        $this->authenticateAs();

        Shift::factory()->create([
            'employee_name' => 'Test Employee',
            'shift' => ['Senin 08:00-16:00'],
        ]);

        Livewire::test(Dashboard::class)
            ->assertSee('Test Employee');
    }

    public function test_timeframe_switch_dispatches_event(): void
    {
        $this->authenticateAs();

        $component = Livewire::test(Dashboard::class);
        $component->set('timeFrame', 'monthly');

        $component->dispatch('get-revenue-by-timeframe')
            ->assertDispatched('get-revenue-by-timeframe-db');
    }
}
