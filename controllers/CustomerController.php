<?php

namespace Controllers;

use Models\DBSingleton;
use PDO;
use PDOStatement;

class CustomerController
{
    protected PDO $db;

    public function __construct()
    {
        DBSingleton::initiateDb();
        $this->db = DBSingleton::getDb();
    }

    public function allTasks($status): PDOStatement
    {
        $statement = $this->db->prepare("
            SELECT a.id, a.`text`, GROUP_CONCAT(a.`comment` SEPARATOR '<br>') AS `comment`, status, receiver_id, author_id, source FROM
            (SELECT records.id, `text`, '' as `comment`, `status`, receiver_id, author_id, source FROM records
            UNION
            SELECT records.id, `text`, `comment`, `status`, receiver_id, records.author_id, source FROM records INNER JOIN comments ON records.id = id_record) as a
            INNER JOIN users ON (a.receiver_id = users.id OR a.author_id = users.id)
            WHERE ? AND login = ?
            GROUP BY a.id
            ORDER BY a.id DESC
        ");
        $statement->execute([$status, $_COOKIE["userLogin"]]);
        return $statement;
    }

    public function statusTask($status): PDOStatement
    {
        $statement = $this->db->prepare("
            SELECT a.id, a.`text`, GROUP_CONCAT(a.`comment` SEPARATOR '<br>') AS `comment`, status, receiver_id, author_id, source FROM
            (SELECT records.id, `text`, '' as `comment`, `status`, receiver_id, author_id, source FROM records
            UNION
            SELECT records.id, `text`, `comment`, `status`, receiver_id, records.author_id, source FROM records INNER JOIN comments ON records.id = id_record) as a
            INNER JOIN users ON (a.receiver_id = users.id OR a.author_id = users.id)
            WHERE `status` = ? AND login = ?
            GROUP BY a.id
            ORDER BY a.id DESC
        ");
        $statement->execute([$status, $_COOKIE["userLogin"]]);
        return $statement;
    }

    public function showTask(int $id): PDOStatement
    {
        $statement = $this->db->prepare("
            SELECT a.id, a.`text`, GROUP_CONCAT(a.`comment` SEPARATOR '<br>') AS `comment`, status, receiver_id, author_id, source FROM
            (SELECT records.id, `text`, '' as `comment`, `status`, receiver_id, author_id, source FROM records
            UNION
            SELECT records.id, `text`, `comment`, `status`, receiver_id, records.author_id, source FROM records INNER JOIN comments ON records.id = id_record) as a
            INNER JOIN users ON (a.receiver_id = users.id OR a.author_id = users.id)
            WHERE a.`id` = ? AND login = ?
        ");
        $statement->execute([$id, $_COOKIE["userLogin"]]);
        return $statement;
    }

    public function userList(): PDOStatement
    {
        return $this->db->query("SELECT DISTINCT login FROM users WHERE login != 'Admin'");
    }
}