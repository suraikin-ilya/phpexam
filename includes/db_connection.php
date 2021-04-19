<?php
$link = mysqli_connect("127.0.0.1", "root", "", "phpexam")
or die("Ошибка " . mysqli_error($link));
mysqli_set_charset($link, "utf8");
$_SERVER['SERVER_NAME'] = 'localhost:63342/phpexam';