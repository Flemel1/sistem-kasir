<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\EditGroup;
use App\Models\AdditionalProduct;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class EditGroupTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $group = AdditionalProduct::factory()->create();

        $response = $this->get(route('master-data.group-product.edit', $group));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_edit_group_page(): void
    {
        $this->authenticateAs();
        $group = AdditionalProduct::factory()->create();

        $response = $this->get(route('master-data.group-product.edit', $group));
        $response->assertOk();
    }

    public function test_can_update_group(): void
    {
        $this->authenticateAs();
        $group = AdditionalProduct::factory()->create([
            'group_name' => 'Old Group',
            'items' => [['item_name' => 'Item A', 'item_price' => 2000]],
        ]);

        Livewire::test(EditGroup::class, ['group' => $group])
            ->set('form.group_name', 'Updated Group')
            ->call('update')
            ->assertDispatched('update-group-product');

        $this->assertDatabaseHas('additional_products', [
            'id' => $group->id,
            'group_name' => 'Updated Group',
        ]);
    }
}
