<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentstvo";

// Создание соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Получаем данные из формы
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Проверка совпадения паролей
if ($password!== $confirmPassword) {
    // Если пароль и подтверждение не совпадают, перенаправляем обратно на страницу регистрации с сообщением об ошибке
    header("Location:./index.php?error=password_mismatch");
    exit;
}

// Проверка email на корректность
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Если email некорректен, перенаправляем обратно на страницу регистрации с сообщением об ошибке
    header("Location:./index.php?error=invalid_email");
    exit;
}

$checkEmailStmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email =?");
$checkEmailStmt->bind_param("s", $email);

// Выполнение подготовленного запроса
$checkEmailStmt->execute();
$checkEmailStmt->store_result();
$checkEmailStmt->bind_result($emailCount);
$checkEmailStmt->fetch();

if ($emailCount > 0) {
    // Если email уже занят, выводим сообщение об ошибке и перенаправляем обратно на страницу регистрации
    header("Location:./index.php?error=email_taken");
    exit;
}

$checkEmailStmt->close();

// Подготовленный запрос для вставки данных в базу
$stmt = $conn->prepare("INSERT INTO users (name, surname, email, password) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

// Выполнение подготовленного запроса
if ($stmt->execute()) {
    // Если запрос выполнен успешно, перенаправляем пользователя на страницу авторизации
    $newUserId = $conn->insert_id; // Получаем айдишник нового пользователя, добавленного при регистрации.
    $_SESSION['user_id'] = $newUserId;
    header("Location:./process_login.php");

} else {
    // Если произошла ошибка при выполнении запроса, перенаправляем обратно на страницу регистрации с сообщением об ошибке
    header("Location:./index.php?error=database");
}

// Закрываем подготовленный запрос и соединение с базой данных
$stmt->close();
$conn->close();
?>