<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\Shift;
use App\Models\Shift as ShiftModel;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class ShiftTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.shift'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_shift_list(): void
    {
        $this->authenticateAs();
        ShiftModel::factory()->count(3)->create();

        Livewire::test(Shift::class)
            ->assertViewHas('shifts');
    }
}
