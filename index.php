<?php

    session_start ();


    function my_autoload($className){
        $fileName = 'core/'.str_replace('\\','/', $className).'.php';
        if (!file_exists($fileName))   throw new \Exception("Сlass not [".$className."] found");
        else require_once $fileName;
    }
    spl_autoload_register("my_autoload");


    try {

     $router = new \base\Router();

     $router->run();



    }catch (\Exception $e){
        die("<br>"."message: ".$e->getMessage()."<br>".
            "code: ".$e->getCode()."<br>".
            "file: ".$e->getFile()."<br>".
            "line: ".$e->getLine ()."<br>"
        );
    }









