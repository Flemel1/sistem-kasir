<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Pages\EditPurchaseReport;
use App\Models\Purchase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class EditPurchaseReportTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $purchase = Purchase::factory()->create();

        $response = $this->get(route('purchase.edit', $purchase));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_edit_purchase_page(): void
    {
        $this->authenticateAs();
        $purchase = Purchase::factory()->create();

        $response = $this->get(route('purchase.edit', $purchase));
        $response->assertOk();
    }

    public function test_can_update_purchase(): void
    {
        $this->authenticateAs();
        $purchase = Purchase::factory()->create([
            'purchase_item_name' => 'Old Item',
        ]);

        Livewire::test(EditPurchaseReport::class, ['purchase' => $purchase])
            ->set('form.purchase_item_name', 'Updated Item')
            ->set('form.purchase_amount', '10')
            ->set('form.purchase_money', '500000')
            ->call('update')
            ->assertRedirect(route('purchase.view', $purchase));

        $this->assertDatabaseHas('purchases', [
            'id' => $purchase->id,
            'purchase_item_name' => 'Updated Item',
        ]);
    }
}
