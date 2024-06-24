<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT u.name, u.surname, t.name AS tour_name 
        FROM users u 
        JOIN booking b ON u.id_user = b.id_user 
        JOIN tours t ON b.id_tour = t.id_tour";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Клиенты и выбранные туры:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . " " . $row["surname"] . " - " . $row["tour_name"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Ошибка";
}

mysqli_close($conn);
?>