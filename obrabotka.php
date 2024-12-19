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

// Обработка добавления клиента
if (isset($_POST['add_client'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $connect->prepare("INSERT INTO Clients (name, email, phone, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $address);
    $stmt->execute();
    $stmt->close();

    header("Location: Client.php");
    exit();
}

// Обработка удаления клиента
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $connect->prepare("DELETE FROM Clients WHERE ID = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: Client.php");
    exit();
}

// Обработка редактирования клиента
if (isset($_POST['edit_client'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $connect->prepare("UPDATE Clients SET name = ?, email = ?, phone = ?, address = ? WHERE ID = ?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: Client.php");
    exit();
}

// Обработка добавления контракта
if (isset($_POST['add_contract'])) {
    $client_id = $_POST['client_id'];
    $service_id = $_POST['service_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $stmt = $connect->prepare("INSERT INTO Contracts (client_id, service_id, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $client_id, $service_id, $start_date, $end_date);
    $stmt->execute();
    $stmt->close();
}

// Обработка удаления контракта (если необходимо)
 if (isset($_GET['delete_contract_id'])) {
     $delete_contract_id = $_GET['delete_contract_id'];
     $stmt = $connect->prepare("DELETE FROM Contracts WHERE ID = ?");
     $stmt->bind_param("i", $delete_contract_id);
     $stmt->execute();
     $stmt->close();
     header("Location: Contracts.php");
     exit();
 }

$result = $connect->query("SELECT * FROM Clients");
$carsResult = $connect->query("SELECT ID, name, description, price FROM Services");
$cars = [];
if ($carsResult->num_rows > 0) {
    while ($car = $carsResult->fetch_assoc()) {
        $cars[] = $car;
    }
}

$connect->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица клиентов</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Таблица клиентов</h1>
</header>
<main>
    <table>
        <thead>
            <tr>
                <th>Имя</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Действия</th>
                <th>Добавить услугу</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr id="row-<?php echo $row['ID']; ?>" class="client-row">
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td>
                            <button class="button complete-button" onclick="completeRow(<?php echo $row['ID']; ?>)">Завершено</button>
                            <a href="?delete_id=<?php echo $row['ID']; ?>" class="button delete-button" onclick="return confirm('Вы уверены, что хотите удалить эту заявку?');">Удалить заявку</a>
                        </td>
                        <td>
                            <button class="button add-car-button" onclick="toggleServiceList(<?php echo $row['ID']; ?>)">Добавить услугу</button>
                            <div id="serviceList-<?php echo $row['ID']; ?>" class="service-list" style="display: none;">
                                <h3>Список услуг</h3>
                                <ul>
                                    <?php foreach ($cars as $car): ?>
                                        <li>
                                            <?php echo htmlspecialchars($car['name']); ?>
                                            <button onclick="selectService(<?php echo $row['ID']; ?>, <?php echo $car['ID']; ?>)">Выбрать</button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Нет данных для отображения</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div id="contractForm" style="display: none;">
        <h3>Добавить контракт</h3>
        <form method="POST">
            <input type="hidden" name="client_id" id="client_id">
            <input type="hidden" name="service_id" id="service_id">
            <p>Дата начала: <input type="date" name="start_date" required></p>
            <p>Дата окончания: <input type="date" name="end_date" required></p>
            <button type="submit" name="add_contract">Добавить контракт</button>
        </form>
    </div>
</main>
<script>
    function toggleServiceList(clientId) {
        var serviceList = document.getElementById('serviceList-' + clientId);
        serviceList.style.display = serviceList.style.display === 'none' ? 'block' : 'none';
    }
    function selectService(clientId, serviceId) {
        document.getElementById('client_id').value = clientId;
        document.getElementById('service_id').value = serviceId;
        document.getElementById('contractForm').style.display = 'block';
    }
    function completeRow(id) {
        var row = document.getElementById('row-' + id);
        row.classList.toggle('completed');
    }
</script>
</body>
</html>
<?php
$connect->close();
?>