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
        $contacts = UserHelper::getContacts($db);
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
                </tr>';
                foreach ($contacts as $contact) {
                    $fullName = $contact['title'] . '. ' . $contact['firstname'] . ' ' . $contact['lastname'];
                    echo '<tr>
                            <td>' . $fullName . '</td>
                            <td>' . $contact['email'] . '</td>
                            <td>' . $contact['company'] . '</td>
                            <td>' . $contact['type'] . '</td>
                            <td>' . $contact['type'] . '</td>
                            </tr>';
                }

            echo '<table>  
        </div>                   
        </section>';
        break;
    case 'newContact':
        echo '<section class="dashboard-contacts" id="contacts">
    
            <div class="contact-dashboard-contents">
                <h1 class="contacts-title">New Contact</h1>
            </div>
            
            <div class="contact-form-wrapper">
                <form action="" class="form" id="contact-form">        
                    <div class="contact-form-content">
                        <div class="contact-form-box">
                            <div class="contact-form-box-input"> 
                                <label for="dropdown" class="contact-form-label">
                                    Title
                                </label>
            
                                <select class="contact-form-input" id="dropdown" name="title-dropdown">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Prof">Prof</option>
                                </select>
                            </div>
                        </div>    
            
                        <div class="contact-form-box">       
                            <div class="contact-form-box-input">
                                <label for="fname" class="contact-form-label">
                                    First Name
                                </label>
            
                                <input type="text" class="contact-form-input" placeholder="Jane" id="fname">
                            </div>   
                            
                            <div class="contact-form-box-input">
                                <label for="lname" class="contact-form-label">
                                    Last Name
                                </label>
            
                                <input type="text" class="contact-form-input" placeholder="Doe" id="lname">
                            </div>    
                        </div> 
                        
                        <div class="contact-form-box">       
                            <div class="contact-form-box-input">
                                <label for="email" class="contact-form-label">
                                    Email
                                </label>
            
                                <input type="email" class="contact-form-input" placeholder="someone@example.com" id="email">
                            </div>    
                            
                            <div class="contact-form-box-input">
                                <label for="telephone" class="contact-form-label">
                                    Telephone
                                </label>
            
                                <input type="tel" class="contact-form-input" placeholder=" " id="tele">
                            </div>        
                        </div> 
                        
                        <div class="contact-form-box">       
                            <div class="contact-form-box-input">
                                <label for="company" class="contact-form-label">
                                    Company
                                </label>
            
                                <input type="text" class="contact-form-input" placeholder=" " id="company">
                            </div>    
                            
                            <div class="contact-form-box-input">
                                <label for="dropdown" class="contact-form-label">
                                    Type
                                </label>
            
                                <select class="contact-form-input" id="dropdown" name="type-dropdown">
                                    <option value="Sales Lead">Sales Lead</option>
                                    <option value="Support">Support</option>
                                </select>
                            </div>        
                        </div>
                        
                        <div class="contact-form-box"> 
                            <div class="contact-form-box-input"> 
                                <label for="dropdown" class="contact-form-label">
                                    Assigned To
                                </label>
                                <select class="contact-form-input" id="dropdown" name="assigned-dropdown">';
        $users = UserHelper::getUsers($db);
        foreach ($users as $user) {
            $fullName = $user['firstname'] . ' ' . $user['lastname'];
            echo '<option value="' . $user['id'] .'">' . $fullName . '</option>';
        }
        echo '</select>
                            </div>    
                        </div>
                    </div>
                    <button type="button" class="btn" id="contact-btn">Save</button>
                </form>
            </div>  
        </section>';
        break;

    case 'addNewContact':
        $formData = json_decode($_POST['formData'], true);
        $title = $formData['title'];
        $fname = $formData['fname'];
        $lname = $formData['lname'];
        $email = $formData['email'];
        $tele = $formData['tele'];
        $company = $formData['company'];
        $type = $formData['type'];
        $assignedTo = $formData['assignedTo'];
        if (UserHelper::createContact($db, $title, $fname, $lname, $email, $tele, $company, $type, $assignedTo)) {
            echo 'success';
        } else {
            echo 'failure';
        }
        break;


}


?>