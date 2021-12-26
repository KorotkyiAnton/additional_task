<?php

namespace Routing;

use Controllers\Admin;
use Controllers\User;
use Views\View;

final class FactoryRouting
{
    static public function Routing($id)
    {
        $user = new User();
        $admin = new Admin();

        switch ($id) {
            case "add_task":
                if(isset($_COOKIE["userLogin"])) {
                    View::addTask($user->userList());
                    if (isset($_POST["note_text"])) {
                        $user->addTask();
                    }
                }
                break;

            case "all_tasks":
                if(isset($_COOKIE["userLogin"])) {
                    $tasks = $user->allTasks(1);
                    View::tasks($tasks);
                }
                break;

            case "in_progress":
                if(isset($_COOKIE["userLogin"])) {
                    $tasks = $user->statusTask("inProgress");
                    View::tasks($tasks);
                }
                break;

            case "stopped":
                if(isset($_COOKIE["userLogin"])) {
                    $tasks = $user->statusTask("stopped");
                    View::tasks($tasks);
                }
                break;

            case "done":
                if(isset($_COOKIE["userLogin"])) {
                    $tasks = $user->statusTask("done");
                    View::tasks($tasks);
                }
                break;

            case "updateStatus":
                if(isset($_COOKIE["userLogin"])) {
                    $user->updateStatus($_GET["status"], $_GET["id"]);
                    $tasks = $user->allTasks(1);
                    View::tasks($tasks);
                }
                break;

            case "deleteTask":
                if(isset($_COOKIE["userLogin"])) {
                    $user->deleteTask($_GET["id"]);
                    $tasks = $user->allTasks(1);
                    View::tasks($tasks);
                }
                break;

            case "rewriteTask":
                if(isset($_COOKIE["userLogin"])) {
                    $text = $user->showTask($_GET["id"]);
                    View::rewrite($text);
                    if (isset($_POST["note_text"])) {
                        $user->rewriteTask(htmlspecialchars($_POST["note_text"], ENT_QUOTES), $_GET["id"]);
                    }
                    if (isset($_POST["update"])) {
                        $user->commentTask(htmlspecialchars($_POST["update"], ENT_QUOTES), $_GET["id"]);
                    }
                }
                break;

            case "login":
                if(isset($_POST["login"]) && isset($_POST["password"])) {
                    $user->login($_POST["login"], $_POST["password"]);
                }
                View::authorization();
                break;

            case "register":
                if(isset($_POST["login"]) && isset($_POST["password"])) {
                    $admin->registration($_POST["login"], password_hash($_POST["password"], PASSWORD_DEFAULT));
                }
                View::authorization();
                break;

            case "logout":
                if(isset($_COOKIE["userLogin"])) {
                    $user->logout();
                    $tasks = $user->allTasks(1);
                    View::tasks($tasks);
                }
                break;

            case "deleteUser":
                $admin->deleteUser();
                View::deleteUser($user->userList());
                break;
        }
    }
}