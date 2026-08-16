<?php

namespace Tests\Feature\Livewire\MasterData;

use App\Livewire\MasterData\Group;
use App\Models\AdditionalProduct;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\AuthenticateAs;

class GroupTest extends TestCase
{
    use AuthenticateAs;

    public function test_guest_is_redirected(): void
    {
        $response = $this->get(route('master-data.group-product'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_view_group_list(): void
    {
        $this->authenticateAs();
        AdditionalProduct::factory()->count(3)->create();

        Livewire::test(Group::class)
            ->assertViewHas('groups');
    }
}
