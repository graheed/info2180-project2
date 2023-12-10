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
    

    // Call loadDashboard when home is clicked
    $('a[href="#home"]').on('click', function(e) {
        e.preventDefault();
        loadDashboard('home');
    });

    $('a[href="#users"]').on('click', function(e) {
        e.preventDefault();
        hideDashboard();
        loadDashboard('getUsers');
    });
    
});
