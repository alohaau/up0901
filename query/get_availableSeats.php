<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT t.id_tour, t.name, t.price, t.available_seats 
        FROM tours t 
        WHERE t.available_seats > 0";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Туры, в которые есть свободные места:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . " - " . $row["price"] . " - " . $row["available_seats"] . " seats available</li>";
    }
    echo "</ul>";
} else {
    echo "Нет свободных мест";
}

mysqli_close($conn);
?>