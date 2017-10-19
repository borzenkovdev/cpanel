<?php

namespace core;

use core\ControlPanel;

class Application
{
    private $ControlPanel;

    private $commandsWhiteList = [
        'add',
        'printCommands',
        'undo',
        'performOn',
        'performOff'
    ];

    public function __construct($arguments)
    {
        if (count($arguments) > 1 && in_array($arguments[1], $this->commandsWhiteList)) {
            if (!is_object($this->ControlPanel)) {
                $this->ControlPanel = new ControlPanel();
            }
            call_user_func([$this->ControlPanel, $arguments[1]], $arguments);
        } else {
            echo 'Error: Incorrect quantity of arguments' . PHP_EOL;
            $this->help();
            return false;
        }
    }

    /**
     * help
     */
    public function help ()
    {
echo  <<<DOC
usage:
These are common commands used in various situations:
   add              Add new actions to buttons
   printCommands    Show all buttons bindings
   undo             Revert previous action
   performOn        Manual executing some action of programm
   performOff       Manual executing some action of programm

'php index.php help' list available subcommands
DOC;
    }
}
?>