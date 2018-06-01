<?php

namespace Nonetallt\Jinitialize\Plugin\Example\Commands;

use Nonetallt\Jinitialize\JinitializeCommand;

class ExampleCommand extends JinitializeCommand
{

    protected function configure()
    {
        $this->setName('example');
        $this->setDescription('This is an example command');
        $this->setHelp('Extended description here');
    }

    protected function handle($input, $output, $style)
    {
        // Run code on command execution
    }

    public function revert()
    {
        // Revert changes made by handle if possible
    }

    public function requiresExecuting()
    {
        return [

        ];
    }

    public function recommendsExecuting()
    {
        return [

        ];
    }

    public function recommendsRoot()
    {
        // bool, wether command should be executed with administrative priviliges
        return false;
    }
}
