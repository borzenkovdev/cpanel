<?php
namespace programs;

/**
 * Class Jalousie
 * @package programs
 */
class Jalousie
{
    public function up()
    {
        print_r('I am method up of class ' . self::class . PHP_EOL);
    }

    public function down()
    {
        print_r('I am method down of class ' . self::class . PHP_EOL);
    }
}
?>
