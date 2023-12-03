<?php
require 'database.php';
require_once 'userhelper.php';

$db = Database::getInstance()->getConnection();

$result = $db->query('SELECT * FROM Users');
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    foreach ($row as $column => $value) {
        echo "$column: $value<br>";
    }
    echo "<hr>";
}

//simple login test
$emailToLogin = "admin@project2.com";
$passwordToLogin = "password1234";

if (UserHelper::login($db, $emailToLogin, $passwordToLogin)) {
    echo "Login successful for $emailToLogin";
} else {
    echo "Login failed for $emailToLogin";
}

?>
