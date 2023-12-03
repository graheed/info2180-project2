<?php
require 'database.php';

$db = Database::getInstance()->getConnection();

$result = $db->query('SELECT * FROM Users');
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    foreach ($row as $column => $value) {
        echo "$column: $value<br>";
    }
    echo "<hr>";
}
?>
