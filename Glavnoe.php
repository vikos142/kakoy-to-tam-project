<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО ЧОП "БЕРКУТ"</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Добро пожаловать в ООО ЧОП "БЕРКУТ"</h1>
        <nav>
            <ul>
                <li><a href="reg.php">Регистрация клиента</a></li>
                <li><a href="index.php">Вход</a></li>
                <li><a href="Glavnoe.php">Главная</a></li>
                <li><a href="Services.php">Охранные услуги</a></li>
                <li><a href="Client.php">Отправить заказ услуги</a></li>
                <li><a href="exit.php">Выход</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Наши охранные услуги</h2>
        <p>ООО "ЧОП БЕРКУТ" - ваш надежный партнер в сфере безопасности!</p>
        <h3>Наши услуги:</h3>
        <ul>
            <li>Физическая охрана объектов</li>
            <li>Монтаж и обслуживание систем видеонаблюдения</li>
            <li>Консультации по вопросам безопасности</li>
            <li>Охрана мероприятий</li>
            <li>Сопровождение грузов</li>
        </ul>
        <div class="contact-info">
            <h3>Контакты:</h3>
            <p>Адрес: г. Белово, ул. Примерная, д. 1</p>
            <p>Телефон: +7 (999) 666-22-87</p>
            <p>E-mail: <a href="mailto:info@berkut.ru">info@berkut.ru</a></p>
            <p>Сайт: <a href="http://www.berkut.ru" target="_blank">www.berkut.ru</a></p>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> ООО ЧОП "БЕРКУТ". Все права защищены.</p>
    </footer>
</body>
</html>