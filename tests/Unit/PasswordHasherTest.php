<?php

namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use Green\Support\PasswordHasher;

class PasswordHasherTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPasswordHashMatch()
    {
        $hashedPassword = PasswordHasher::hash('1234');
        $this->assertTrue(PasswordHasher::verify('1234',$hashedPassword));
    }
}