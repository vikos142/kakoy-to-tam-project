<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Охранные услуги</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Охранные услуги ООО ЧОП "БЕРКУТ"</h1>
        </header>
        <main>
            <h2>Наши услуги</h2>
            <table>
                <thead>
                    <tr>
                        <th>Название услуги</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Заказать</th>
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
                $result = $connect->query("SELECT * FROM Services");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['description']) . "</td>
                                <td>" . htmlspecialchars($row['price']) . " руб.</td>
                                <td>
                                    <form method='POST' action='order.php'>
                                        <input type='hidden' name='service_id' value='" . $row['ID'] . "'>
                                        <button type='submit' class='btn'>Заказать</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Нет доступных услуг</td></tr>";
                }
                $connect->close();
                ?>
            </tbody>
        </table>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> ООО ЧОП "БЕРКУТ". Все права защищены.</p>
        </footer>
    </div>
</body>
</html>