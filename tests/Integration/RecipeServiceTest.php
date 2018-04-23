<?php

namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use Green\Services\RecipeService;
use Green\Database\Connection;

class RecipeServiceTest extends TestCase
{
    public function testCreate()
    {
        Connection::boot();

        $service = new RecipeService();
        $recipe = $service->create([
            'difficulty' => 2,
            'name' => "fresh",
            'vegetarian' => true,
            'prepare_time' => 20
        ]);

        $this->assertTrue($recipe->exists());
    }

    public function testUpdate()
    {
        Connection::boot();

        $service = new RecipeService();
        $recipe = $service->create([
            'difficulty' => 2,
            'name' => "fresh",
            'vegetarian' => true,
            'prepare_time' => 20
        ]);

        $updatedService = $service->update($recipe->id,[
            'difficulty' => 1
        ]);

        $this->assertEquals($recipe->fresh()->difficulty, $updatedService->difficulty);
    }

    public function testDelete()
    {
        Connection::boot();
        
        $service = new RecipeService();
        $recipe = $service->create([
            'difficulty' => 2,
            'name' => "fresh",
            'vegetarian' => true,
            'prepare_time' => 20
        ]);

        $service->delete($recipe->id);
        $this->assertNull($recipe->fresh());
    }

    public function testRating()
    {
        Connection::boot();
        
        $service = new RecipeService();
        $recipe = $service->create([
            'difficulty' => 2,
            'name' => "fresh",
            'vegetarian' => true,
            'prepare_time' => 20
        ]);

        $service->rate($recipe->id,[
            'stars' => 1
        ]);

        $this->assertEquals($recipe->ratings->count(),1);
    }
}