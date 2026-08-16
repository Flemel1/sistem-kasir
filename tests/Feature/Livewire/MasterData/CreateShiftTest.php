<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\CreateShift;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class CreateShiftTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.shift.create'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_create_shift_page(): void
    {
        $this->authenticateAs();

        $response = $this->get(route('master-data.shift.create'));
        $response->assertOk();
    }

    public function test_can_create_shift_with_valid_data(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateShift::class)
            ->set('form.employee_name', 'Budi')
            ->set('form.shifts', ['Senin 08:00-16:00', 'Selasa 08:00-16:00'])
            ->call('save')
            ->assertDispatched('create-shift');

        $this->assertDatabaseHas('shifts', [
            'employee_name' => 'Budi',
        ]);
    }

    public function test_validation_rules_are_enforced(): void
    {
        $this->authenticateAs();

        Livewire::test(CreateShift::class)
            ->set('form.employee_name', '')
            ->set('form.shifts', [])
            ->call('save')
            ->assertHasErrors([
                'form.employee_name',
                'form.shifts',
            ]);
    }
}
