<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$type = "Пляжный тур"; 
$sql = "SELECT DISTINCT u.id_user, u.name, u.surname 
        FROM booking b 
        JOIN users u ON b.id_user = u.id_user 
        JOIN tours t ON b.id_tour = t.id_tour 
        JOIN TypeTours tt ON t.id_TypeTour = tt.id_TypeTour 
        WHERE tt.type = '$type'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Клиенты, которые забронировали тип тура: $type:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . " " . $row["surname"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Тип тура: $type не бронировали.";
}

mysqli_close($conn);
?>