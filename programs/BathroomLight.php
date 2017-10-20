<?php
namespace programs;

/**
 * Class BathroomLight
 * @package programs
 */
class BathroomLight
{
    public function on()
    {
       print_r('I am method On of class ' . self::class . PHP_EOL);
    }

    public function off()
    {
        print_r('I am method Off of class ' . self::class . PHP_EOL);
    }

    public function dimm()
    {
        print_r('I am method dimm of class ' . self::class . PHP_EOL);
    }
}
?>
