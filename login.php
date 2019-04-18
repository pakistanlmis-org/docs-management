<?php

require_once 'classes/users.php';

$users = new users();
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = $_POST['username'];
    $users->username = $username;
}
if (isset($_POST['password']) && !empty($_POST['password'])) {
    $password = $_POST['password'];
    $users->password = $password;
}

if ($users->login()) {
    header("location:files.php");
} else {
    header("location:index.php");
}
die();