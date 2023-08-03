<?php
declare(strict_types=1)
spl_autoload_register(function ($className){
    $path = "../src/{$className}.php";
    if(file_exists($path)){
        require_once ($path);
    }
});

$front_controller = new FrontController();
$front_controller->run();






