<?php

//Подключение к бд и сессии юзера
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentstvo";
$conn = new mysqli($servername, $username, $password, $dbname);

if(!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}


?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTours</title>
    <link rel="stylesheet" href="./src/scss/style.css">
    <link rel="icon" href="./src/image/Ресурс 5 1.png" type="image/icon type">
</head>
<body>
    <header class="header">
                <div class="container">
                    <nav class="menoy">
                    <img src="./src/image/Ресурс 5 1.png" alt="" class="logo">
                    <ul class="list">
                    <?php
                // Показывает меню админа если роль = 1 (админ)
                if($_SESSION['user_role'] == 1) {
                    echo "<li><a href='admin_panel.php' class='link'>Admin Panel</a></li>";
                    echo "<li><a href='./main.php' class='link'>Главная</a></li>";
                    echo "<li><a href='./tours.html' class='link'>Все туры</a></li>";
                    echo "<li><a href='./bron.php' class='link'>Бронь</a></li>";
                    echo "<li><a href='./account.php' class='link'>Личный кабинет</a></li>";
                    echo "<li><a href='' class='link'>8 (901) 365 99 05</a></li>";

                    //показывает меню обычного юзера, если роль не админская
                } else {
                    echo "<li><a href='./main.php' class='link'>Главная</a></li>";
                    echo "<li><a href='./tours.html' class='link'>Все туры</a></li>";
                    echo "<li><a href='./bron.php' class='link'>Бронь</a></li>";
                    echo "<li><a href='./account.php' class='link'>Личный кабинет</a></li>";
                    echo "<li><a href='' class='link'>8 (901) 365 99 05</a></li>";
                }
              ?>
            </ul>
                    </nav>

                    <div class="intro-cont">
                        <h2 class="intro-title">ПУТЕШЕСТВУЙ</h2>
                        <h2 class="intro-title2">ВМЕСТЕ С</h2>
                        <h2 class="intro-title3">Мои Туры</h2>
                    </div>
        </div>
    </header>

    <section class="popular">
        <div class="container">
            <h2 class="title">Популярные туры</h2>
            <div class="container-card">
                <div class="cont-card">
                    <div class="card1">
                        <h3 class="card-title">Тур по дагестану</h3>
                        <p class="card-text">4-5 дней<br>
                            Отель все включено<br>
                            Автобус<br>
                            20.000 рублей</p>
                            <a href="./bron.php" class="card-button">Забронировать</a>
                    </div>
                    <div class="card2">
                        <h3 class="card-title">Тур по алтаю</h3>
                        <p class="card-text">4-5 дней<br>
                            Отель все включено<br>
                            Автобус<br>
                            20.000 рублей</p>
                            <a href="./bron.php" class="card-button">Забронировать</a>
                    </div>
                </div>
    
                <div class="cont-card">
                    <div class="card3">
                        <h3 class="card-title">Тур по кавказу </h3>
                        <p class="card-text">5-6 дней<br>
                            Отель все включено<br>
                            Автобус, квадроциклы<br>
                            40.000 рублей</p>
                            <a href="./bron.php" class="card-button">Забронировать</a>
                    </div>
                    <div class="card4">
                        <h3 class="card-title">Тур по сербии</h3>
                        <p class="card-text">4-5 дней<br>
                            Отель все включено<br>
                            Автобус, машины<br>
                            43.000 рублей</p>
                            <a href="./bron.php" class="card-button">Забронировать</a>
                    </div>
    
                </div>

            </div>
        </div>
    </section>

    <section class="about">
        <div class="container">
                <div class="cont">
                    <img src="./src/image/rishabh-mathew-cCO7jv-dxbI-unsplash 1.png" alt="" class="about-img">
                    <div class="cont-about">
                        <h2 class="title-card">О нас</h2>
                        <p class="about-text">Наше туристическое агентство<br> 
                            предоставляет широкий выбор туров,<br> 
                            экскурсий, круизов и визовую поддержку<br> 
                            для путешественников.<br> 
                            Наша команда специалистов готова<br> 
                            помочь с выбором и организацией<br> 
                            путешествия для незабываемого опыта.</p>
                    </div>

                </div>
        </div>
    </section>


    <section class="uslugi">
        <div class="container">
            <h2 class="title">Виды услуг</h2>

            <div class="uslugi-cont">
                <div class="cont-uslugi">
                    <img src="./src/image/1.png" alt="" class="card-img">
                    <div class="card-uslugi">
                        <h3 class="uslugi-title">Туры</h3>
                        <p class="uslugi-text">Программа туров<br>
                            включает отель, много<br>
                            экскурсий и долгодневное<br>
                            пребывание.</p>
                    </div>
                </div>

                <div class="cont-uslugi">
                    <img src="./src/image/2.png" alt="" class="card-img">
                    <div class="card-uslugi">
                        <h3 class="uslugi-title">Экскурсии</h3>
                        <p class="uslugi-text">Экскурсии включают в себя<br>
                            посещение одного или нескольких<br>
                            мест в соответствии с программой.</p>
                    </div>
                </div>
            </div>

            <div class="uslugi-cont">
                <div class="cont-uslugi">
                    <img src="./src/image/3.png" alt="" class="card-img">
                    <div class="card-uslugi">
                        <h3 class="uslugi-title">Круизы</h3>
                        <p class="uslugi-text">Программа круизов<br>
                            включает в себя путешествие<br>
                            на судне, питание, выход на берег<br>
                            в соответствии с программой круиза.</p>
                    </div>
                </div>

                <div class="cont-uslugi-last">
                    <img src="./src/image/Group 170.png" alt="" class="card-img">
                    <div class="card-uslugi">
                        <h3 class="uslugi-title">Визовая помощь</h3>
                        <p class="uslugi-text">Визовая помощь подразумевает<br>
                            оказание информационных услуг клиенту<br>
                            для удовлетворения визовой программы<br>
                            страны.</p>
                    </div>
                </div>
            </div>
                
        </div>
    </section>


    <section class="galery">
        <div class="container">
            <h2 class="title">Галерея</h2>
            <div class="cont-galery">
                <div class="card-galery">
                        <img class="galery-img" src="./src/image/10.png">
                        <img class="galery-img" src="./src/image/6.png">
                        <img class="galery-img" src="./src/image/7.png">
                        <img class="galery-img" src="./src/image/5.png">
                        <img class="galery-img" src="./src/image/8.png">
                        <img class="galery-img" src="./src/image/9.png">
                </div>
            </div>
        </div>
    </section>

    <section class="reviews">
        <div class="container">
            <h2 class="title">Отзывы</h2>
            <div class="slider-cont">
                <div class="slide-container">
                    <div class="slider">
                        <img src="./src/image/Man vs_ Winter - Bangstyle 1.png" alt="" class="slider-img">
                        <div class="card-slider">
                            <h3 class="reviews-title">Максим Иванов</h3>
                            <p class="reviews-text">Мой тур по Дагестану с туристической<br>
                                компанией "Мои Туры" был просто<br> 
                                потрясающим! Благодаря им я<br> 
                                познакомился с красотами природы,<br> 
                                проникся в удивительную культуру и<br> 
                                приятно удивился гостеприимству<br> 
                                местных жителей. Рекомендую эту<br> 
                                компанию всем, кто ищет<br> 
                                захватывающие приключения и<br> 
                                незабываемые впечатления!</p>
                        </div>
                    </div>
                </div>
    
                <div class="slide-container">
                    <div class="slider">
                        <img src="./src/image/e12872da-41d4-431a-b8ac-b0cd7cfb17f3 1.png" alt="" class="slider-img">
                        <div class="card-slider">
                            <h3 class="reviews-title">Алексей Щукин</h3>
                            <p class="reviews-text">Мой тур по Дагестану с туристической<br>
                                компанией "Мои Туры" был просто<br> 
                                потрясающим! Благодаря им я<br> 
                                познакомился с красотами природы,<br> 
                                проникся в удивительную культуру и<br> 
                                приятно удивился гостеприимству<br> 
                                местных жителей. Рекомендую эту<br> 
                                компанию всем, кто ищет<br> 
                                захватывающие приключения и<br> 
                                незабываемые впечатления!</p>
                        </div>
                    </div>
                </div>

                <div class="slide-container">
                    <div class="slider">
                        <img src="./src/image/tim-marshall-K2u71wv2eI4-unsplash 1.png" alt="" class="slider-img">
                        <div class="card-slider">
                            <h3 class="reviews-title">Максим Понамарев</h3>
                            <p class="reviews-text">Мой тур по Дагестану с туристической<br>
                                компанией "Мои Туры" был просто<br> 
                                потрясающим! Благодаря им я<br> 
                                познакомился с красотами природы,<br> 
                                проникся в удивительную культуру и<br> 
                                приятно удивился гостеприимству<br> 
                                местных жителей. Рекомендую эту<br> 
                                компанию всем, кто ищет<br> 
                                захватывающие приключения и<br> 
                                незабываемые впечатления!</p>
                        </div>
                    </div>
                </div>

                <div class="slide-container">
                    <div class="slider">
                        <img src="./src/image/amirreza-momennia-Y6lZfWew8pw-unsplash 1.png" alt="" class="slider-img">
                        <div class="card-slider">
                            <h3 class="reviews-title">Елизавета Глыбова</h3>
                            <p class="reviews-text">Мой тур по Дагестану с туристической<br>
                                компанией "Мои Туры" был просто<br> 
                                потрясающим! Благодаря им я<br> 
                                познакомился с красотами природы,<br> 
                                проникся в удивительную культуру и<br> 
                                приятно удивился гостеприимству<br> 
                                местных жителей. Рекомендую эту<br> 
                                компанию всем, кто ищет<br> 
                                захватывающие приключения и<br> 
                                незабываемые впечатления!</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="slider-button">
                <button id="left" class="slide"></button>
                <button id="right" class="slide-right"></button>
            </div>
        </div>

       <script> //скрипт слайдера, чтобы менялись сразу два контейнера при нажатии на кнопку
        var startingIndex = 0;
var containers = document.querySelectorAll('.slide-container');
showContainers(startingIndex);

function showContainers(startIndex) {
    var endIndex = startIndex + 1;
  
    for (var i = 0; i < containers.length; i++) {
        containers[i].style.display = (i >= startIndex && i <= endIndex) ? 'block' : 'none';
    }
}

document.getElementById('left').addEventListener('click', function() {
    startingIndex = Math.max(0, startingIndex - 2);
    showContainers(startingIndex);
});

document.getElementById('right').addEventListener('click', function() {
    startingIndex = Math.min(containers.length - 2, startingIndex + 2);
    showContainers(startingIndex);
});


       </script>
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