<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT c.name AS country_name, t.price 
        FROM country c 
        JOIN tours t ON c.id_country = t.id_country";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Туры с ценами по странам:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["country_name"] . " - " . $row["price"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Ошибка";
}

mysqli_close($conn);
?>