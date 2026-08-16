<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\CreateCategory;
use App\Models\ProductCategory;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CreateCategoryTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.category.create'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_create_category_page(): void
    {
        $this->authenticateAs();

        $response = $this->get(route('master-data.category.create'));
        $response->assertOk();
    }

    public function test_can_create_category_with_valid_data(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateCategory::class)
            ->set('form.category_name', 'Minuman')
            ->call('store')
            ->assertRedirect(route('master-data.category'));

        $this->assertDatabaseHas('product_categories', [
            'category_name' => 'Minuman',
        ]);
    }

    public function test_cannot_create_duplicate_category(): void
    {
        $this->authenticateAs();
        ProductCategory::factory()->create(['category_name' => 'Minuman']);

        Livewire::test(CreateCategory::class)
            ->set('form.category_name', 'Minuman')
            ->call('store')
            ->assertHasErrors(['form.category_name']);
    }

    public function test_validation_rules_are_enforced(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateCategory::class)
            ->set('form.category_name', '')
            ->call('store')
            ->assertHasErrors(['form.category_name']);
    }
}
