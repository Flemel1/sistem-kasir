<?php

namespace Tests\Feature\Livewire\Pages;

use App\Livewire\Pages\PurchaseReport;
use App\Models\Purchase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class PurchaseReportTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('purchase'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_purchase_list(): void
    {
        $this->authenticateAs();
        Purchase::factory()->count(3)->create();

        Livewire::test(PurchaseReport::class)
            ->assertViewHas('purchases');
    }
}
