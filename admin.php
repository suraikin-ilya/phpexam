<?php
require "includes/db_connection.php";
if (isset($_GET['logout'])) {
    setcookie('user', $user['login'], time() - 3600, "/");
    header('Location: admin.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Экспертная сессия</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body class="text-center">
<?php
if($_COOKIE['user']== ''):
?>
<main class="form-signin">
    <form method="post" action="includes/authorization.php">
        <h1 class="h3 mb-3 fw-normal">Админ панель</h1>
        <div class="form-floating">
            <input type="password" class="form-control" name="pass" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
</main>
<?php else: ?>
    <div class="container">
    <a href="admin.php?logout" class=" btn btn-lg btn-primary w100">Выйти</a>
    <h1 >Панель администратора</h1>
    </div>
    <?php
    $result = mysqli_query($link,'SELECT session_link, theme, session_status FROM sessions');
    echo '<h3> Актуальные сессии: </h3>';
    echo '<div class="list"> <ol>';
    while ($row = mysqli_fetch_array($result)){
        echo'
                    <li><div class=""><h6>' . $row['theme'] .'   '.  ': <a href="//'.$_SERVER['SERVER_NAME'].'/?link='.$row['session_link'].'">' . $_SERVER['SERVER_NAME'] . '/?link=' . $row['session_link'] .
            '</a> <a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?status=edit&id=' . $row['session_link'] . '" class="editLink">[Редактировать]</a>'.
            '<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?action=delete&id=' . $row['session_link'] . '" class="editLink">[Удалить]</a>' .
            ( ($row['session_status'] == 'active')
                ?'<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?action=deactivate&id=' . $row['session_link'] . '" class="editLink">[Закрыть]</a>'
                :'<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?action=activate&id=' . $row['session_link'] . '" class="editLink">[Открыть]</a>') .
            '<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?status=analyze&id=' . $row['session_link'] . '" class="editLink">[Ответы]</a>' .
            '</h6></div></li>';
    }
    echo '</ol> </div>';
    ?>
<?php endif; ?>

</body>
</html>