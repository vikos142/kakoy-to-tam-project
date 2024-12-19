<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Клиенты</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Клиенты ООО ЧОП "БЕРКУТ"</h1>
    </header>
    <main>
        <h2>Добавить нового клиента</h2>
        <form method="POST" action="obrabotka.php">
            <div class="input-box">
                <input type="text" name="name" placeholder="Имя клиента" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                <input type="text" name="phone" placeholder="Телефон" required>
            </div>
            <div class="input-box">
                <input type="text" name="address" placeholder="Адрес" required>
            </div>
            <button type="submit" name="add_client" class="btn">Добавить клиента</button>
        </form>

        <h2>Список клиентов</h2>
        <table>
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root"; 
                $password = "";   
                $dbname = "p_bd";
                $connect = new mysqli($servername, $username, $password, $dbname);
                
                if ($connect->connect_error) {
                    die("Ошибка подключения: " . $connect->connect_error);
                }

                $result = $connect->query("SELECT * FROM Clients");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['address']) . "</td>
                                <td>
                                    <a href='obrabotka.php?delete_id=" . $row['ID'] . "' onclick=\"return confirm('Вы уверены, что хотите удалить этого клиента?');\">Удалить</a>
                                    <a href='edit_client.php?id=" . $row['ID'] . "'>Редактировать</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Нет клиентов для отображения</td></tr>";
                }

                $connect->close();
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> ООО ЧОП "БЕРКУТ". Все права защищены.</p>
    </footer>
</body>
</html>