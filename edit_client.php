<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование клиента</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Редактирование клиента</h1>
    </header>
    <main>
        <?php
        $servername = "localhost";
        $username = "root"; 
        $password = "";   
        $dbname = "p_bd";
        $connect = new mysqli($servername, $username, $password, $dbname);
        
        if ($connect->connect_error) {
            die("Ошибка подключения: " . $connect->connect_error);
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $connect->prepare("SELECT * FROM Clients WHERE ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $client = $result->fetch_assoc();
            $stmt->close();
        }
        ?>
        <form method="POST" action="obrabotka.php">
            <input type="hidden" name="id" value="<?php echo $client['ID']; ?>">
            <div class="input-box">
                <input type="text" name="name" value="<?php echo htmlspecialchars($client['name']); ?>" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
            </div>
            <div class="input-box">
                <input type="text" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required>
            </div>
            <div class="input-box">
                <input type="text" name="address" value="<?php echo htmlspecialchars($client['address']); ?>" required>
            </div>
            <button type="submit" name="edit_client" class="btn">Сохранить изменения</button>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> ООО ЧОП "БЕРКУТ". Все права защищены.</p>
    </footer>
</body>
</html>