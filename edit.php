<?php
require "includes/db_connection.php";
require "includes/header.php";
    $result = mysqli_query($link, 'SELECT theme, questions FROM `sessions` WHERE session_link = "' . $_GET['id'] . '"');
    $result = mysqli_fetch_array($result);
    $theme = $result['theme'];
    $questions = json_decode($result['questions']);
    echo'   <body class="text-center">
            <h1>Изменение сессии</h1></br>
            <form method="post">
            <label for="theme">Название сессии</label>
            <input type="text" id="theme" name="theme" value="'.$theme.'" class="form-control mlr"></br>
            <label for="count_questions" >Количество вопросов в сессии</label>
            <br>
            ';
    if(!$_POST['count_questions']){
        echo '<input class="form-control mlrs" type="number" id="count_questions" name="count_questions" value="'.count($questions).'">
                    </br>
                    <input type="submit" value="Выбрать" class="button_margin btn btn-secondary my-2">';
    } else {
        echo '<input type="number" id="count_questions" name="count_questions" value="'.$_POST['count_questions'].'">
                    </br>';
    }
    if($_POST['theme']){
        echo '<h2>'.$_POST['theme'].'</h2>';
    }
    $selectedArray = Array();
    if($_POST['count_questions'] && !$_POST['theme0']){
        for ($i = 0; $i < count($questions); $i++) {
            echo '
                <label for="theme' . $i . '">Вопрос №' . ($i+1) . '</label>
                <select name="theme' . $i . '" id="theme' . $i . '" value="'.$_POST['theme'.$i].'" class="form-control mlr">
                    <option value="number"'; if(($questions[$i] -> type)=='number'){echo 'selected'; $selectedArray[$i]='number';}echo '>Число</option>
                    <option value="positive_number"'; if(($questions[$i] -> type)=='positive_number'){echo 'selected'; $selectedArray[$i]='positive_number';}echo '>Положительно число</option>
                    <option value="small_text"'; if(($questions[$i] -> type)=='small_text'){echo 'selected'; $selectedArray[$i]='small_text';}echo '>строка</option>
                    <option value="big_text"'; if(($questions[$i] -> type)=='big_text'){echo 'selected'; $selectedArray[$i]='big_text';}echo '>текст</option>
                    <option value="radio"'; if(($questions[$i] -> type)=='radio'){echo 'selected'; $selectedArray[$i]='radio';}echo '>С единственным выбором</option>
                    <option value="checkbox"'; if(($questions[$i] -> type)=='checkbox'){echo 'selected'; $selectedArray[$i]='checkbox';}echo '>С множественным выбором</option>
                </select>
                <br><br>
                '; }
        for ($i = count($questions); $i < $_POST['count_questions']; $i++) {
            echo '
                <label for="theme' . $i . '">Вопрос №' . ($i+1) . '</label>
                <select name="theme' . $i . '" id="theme' . $i . '" value="'.$_POST['theme'.$i].'" class="form-control mlr">
                    <option value="number"'; if($_POST['theme'.$i]=='number'){echo 'selected'; $selectedArray[$i]='number';}echo '>Число</option>
                    <option value="positive_number"'; if($_POST['theme'.$i]=='positive_number'){echo 'selected'; $selectedArray[$i]='positive_number';}echo '>Положительно число</option>
                    <option value="small_text"'; if($_POST['theme'.$i]=='small_text'){echo 'selected'; $selectedArray[$i]='small_text';}echo '>строка</option>
                    <option value="big_text"'; if($_POST['theme'.$i]=='big_text'){echo 'selected'; $selectedArray[$i]='big_text';}echo '>текст</option>
                    <option value="radio"'; if($_POST['theme'.$i]=='radio'){echo 'selected'; $selectedArray[$i]='radio';}echo '>С единственным выбором</option>
                    <option value="checkbox"'; if($_POST['theme'.$i]=='checkbox'){echo 'selected'; $selectedArray[$i]='checkbox';}echo '>С множественным выбором</option>
                </select>
                <br><br>
                '; }
        echo '<input type="submit" value="Выбрать типы вопросов" class="button_margin btn btn-secondary my-2">';

    }
    if($_POST['count_questions'] && $_POST['theme0']){
        for ($i = 0; $i < $_POST['count_questions']; $i++) {
            echo '
                <label for="theme' . $i . '">Вопрос №' . ($i+1) . '</label>
                <select name="theme' . $i . '" id="theme' . $i . '" value="'.$_POST['theme'.$i].'" class="form-control mlr">
                    <option value="number"'; if($_POST['theme'.$i]=='number'){echo 'selected'; array_push($selectedArray,'number');}echo '>Число</option>
                    <option value="positive_number"'; if($_POST['theme'.$i]=='positive_number'){echo 'selected'; array_push($selectedArray,'number');}echo '>Положительно число</option>
                    <option value="small_text"'; if($_POST['theme'.$i]=='small_text'){echo 'selected'; array_push($selectedArray,'number');}echo '>строка</option>
                    <option value="big_text"'; if($_POST['theme'.$i]=='big_text'){echo 'selected'; array_push($selectedArray,'number');}echo '>текст</option>
                    <option value="radio"'; if($_POST['theme'.$i]=='radio'){echo 'selected'; array_push($selectedArray,'number');}echo '>С единственным выбором</option>
                    <option value="checkbox"'; if($_POST['theme'.$i]=='checkbox'){echo 'selected'; array_push($selectedArray,'number');}echo '>С множественным выбором</option>
                </select>
                <br><br>
                '; }
        for ($i = 0; $i < count($questions); $i++){
            echo '<label for="question'.$i.'">Вопрос№' . ($i+1) . ': </label>
                             <input class="form-control mlr" type="text" id="question'.$i.'"  name="question'.$i.'" value="'.($questions[$i] -> question).'" required>';
            if($_POST['theme'.$i]=='radio'||$_POST['theme'.$i]=='checkbox'){
                echo '<label for="options'.$i.'">Варианты(через ","): </label>
                             <input class="form-control mlr" type="text" id="options'.$i.'" name="options'.$i.'" value="'.
                    ($questions[$i]->options).'" required>';
            }
            echo '<label for="answer'.$i.'">Ответ: </label>
                             <input class="form-control mlr" type="text" id="answer'.$i.'" name="answer'.$i.'" value="'.($questions[$i] -> answer).'" required><br><br>';
        }
        for ($i = count($questions); $i < $_POST['count_questions']; $i++){
            echo '<label for="question'.$i.'">Вопрос№' . ($i+1) . ': </label>
                            <input class="form-control mlr" type="text" id="question'.$i.'"  name="question'.$i.'"required>';
            if($_POST['theme'.$i]=='radio'||$_POST['theme'.$i]=='checkbox'){
                echo '<label for="options'.$i.'">Варианты ответов(Перечислите через ","): </label>
                            <input class="form-control mlr" type="text" id="options'.$i.'" name="options'.$i.'" required>';
            }
            echo '<label for="answer'.$i.'">Ответ:</label>
                            <input class="form-control mlr" type="text" id="answer'.$i.'" name="answer'.$i.'" required><br><br>';
        }
        echo '
                <label for="session_link">Ссылка:&nbsp;</label><input name="session_link" id="session_link" type="text" placeholder="Имя сессии" value="'.$_GET['id'].'">
                <input type="submit" value="Обновить сессию" class="btn btn-primary btn-lg btn-block button_margin ">';
    }
    echo '</form>'.'<body class="text-center">';

    $questions=Array();
    $session_link = $_POST['session_link'];
    for ($i = 0; $i < $_POST['count_questions']; $i++){
        $questions[$i]['type']=$_POST['theme'.$i];
        $questions[$i]['question']=$_POST['question'.$i];
        $questions[$i]['options']=$_POST['options'.$i];
        $questions[$i]['answer']=$_POST['answer'.$i];
    }
    $questions = json_encode($questions, JSON_UNESCAPED_UNICODE);
    $theme = $_POST['theme'];
    // mysqli_query($link, "UPDATE `sessions` SET session_link = '$session_link' WHERE session_link='$session_link'") or die("Ошибка " . mysqli_error($link));
    $questions_query="UPDATE `sessions` SET session_status = 'active', theme='$theme', questions='$questions'
                        WHERE session_link='$session_link'";
    $result = mysqli_query($link, $questions_query) or die("Ошибка " . mysqli_error($link));
    if($result){
        echo '<a href="admin.php" class="btn btn-primary btn-lg btn-block button_margin">На главную</a>';
        $success = 1;
    }
    unset($_POST);