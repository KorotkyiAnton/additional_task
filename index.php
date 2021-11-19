<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planner</title>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <main>
        <div class="block_menu">
            <form class="add_notes" action="index.php" method="post">
                <textarea class="note_text" placeholder="Добавь запись" name="note_text"></textarea><br>
                <input class="add_note" type="submit" value="Добавить запись">
            </form>
            <a href="index.php?id='show'">Показать записи</a>
        </div>
        <?php
            include "db_conf.php";
            if(!$connection){
                echo 'connection lost';
                exit();
            }
            if(isset($_COOKIE['login'])){
                $login = $_COOKIE['login'];
            }
            $text =
            $result = mysqli_query($connection, "INSERT INTO articles (photo, `title`, `text`, categorie_id) VALUES ('$photo_dir', '$title', '$HTML_CONTENT', '$cat_id')");
        ?>
    </main>
</body>
</html>
