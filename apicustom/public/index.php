<?php
global $CoreParams;
require_once ("../config/config.php");
spl_autoload_register(function ($className){
    $path = "../src/{$className}.php";
    if(file_exists($path)){
        require_once ($path);
    }
});


$database = new Database($CoreParams['Database']['Host'], $CoreParams['Database']['Username'],$CoreParams['Database']['Password'], $CoreParams['Database']['Database']);
$database->connect();
$query = new QueryBuilder();


$query->select(["title", "text"])
    ->from('news')
->where(["id"=>5]);
$rows = $database->execute($query);

//$pdo = new PDO("mysql:host=172.22.75.8;dbname=cms","student", "root");
//$sth=$pdo->prepare("SELECT * FROM news WHERE id= :id");
//$sth->execute([4]);
//$rows = $sth->fetchAll();
//var_dump($rows);
//$front_controller = new FrontController();
//$front_controller->run();

$CoreParams['Database'] = [
    "Host"=>"172.22.75.8",
    "Username"=>"student",
    "Password"=>"root",
    "Database"=>"cms"
];










