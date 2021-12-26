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

    <div class="block_main" id="block_main">
        <?php
        include "db_conf.php";
        if(!$connection){
            echo 'connection lost';
            exit();
        }

        if(isset($_GET["rec_st"])) {
            $rec_st = $_GET["rec_st"];
            $request = mysqli_query($connection, "SELECT id, text, additional_text FROM records WHERE status = '$rec_st' ORDER BY id DESC");
        } else{
            $request = mysqli_query($connection, "SELECT id, text, additional_text FROM records ORDER BY id DESC");
        }


        if(!$request){
            echo 'request lost';
            exit();
        }

        while ($row = $request->fetch_assoc()){?>
        <div class="record_area" ondblclick="displayOptions()">
            <div class="records">
                <?php echo htmlspecialchars_decode($row['text']); ?>
                <hr>
                <?php echo htmlspecialchars_decode($row['additional_text']); ?>
            </div>
            <div class="options" style="display: none">
                <a class="op_menu" href="rewrite.php?id=<?php echo $row['id']?>">🖊</a>
                <a class="op_menu" href="rewrite.php?id=<?php echo $row['id']?>">💬</a>
                <a class="op_menu" href="records.php?status=inProgress&id=<?php echo $row['id']?>">🞂</a>
                <a class="op_menu" href="records.php?status=stopped&id=<?php echo $row['id']?>">⏸</a>
                <a class="op_menu" href="records.php?status=done&id=<?php echo $row['id']?>">✓</a>
                <a class="op_menu" href="records.php?status=deleted&id=<?php echo $row['id']?>">🗑</a>
            </div>
        </div>
        <?php }
            if(isset($_GET["status"])){
                $status = $_GET["status"];
                switch ($_GET["status"]){
                    case "inProgress":
                        $result = mysqli_query($connection, "UPDATE records SET status='$status' WHERE id=".(int)$_GET['id']);
                        break;
                    case "stopped":
                        $result = mysqli_query($connection, "UPDATE records SET status='$status' WHERE id=".(int)$_GET['id']);
                        break;
                    case "done":
                        $result = mysqli_query($connection, "UPDATE records SET status='$status' WHERE id=".(int)$_GET['id']);
                        break;
                    case "deleted":
                        $result = mysqli_query($connection, "DELETE FROM records WHERE id=".(int)$_GET['id']);
                        break;
                }
            }
        ?>
    </div>
</main>
</body>
</html>
