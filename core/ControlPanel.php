<?php
namespace core;

use core\Db;

class ControlPanel
{
    public function add($arguments)
    {
        $argumentsArray = explode('/', $arguments[2]);

        if (count($arguments) !== 3 || count($argumentsArray) !== 4) {
            echo 'Error add: Incorrect quantity of arguments' . PHP_EOL;
            echo 'Typical usage: add position/perform_on/performoff/programmClass' . PHP_EOL;
            return false;
        }

        try {
            $this->updateButton($argumentsArray[0], $argumentsArray[1], $argumentsArray[2], $argumentsArray[3]);
        } catch (\Exception $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }



    /**
     * Вывод всех кнопок  и их полей
     * @param $arguments
     */
    public function printCommands($arguments)
    {
        if (count($arguments) !== 3) {
            echo 'Error printCommands: Incorrect quantity of arguments' . PHP_EOL;
        }
        $db = new Db();
        $res = $db->query('SELECT * FROM `buttons`');
        echo '<pre>'; print_r($res); echo '</pre>';
    }

    /**
     * @param $arguments
     */
    public function undo($arguments)
    {
        print_r('undo');
    }


    /**
     * @param $arguments
     */
    public function performOff($arguments)
    {
        if (count($arguments) !== 3) {
            echo 'Error performOn: Incorrect quantity of arguments' . PHP_EOL;
            echo 'Typical usage: performOff position' . PHP_EOL;
            return false;
        }

        $position = intval($arguments[2]);

        try {
            $this->perform($position, 'perform_off');
        } catch (\Exception $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }


    /**
     * @param $arguments
     * @return bool
     */
    public function performOn($arguments)
    {
        if (count($arguments) !== 3) {
            echo 'Error performOn: Incorrect quantity of arguments' . PHP_EOL;
            echo 'Typical usage: performOn position' . PHP_EOL;
            return false;
        }

        $position = intval($arguments[2]);

        try {
            $this->perform($position, 'perform_on');
        } catch (\Exception $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    /**
     * @param $position
     * @param $action
     * @throws \Exception
     */
    protected function perform($position, $action)
    {
        $db = new Db();
        $resArray = $db->query('SELECT * FROM `buttons` WHERE id=:id LIMIT 1', ['id' => $position]);
        if (! $resArray) {
            throw new \Exception("Error {$action}: Buttons row {$position} doesnt exist");
        }

        $result = $resArray[0];

        if (class_exists( 'programs\\' . $result['programm']) && method_exists('programs\\'  . $result['programm'], $result[$action])) {
            $class = 'programs\\' . $result['programm'];
            $obj = new $class();
            call_user_func([$obj, $result[$action]]);
        } else {
            throw new \Exception("Error performOn: Class or method doesnt exist  {$result['programm']}->{$result[$action]}");
        }
    }


    /**
     * @param $position
     * @param $action
     * @throws \Exception
     */
    protected function updateButton($position, $actionOn, $actionOff, $programm)
    {
        $db = new Db();
        $resArray = $db->query('SELECT * FROM `buttons` WHERE id=:id LIMIT 1', ['id' => $position]);
        if (! $resArray) {
            throw new \Exception("Buttons row {$position} doesnt exist");
        }
    }
}
?>
