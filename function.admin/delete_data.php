<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentstvo";
$db = new mysqli($servername, $username, $password, $dbname);

// Проверяем, есть ли ошибки подключения
if ($db->connect_error) {
    die('Ошибка подключения: '. $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Удаление пользователя
    if (isset($_POST['delete_user']) && isset($_POST['id_user'])) {
        $id_user = intval($_POST['id_user']);
        $delete_sql = "DELETE FROM users WHERE id_user =?";
        $stmt = $db->prepare($delete_sql);
        $stmt->bind_param("i", $id_user);
        
        if ($stmt->execute()) {
            echo 'Пользователь успешно удален';
        } else {
            echo 'Ошибка удаления пользователя: '. $db->error;
        }
    }

    // Удаление тура
    if (isset($_POST['delete_tour']) && isset($_POST['id_tour'])) {
        $id_tour = intval($_POST['id_tour']);
        $delete_sql = "DELETE FROM tours WHERE id_tour =?";
        $stmt = $db->prepare($delete_sql);
        $stmt->bind_param("i", $id_tour);
        
        if ($stmt->execute()) {
            echo 'Тур успешно удален';
        } else {
            echo 'Ошибка удаления тура: '. $db->error;
        }
    }

    // Удаление бронирования
    if (isset($_POST['delete_booking']) && isset($_POST['id_booking'])) {
        $id_booking = intval($_POST['id_booking']);
        $delete_sql = "DELETE FROM booking WHERE id_booking =?";
        $stmt = $db->prepare($delete_sql);
        $stmt->bind_param("i", $id_booking);
        
        if ($stmt->execute()) {
            echo 'Бронирование успешно удалено';
        } else {
            echo 'Ошибка удаления бронирования: '. $db->error;
        }
    }

    // Удаление страны
    if (isset($_POST['delete_country']) && isset($_POST['id_country'])) {
        $id_country = intval($_POST['id_country']);
        $delete_sql = "DELETE FROM country WHERE id_country =?";
        $stmt = $db->prepare($delete_sql);
        $stmt->bind_param("i", $id_country);
        
        if ($stmt->execute()) {
            echo 'Страна успешно удалена';
        } else {
            echo 'Ошибка удаления страны: '. $db->error;
        }
    }

    // Удаление типа тура
    if (isset($_POST['delete_TypeTour']) && isset($_POST['id_TypeTour'])) {
        $id_TypeTour = intval($_POST['id_TypeTour']);
        $delete_sql = "DELETE FROM TypeTours WHERE id_TypeTour =?";
        $stmt = $db->prepare($delete_sql);
        $stmt->bind_param("i", $id_TypeTour);
        
        if ($stmt->execute()) {
            echo 'Тип тура успешно удален';
        } else {
            echo 'Ошибка удаления типа тура: '. $db->error;
        }
    }
}

// Закрываем подключение к базе данных
$db->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Удалить данные</title>
</head>
<body>

<h2 class="title-fuction_admin">Удалить пользователя</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_user">ID пользователя:</label><br>
    <input type="number" id="id_user" name="id_user" required><br>
    <input type="submit" name="delete_user" value="Удалить">
</form>

<h2 class="title-fuction_admin">Удалить тур</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_tour">ID тура:</label><br>
    <input type="number" id="id_tour" name="id_tour" required><br>
    <input type="submit" name="delete_tour" value="Удалить">
</form>

<h2 class="title-fuction_admin">Удалить бронирование</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_booking">ID бронирования:</label><br>
    <input type="number" id="id_booking" name="id_booking" required><br>
    <input type="submit" name="delete_booking" value="Удалить">
</form>

<h2 class="title-fuction_admin">Удалить страну</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_country">ID страны:</label><br>
    <input type="number" id="id_country" name="id_country" required><br>
    <input type="submit" name="delete_country" value="Удалить">
</form>

<h2 class="title-fuction_admin">Удалить тип тура</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_TypeTour">ID типа тура:</label><br>
    <input type="number" id="id_TypeTour" name="id_TypeTour" required><br>
    <input type="submit" name="delete_TypeTour" value="Удалить">
</form>

</body>
</html>