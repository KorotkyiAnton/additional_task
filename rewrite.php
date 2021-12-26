<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planner</title>
    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="script.js"></script>
</head>
<body>
<main id="main">
    <div class="main_menu" id="main_menu" style="display: none">
        <a href="records.php">Все задания</a>
        <a href="records.php?rec_st=inProgress">Исполняемые</a>
        <a href="records.php?rec_st=stopped">Приостановленные</a>
        <a href="records.php?rec_st=done">Завершенные</a>
        <a href="index.php">Добавить задание</a>
    </div>

    <?php
    include "db_conf.php";
    if(!$connection){
        echo 'connection lost';
        exit();
    }

    $request = mysqli_query($connection, "SELECT id, text, additional_text FROM records WHERE id=".(int)$_GET['id']);
    if(!$request){
        echo 'request lost';
        exit();
    }
    $record = $request->fetch_assoc();
    ?>

    <div class="block_main" id="block_main">
        <form class="add_notes" action="rewrite.php?id=<?php echo $record['id']?>" method="post">
            <textarea class="note_text" placeholder="Добавь запись" name="note_text"><?php echo htmlspecialchars_decode($record['text']) ?></textarea><br>
            <textarea class="update" placeholder="Добавь комментарий" name="update"></textarea><br>
            <input class="add_note" type="submit" value="Добавить запись">
        </form>
    </div>
    <?php
    if (!empty($_POST)){
        $text = htmlspecialchars($_POST['note_text'], ENT_QUOTES);
        $update = $record['additional_text'].
            "<hr> Update: ".
            htmlspecialchars($_POST['update'], ENT_QUOTES);
        if(!empty($text)){
            $result = mysqli_query($connection, "UPDATE records SET text='$text' WHERE id=".(int)$_GET['id']);
            header("Location:records.php");
        }
        if ($update!="<hr> Update: "){
            $result = mysqli_query($connection, "UPDATE records SET additional_text='$update' WHERE id=".(int)$_GET['id']);
            header("Location:records.php");
        }
    }
    mysqli_close($connection);
    ?>
</main>
</body>
</html>

