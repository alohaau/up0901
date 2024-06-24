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
    // Добавление нового пользователя
    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
        $name = $db->real_escape_string($_POST['name']);
        $surname = $db->real_escape_string($_POST['surname']);
        $email = $db->real_escape_string($_POST['email']);
        $password = $db->real_escape_string($_POST['password']);
        $role = intval($_POST['role']);
        
        if (!empty($name) && !empty($surname) && !empty($email) && !empty($password)) {
            $check_sql = "SELECT * FROM users WHERE email='$email'";
            $check_result = $db->query($check_sql);

            if ($check_result->num_rows > 0) {
                echo 'Пользователь с таким email уже существует';
            } else {
                $insert_sql = "INSERT INTO users (name, surname, email, password, role) VALUES (?, ?, ?, ?, ?)";
                $stmt = $db->prepare($insert_sql);
                $stmt->bind_param("ssssi", $name, $surname, $email, $password, $role);
                
                if ($stmt->execute()) {
                    echo 'Данные пользователя успешно добавлены';
                } else {
                    echo 'Ошибка добавления данных пользователя: '. $db->error;
                }
            }
        } else {
            echo 'Пожалуйста, заполните все поля формы для пользователя.';
        }
    }

    // Добавление нового тура
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['id_country']) && isset($_POST['id_TypeTour']) && isset($_POST['available_seats'])) {
        $tour_name = $db->real_escape_string($_POST['name']);
        $tour_price = isset($_POST['price']) ? floatval($_POST['price']) : 0; 
        $id_country = $_POST["id_country"];
        $id_TypeTour = $_POST["id_TypeTour"];
        $available_seats = $_POST["available_seats"];

        if (!empty($tour_name) && !empty($tour_price) && !empty($id_country) && !empty($id_TypeTour) && !empty($available_seats)) {
            $check_tour_sql = "SELECT * FROM tours WHERE name='$tour_name'";
            $check_tour_result = $db->query($check_tour_sql);

            if ($check_tour_result->num_rows > 0) {
                echo 'Тур с таким названием уже существует';
            } else {
                $insert_tour_sql = "INSERT INTO tours (name, price, id_country, id_TypeTour, available_seats) VALUES (?, ?, ?, ?, ?)";
                $stmt = $db->prepare($insert_tour_sql);
                $stmt->bind_param("sdiii", $tour_name, $tour_price, $id_country, $id_TypeTour, $available_seats);
                
                if ($stmt->execute()) {
                    echo 'Новый тур успешно добавлен';
                } else {
                    echo 'Ошибка добавления тура: '. $db->error;
                }
            }
        } else {
            echo 'Пожалуйста, заполните все поля формы для тура.';
        }
    }


     // Добавление нового бронирования        
     if (isset($_POST['booking_date']) && isset($_POST['id_user']) && isset($_POST['id_tour']) && isset($_POST['kolvo'])) {
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
    
                $insert_booking_sql = "INSERT INTO booking (booking_date, id_user, id_tour, kolvo, total_cost) VALUES (?, ?, ?, ?, ?)";
                $stmt = $db->prepare($insert_booking_sql);
                $total_cost = $kolvo * $tour_price;
    
                $stmt->bind_param("siiid", $booking_date, $id_user, $id_tour, $kolvo, $total_cost);
    
                if ($stmt->execute()) {
                    echo 'Новое бронирование успешно добавлено';
                    header("location: ./add_data.php");
                } else {
                    echo 'Ошибка добавления бронирования: ' . $db->error;
                }
            } else {
                echo 'Тур с указанным ID не найден';
            }
    
        } else {
            echo 'Пожалуйста, заполните все поля формы для бронирования или укажите корректное количество человек в брони.';
        }
    }

    //добавление новой страны
    if (isset($_POST['name'])) {
        $name = $db->real_escape_string($_POST['name']);
        
        if (!empty($name)) {
            $check_sql = "SELECT * FROM country WHERE name='$name'";
            $check_result = $db->query($check_sql);

            if ($check_result->num_rows > 0) {
                echo 'Такая страна уже есть в базе данных';
            } else {
                $insert_sql = "INSERT INTO country (name) VALUES (?)";
                $stmt = $db->prepare($insert_sql);
                $stmt->bind_param("s", $name);
                
                if ($stmt->execute()) {
                    echo 'Страна успешно добавлена';
                } else {
                    echo 'Ошибка добавления страны: '. $db->error;
                }
            }
        } else {
            echo 'Пожалуйста, заполните все поля';
        }
    }

//добавление нового типа тура
    if (isset($_POST['type'])) {
        $type = $db->real_escape_string($_POST['type']);
        
        if (!empty($type)) {
            $check_sql = "SELECT * FROM TypeTours WHERE type='$type'";
            $check_result = $db->query($check_sql);

            if ($check_result->num_rows > 0) {
                echo 'Такой тип тура уже есть';
            } else {
                $insert_sql = "INSERT INTO TypeTours (type) VALUES (?)";
                $stmt = $db->prepare($insert_sql);
                $stmt->bind_param("s", $type);
                
                if ($stmt->execute()) {
                    echo 'Тип тура добавлен';
                } else {
                    echo 'Ошибка добавления типа тура: '. $db->error;
                }
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
    <title>Добавить данные</title>
</head>
<body>


<section class="add">
    <div class="container">
        <h2 class="title-fuction_admin">Добавить пользователя</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <label for="name">Имя:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="surname">Фамилия:</label><br>
            <input type="surname" id="surname" name="surname" required><br>
            <label for="email">Почта:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="role">Роль:</label><br>
            <input type="number" id="role" name="role" required><br>
            <input type="submit" value="Добавить">
        </form>
    </div>

</section>


<h2 class="title-fuction_admin">Добавить тур</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="name">Название:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="price">Цена:</label><br>
    <input type="price" id="price" name="price" required><br>
    <label for="id_country">id страны</label>
    <input type="number" name="id_country" id="id_country">
    <label for="id_TypeTour">id типа тура</label>
    <input type="number" name="id_TypeTour" id="id_TypeTour">
    <label for="available_seats">Мест</label>
    <input type="number" name="available_seats" id="available_seats">
    <input type="submit" value="Добавить">
</form>

<h2 class="title-fuction_admin">Добавить бронирование</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="booking_date">Дата бронирования:</label><br>
    <input type="date" id="booking_date" name="booking_date" required><br>
    <label for="id_user">ID пользователя:</label><br>
    <input type="number" id="id_user" name="id_user" required><br>
    <label for="id_tour">ID тура:</label><br>
    <input type="number" id="id_tour" name="id_tour" required><br>
    <label for="kolvo">Количество человек в брони:</label><br>
    <input type="number" id="kolvo" name="kolvo" required><br>
    <input type="submit" value="Добавить бронь">
</form>

<h2 class="title-fuction_admin">Добавить страну</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="name">Страна:</label><br>
    <input type="text" id="name" name="name" required><br>
    <input type="submit" value="Добавить">
</form>


<h2 class="title-fuction_admin">Добавить тип тура</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="type">Тип тура:</label><br>
    <input type="text" id="type" name="type" required><br>
    <input type="submit" value="Добавить">
</form>


</body>
</html>