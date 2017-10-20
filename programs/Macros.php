<?php
namespace programs;

use programs\BathroomLight;
use programs\Door;
use programs\Heating;
use programs\Jalousie;
use programs\Garage;
use programs\Kettle;
use programs\Jacuzzi;

/**
 * This class can bind few operations to one button
 * Class Macros
 * @package programs
 */
class Macros
{
    public function on()
    {
        print_r('I am method On of class ' . self::class . PHP_EOL);

        $door = new Door();
        $door->open();

        $jac = new Jacuzzi();
        $jac->playMusic();
    }

    public function off()
    {
        print_r('I am method Off of class ' . self::class . PHP_EOL);

        $door = new Door();
        $door->close();

        $jac = new Jacuzzi();
        $jac->turnOff();
    }
}
?>
