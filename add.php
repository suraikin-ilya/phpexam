<?php
require "includes/db_connection.php";


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP exam</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body class="text-center">
<?php
    echo '
<div class="card-">
    <h3>Добавление новой сессии</h3></br>
    <form method="post">
        <label for="theme" >Название сессии</label>
        <br>
        <input type="text" id="theme" name="theme" value="' . $_POST['theme'] . '" class="form-control mlr"></br>
        <label for="count_questions">Количество вопросов в сессии</label>
        <br>
        <input type="number" id="count_questions" name="count_questions" value="' . $_POST['count_questions'].'" class="form-control mlr"></hr>
</div>';
if(!$_POST['count_questions']){
echo '<input type="submit" value="Добавить" class="button_margin btn btn-secondary my-2">';
;
}
if($_POST['theme']){
echo '<h2>Название сессии '.$_POST['theme'].'</h2>';
}
for ($i = 0; $i < $_POST['count_questions']; $i++) {
echo '
<label for="theme' . $i . '">Вопрос №' . ($i+1) . '</label>
<select name="theme' . $i . '" id="theme' . $i . '" value="'.$_POST['theme'.$i].'">
    <option value="number"'; if($_POST['theme'.$i]=='number')echo 'selected';echo '>Число</option>
    <option value="positive_number"'; if($_POST['theme'.$i]=='positive_number')echo 'selected';echo '>Положительно число</option>
    <option value="small_text"'; if($_POST['theme'.$i]=='small_text')echo 'selected';echo '>строка</option>
    <option value="big_text"'; if($_POST['theme'.$i]=='big_text')echo 'selected';echo '>текст</option>
    <option value="radio"'; if($_POST['theme'.$i]=='radio')echo 'selected';echo '>С единственным выбором</option>
    <option value="checkbox"'; if($_POST['theme'.$i]=='checkbox')echo 'selected';echo '>С множественным выбором</option>
</select>
<br><br>
'; }
if($_POST['count_questions'] && !$_POST['theme0']){
echo '<input type="submit" value="Выбрать типы вопросов" class="button_margin btn btn-secondary my-2">';
}
if($_POST['count_questions'] && $_POST['theme0']) {
    for ($i = 0; $i < $_POST['count_questions']; $i++) {
        echo '<label for="question' . $i . '">Вопрос №' . ($i + 1) . ': </label>
<input type="text" class="form-control mlrb" id="question' . $i . '"  name="question' . $i . '"required>';
        if ($_POST['theme' . $i] == 'radio' || $_POST['theme' . $i] == 'checkbox') {
            echo '<label for="options' . $i . '">Варианты ответов: </label>
<input type="text" class="form-control mlrb" id="options' . $i . '" name="options' . $i . '" required>';
        }
        echo '<label for="answer' . $i . '">Ответ: </label>
<input type="text" class="form-control mlrb" id="answer' . $i . '" name="answer' . $i . '" required><br><br>';
    }
    echo '
<label for="session_link">Ссылка на сессию</label> <input class="form-control mlrb" name="session_link" id="session_link" type="text">
<input type="submit" value="Создать сессию" class="btn btn-primary btn-lg btn-block button_margin" >';
}
echo '</form>';
if($_POST['question0']) {
    if (empty($_POST['session_link'])) {
        $session_link = bin2hex(random_bytes(5));
    } else {
        $session_link = $_POST['session_link'];
    }
    $questions = array();
    for ($i = 0; $i < $_POST['count_questions']; $i++) {
        $questions[$i]['type'] = $_POST['theme' . $i];
        $questions[$i]['question'] = $_POST['question' . $i];
        $questions[$i]['options'] = $_POST['options' . $i];
        $questions[$i]['answer'] = $_POST['answer' . $i];
    }
    $questions = json_encode($questions, JSON_UNESCAPED_UNICODE);
    $theme = $_POST['theme'];
    $questions_query = "INSERT INTO `sessions` (session_link, session_status, theme, questions)
            VALUES ('$session_link', 'active', '$theme', '$questions')";
    $result = mysqli_query($link, $questions_query) or die("Ошибка " . mysqli_error($link));
    if($result){
        echo '<a href="admin.php" class="btn btn-primary btn-lg btn-block button_margin">На главную</a>';
        $success = 1;
    }
    unset($_POST);
    header('location: admin.php');
}
?>
</body>
