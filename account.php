<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentstvo";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php"); // Перенаправляем на страницу авторизации, если пользователь не вошёл в систему
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['id_user'];

// Получаем данные о пользователе
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id_user = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();

// Получаем последний забронированный тур пользователя
$stmt = $conn->prepare("SELECT t.name as tour_name FROM booking b JOIN tours t ON b.id_tour = t.id_tour WHERE id_user = ? ORDER BY booking_date DESC LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$bookingData = $result->fetch_assoc();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="./src/scss/style.css">
</head>
<body>
    <header class="header-2">
         <div class="container">
             <nav class="menoy">
                <img src="./src/image/Ресурс 5 1.png" alt="" class="logo">
                 <ul class="list">
                     <a href="./main.php" class="link">Главная</a>
                     <a href="./tours.html" class="link">Все туры</a>
                     <a href="./bron.php" class="link">Бронь</a>
                     <a href="./account.php" class="link">Личный кабинет</a>
                     <a href="" class="link">8 (901) 365 99 05</a>
                 </ul>
                 <h2 class="title-2">Личный Кабинет</h2>
             </nav>
         </div>
    </header>
    
    <section class="account-info">
        <h2 class="account-title">Информация о пользователе</h2>
        <p class="account-name">Имя: <?php echo $userData['name']; ?></p>
        <p class="account-name">Email: <?php echo $userData['email']; ?></p>
        <?php if(isset($bookingData['tour_name'])): ?>
            <p class="account-name">Забронированный тур: <?php echo $bookingData['tour_name']; ?></p>
        <?php else: ?>
            <p class="account-name">Нет забронированных туров</p>
        <?php endif; ?>
    </section>

    <section class="footer">
        <div class="container">
            <div class="footer-cont">
                <img src="./src/image/Слой 1.png" alt="" class="logo-footer">
                <div class="footer-menoy-cont">
                    <ul class="footer-menoy">
                        <a href="./main.html" class="footer-item">Главная</a>
                        <a href="./tours.html" class="footer-item">Все туры</a>
                        <a href="./bron.php" class="footer-item">Бронь</a>
                        <a href="./account.php" class="footer-item">Личный кабинет</a>
                    </ul>
                </div>
                <img src="./src/image/Media.png" alt="" class="social">
            </div>
        </div>
    </section>
</body>
</html>
