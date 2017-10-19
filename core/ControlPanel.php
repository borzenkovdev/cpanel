<?php
namespace core;

use core\Db;

class ControlPanel
{
    const MAX_HISTORY_OPERATIONS = 8;

    private $dbInstance;

    /**
     * constructor of class
     */
    public function __construct () {
        $this->dbInstance = new Db();
    }

    /**
     * change binding of button
     * @param $arguments
     * @return bool
     */
    public function add($arguments)
    {
        if (count($arguments) !== 3) {
            echo 'Error add: Incorrect quantity of arguments' . PHP_EOL;
            echo 'Typical usage: add position/perform_on/perform_off/programClass' . PHP_EOL;
            return false;
        }

        $argumentsArray = explode('/', $arguments[2]);
        if (count($argumentsArray) !== 4) {
            echo 'Error add: Incorrect quantity of parameters' . PHP_EOL;
            echo 'Typical usage: add position/perform_on/perform_off/programClass' . PHP_EOL;
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
     * show all buttons bindings
     * @param $arguments
     */
    public function printCommands($arguments)
    {
        if (count($arguments) !== 3) {
            echo 'Error printCommands: Incorrect quantity of arguments' . PHP_EOL;
        }
        $res = $this->dbInstance->query('SELECT * FROM `buttons`');
        echo '<pre>'; print_r($res); echo '</pre>';
    }

    /**
     * revert last N operations
     * @param $arguments
     */
    public function undo($arguments)
    {
        if (count($arguments) !== 3)  {
            echo 'Error add: Incorrect quantity of arguments' . PHP_EOL;
            echo 'Typical usage: undo 3 "- its revert last three operations, max ' . self::MAX_HISTORY_OPERATIONS . '"' . PHP_EOL;
            return false;
        }

        $limit = intval($arguments[2]);
        if ($limit > self::MAX_HISTORY_OPERATIONS) {
            echo 'Error: You cant revert ' . $limit .' operations, maximum ' . self::MAX_HISTORY_OPERATIONS . ' operations' . PHP_EOL;
            return false;
        }

        //get all histories of operations by limit
        $res = $this->dbInstance->query("SELECT * FROM `operations` ORDER BY created_at DESC LIMIT {$limit};");

        foreach ($res as $button) {
            try {
                $isExecuted = $this->perform($button['button_id'], $button['prev_action'], false);
            } catch (\Exception $e) {
                print "Error!: " . $e->getMessage();
                die();
            }

            //remove operation from hostory
            if ($isExecuted) {
                echo " - Reverted succesfully - button row {$button['button_id']} - executed action {$button['prev_action']}, program {$button['program']}" . PHP_EOL;
                $this->dbInstance->query("DELETE FROM `operations` WHERE  `id`= {$button['id']}");
            }
        }
    }


    /**
     * Execute Off operation
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
     * Execute On operation
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
     * Execute code of operation
     * @param $position
     * @param $action
     * @throws \Exception
     */
    protected function perform($position, $action, $saveHistory = true)
    {
        $resArray = $this->dbInstance->query('SELECT * FROM `buttons` WHERE id=:id LIMIT 1', ['id' => $position]);
        if (! $resArray || !$resArray[0]) {
            throw new \Exception("Error {$action}: Buttons row {$position} doesnt exist");
        }

        $result = $resArray[0];

        if($this->checkMethodExist($result['program'], $result[$action])) {
            $class = 'programs\\' . $result['program'];
            $obj = new $class();
            call_user_func([$obj, $result[$action]]);
            if ($saveHistory) {
                $this->addHistoryOpertions($result['id'], $action, $result['program']);
            }
            return true;
        }
    }

    /**
     * @param $position
     * @param $action
     * @throws \Exception
     */
    protected function updateButton($position, $actionOn, $actionOff, $program)
    {
        $exist = $this->dbInstance->query('SELECT * FROM `buttons` WHERE id=:id LIMIT 1', ['id' => $position]);
        if (! $exist) {
            throw new \Exception("Buttons row {$position} doesnt exist");
        }

        if(! $this->checkMethodExist($program, $actionOff) || !$this->checkMethodExist($program, $actionOn) ) {
            die();
        }

        $isUpdated = $this->dbInstance->query("UPDATE `buttons` SET
                perform_on = :perform_on,
                perform_off = :perform_off,
                program = :program,
                updated_at = now()
            WHERE id = :position", [
                'perform_on' => $actionOn,
                'perform_off' => $actionOff,
                'program' => $program,
                'position' => $position
        ]);

        if ($isUpdated) {
            print_r("Button row {$position} successfully updated!". PHP_EOL);
        } else {
            throw new \Exception("Error with updating button row  {$position}");
        }
    }


    /**
     * @param $position
     * @param $action
     * @throws \Exception
     */
    protected function addHistoryOpertions($button_id, $action, $program)
    {
        $this->dbInstance->query("INSERT INTO `operations` (button_id, prev_action, program) VALUES (:button_id, :prev_action, :program)",
            ['button_id' => $button_id, 'prev_action' => $action, 'program' => $program]);
        $this->removeGarbageHistoryOperation();
    }

    /**
     * Remove old history operations
     */
    protected function removeGarbageHistoryOperation () {
        $this->dbInstance->query('DELETE a FROM operations a LEFT JOIN (SELECT id FROM operations ORDER BY id DESC LIMIT '. self::MAX_HISTORY_OPERATIONS . ') b ON a.id = b.id WHERE b.id is null;');
    }

    /**
     * @param $className
     * @param $method
     * @return bool
     * @throws \Exception
     */
    protected function checkMethodExist ($className, $method)
    {
        if (! method_exists('programs\\'  . $className, $method)) {
            throw new \Exception("Method '{$method}' of class '{$className}' doesnt exist  ");
        } else {
            return true;
        }
    }
}
?>
