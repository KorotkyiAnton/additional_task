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
            <form class="add_notes" action="index.php" method="post">
                <textarea class="note_text" placeholder="Добавь запись" name="note_text"></textarea><br>
                <input class="add_note" type="submit" value="Добавить запись">
            </form>
        </div>
        <?php
            include "db_conf.php";
            if(!$connection){
                echo 'connection lost';
                exit();
            }
            if (!empty($_POST)){
                $text = htmlspecialchars($_POST['note_text'], ENT_QUOTES);
                if(!empty($text)){
                    $result = mysqli_query($connection, "INSERT INTO records (`text`) VALUES ('$text')");
                }
            }
        ?>
    </main>
</body>
</html>
