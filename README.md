# jinitialize-plugin

Boilerplate setup for creating a new [jinitialize](https://github.com/nonetallt/jinitialize) plugin.

## Installation
```
composer create-project nonetallt/jinitialize-plugin [project name]
```

## Composer setup

In order for your plugin to be registered in a jinitialize project, you must define the plugin information in the **extra** section of your composer.json file.

```json
extra: {
    "jinitialize-plugin": {
        "name": "MyPlugin",
        "commands": [
            "Nonetallt\\Jinitialize\\Plugin\\Example\\Commands\\MyCommand::class"
        ],
        "procedures": [
            "procedures/my-procedure.json"
        ],
        "settings": [
            "mySetting1",
            "mySetting2"
        ]
    }
}
```

### name
The name of the plugin. This will be used as the namespace for commands exported by this plugin so making it short is preferable.

### commands
An array including fully qualified names of the command classes you wish this plugin to export.

### procedures
An array including all the filepaths from the root of the project to the [procedure](https://github.com/nonetallt/jinitialize#procedure) files you wish this plugin to export.

### settings
An array of strings that the user of this plugin can define in their jinitialize .env file. Settings are useful for defining commonly used default values instead of prompting the user for input each time. Examples of settings could be along the lines of "defaultUser" and "defaultPassword".


## Keeping the commands section up to date
You can use the following command to automatically export all of the command classes in the *src/Commands* folder to your composer.json file:
```
vendor/bin/robo update:commands
```

## Commands

The [JinitializeCommand class](https://github.com/nonetallt/jinitialize-core/blob/master/src/JinitializeCommand.php) extends from [Symfony\Component\Console\Command\Command](https://api.symfony.com/3.4/Symfony/Component/Console/Command/Command.html) and defines a couple of useful helpers you might need when creating your own subclasses.

```php
use Nonetallt\Jinitialize\Plugin\JinitializeCommand;

class ExampleCommand extends JinitializeCommand
{
    protected function configure()
    {
        $this->setName('nameofcommand');
        $this->setDescription('desc');
        $this->setHelp('extended description here');
    }
    
    protected function handle($input, $output, $style)
    {
        // Run code on command execution
        
        // Ask for user input, suggest default value of 'World'
        $name = $style->ask('What is your name?', 'World');
        
        $style->title("Hello $name!");
        
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
```

### abort(string $message);
Stops the execution of the comand by throwing Nonetallt\Jinitialize\Exceptions\CommandAbortedException. The procedure running the command will then attempt to revert executed commands by calling their **revert()** method.

### configure();
Implemented from the command class. Used to define basic command information, [input options and arguments](http://symfony.com/doc/3.4/console/input.html).

### export(string $key, $value);
Stores a given key - value pair to the application container. This should be used to give other plugins access to useful values defined by the command. For example, a database plugin might define a command for creating a new database and then export the name of the created database so it can be later used for defining database name in the settings of an application.

### getPluginName();
Get the name of the plugin this command is registered by.

### getUser();
Get an instance of Nonetallt\Jinitialize\Plugin\ShellUser. The class has following helper methods:
* isRoot()
* getName()
* getInfo()
* getId()

### handle($input, $output, $style);
The main method for code execution when the command is ran. The parameters gives you access to Symfony console I/O. For examples on the I/O usage, please check out the [symfony console documentation](https://symfony.com/doc/current/console/style.html#helper-methods).

* [$input](https://api.symfony.com/3.4/Symfony/Component/Console/Input/InputInterface.html)
* [$output](https://api.symfony.com/3.4/Symfony/Component/Console/Output/OutputInterface.html)
* [$style](https://api.symfony.com/3.4/Symfony/Component/Console/Style/SymfonyStyle.html)

### import(string $plugin, string $key);
Get a value stored in the application container. Imported values should only be used as default options or suggestions, given that they can be null if the commands from a given plugin haven't been executed yet.
