<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$start_date = '2024-06-01'; 
$end_date = '2024-06-30'; 
$sql = "SELECT u.id_user, u.name, u.surname, b.booking_date, t.name AS tour_name 
        FROM booking b 
        JOIN users u ON b.id_user = u.id_user 
        JOIN tours t ON b.id_tour = t.id_tour 
        WHERE b.booking_date BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Клиенты забронировавшие тур с $start_date по $end_date:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . " " . $row["surname"] . " booked " . $row["tour_name"] . " on " . $row["booking_date"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Нет клиентов забронировавшие тур с $start_date по $end_date.";
}

mysqli_close($conn);
?>