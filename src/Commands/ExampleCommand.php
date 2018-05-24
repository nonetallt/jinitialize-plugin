<?php

namespace Nonetallt\Jinitialize\Plugin\Example\Commands;

use Nonetallt\Jinitialize\Plugin\JinitializeCommand;

class ExampleCommand extends JinitializeCommand
{

    protected function configure()
    {
        $this->setName('nameofcommand');
        $this->setDescription('This is an example command');
        $this->setHelp('Asks the user for their username and outputs Hello [username]! Exports userName.');
    }

    protected function handle()
    {
        // Run code on command execution

        // Ask for user input, suggest default value of 'World'
        $name = $this->getIo()->ask('What is your name?', 'World');

        $this->getIo()->title("Hello $name!");

        $this->export('userName', $name); 
    }

    public function revert()
    {
        // Revert changes made by handle if possible
    }

    public function recommendsRoot()
    {
        // bool, wether command should be executed with administrative priviliges
        return false;
    }
}
