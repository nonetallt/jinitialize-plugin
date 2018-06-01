<?php

namespace Tests\Feature;

use Nonetallt\Jinitialize\Testing\TestCase;

class FeatureTest extends TestCase
{

    public function testExample()
    {
        //
    }

    public function setUp()
    {
        parent::setUp();
        $this->registerLocalPlugin(__DIR__.'/../../composer.json');
    }
}
