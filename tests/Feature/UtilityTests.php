<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UtilityTests extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHelloWorld()
    {
        $this->assertArrayHasKey('test_key', array('test' => 'Test Example'), "Failure expected");
    }
}

