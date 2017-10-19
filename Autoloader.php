<?php

/**
 * Class Autoloader
 */
class Autoloader {
    static public function loader($className) {
        $included = false;
        $filename =  __DIR__  . '/' . str_replace("\\", '/', $className) . ".php";

        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                $included = true;
            }
        }

        if ($included) {
            return true;
        } else {
            throw new Exception("Cant load : {$className}. Class doesnt exist!");
        }
    }
}

spl_autoload_register('Autoloader::loader');