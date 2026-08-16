<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\EditShift;
use App\Models\Shift as ShiftModel;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class EditShiftTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $shift = ShiftModel::factory()->create();

        $response = $this->get(route('master-data.shift.edit', $shift));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_edit_shift_page(): void
    {
        $this->authenticateAs();
        $shift = ShiftModel::factory()->create();

        $response = $this->get(route('master-data.shift.edit', $shift));
        $response->assertOk();
    }

    public function test_can_update_shift(): void
    {
        $this->authenticateAs();
        $shift = ShiftModel::factory()->create([
            'employee_name' => 'Old Name',
            'shift' => ['Senin 08:00-16:00'],
        ]);

        Livewire::test(EditShift::class, ['shift' => $shift])
            ->set('form.employee_name', 'Updated Name')
            ->call('update')
            ->assertDispatched('update-shift');

        $this->assertDatabaseHas('shifts', [
            'id' => $shift->id,
            'employee_name' => 'Updated Name',
        ]);
    }
}
