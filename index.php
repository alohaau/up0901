<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Регистрация</title>
    <link rel="stylesheet" href="./src/scss/style.css">
</head>
<body>
  <div class="container">
    <img src="./src/image/Слой 3.png" alt="" class="logo">
    <h1 class="reg-title">Регистрация</h1>
    <form action="registration_process.php" method="post">
      <div class="reg">
        <input name="firstName" placeholder="Имя" class="input" required>
        <input name="lastName" placeholder="Фамилия" class="input" required>
        <input name="email" type="email" placeholder="Почта" class="input" required>
        <input name="password" type="password" placeholder="Пароль" class="input" minlength="6" required>
        <input name="confirmPassword" type="password" placeholder="Подтверждение пароля" class="input" minlength="6" required>
        <button type="submit" class="button">Зарегистрироваться</button>
      </div>
    </form>

    <?php
    // PHP-код для отображения сообщения об ошибке, что поля пароль и подтверждение пароля не совпали
    if(isset($_GET['error'])) {
        $error = $_GET['error'];

        switch($error) {
            case 'password_mismatch':
                echo "<p style='color: red;'>Пароли не совпадают. Пожалуйста, попробуйте еще раз.</p>";
                break;
            case 'database':
                echo "<p style='color: red;'>Произошла ошибка при сохранении данных в базе. Пожалуйста, попробуйте позже.</p>";
                break;
        }
    }
    ?>

<?php
        //проверка на дублирование почты, если такая почта уже регалась, то ошибка и досвидос
        if(isset($_GET['error'])) {
            $error = $_GET['error'];
            if($error === 'email_taken') {
                echo "<p style='color: red;'>Этот email уже занят. Пожалуйста, используйте другой email.</p>";
            }
        }
        ?>
    <div class="auth-cont">
      <p class="text">Уже зарегистрированы?</p>
      <a href="./process_login.php" class="button2">Войти</a>
    </div>
  </div>
</body>
</html>