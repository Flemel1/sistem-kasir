<?php

namespace Tests\Unit\Enums;

use App\Enums\StatusOrder;
use PHPUnit\Framework\TestCase;

class StatusOrderTest extends TestCase
{
    public function test_cases_have_expected_values(): void
    {
        $this->assertEquals('opened', StatusOrder::OPENED->value);
        $this->assertEquals('closed', StatusOrder::CLOSED->value);
    }

    public function test_all_cases_are_covered(): void
    {
        $cases = StatusOrder::cases();
        $this->assertCount(2, $cases);
        $this->assertContains(StatusOrder::OPENED, $cases);
        $this->assertContains(StatusOrder::CLOSED, $cases);
    }
}
