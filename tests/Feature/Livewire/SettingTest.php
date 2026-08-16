<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Setting;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class SettingTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected_from_setting(): void
    {
        $response = $this->get(route('setting'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_setting_page(): void
    {
        $this->authenticateAs();

        $response = $this->get(route('setting'));
        $response->assertOk();
    }

    public function test_can_update_password_with_valid_data(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('currentpass'),
        ]);
        $this->authenticateAs($user);

        Livewire::test(Setting::class)
            ->set('current_password', 'currentpass')
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'newpassword')
            ->call('update_password')
            ->assertDispatched('password-updated');
    }

    public function test_cannot_update_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('currentpass'),
        ]);
        $this->authenticateAs($user);

        Livewire::test(Setting::class)
            ->set('current_password', 'wrongpass')
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'newpassword')
            ->call('update_password')
            ->assertHasErrors(['current_password']);
    }

    public function test_cannot_update_password_with_mismatched_confirmation(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('currentpass'),
        ]);
        $this->authenticateAs($user);

        Livewire::test(Setting::class)
            ->set('current_password', 'currentpass')
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'different')
            ->call('update_password')
            ->assertHasErrors(['password']);
    }

    public function test_cannot_update_password_with_too_short_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('currentpass'),
        ]);
        $this->authenticateAs($user);

        Livewire::test(Setting::class)
            ->set('current_password', 'currentpass')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('update_password')
            ->assertHasErrors(['password']);
    }
}
