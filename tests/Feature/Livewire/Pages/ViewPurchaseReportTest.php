<?php

namespace Tests\Feature\Livewire\Pages;

use App\Models\Purchase;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ViewPurchaseReportTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $purchase = Purchase::factory()->create();

        $response = $this->get(route('purchase.view', $purchase));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_purchase_details(): void
    {
        $this->authenticateAs();
        $purchase = Purchase::factory()->create([
            'purchase_item_name' => 'Test Purchase',
        ]);

        $response = $this->get(route('purchase.view', $purchase));
        $response->assertOk();
    }
}
