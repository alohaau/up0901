<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentstvo";

if (!isset($_SESSION['id_user'])) {
    echo "Ошибка: Необходимо авторизоваться";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION['id_user'];
    $tour = $_POST['selectvalue'];
    $date = $_POST['launch_date'];
    $kolvo = intval($_POST['selectvalue-humans']);

    // Проверка, что дата выбрана
    if ($date == "") {
        echo "Ошибка: Не выбрана дата";
        exit;
    }

    // Преобразование формата даты
    $formattedDate = date_create_from_format('Y-m-d', $date);
    if ($formattedDate) {
        $formattedDateString = $formattedDate->format('Y-m-d');

        $stmt = $conn->prepare("SELECT id_tour, price FROM tours WHERE name = ?");
        $stmt->bind_param("s", $tour);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_tour = $row['id_tour'];
            $price = $row['price'];

            $total_cost = $price * $kolvo; //умножаем цену тура на количество человек, которые поедут в тур

            $current_date = date('Y-m-d');

            if ($formattedDateString < $current_date) {
                echo "Ошибка: нельзя выбрать прошедшую дату";
            } else {
                $stmt = $conn->prepare("INSERT INTO booking (id_user, id_tour, booking_date, kolvo, total_cost) VALUES (?,?,?,?,?)");
                $stmt->bind_param("iissi", $userId, $id_tour, $formattedDateString, $kolvo, $total_cost);
                $stmt->execute();

                if ($stmt->errno) {
                    echo "Ошибка в запросе: " . $stmt->error;
                } else {
                    $stmt = $conn->prepare("UPDATE tours SET available_seats = available_seats - ? WHERE id_tour = ?");
                    $stmt->bind_param("ii", $kolvo, $id_tour);
                    $stmt->execute();

                    echo "Вы забронировали тур, поздравляем!";
                }
            }
        } else {
            echo "Ошибка: Тур не найден";
        }
    } else {
        echo "Ошибка: Неправильный формат даты";
    }

    $conn->close();
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTours</title>
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
                <h2 class="title-2">Бронь</h2>
            </nav>
        </div>
    </header>

    <section class="bron">
        <div class="container">
            <div class="bron-cont">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <div class="place-cont">
                        <p class="place-text">Выберите тур:</p>
                        <select name="selectvalue" id="selectvalue">
                            <option>Дагестан</option>
                            <option>Алтай</option>
                            <option>Кавказ 1</option>
                            <option>Кавказ 2</option>
                            <option>Турция 1</option>
                            <option>Турция 2</option>
                            <option>ОАЭ 1</option>
                            <option>ОАЭ 2</option>
                            <option>Сербия 1</option>
                            <option>Сербия 2</option>
                            <option>Египет 1</option>
                            <option>Египет 2</option>
                        </select>
                        <img src="./src/image/map 1.png" alt="">
                    </div>

                    <div class="time-cont">
                        <p class="time-text">Дата:</p>
                        <input type="date" name="launch_date" value=""/>
                    </div>

                    <div class="humans-cont">
    <p class="place-text">Людей:</p>
    <select name="selectvalue-humans" id="selectvalue-humans">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
        <option>6</option>
        <option>7</option>
    </select>
    <img src="./src/image/k.lb.png" alt="" class="human">
</div>

<input type="submit" class="bron-button" value="Забронировать">
</form>
</div>
</div>
</section>

<section class="footer">
<div class="container">
    <div class="footer-cont">
        <img src="./src/image/Слой 1.png" alt="" class="logo-footer">
        <div class="footer-menoy-cont">
            <ul class="footer-menoy">
                <a href="./main.php" class="footer-item">Главная</a>
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