<?php

namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use Green\Config\Repository;

class RepositoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testConfigCorrectlySet()
    {
        $repository = new Repository();
        $repository->set("name","hellofresh");
        $this->assertEquals("hellofresh", $repository->get("name"));
    }
}