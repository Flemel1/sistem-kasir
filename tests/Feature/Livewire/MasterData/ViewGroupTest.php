<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\ViewGroup;
use App\Models\AdditionalProduct;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ViewGroupTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $group = AdditionalProduct::factory()->create();

        $response = $this->get(route('master-data.group-product.view', $group));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_group_details(): void
    {
        $this->authenticateAs();
        $group = AdditionalProduct::factory()->create(['group_name' => 'Test Group']);

        $response = $this->get(route('master-data.group-product.view', $group));
        $response->assertOk();
    }

    public function test_can_delete_group(): void
    {
        $this->authenticateAs();
        $group = AdditionalProduct::factory()->create();

        Livewire::test(ViewGroup::class, ['group' => $group])
            ->call('delete')
            ->assertDispatched('delete-group-product');

        $this->assertSoftDeleted('additional_products', ['id' => $group->id]);
    }
}
