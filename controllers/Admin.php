<?php

namespace Controllers;

use Models\DBSingleton;
use PDO;

class Admin extends CustomerController
{
    public function registration($login, $password)
    {
        if(isset($_COOKIE["userLogin"])) {
            $statement = $this->db->prepare("INSERT INTO users (login, password) VALUES (?, ?)");
            $statement->execute([$login, $password]);
        }
    }

    public function deleteUser()
    {
        if(isset($_POST["deleteUser"])) {
            $statement = $this->db->prepare("DELETE FROM users WHERE login=?");
            $statement->execute([$_POST["deleteUser"]]);
        }
    }
}