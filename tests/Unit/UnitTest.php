<?php

namespace Tests\Unit;

use Nonetallt\Jinitialize\Testing\TestCase;

class UnitTest extends TestCase
{

    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function setUp()
    {
        parent::setUp();
        $this->registerLocalPlugin(__DIR__.'/../../composer.json');
    }
}
