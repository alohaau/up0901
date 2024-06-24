<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$type = "Туристический тур"; 
$sql = "SELECT * FROM tours WHERE id_TypeTour = (SELECT id_TypeTour FROM TypeTours WHERE type = '$type')";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Туры с типом $type:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Туров $type не найдено";
}

mysqli_close($conn);
?>