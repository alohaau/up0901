<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$start_date = '2024-06-01'; 
$end_date = '2024-06-30'; 
$sql = "SELECT t.id_tour, t.name, t.price, t.available_seats 
        FROM tours t 
        WHERE t.id_tour NOT IN (
            SELECT b.id_tour 
            FROM booking b 
            WHERE b.booking_date BETWEEN '$start_date' AND '$end_date'
        )";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Туры доступные для бронирования с $start_date до $end_date:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . " - " . $row["price"] . " - " . $row["available_seats"] . " seats available</li>";
    }
    echo "</ul>";
} else {
    echo "Туры с $start_date до $end_date недоступны для бронирования.";
}

mysqli_close($conn);
?>