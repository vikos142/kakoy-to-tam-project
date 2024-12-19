<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h1>Войти</h1>
            <div class="input-box">
                <input type="text" name="login" placeholder="Логин" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Пароль" required>
            </div>
            <div class="remember">
                <label for=""> <input type="checkbox" name="remember" id="remember">Запомнить меня </label>
            </div>
            <button type="submit" class="btn">Войти</button>
            <div class="register-link">
                <p>Нет аккаунта? <a href="reg.php">Регистрация</a></p>
            </div>
        </form>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $servername = "localhost";
            $username = "root";
            $db_password = "";
            $dbname = "p_bd";
            $connect = mysqli_connect($servername, $username, $db_password, $dbname);
            if (!$connect) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $stmt = $connect->prepare("SELECT * FROM users WHERE login = ?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if (password_verify($password, $user_data['password'])) {
                    if (isset($_POST['remember'])) {
                        setcookie('user_ID', $user_data['ID'], time() + (30 * 24 * 60 * 60), "/");
                        setcookie('Role', $user_data['Role'], time() + (30 * 24 * 60 * 60), "/");
                    }
                    switch ($user_data['Role']) {
                        case 'client':
                            header("Location: Glavnoe.php");
                            exit();
                        default:
                            echo "<p style='color: red;'>Неизвестная роль пользователя.</p>";
                            break;
                    }
                } else {
                    echo "<p style='color: red;'>Неверный пароль.</p>";
                }
            } else {
                echo "<p style='color: red;'>Пользователь не найден.</p>";
            }
            mysqli_close($connect);
        }
        ?>
    </div>
</body>
</html>