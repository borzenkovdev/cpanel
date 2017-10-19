<?php
namespace programs;

class Door
{
    public function open()
    {
        print_r('I am method open of class ' . self::class);
    }

    public function close()
    {
        print_r('I am method close of class ' . self::class);
    }
}
?>
