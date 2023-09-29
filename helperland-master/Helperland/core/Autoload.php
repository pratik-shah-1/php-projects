<?php

    spl_autoload_register(function($class){
        $class = str_replace('\\', '/', $class);
        $path1 = __DIR__.'/../'.$class.'.php';
        $path2 = __DIR__.'/../core/'.$class.'.php';
        if(file_exists($path1))
            require_once $path1;
        else if(file_exists($path2))
            require_once $path2;
    });

    // FILE NAME AND CLASS NAME MUST BE SAME OTHERWISE FILE NOT BE LOADED...
    // FOLDER NAME WILL BE LOWERCASE...
    // FILE NAME WILL BE UPPERCASE...
    // PATH1 FOR CUSTOM CLASS
    // PATH2 FOR PHP MAILER CLASS
