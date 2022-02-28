<?php
declare(strict_types=1);

require('Calculator.php');

use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    public function testSum()
    {
        $calculator = new Calculator();

        $this->assertSame(9, $calculator->sum(4,5));
        $this->assertSame(12, $calculator->sum(2,10));
    }

    public function testSumWithBadParameters1()
    {
        $calculator = new Calculator();

        $this->expectException('TypeError');

        $calculator->sum('nevim', 5);
    }

    public function testSumWithBadParameters2()
    {
        $calculator = new Calculator();

        $this->expectException('TypeError');

        $calculator->sum(5, 'ahoj');
    }
}