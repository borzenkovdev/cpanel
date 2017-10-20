<?php

namespace core;

use core\ControlPanel;

class Application
{
    private $ControlPanel;

    /**
     * @var array
     */
    private $commandsWhiteList = [
        'add',
        'printCommands',
        'undo',
        'performOn',
        'performOff'
    ];

    /**
     * @param $arguments
     */
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
   add              Add new actions to buttons - Typical usage: 'php index.php add position/perform_on/perform_off/programClass'
   printCommands    Show all buttons bindings - Typical usage: 'php index.php printCommands'
   undo             Revert previous action - Typical usage: 'php index.php undo 3 (its revert last three operations, max 8)'
   performOn        Manual executing On action of programm - Typical usage: 'php index.php performOn n (where n = position of button row )'
   performOff       Manual executing Off some action of programm - Typical usage: 'php index.php performOff n (where n = position of button row )'

'php index.php help' list available subcommands
DOC;
    }
}
?>
