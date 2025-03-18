<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
    <title>Страница авторизации</title>
</head>
<body>
    <?php 

    session_destroy();
    session_start();

    require_once('../config/link.php');

    if ((!empty($_POST) && isset($_POST))) {

        $login = mysqli_real_escape_string($link, $_POST['login']);
        $password = mysqli_real_escape_string($link, $_POST['password']);

        if ($login == "" || $password == "") {
            header("Location: index.php");
        }
        else if($login != "" && $password != "") {
            if ($login == "loem" && $password == "loh") {
                $_SESSION['role'] = 'admin';
                $_SESSION['username'] = 'loem';
                header("Location: admin.php");
            }
            else{
                $_SESSION['role'] = 'user';
                $_SESSION['username'] = $login;
                header("Location: user.php");
            }
        }
    }
    ?>
    <h1 class="text-center mt-5 mb-5 ">Авторизация</h1>
    <form action="" method="POST" class="authForm m-auto text-center">
        <label for="login">Логин</label><br>
        <input type="text" id="login" name="login"><br><br>
        <label for="login">Пароль</label><br>
        <input type="password" id="password" name="password"><br><br><br>
        <input class="mb-5" type="submit" id="button">
        <a class="text-center" href="main.php">Вернуться на главную</a>
    </form>

</body>
</html>