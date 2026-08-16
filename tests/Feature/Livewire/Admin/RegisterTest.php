<?php

namespace Tests\Feature\Livewire\Admin;

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Admin\Register;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_can_view_register_page(): void
    {
        $response = $this->get(route('auth.register'));
        $response->assertOk();
    }

    public function test_authenticated_user_is_redirected_from_register_page(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.register'));
        $response->assertRedirect(route('dashboard'));
    }

    public function test_can_register_with_valid_data(): void
    {
        Livewire::test(Register::class)
            ->set('form.name', 'New User')
            ->set('form.username', 'newuser')
            ->set('form.email', 'newuser@example.com')
            ->set('form.password', 'password123')
            ->call('register')
            ->assertRedirect(route('auth.login'));

        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'name' => 'New User',
        ]);
    }

    public function test_cannot_register_with_duplicate_username(): void
    {
        User::factory()->create(['username' => 'existing']);

        Livewire::test(Register::class)
            ->set('form.name', 'Another User')
            ->set('form.username', 'existing')
            ->set('form.email', 'another@example.com')
            ->set('form.password', 'password123')
            ->call('register')
            ->assertHasErrors(['form.username']);
    }

    public function test_cannot_register_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        Livewire::test(Register::class)
            ->set('form.name', 'Another User')
            ->set('form.username', 'another')
            ->set('form.email', 'taken@example.com')
            ->set('form.password', 'password123')
            ->call('register')
            ->assertHasErrors(['form.email']);
    }

    public function test_validation_rules_are_enforced_on_register(): void
    {
        Livewire::test(Register::class)
            ->set('form.name', '')
            ->set('form.username', '')
            ->set('form.email', 'invalid')
            ->set('form.password', '')
            ->call('register')
            ->assertHasErrors([
                'form.name',
                'form.username',
                'form.email',
                'form.password',
            ]);
    }
}
