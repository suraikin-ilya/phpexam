<?php
require "includes/db_connection.php";
require "includes/header.php";
    echo '<a href="admin.php" class="btn btn-primary btn-lg btn-block button_margin mlr mb-3 mt-3">На главную</a>';
    if($_GET['id']){
    $session_link = $_GET['id'];
    echo "<h1>Ответы сессии \"$session_link\"</h1><hr>";
    $result = mysqli_query($link, 'SELECT answers FROM `answers` WHERE session_link = "' . $session_link . '"');
    $users = Array();
    while($row = mysqli_fetch_array($result)){
        array_push($users, json_decode($row['answers'], true));
    }
    $result = mysqli_query($link, "SELECT questions FROM sessions WHERE session_link = '$session_link'");
    if (!$result) die();
    $questions = json_decode(mysqli_fetch_array($result)[0], true);
    $statsByAnswer = Array();
    for($j=0;$j<count($questions);$j++){
        $statsByAnswer[j] = 0;
    }
    for($i=0;$i<count($users);$i++){
        for($j=0;$j<count($questions);$j++){
            $statsByAnswer[$j] += $questions[$j]['answer']==$users[$i][$j]['answer'];
        }
    }
    for ($j=0;$j<count($questions);$j++) {
        $trueAnswer = $questions[$j]['answer'];
        $question = $questions[$j]['question'];
        echo "<h3> $question </h3>";
        echo "Процент правильных ответов: " . floor(count($users) > 0 ? $statsByAnswer[$j]/count($users)*100  : "-"). "%" . "<br>";
        echo "Количество правильных ответов: " . $statsByAnswer[$j] . "<br>";
        echo "Количество ответов: " . count($users) . "<br>";
        echo "<h5> Правильный ответ: " . $trueAnswer . "<h5>";
        echo "<hr>";
        echo "<br><br>";
    }
}
