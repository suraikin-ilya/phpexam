<?php
require "includes/db_connection.php";
if (isset($_GET['logout'])) {
    setcookie('user', $user['login'], time() - 3600, "/");
    header('Location: admin.php');
}
require "includes/header.php";
?>
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
        <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
    </form>
</main>
<?php else: ?>
    <div class="container">
    <a href="admin.php?logout" class=" btn btn-lg btn-primary w100">Выйти</a>
    <h1 >Панель администратора</h1>
    </div>
    <?php
    if($_GET['action'] == 'delete' and !empty($_GET['id'])) {
        $result = mysqli_query($link, 'DELETE FROM `sessions` WHERE session_link = "' . $_GET['id'] . '"');
        if (!$result) die("Ошибка");
    }
    if($_GET['action'] == 'open' and !empty($_GET['id'])) {
        $session_link = $_GET['id'];
        $result = mysqli_query($link, "UPDATE `sessions` SET session_status = 'active' WHERE session_link='$session_link'");
        if (!$result) die("Ошибка");
    }
    if($_GET['action'] == 'close' and !empty($_GET['id'])) {
        $session_link = $_GET['id'];
        $result = mysqli_query($link, "UPDATE `sessions` SET session_status = 'inactive' WHERE session_link='$session_link'");
        if (!$result) die("Ошибка");
    }
    ?>
    <?php
    $result = mysqli_query($link,'SELECT session_link, theme, session_status FROM sessions');
    echo '<h3> Актуальные сессии: </h3>';
    echo '<div class="list"> <ol>';
    while ($row = mysqli_fetch_array($result)){
        echo'
                    <li><div class="">
                    <h6>' . $row['theme'] .'   '.  ': 
                    <a href="//'.$_SERVER['SERVER_NAME'].'/?link='.$row['session_link'].'">' . $_SERVER['SERVER_NAME'] . '/?link=' . $row['session_link'] . '</a> 
                    <a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?status=edit&id=' . $row['session_link'] . '" class="editLink">Редактировать</a>'.
            '<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?action=delete&id=' . $row['session_link'] . '" class="editLink">Удалить</a>' .
            ( ($row['session_status'] == 'active')
                ?'<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?action=close&id=' . $row['session_link'] . '" class="editLink">Закрыть</a>'
                :'<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?action=open&id=' . $row['session_link'] . '" class="editLink">Открыть</a>') .
            '<a href="//' . $_SERVER['SERVER_NAME'] .'/admin.php?status=analyze&id=' . $row['session_link'] . '" class="editLink">Ответы</a>' .
            '</h6></div></li>';
    }
    echo '</ol> </div>';
    ?>
    <a href="add.php" class="btn btn-lg btn-block btn-outline-primary ">Добавить сессию</a>
<?php endif; ?>

</body>
</html>