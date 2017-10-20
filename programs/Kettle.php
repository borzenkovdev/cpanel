<?php
namespace programs;

/**
 * Class Kettle
 * @package programs
 */
class Kettle
{
    public function on()
    {
        print_r('I am method On of class ' . self::class . PHP_EOL);
    }

    public function off()
    {
        print_r('I am method Off of class ' . self::class . PHP_EOL);
    }
}
?>
