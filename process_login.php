<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentstvo";

// создание коннекта с бд и хостом
$conn = new mysqli($servername, $username, $password, $dbname);

// проверка коннекта
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // проверка на присутствие юзера в бд
    $stmt = $conn->prepare("SELECT id_user, password, role FROM users WHERE email =?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_user, $stored_password, $role);
        $stmt->fetch();

        // проверка на совпадение паролей в поле и в бд
        if ($password == $stored_password) {
            // авторизация успешна и сессия открывается
            
            session_start();
            $_SESSION['id_user'] = $id_user;
            $_SESSION['user_role'] = $role;
            header("Location: ./main.php");
            exit;
        } else {
            // авторизация провалена и сообщение об ошибке
            $error = 'авторизация пошла не по плану';
        }
    } else {
        // пользователь не найден и ошибка
        $error = 'пользователь не найден';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="./src/scss/style.css">
</head>
<body>
    <div class="container">
        <img src="./src/image/Слой 3.png" alt="" class="logo">
        
        <h1 class="reg-title">Авторизация</h1>
        
        <div class="reg">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <input type="email" name="email" placeholder="Email" class="input" required> <br>
                <input type="password" name="password" placeholder="Пароль" class="input" required> <br>
                <?php
                //проверка и ошибка если почта не найдена или пароль ввели неверно
                if(isset($error)) {
                    if($error === 'login_failed') {
                        echo "<p style='color: red;'>Неверный email или пароль. Пожалуйста, попробуйте еще раз.</p>";
                    } elseif($error === 'user_not_found') {
                        echo "<p style='color: red;'>Пользователь не найден.</p>";
                    }
                }
               ?>
    <div class="g-recaptcha" data-sitekey="6Lff0_spAAAAAF8B3ZN8FyKoh5D5Ywu6dRJdg3qf"></div>
<input type="submit" name="submit" class="button2" value="Вход">
                <!-- <button type="submit" class="button2">Войти</button> -->
            </form>
            <p class="text">Еще не зарегистрированы?</p>
            <a href="./index.php" class="button">Зарегистрироваться</a>
        </div>

    </div>
</body>
</html>

<?php
$conn->close();
?>