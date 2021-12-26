<?php

namespace Controllers;

use Models\DBSingleton;
use PDO;
use PDOStatement;

class User extends CustomerController
{
    public function addTask()
    {
        $text = htmlspecialchars($_POST['note_text'], ENT_QUOTES);
        $source = "";
        if ($_COOKIE["userLogin"] != $_POST["user"]) {
            $text = "(From {$_COOKIE['userLogin']}. To {$_POST['user']}) " . $text;
        }

        if (isset($_FILES)) {
            foreach ($_FILES as $file) {
                move_uploaded_file($file['tmp_name'], __DIR__ . "/../uploaded/" . $file['name']);
                $source = __DIR__ . "/uploaded/" . $file['name'];
            }
        }

        if (!empty($text)) {
            $statement = $this->db->prepare("SELECT id FROM users WHERE login=?");
            $statement->execute([$_POST["user"]]);
            $receiver_id = $statement->fetch()["id"];
            $statement = $this->db->prepare("SELECT id FROM users WHERE login=?");
            $statement->execute([$_COOKIE["userLogin"]]);
            $author_id = $statement->fetch()["id"];
            $statement = $this->db->prepare("INSERT INTO records (`text`, receiver_id, author_id, source) VALUES (?, ?, ?, ?); ");
            $statement->execute([$text, $receiver_id, $author_id, $source]);
        }
    }

    public function updateStatus(string $status, int $id): void
    {
        $statement = $this->db->prepare("UPDATE records SET status=? WHERE id=?");
        $statement->execute([$status, $id]);
    }

    public function deleteTask(int $id): void
    {
        $statement = $this->db->prepare("SELECT `id` FROM users WHERE login = ?");
        $statement->execute([$_COOKIE["userLogin"]]);
        $author_id = $statement->fetch()["id"];
        $statement = $this->db->prepare("DELETE FROM comments WHERE id_record=? AND author_id=?; DELETE FROM records WHERE id=? AND author_id=?");
        $statement->execute([$id, $author_id, $id, $author_id]);
    }

    public function rewriteTask(string $text, int $id)
    {
        $statement = $this->db->prepare("UPDATE records SET text=? WHERE id=?");
        $statement->execute([$text, $id]);
        header("Location:index.php?page=all_tasks");
    }

    public function commentTask(string $text, int $id)
    {
        if (!empty($text)) {
            $text = "Update ({$_COOKIE['userLogin']}): " . $text . "<br>";
            $statement = $this->db->prepare("SELECT id FROM users WHERE login=?");
            $statement->execute([$_COOKIE["userLogin"]]);
            $author_id = $statement->fetch()["id"];
            $statement = $this->db->prepare("INSERT INTO comments (`comment`, id_record, author_id) VALUES (?, ?, ?)");
            $statement->execute([$text, $id, $author_id]);
            header("Location:index.php?page=all_tasks");
        }
    }

    public function login(string $login, string $password)
    {
        $statement = $this->db->prepare("SELECT login, password FROM users WHERE login = ?");
        $statement->execute([$login]);
        $profile = $statement->fetch();
        if (password_verify($password, $profile["password"])) {
            setcookie("userLogin", $login);
            $statement = $this->db->prepare("UPDATE users SET session=1 WHERE login=?");
            $statement->execute([$login]);
        }
        header("Location:index.php?page=all_tasks");
    }

    public function logout()
    {
        if (isset($_COOKIE["userLogin"])) {
            setcookie("userLogin", 0, time() - 1);
            $statement = $this->db->prepare("UPDATE users SET session=0 WHERE login=?");
            $statement->execute([$_COOKIE["userLogin"]]);
        }
       header("Location:index.php?page=all_tasks");
    }
}