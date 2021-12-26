<?php

use Routing\FactoryRouting;

require_once __DIR__ . "/../vendor/autoload.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planner</title>
    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="script.js"></script>
</head>
<body>
<main id="main">
    <div class="main_menu" id="main_menu" <?php if(isset($_COOKIE["userLogin"])) { ?>style="display: none"<?php } ?>>
        <a href="index.php?page=all_tasks">Все задания</a>
        <a href="index.php?page=in_progress">Исполняемые</a>
        <a href="index.php?page=stopped">Приостановленные</a>
        <a href="index.php?page=done">Завершенные</a>
        <a href="index.php?page=add_task">Добавить задание</a>
        <div class="bottom_menu">
            <?php if(isset($_COOKIE["userLogin"])){?>
            <a href="index.php?page=logout">Выйти из аккаунта</a>
            <?php } else {?>
            <a href="index.php?page=login">Войти в аккаунт</a>
            <?php }
            if(isset($_COOKIE["userLogin"]) && $_COOKIE["userLogin"]=="Admin") {?>
            <a href="index.php?page=register">Регистрация аккаунта</a>
            <a href="index.php?page=deleteUser">Удаление аккаунта</a>
            <?php } ?>
        </div>
    </div>

    <?php
    if (isset($_GET["page"])) {
        FactoryRouting::Routing($_GET["page"]);
    }
    ?>
</main>
</body>
</html>
