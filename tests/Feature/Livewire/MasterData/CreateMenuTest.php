<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\CreateMenu;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CreateMenuTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.menu.create'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_create_menu_page(): void
    {
        $this->authenticateAs();
        ProductCategory::factory()->create(['category_name' => 'Kopi']);

        $response = $this->get(route('master-data.menu.create'));
        $response->assertOk();
    }

    public function test_can_create_product_with_valid_data(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();

        Livewire::test(CreateMenu::class)
            ->set('form.product_name', 'Espresso')
            ->set('form.product_description', 'Strong coffee')
            ->set('form.product_price', '18000')
            ->set('form.product_takeaway_price', '20000')
            ->set('form.category_id', (string) $category->id)
            ->call('save')
            ->assertDispatched('create-product');

        $this->assertDatabaseHas('products', [
            'product_name' => 'Espresso',
            'product_price' => 18000,
            'category_id' => $category->id,
        ]);
    }

    public function test_validation_rules_are_enforced(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateMenu::class)
            ->set('form.product_name', '')
            ->set('form.product_description', '')
            ->set('form.product_price', '')
            ->set('form.product_takeaway_price', '')
            ->set('form.category_id', '')
            ->call('save')
            ->assertHasErrors([
                'form.product_name',
                'form.product_description',
                'form.product_price',
                'form.product_takeaway_price',
                'form.category_id',
            ]);
    }
}
