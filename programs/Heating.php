<?php
namespace programs;

class Heating
{
    public function warmUp()
    {
        print_r('I am method On of class ' . self::class);
    }

    public function warmDown()
    {
        print_r('I am method Off of class ' . self::class);
    }

    public function warmMax()
    {
        print_r('I am method warmMax of class ' . self::class);
    }

    public function off()
    {
        print_r('I am method off of class ' . self::class);
    }
}
?>
