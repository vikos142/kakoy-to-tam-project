<!DOCTYPE html>
<html lang="ru">
<?php
$servername = "localhost";
$username = "root"; 
$password = "";   
$dbname = "p_bd";
$connect = new mysqli($servername, $username, $password, $dbname);
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $Role = $_POST['Role'];
    $login = $connect->real_escape_string($login);
    $Role = $connect->real_escape_string($Role);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO `users`(`Role`, `login`, `password`) VALUES ('$Role','$login','$hashed_password')";
    $result = mysqli_query($connect, $query);
    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color: red;'>Ошибка: " . $connect->error . "</p>";
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="wrapper">
        <form action="" method="POST">
            <input type="hidden" name="action" value="add">
            <h1>Регистрация</h1>
            <div class="input-box">
                <select id="Role" name="Role" required>
                    <option value="client">Клиент</option>
                </select>
            </div>
            <div class="input-box">  
                <input type="text" name="login" placeholder="Логин" required> 
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Пароль" required>
            </div>
            <div class="input-box">
                <input type="password" id="confirm-password" placeholder="Повторить пароль" required> 
            </div>
            <button type="submit" class="btn">Регистрация</button>
        </form>
    </div>
</body>
</html>