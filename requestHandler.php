<?php
require 'database.php';
require_once 'userhelper.php';

$db = Database::getInstance()->getConnection();

$action = $_POST['action'];

switch($action) {
    case 'login':
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (UserHelper::login($db, $email, $password)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;
    case 'register':
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];


       if (UserHelper::register($db, $fname, $lname, $password, $email, $role)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;

    case 'logout':
        if (UserHelper::logout()) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;
    case 'getUsers':
        echo json_encode(UserHelper::getUsers($db));
        break;


}


?>