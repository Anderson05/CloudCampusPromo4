<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testStatutPositif():void {
        $status = 5;
        $this->assertTrue($status > 0, "Statut Positif...");
    }

}
