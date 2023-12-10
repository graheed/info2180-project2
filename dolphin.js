$(document).ready(function() {

    function loadDashboard(component) {
        $.ajax({
            type: "POST",
            url: "requestHandler.php",
            data: { action: component },
            success: function(response) {
                $('.dashboard-area').html(response);
                if (component == 'home') {
                    $('.dashboard-home').css('display', 'grid'); // Change display to grid
                }
                if (component == 'getUsers') {
                    $('.dashboard-user').css('display', 'grid'); // Change display to grid
                }
                if (component == 'newContact') {
                    $('.dashboard-contacts').css('display', 'grid'); // Change display to grid
                }
            }
        });
    }
    
    $('#form-btn').on('click', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#pass').val();

        $.ajax({
            type: "POST",
            url: "requestHandler.php",
            data: { action: "login", email: email, password: password },
            success: function(response) {
                if(response.trim() === 'success') {
                    window.location.href = "index.php";
                } else {
                    alert("Login failed. Please try again.");
                }
            }
        });        
    });

    $(document).on('click', '#contact-btn', function(event) {
        
        event.preventDefault();

        var formData = {
            title: $('#dropdown[name="title-dropdown"]').val(),
            fname: $('#fname').val(),
            lname: $('#lname').val(),
            email: $('#email').val(),
            tele: $('#tele').val(),
            company: $('#company').val(),
            type: $('#dropdown[name="type-dropdown"]').val(),
            assignedTo: $('#dropdown[name="assigned-dropdown"]').val()
        };
        

        $.ajax({
            type: 'POST',
            url: 'requestHandler.php',
            data: { action: "addNewContact", formData: JSON.stringify(formData)},
            success: function(response) {
                if(response.trim() === 'success') {
                    alert("Contact Successfully Added")
                    loadDashboard('newContact');
                } else {
                    alert("Error creating contact");
                }
            }
        });
    });

    $('#logoutLink').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: "requestHandler.php",
            data: { action: "logout"},
            success: function(response) {
                if(response.trim() === 'success') {
                    alert("User logged out");
                    window.location.href = "log.php";
                } else {
                    alert("Logout failed. Please try again.");
                }
            }
        });
    });


    

    function hideDashboard() {
        $('.dashboard-home').css('display', 'none'); // Change display to none
    }

    function hideUsers() {
        $('.dashboard-user').css('display', 'none'); // Change display to none
    }

    function hideNewContact() {
        $('.dashboard-contacts').css('display', 'none'); // Change display to none
    }
    

    // Call loadDashboard when home is clicked
    $('a[href="#home"]').on('click', function(e) {
        e.preventDefault();
        hideUsers();
        hideNewContact();
        loadDashboard('home');
    });

    $('a[href="#users"]').on('click', function(e) {
        e.preventDefault();
        hideDashboard();
        hideNewContact();
        loadDashboard('getUsers');
    });

    $('a[href="#contacts"]').on('click', function(e) {
        e.preventDefault();
        hideDashboard();
        hideUsers();
        loadDashboard('newContact');
    });
    
});



