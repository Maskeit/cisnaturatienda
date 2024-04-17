<?php

    define('ROOT',dirname(__FILE__));
    define('DS',DIRECTORY_SEPARATOR);

    spl_autoload_register('autoload');

    // function autoload($class){
    //     $class = ROOT . DS . str_replace("\\",DS,$class) . '.php';
    //     if(!file_exists($class)){
    //         throw new Exception("Error, clase no encontrada " . $class, 1);
    //     }
    //     require_once $class;
    // }

    function autoload($class) {
        $classFile = ROOT . DS . str_replace("\\", DS, $class) . '.php';
        
        if (file_exists($classFile)) {
            require_once $classFile;
        }
        // No lanzar una excepción si la clase no se encuentra, permitir que otros autoloaders intenten cargarla.
    }
    