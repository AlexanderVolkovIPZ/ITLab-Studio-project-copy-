<?php
global $CoreParams;
require_once("../config/config.php");
spl_autoload_register(function ($className) {
    $path = "../src/{$className}.php";
    if (file_exists($path)) {
        require_once($path);
    }
});


$database = new Database($CoreParams['Database']['Host'], $CoreParams['Database']['Username'], $CoreParams['Database']['Password'], $CoreParams['Database']['Database']);
$database->connect();
$query = new QueryBuilder();

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
            "text" => "check1",
            "date" => "2023-01-12"
        ],
        [
            "title" => 'title',
            "text" => "check2",
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


$CoreParams['Database'] = [
    "Host" => "172.22.75.8",
    "Username" => "student",
    "Password" => "root",
    "Database" => "cms"
];










