<?php
$conn = mysqli_connect("localhost", "root", "", "agentstvo");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT u.id_user, u.name, u.surname, SUM(b.total_cost) AS total_spent 
        FROM booking b 
        JOIN users u ON b.id_user = u.id_user 
        GROUP BY u.id_user 
        HAVING SUM(b.total_cost) > (
            SELECT AVG(total_cost) 
            FROM (
                SELECT SUM(total_cost) AS total_cost 
                FROM booking 
                GROUP BY id_user
            ) AS subquery
        )";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Клиенты, потратившие больше больше всех:</h2>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["name"] . " " . $row["surname"] . " spent " . $row["total_spent"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Ошибка";
}

mysqli_close($conn);
?>