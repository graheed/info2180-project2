<?php
require 'database.php';
require_once 'userhelper.php';

session_start();



$db = Database::getInstance()->getConnection();

$action = $_POST['action'];

switch($action) {
    case 'login':
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (UserHelper::login($db, $email, $password)) {
            $_SESSION['just_logged_in'] = true;
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
        $users = UserHelper::getUsers($db);
    
        echo '<section class="dashboard-user" id="user">
                <div class="user-dashboard-contents">
                    <h1 class="user-title">Users</h1>
                    <button class="btn" id="user-btn" onclick=""> Add User </button>
                </div>
                <div class="user-area-contents">    
                    <table id="user-table">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                        </tr>';
    
        foreach ($users as $user) {
            $fullName = $user['firstname'] . ' ' . $user['lastname'];
            echo '<tr>
                    <td>' . $fullName . '</td>
                    <td>' . $user['email'] . '</td>
                    <td>' . $user['role'] . '</td>
                    <td>' . $user['created_at'] . '</td>
                    </tr>';
        }
    
        echo '</table>
                </div>    
            </section>';
        break;

    case 'home':
        echo '<section class="dashboard-home" id="home">

        <div class="home-dashboard-contents">
            <h1 class="home-title">Dashboard</h1>
            <button class="btn"id="home-btn" onclick=""> Add Contact </button>
        </div>

        <div class="home-area-contents">

            <div class="home-filter">
                
                <div class="filter">
                    <i class="fa-solid fa-filter"></i> 
                    <h6 class="filter-title"> Filter By: </h6>
                </div>

                <nav class = "nav">                  
                    <ul class = "nav-list">
                        <li class = "nav-item">
                            <a href = "" class = "nav-link"> All </a>
                        </li>

                        <li class = "nav-item">
                            <a href = "" class = "nav-link"> Sales Leads </a>
                        </li>

                        <li class = "nav-item">
                            <a href = "" class = "nav-link"> Support </a>
                        </li>

                        <li class = "nav-item">
                            <a href = "" class = "nav-link"> Assigned to me </a>
                        </li>
                    </ul> 
                </nav>
            </div>

            <table id="home-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th> </th>
                </tr>

                <tr>
                    <td value="">Mr. Josiah-John Green </td>
                    <td value="">josiahjohngreen@gmail.com</td>
                    <td value="">StackGROW Ltd</td>
                    <td value="">Sales Lead</td>
                    <td value=""><button class="table-btn" id="table-view-button"> View </button></td>
                </tr>
            <table>  
        </div>                   
        </section>';
        break;


}


?>