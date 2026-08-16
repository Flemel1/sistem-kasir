<?php

namespace Tests\Unit\Enums;

use App\Enums\PriceChoose;
use PHPUnit\Framework\TestCase;

class PriceChooseTest extends TestCase
{
    public function test_cases_have_expected_values(): void
    {
        $this->assertEquals('normal', PriceChoose::NORMAL->value);
        $this->assertEquals('takeaway', PriceChoose::TAKEAWAY->value);
    }

    public function test_all_cases_are_covered(): void
    {
        $cases = PriceChoose::cases();
        $this->assertCount(2, $cases);
        $this->assertContains(PriceChoose::NORMAL, $cases);
        $this->assertContains(PriceChoose::TAKEAWAY, $cases);
    }
}
