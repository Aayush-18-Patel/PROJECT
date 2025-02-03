$(document).ready(function() {
    // Handle company signup form
    $('#company-signup-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'process_signup.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    alert(result.message);
                    if (result.success) {
                        window.location.href = 'index.php';
                    }
                } catch (e) {
                    alert('An error occurred. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });

    // Handle jobseeker signup form
    $('#jobseeker-signup-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'process_signup.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    alert(result.message);
                    if (result.success) {
                        window.location.href = 'index.php';
                    }
                } catch (e) {
                    alert('An error occurred. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
