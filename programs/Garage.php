<?php
namespace programs;

class Garage
{
    public function on()
    {
        print_r('I am method On of class' . self::class);
    }

    public function off()
    {
        print_r('I am method Off of class' . self::class);
    }
}
?>
