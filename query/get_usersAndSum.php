<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$amount = 100000; 
$sql = "SELECT u.id_user, u.name, u.surname, SUM(b.total_cost) AS total_spent 
        FROM booking b 
        JOIN users u ON b.id_user = u.id_user 
        GROUP BY u.id_user 
        HAVING SUM(b.total_cost) > $amount";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Клиенты, потратившие больше $amount:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . " " . $row["surname"] . " spent " . $row["total_spent"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No clients spent more than $amount.";
}

mysqli_close($conn);
?>