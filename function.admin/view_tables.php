<?php
// коннект с бд
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'agentstvo';


$db = new mysqli($host, $user, $password, $dbname);

// проверка с соединением к бд
if ($db->connect_error) {
    die('Connection failed: '. $db->connect_error);
}

//показ всех таблиц
$tables = $db->query('SHOW TABLES');

// вывод всех таблицы и их содержимое
if ($tables && $tables->num_rows > 0) {
    while ($table = $tables->fetch_assoc()) {
        $tableName = $table['Tables_in_'. $dbname];
        echo "<h2>$tableName</h2>";
        echo "<table border='1'>";
        echo "<tr>";
        $columns = $db->query("SHOW COLUMNS FROM $tableName");
        while ($column = $columns->fetch_assoc()) {
            echo "<th>". $column['Field']. "</th>";
        }
        echo "</tr>";
        $rows = $db->query("SELECT * FROM $tableName");
        while ($row = $rows->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>". $cell. "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
    }
} else {
    echo 'Таблицы не найдены';
}

// Close the database connection
$db->close();
?>