# info2180-project2

## Database Requirements to Startup
1. To startup this project, a database is needed. Go ahead and install composer on your device. Get it from here: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
2. Next up, run this command in the terminal to install the dependencies needed `php composer.phar install`.
3. Remember to include this variables in your .env file to start the database connection as they are needed.
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
4. After this, you can get access to the database on any page but adding the `require 'database.php';` tag at the top of your code. You will now have a PDO to run queries on by using this line of code `$db = Database::getInstance()->getConnection();`

5. You may use this line to test the code:

``` php
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
```
it should return something like this, but created at will be the date you created it at
```
id: 1
firstname: Nikola
lastname: Tesla2
password: password123
email: admin@project2.com
role: Admin
created_at: 2023-12-02 20:47:20
```
