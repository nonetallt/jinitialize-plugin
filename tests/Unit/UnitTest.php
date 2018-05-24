<?php

namespace Tests\Unit;

use PHPunit\Framework\TestCase;

class UnitTest extends TestCase
{

    public function testExample()
    {
        $ar = [
            'extra' => [
                'jinitialize-plugin' => [
                    'commands' => [
                        'ExampleCommand'
                    ]
                ]
            ]
        ];
        $this->assertTrue($this->isset('extra.jinitialize-plugin.commands', $ar));
    }

    private function isset(string $path, array $composer)
    {
        $parts = explode('.', $path);
        $currentPath = $composer;

        foreach($parts as $part) {

            if(! isset($currentPath[$part])) {
                return false;
            }

            $currentPath = $currentPath[$part];
        }

        return true;
    }
}
