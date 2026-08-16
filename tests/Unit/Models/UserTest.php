<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $user = new User();
        $this->assertEquals(['name', 'username', 'email', 'password'], $user->getFillable());
    }

    public function test_hidden_attributes(): void
    {
        $user = new User();
        $this->assertEquals(['password', 'remember_token'], $user->getHidden());
    }

    public function test_password_is_cast_to_hashed(): void
    {
        $user = new User();
        $casts = $user->getCasts();
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }

    public function test_email_verified_at_is_cast_to_datetime(): void
    {
        $user = new User();
        $casts = $user->getCasts();
        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
    }
}
