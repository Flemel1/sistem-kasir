<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\CreateGroup;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CreateGroupTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.group-product.create'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_create_group_page(): void
    {
        $this->authenticateAs();

        $response = $this->get(route('master-data.group-product.create'));
        $response->assertOk();
    }

    public function test_can_create_group_with_valid_data(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateGroup::class)
            ->set('form.group_name', 'Topping')
            ->set('form.items', [
                ['item_name' => 'Caramel', 'item_price' => '3000'],
            ])
            ->set('form.is_multiple', true)
            ->set('form.is_optional', true)
            ->call('store')
            ->assertDispatched('create-group-product');

        $this->assertDatabaseHas('additional_products', [
            'group_name' => 'Topping',
        ]);
    }

    public function test_can_add_item_to_group(): void
    {
        $this->authenticateAs();

        $component = Livewire::test(CreateGroup::class);
        $component->call('add_item');
        $this->assertCount(2, $component->get('form.items'));
    }

    public function test_can_remove_item_from_group(): void
    {
        $this->authenticateAs();

        $component = Livewire::test(CreateGroup::class);
        $component->call('add_item');
        $component->call('delete_item');
        $this->assertCount(1, $component->get('form.items'));
    }

    public function test_validation_rules_are_enforced(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateGroup::class)
            ->set('form.group_name', '')
            ->set('form.items', [])
            ->call('store')
            ->assertHasErrors([
                'form.group_name',
                'form.items',
            ]);
    }
}
