<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\Category;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CategoryTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.category'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_category_list(): void
    {
        $this->authenticateAs();
        ProductCategory::factory()->count(3)->create();

        Livewire::test(Category::class)
            ->assertViewHas('categories');
    }
}
