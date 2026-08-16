<?php

namespace Tests\Traits;

use App\Models\User;

trait AuthenticateAs
{
    protected function authenticateAs(User $user = null): User
    {
        $user ??= User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}
