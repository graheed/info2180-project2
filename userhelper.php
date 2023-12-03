<?php
session_start();

class UserHelper {
    public static function register($db, $firstname, $lastname, $password, $email, $role) {
        if (!self::isAdmin()) {
            echo "Not an Admin";
            return false;
        };
        
        // Check if the user already exists
        $userExistsQuery = 'SELECT * FROM Users WHERE email = :email';
        $userExistsStatement = $db->prepare($userExistsQuery);
    
        $userExistsParams = array(
            ':email' => $email
        );
    
        $userExistsStatement->execute($userExistsParams);
        $existingUser = $userExistsStatement->fetch(PDO::FETCH_ASSOC);
    
        if ($existingUser !== false) {
            return false;
        }
    
        // User does not exist, proceed with registration
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $insertQuery = 'INSERT INTO Users (firstname, lastname, password, email, role)
                        VALUES (:firstname, :lastname, :password, :email, :role)';
        $insertStatement = $db->prepare($insertQuery);
    
        $params = array(
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':password' => $hashed_password,
            ':email' => $email,
            ':role' => $role
        );
    
        $insertResult = $insertStatement->execute($params);
        return true; 
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
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['userfname'] = $user['firstname'];
            return true;
        } else {
            return false;
        }
    }

    public static function logout() {
        session_destroy();
        return true;
    }

    public static function getUsers($db) {
        if (!self::isAdmin()){
            echo 'not an admin';
            return;
        }

        $result = $db->prepare('SELECT * FROM Users');

        $result->execute();
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        return $users;

    }

    private static function isAdmin() {
        return strcmp($_SESSION['user_role'], 'Admin') == 0;
    }

}