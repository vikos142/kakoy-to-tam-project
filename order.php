<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; 
$password = "";   
$dbname = "p_bd";

$connect = new mysqli($servername, $username, $password, $dbname);
if ($connect->connect_error) {
    die("Ошибка подключения: " . $connect->connect_error);
}

// Обработка заказа услуги
if (isset($_POST['service_id'])) {
    $service_id = $_POST['service_id'];

    // Здесь вы можете добавить дополнительную информацию о заказе, например, имя клиента, контактные данные и т.д.
    // Например, вы можете использовать форму для ввода данных клиента.
    
    // Пример простого заказа без дополнительных данных
    $stmt = $connect->prepare("INSERT INTO Orders (service_id) VALUES (?)");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $stmt->close();

    echo "Заказ на услугу успешно отправлен!";
} else {
    echo "Ошибка: Не указана услуга.";
}

$connect->close();
?>