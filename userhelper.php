<?php
class UserHelper {
    public static function register($db, $firstname, $lastname, $password, $email, $role) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = 'INSERT INTO Users (firstname, lastname, password, email, role)
                  VALUES (:firstname, :lastname, :password, :email, :role)';
        $statement = $db->prepare($query);

        $params = array(
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':password' => $hashed_password,
            ':email' => $email,
            ':role' => $role
        );

        $statement->execute($params);
    }

    public static function login($db, $email, $password) {
        $query = 'SELECT * FROM Users WHERE email = :email';
        $statement = $db->prepare($query);

        $params = array(
            ':email' => $email
        );

        $statement->execute($params);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    }
}