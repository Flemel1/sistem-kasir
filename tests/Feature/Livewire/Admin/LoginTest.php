<?php

namespace Tests\Feature\Livewire\Admin;

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Admin\Login;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_can_view_login_page(): void
    {
        $response = $this->get(route('auth.login'));
        $response->assertOk();
    }

    public function test_authenticated_user_is_redirected_from_login_page(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.login'));
        $response->assertRedirect(route('dashboard'));
    }

    public function test_can_authenticate_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('secret123'),
        ]);

        Livewire::test(Login::class)
            ->set('form.username', 'testuser')
            ->set('form.password', 'secret123')
            ->call('login')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_cannot_authenticate_with_invalid_password(): void
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => 'secret123',
        ]);

        Livewire::test(Login::class)
            ->set('form.username', 'testuser')
            ->set('form.password', 'wrongpassword')
            ->call('login');

        $this->assertGuest();
    }

    public function test_cannot_authenticate_with_nonexistent_username(): void
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => 'secret123',
        ]);

        Livewire::test(Login::class)
            ->set('form.username', 'nonexistent')
            ->set('form.password', 'secret123')
            ->call('login');

        $this->assertGuest();
    }

    public function test_validation_rules_are_enforced(): void
    {
        Livewire::test(Login::class)
            ->set('form.username', '')
            ->set('form.password', '')
            ->call('login')
            ->assertHasErrors([
                'form.username',
                'form.password',
            ]);
    }
}
