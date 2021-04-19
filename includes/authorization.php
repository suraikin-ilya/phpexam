<?php
require 'db_connection.php';
$pass = filter_var (trim($_POST['pass']),
    FILTER_SANITIZE_STRING);
$link = mysqli_connect("127.0.0.1", "root", "", "phpexam");
$result = $link->query("SELECT * FROM `users` WHERE `pass`= '$pass'");
$user = $result->fetch_assoc();
if(count($user)==0){
    echo "Пользователь не найден";
    exit();
}
setcookie('user', $user['login'], time() + 3600, "/");
header('Location: .././admin.php');