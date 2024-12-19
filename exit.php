<?php
// Удаление куки
setcookie('user_ID', '', time() - 3600, "/");
setcookie('Role', '', time() - 3600, "/");
// Перенаправление на страницу входа
header("Location: index.php");
exit();
?>