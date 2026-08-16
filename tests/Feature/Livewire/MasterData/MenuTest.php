<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\Menu;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class MenuTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.menu'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_menu_list(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        Livewire::test(Menu::class)
            ->assertViewHas('products');
    }

    public function test_lists_products_paginated(): void
    {
        $this->authenticateAs();
        $category = ProductCategory::factory()->create();
        Product::factory()->count(15)->create(['category_id' => $category->id]);

        $component = Livewire::test(Menu::class);
        $this->assertCount(10, $component->viewData('products'));
    }
}
