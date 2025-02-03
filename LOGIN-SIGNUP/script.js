document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('container');
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const companySignup = document.getElementById('company-signup');
    const jobseekerSignup = document.getElementById('jobseeker-signup');
    const signupForm = document.getElementById('signup-form');
    const signupOptions = document.getElementById('signup-options');
    const signupBack = document.getElementById('signup-back');
    const companySignin = document.getElementById('company-signin');
    const jobseekerSignin = document.getElementById('jobseeker-signin');
    const signinForm = document.getElementById('signin-form');
    const signinOptions = document.getElementById('signin-options');
    const signinBack = document.getElementById('signin-back-btn');
    const adminSigninForm = document.getElementById('admin-signin-form');
    const adminBackBtn = document.getElementById('admin-back-btn');
    const homeBcakBtn = document.getElementById('home-back-btn');

   window.onload = function() {
    const homeBackBtn = document.getElementById('homeBackBtn');
    homeBackBtn.addEventListener('click', function() {
        window.location.href = '../HOME/index.html';
    });
};
    signUpButton.addEventListener('click', () => container.classList.add('right-panel-active'));
    signInButton.addEventListener('click', () => container.classList.remove('right-panel-active'));

    companySignup.addEventListener('click', () => showSignupForm('company'));
    jobseekerSignup.addEventListener('click', () => showSignupForm('jobseeker'));
    signupBack.addEventListener('click', showSignupOptions);

    companySignin.addEventListener('click', () => showSigninForm('company'));
    jobseekerSignin.addEventListener('click', () => showSigninForm('jobseeker'));
    signinBack.addEventListener('click', showSigninOptions);

    adminBackBtn.addEventListener('click', hideAdminLogin);

    function showSignupForm(type) {
        signupOptions.style.display = 'none';
        signupForm.style.display = 'flex';
        document.getElementById('account-type-display').textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} Account`;
        document.getElementById(`${type}-fields`).style.display = 'block';
        document.getElementById(`${type === 'company' ? 'jobseeker' : 'company'}-fields`).style.display = 'none';
        document.getElementById('signup-back').style.display = 'flex'; // Show the back arrow
    }

    function showSigninForm(type) {
        signinOptions.style.display = 'none';
        signinForm.style.display = 'flex';
        document.getElementById('signin-account-type-display').textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} Account`;
    }

    function showSignupOptions() {
        signupForm.style.display = 'none';
        signupOptions.style.display = 'flex';
        document.getElementById('signup-back').style.display = 'none'; // Hide the back arrow
    }

    function showSigninOptions() {
        signinForm.style.display = 'none';
        adminSigninForm.style.display = 'none';
        signinOptions.style.display = 'flex';
    }

    function showAdminLogin() {
        console.log('Showing admin login');
        signinOptions.style.display = 'none';
        signinForm.style.display = 'none';
        adminSigninForm.style.display = 'flex';
    }

    function hideAdminLogin() {
        adminSigninForm.style.display = 'none';
        showSigninOptions();
    }

    signinForm.addEventListener('submit', (e) => {
        e.preventDefault();
        // Add your regular login logic here
    });

   

    // Hidden admin login activation
    let adminTypingBuffer = '';
    let adminTypingTimer;

    document.addEventListener('keydown', (e) => {
        console.log('Key pressed:', e.key);
        clearTimeout(adminTypingTimer);
        adminTypingBuffer += e.key.toLowerCase();
        
        console.log('Current buffer:', adminTypingBuffer);

        adminTypingTimer = setTimeout(() => {
            console.log('Clearing buffer');
            adminTypingBuffer = '';
        }, 1000);

        if (adminTypingBuffer.includes('admin')) {
            console.log('Admin login triggered');
            showAdminLogin();
            adminTypingBuffer = '';
        }
    });

    console.log('Script loaded and event listeners attached');
});

// Add event listener for the back button
document.getElementById('signup-back').addEventListener('click', showSignupOptions);

$(document).ready(function () {
    $('#signup-form').submit(function (e) {
        e.preventDefault();
        console.log("Form submitted"); // Debug log
        var formData = new FormData(this);
        formData.append('account_type', $('#account-type-display').text().toLowerCase());
        console.log("Account type:", formData.get('account_type')); // Debug log

        $.ajax({
            url: '/signup.php',
            type: 'POST', // Ensure this is set to POST
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Response received:", response); // Debug log
                try {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Sign up successful!');
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e); // Debug log
                    alert('An error occurred. Please try again.');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error); // Debug log
                alert('An error occurred. Please try again.');
            }
        });
    });

    $('#signin-form').submit(function (e) {
        e.preventDefault();
        var formData = {
            account_type: $('#signin-account-type-display').text().toLowerCase(),
            email: $('#signin-email').val(),
            password: $('#signin-password').val()
        };

        $.ajax({
            url: '/signin.php', // Updated path
            type: 'POST',
            data: formData,
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert('Sign in successful!');
                } else {
                    alert('Error: ' + result.message);
                }
            }
        });
    });

    $('#admin-signin-form').submit(function (e) {
        e.preventDefault();
        var formData = {
            account_type: 'admin',
            email: $('#admin-username').val(),
            password: $('#admin-password').val()
        };

        $.ajax({
            url: '/signin.php', // Updated path
            type: 'POST',
            data: formData,
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert('Admin sign in successful!');
                } else {
                    alert('Error: ' + result.message);
                }
            }
        });
    });
});

$(document).ready(function () {
    // Show the corresponding sign-up form based on account type
    $('#company-signup').click(function () {
        $('#signup-options').hide();
        $('#company-fields').show();
        $('#account-type-display').text("Company");
    });

    $('#jobseeker-signup').click(function () {
        $('#signup-options').hide();
        $('#jobseeker-fields').show();
        $('#account-type-display').text("Job Seeker");
    });

    // Sign-In Options
    $('#company-signin').click(function () {
        $('#signin-options').hide();
        $('#signin-form').show();
        $('#signin-account-type-display').text("Company");
        $('#account_type').val("company");
    });

    $('#jobseeker-signin').click(function () {
        $('#signin-options').hide();
        $('#signin-form').show();
        $('#signin-account-type-display').text("Job Seeker");
        $('#account_type').val("jobseeker");
    });

    $('#admin-signin').click(function () {
        $('#signin-options').hide();
        $('#admin-signin-form').show();
    });

    // Back buttons
    $('#signin-back-btn').click(function () {
        $('#signin-form').hide();
        $('#signin-options').show();
    });

    $('#admin-back-btn').click(function () {
        $('#admin-signin-form').hide();
        $('#signin-options').show();
    });

    $('#signup-back').click(function () {
        $('#company-fields, #jobseeker-fields').hide();
        $('#signup-options').show();
    });
});
