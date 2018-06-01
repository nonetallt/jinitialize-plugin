<?php

use Nonetallt\Jinitialize\JinitializeCommand;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    // define public methods as commands

    public function watchTests()
    {
        $this->taskWatch()
            ->monitor(['src', 'tests/Feature', 'tests/Unit'], function() {
                echo 'test';
                $this->taskExec('phpunit')->run();
            })->run();
    }

    public function updateCommands()
    {
        $filepath = __DIR__.'/composer.json';
        $contents = file_get_contents($filepath);
        $composer = json_decode($contents, true);

        if(! $this->isset('extra.jinitialize-plugin.commands', $composer)) {
            echo 'Path extra.jinitialize-plugin.commands is not set in composer.json';
            return;
        }

        $namespace = $this->getCommandNamespace($composer);

        if(is_null($namespace)) {
            echo 'Namespace could not be resolved';
            return;
        }

        /* Get files in the commands folder */
        $files = array_diff(scandir(__DIR__.'/src/Commands'), ['..', '.']);
        $commands = [];

        foreach($files as $file) {
            /* Get full class name */
            $class = "$namespace$file";
            $class = str_replace('.php', '', $class);

            if(is_subclass_of($class, JinitializeCommand::class)) {
                $commands[] = $class;
            }
        }

        $this->printInfo($commands);

        /* Update commands to json */
        $composer['extra']['jinitialize-plugin']['commands'] = $commands;
        $content = json_encode($composer, JSON_PRETTY_PRINT);
        file_put_contents($filepath, $content);
    }

    private function printInfo(array $commands)
    {
        $count = count($commands);
        echo "\nFound $count command(s) in src/Commands \n\n";

        foreach($commands as $command) {
            echo "$command\n";
        }
        echo "\n";
    }

    /**
     * Only supports psr4 for now.
     */
    private function getCommandNamespace(array $composer)
    {
        if(! $this->isset('autoload.psr-4', $composer)) {
            return null;
        }

        foreach($composer['autoload']['psr-4'] as $namespace => $folder) {
            if($folder === 'src/') return $namespace . 'Commands\\';
        }
        return null;
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
