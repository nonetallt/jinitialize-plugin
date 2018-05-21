# jinitialize-plugin-new

Boilerplate setup for creating a new jinitialize plugin

## Composer setup

In order for your plugin to be registered in a jinitialize project, you must define the plugin information in the **extra** section of your composer.json file.

```json
extra: {
    "jinitialize-plugin": {
        "name": "MyPlugin",
        "commands": [
            "Nonetallt\\Jinitialize\\Plugin\\Example\\Commands\\MyCommand::class"
        ],
        "settings": [
            "mySetting1",
            "mySetting2"
        ]
    }
}
```

### name
The name of the plugin.

### commands
An array including fully qualified names of the command classes you wish this plugin to export.

### settings
An array of strings that the user of this plugin can define in their main project .env file. Settings are useful for defining commonly used default values instead of prompting the user for imput each time. Examples of settings could be along the lines of "defaultUser" and/or "defaultPassword".


## Keeping the commands section up to date
You can use the following command to automatically export all of the command classes in the *src/Commands* folder to your composer.json file:
```
vendor/bin/robo watch:commands
```

## Commands

The JinitializeCommand class extends from Symfony\Component\Console\Command\Command and defines a couple of useful helpers you might need when creating your own subclasses.

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
```

### abort(string $message);
Stops the execution of the comand by throwing Nonetallt\Jinitialize\Plugin\Exceptions\CommandAbortedException. The procedure running the command will then attempt to revert executed commands by calling their **revert()** method.

### export(string $key, $value);
Stores a given key - value pair to the application container. This should be used to give other plugins access to useful values defined by the command. For example, a database plugin might define a command for creating a new database and then export the name of the created database so it can be later used for defining database name in the settings of an application.

### import(string $plugin, string $key);
Get a value stored in the application container. Imported values should only be used as default options or suggestions given that they can be null if the commands from a given plugin haven't been executed yet.

### getIo();
Get an instance of [Symfony\Component\Console\Style\SymfonyStyle](https://api.symfony.com/4.0/Symfony/Component/Console/Style/SymfonyStyle.html). This can be used to write and get input from the [CLI](https://en.wikipedia.org/wiki/Command-line_interface). For examples on the IO usage, please check out the [symfony console documentation](https://symfony.com/doc/current/console/style.html#helper-methods).

### getUser();
Get an instance of Nonetallt\Jinitialize\Plugin\ShellUser. The class has following helper methods:
* isRoot()
* getName()
* getInfo()
* getId()

### getPluginName();
Get the name of the plugin this command is registered by.
