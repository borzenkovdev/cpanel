<?php
namespace programs;

/**
 * Class Jacuzzi
 * @package programs
 */
class Jacuzzi
{
    public function turnOn()
    {
        print_r('I am method On of class ' . self::class . PHP_EOL);
    }

    public function turnOff()
    {
        print_r('I am method Off of class ' . self::class . PHP_EOL);
    }

    public function playMusic()
    {
        print_r('I am method Off of class ' . self::class . PHP_EOL);
    }
}
?>
