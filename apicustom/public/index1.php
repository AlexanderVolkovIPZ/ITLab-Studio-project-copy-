

<?php
$pdo = new PDO("mysql:host=172.22.75.8;dbname=cms","student", "root");
date_default_timezone_set('Europe/Kiev');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $text = $_POST['text'];
    $date = date('Y-m-d H:i:s');
    $pdo->query("INSERT INTO news (title, text, date ) VALUES ('{$text}','{$title}', '{$date}')");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <div>Title</div>
    <div>
        <input type="text" name="title">
    </div>
    <div>Text</div>
    <div>
        <textarea name="text" id="" cols="30" rows="10" placeholder="Введіть текст">

        </textarea>
    </div>
    <button>
        Відправити
    </button>

</form>

<div>
    <h1>NEW LIST</h1>
    <table>
        <?php
        $count_records_on_page = 5;
        $count_records = $pdo->query("SELECT count(*) FROM news")->fetch()[0];
        $count_page = ceil($count_records/$count_records_on_page);
        $offset = 0;
        if(isset($_GET['page'])){
            $offset = (intval($_GET['page'])-1)* $count_records_on_page;

        }
        $sth_page = $pdo->query("SELECT * FROM news LIMIT {$offset},{$count_records_on_page}");
        while($row=$sth_page->fetch()):?>
            <tr>
                <td><?=$row['title']?></td>
                <td><?=$row['text']?></td>
                <td><?=$row['date']?></td>
            </tr>
        <?php endwhile;?>

    </table>
    <div style="margin-top: 10px; font-size: 30px;">
        <?php
        for ($i = 1;$i<=$count_page;$i++):?>
            <a href="?page=<?=$i?>"><?=$i?></a>
        <?php endfor;?>
    </div>
</div>
</body>
</html>



