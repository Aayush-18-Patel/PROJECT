<html>      
<head>
	<title>Flexi Recruits</title>
</head>
<body>
<button id="homeBackBtn" class="back-btn"></button>

<div class="container" id="container">
	<link rel="stylesheet" href="style.css">

	<!-- Sign-Up Section -->

	<div class="form-container sign-up-container">
		<div id="signup-options" class="signin-options">
			<h1>Choose Account Type</h1>
			<button class="signin-option-btn" id="company-signup" >Company</button>
			<button class="signin-option-btn" id="jobseeker-signup">Job Seeker</button>
		</div>
		<form id="signup-form" action="signup.php" method="POST" enctype="multipart/form-data">
			<button type="button" class="back-btn" id="signup-back" style="margin-left: -10px;"></button>
			<h1>Sign-Up</h1>
			<span id="account-type-display" style="font-size: 25px;"></span>

			<!-- Company Fields -->
			<div id="company-fields" style="display: none;">
				<div class="input-row">
					<input type="text" placeholder="Company Name" name="company_name" id="company-name" />
					<input type="text" placeholder="Industry" name="company_industry" id="company-industry" />
				</div>
				<input type="email" placeholder="Email" name="company_email" id="company-email" />
				<input type="password" placeholder="Password" name="company_password" id="company-password" />
				<input type="hidden" name="signup-company-btn" value="1">
			</div>

			<!-- Job Seeker Fields -->
			<div id="jobseeker-fields" style="display: none;">
				<div class="input-row">
					<input type="text" placeholder="Username" name="jobseeker_username" id="jobseeker-username" />
					<input type="text" placeholder="Job Preferences" name="jobseeker_preferences" id="jobseeker-preferences">
				</div>
				<input type="email" placeholder="Email" name="jobseeker_email" id="jobseeker-email" />
				<input type="password" placeholder="Password" name="jobseeker_password" id="jobseeker-password" />
				<div class="file-input-container">
					<label for="jobseeker-resume">Upload Resume (PDF or Word document)</label>
					<input type="file" id="jobseeker-resume" name="jobseeker_resume" accept=".pdf,.doc,.docx">

				</div>
				<input type="hidden" name="signup-jobseeker-btn" value="1">
			</div>

			<button type="submit">Sign Up</button>
		</form>
	</div>

	<!-- Sign-In Section -->
	<div class="form-container sign-in-container">
		<div id="signin-options" class="signin-options">
			<h1>Choose Account Type</h1>
			<button class="signin-option-btn" id="company-signin">Company</button>
			<button class="signin-option-btn" id="jobseeker-signin">Job Seeker</button>
		</div>

		<!-- Sign-In Form for Companies and Job Seekers -->
		<form id="signin-form" action="signin.php" method="POST" style="display: none;">
			<button type="button" class="back-btn" id="signin-back-btn" style="margin-left: -10px;"></button>
			<h1>Sign in</h1>
			<span id="signin-account-type-display"></span>
			<input type="hidden" id="account_type" name="account_type" value="">
			<input type="email" placeholder="Email" name="email" id="signin-email" />
			<input type="password" placeholder="Password" name="password" id="signin-password" />
			<a href="#">Forgot your password?</a>
			<button type="submit">Sign In</button>
		</form>

		<!-- Admin Sign-In Form -->
		<form id="admin-signin-form" action="signin.php" method="POST" style="display: none;">
			<button type="button" class="back-btn" id="admin-back-btn"></button>
			<h1>Admin Sign in</h1><br>
			<input type="hidden" name="account_type" value="admin">
			<input type="text" placeholder="Admin Username" name="Username" id="admin-username" />
			<input type="password" placeholder="Admin Password" name="password" id="admin-password" /><br>
			<button type="submit">Sign In</button>
		</form>
	</div>

	<!-- Overlay Section -->
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
<script>
function goHome() {
    window.location.href = '/var/www/html/FLEXI-RECRUITS/HOME/index.html';
}
</script>

</body>
</html>
