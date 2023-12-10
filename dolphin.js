$(document).ready(function() {
    
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
});
