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


    // Обновление пользователя
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //кнопка в форме html должна иметь name как в примере "update_user" иначе работать не будет
        if (isset($_POST['update_user']) && isset($_POST['id_user']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
            $id_user = intval($_POST['id_user']);
    $name = $db->real_escape_string($_POST['name']);
    $surname = $db->real_escape_string($_POST['surname']);
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);
    $role = intval($_POST['role']);

    // проверка всех полей
    if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($role)) {
        // Prepare the SQL statement
        $update_sql = "UPDATE users SET name=?, surname=?, email=?, password=?, role=? WHERE id_user=?";
        $stmt = $db->prepare($update_sql);

        //параметры полей 
        $stmt->bind_param("ssssii", $name, $surname, $email, $password, $role, $id_user);

        
        if ($stmt->execute()) {
            echo 'Данные пользователя успешно обновлены';
        } else {
            echo 'Ошибка обновления данных пользователя: '. $db->error;
        }
    } else {
        echo 'Пожалуйста, заполните все поля формы для пользователя.';
    }
        }
    
        
        //обновление туров
        if (isset($_POST['update_tour']) && isset($_POST['id_tour']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['id_country']) && isset($_POST['id_TypeTour']) && isset($_POST['available_seats'])) {
            $id_tour = intval($_POST['id_tour']);
            $tour_name = $db->real_escape_string($_POST['name']);
            $tour_price = isset($_POST['price']) ? floatval($_POST['price']) : 0; 
            $id_country = $_POST["id_country"];
            $id_TypeTour = $_POST["id_TypeTour"];
            $available_seats = $_POST["available_seats"];
    
            if (!empty($tour_name) && !empty($tour_price) && !empty($id_country) && !empty($id_TypeTour) && !empty($available_seats)) {
                $update_tour_sql = "UPDATE tours SET name=?, price=?, id_country=?, id_TypeTour=?, available_seats=? WHERE id_tour=?";
                $stmt = $db->prepare($update_tour_sql);
                $stmt->bind_param("sdiiii", $tour_name, $tour_price, $id_country, $id_TypeTour, $available_seats, $id_tour);
    
                if ($stmt->execute()) {
                    echo 'Тур успешно обновлен';
                } else {
                    echo 'Ошибка обновления тура: '. $db->error;
                }
            } else {
                echo 'Пожалуйста, заполните все поля формы для тура.';
            }
        }


    // Обновление бронирования
    if (isset($_POST['update_booking']) && isset($_POST['id_booking']) && isset($_POST['booking_date']) && isset($_POST['id_user']) && isset($_POST['id_tour']) && isset($_POST['kolvo'])) {
        $id_booking = intval($_POST['id_booking']);
        $booking_date = $db->real_escape_string($_POST['booking_date']);
        $id_user = $db->real_escape_string($_POST['id_user']);
        $id_tour = $db->real_escape_string($_POST['id_tour']);
        $kolvo = $_POST['kolvo'];
    
        if (!empty($booking_date) && !empty($id_user) && !empty($id_tour) && !empty($kolvo) && is_numeric($kolvo) && $kolvo > 0) {
            $get_tour_sql = "SELECT price FROM tours WHERE id_tour = $id_tour";
            $result = $db->query($get_tour_sql);
    
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $tour_price = $row['price'];
    
                $update_booking_sql = "UPDATE booking SET booking_date=?, id_user=?, id_tour=?, kolvo=?, total_cost=? WHERE id_booking=?";
                $stmt = $db->prepare($update_booking_sql);
                $total_cost = $kolvo * $tour_price; //умножаем количество чел на цену тура за олного чела
                $stmt->bind_param("siiidi", $booking_date, $id_user, $id_tour, $kolvo, $total_cost, $id_booking);
    
                if ($stmt->execute()) {
                    echo 'Бронирование успешно обновлено';
                } else {
                    echo 'Ошибка обновления бронирования: '. $db->error;
                }
            } else {
                echo 'Тур с указанным ID не найден';
            }
    
        } else {
            echo 'Пожалуйста, заполните все поля формы для бронирования или укажите корректное количество человек в брони.';
        }
    }

    // Обновление страны
    if (isset($_POST['update_country']) && isset($_POST['id_country']) && isset($_POST['name'])) {
        $id_country = intval($_POST['id_country']);
        $name = $db->real_escape_string($_POST['name']);
        
        if (!empty($name)) {
            $update_sql = "UPDATE country SET name=? WHERE id_country=?";
            $stmt = $db->prepare($update_sql);
            $stmt->bind_param("si", $name, $id_country);
            
            if ($stmt->execute()) {
                echo 'Страна успешно обновлена';
            } else {
                echo 'Ошибка обновления страны: '. $db->error;
            }
        } else {
            echo 'Пожалуйста, заполните все поля';
        }
    }

    // Обновление типа тура
    if (isset($_POST['update_type']) && isset($_POST['id_type']) && isset($_POST['type'])) {
        $id_type = intval($_POST['id_type']);
        $type = $db->real_escape_string($_POST['type']);
        
        if (!empty($type)) {
            $update_sql = "UPDATE TypeTours SET type=? WHERE id_type=?";
            $stmt = $db->prepare($update_sql);
            $stmt->bind_param("si", $type, $id_type);
            
            if ($stmt->execute()) {
                echo 'Тип тура успешно обновлен';
            } else {
                echo 'Ошибка обновления типа тура: '. $db->error;
            }
        } else {
            echo 'Пожалуйста, заполните все поля';
        }
    }
}

// Закрываем подключение к базе данных
$db->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Обновить данные</title>
</head>
<body>

<h2>Обновить пользователя</h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_user">ID пользователя:</label><br>
    <input type="number" id="id_user" name="id_user" required><br>
    <label for="name">Имя:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="surname">Фамилия:</label><br>
    <input type="text" id="surname" name="surname" required><br>
    <label for="email">Почта:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Пароль:</label><br>
    <input type="password" id="password" name="password" required><br>
    <label for="role">Роль:</label><br>
    <input type="number" id="role" name="role" required><br>
    <input type="submit" name="update_user" value="Обновить пользователя"> 
</form>

<h2>Обновить тур</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_tour">ID тура:</label><br>
    <input type="number" id="id_tour" name="id_tour" required><br>
    <label for="name">Название:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="price">Цена:</label><br>
    <input type="price" id="price" name="price" required><br>
    <label for="id_country">id страны</label>
    <input type="number" name="id_country" id="id_country"><br>
    <label for="id_TypeTour">id типа тура</label>
    <input type="number" name="id_TypeTour" id="id_TypeTour"><br>
    <label for="available_seats">Мест</label>
    <input type="number" name="available_seats" id="available_seats"><br>
    <input type="submit" name="update_tour" value="Обновить тур">
</form>

<h2>Обновить бронирование</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_booking">ID бронирования:</label><br>
    <input type="number" id="id_booking" name="id_booking" required><br>
    <label for="booking_date">Дата бронирования:</label><br>
    <input type="date" id="booking_date" name="booking_date" required><br>
    <label for="id_user">ID пользователя:</label><br>
    <input type="number" id="id_user" name="id_user" required><br>
    <label for="id_tour">ID тура:</label><br>
    <input type="number" id="id_tour" name="id_tour" required><br>
    <label for="kolvo">Количество человек в брони:</label><br>
    <input type="number" id="kolvo" name="kolvo" required><br>
    <input type="submit" name="update_booking" value="Обновить бронирование">
</form>

<h2>Обновить страну</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_country">ID страны:</label><br>
    <input type="number" id="id_country" name="id_country" required><br>
    <label for="name">Страна:</label><br>
    <input type="text" id="name" name="name" required><br>
    <input type="submit" name="update_country" value="Обновить страну">
</form>

<h2>Обновить тип тура</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="id_type">ID типа тура:</label><br>
    <input type="number" id="id_type" name="id_type" required><br>
    <label for="type">Тип тура:</label><br>
    <input type="text" id="type" name="type" required><br>
    <input type="submit" name="update_type" value="Обновить тип тура">
</form>

</body>
</html>