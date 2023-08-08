<?php
global $CoreParams;


use App\Controllers\FrontController;
use App\Core\Database\Database;

require_once("../config/config.php");
spl_autoload_register(function ($className) {

    $newClassName = str_replace('\\', "/", $className);
    if (stripos($newClassName, 'App/',) === 0) {
        $newClassName = substr($newClassName, 4);
    }
    $path = "../src/{$newClassName}.php";

    if (file_exists($path)) {
        require_once($path);
    }
});

$front_controller = new FrontController();
$front_controller->run();

$database = new Database($CoreParams['Database']['Host'], $CoreParams['Database']['Username'], $CoreParams['Database']['Password'], $CoreParams['Database']['Database']);
$database->connect();


//$query = new QueryBuilder();

/*SELECT*/
/*$query->select(["title", "text"])
    ->from('news')
    ->where(["id" => 5]);
$rows = $database->execute($query);*/


/*INSERT*/
/*$query->insert(
    [
        [
            "title" => 'title',
            "text" => "check3",
            "date" => "2023-01-12"
        ],
        [
            "title" => 'title',
            "text" => "check4",
            "date" => "2023-01-12"
        ]
    ]
)->into("news");
$database->execute($query);
echo $query->getSql();*/

/*UPDATE*/
/*$query->update("news")->set([
    'title'=>'update_title',
    'text'=>'update_text'
])->where([
    'id'=>1
]);
$database->execute($query);
echo $query->getSql();*/

/*DELETE*/
/*$query->delete("news")->where([
    'id'=>1
]);
$database->execute($query);
echo $query->getSql();*/

/*LEFT JOIN SELECT*/
/*$query->select(["title", "text", "user_id","comment"])
    ->from('news')
    ->left_join("comments", "id","news_id")
    ->where(['news_id'=>6]);
$rows = $database->execute($query);
var_dump($rows);
echo $query->getSql();*/

/*LEFT JOIN and RIGHT JOIN SELECT*/
/*$query->select([ "user_id","first_name","middle_name","last_name","comment","title", "text",])
    ->from('comments')
    ->left_join("news", "news_id","id")
    ->right_join("users","user_id","id");
$rows = $database->execute($query);
var_dump($rows);
echo $query->getSql();*/


$CoreParams['Database'] = [
    "Host" => "172.22.75.8",
    "Username" => "student",
    "Password" => "root",
    "Database" => "cms"
];










