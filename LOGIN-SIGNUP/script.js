// Get elements
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');
const signInContainer = document.querySelector('.sign-in-container');
const signUpContainer = document.querySelector('.sign-up-container');
const companySignupBtn = document.getElementById('company-signup');
const jobSeekerSignupBtn = document.getElementById('jobseeker-signup');
const signupOptions = document.getElementById('signup-options');
const companyForm = document.getElementById('company-form');
const jobSeekerForm = document.getElementById('jobseeker-form');
const backToOptionsCompany = document.getElementById('back-to-options-company');
const backToOptionsJobseeker = document.getElementById('back-to-options-jobseeker');

// Show signup options when clicking Sign Up
signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
    signUpContainer.style.display = "block";  
    signInContainer.style.display = "none";   
    signupOptions.style.display = "block";     
    companyForm.style.display = "none";        
    jobSeekerForm.style.display = "none";
});

// Show Company Signup Form
companySignupBtn.addEventListener('click', () => {
    signupOptions.style.display = "none";      
    companyForm.style.display = "block";       
    jobSeekerForm.style.display = "none";      
});

// Show Job Seeker Signup Form
jobSeekerSignupBtn.addEventListener('click', () => {
    signupOptions.style.display = "none";      
    jobSeekerForm.style.display = "block";     
    companyForm.style.display = "none";        
});

// Back to account selection
backToOptionsCompany.addEventListener('click', () => {
    signupOptions.style.display = "block";  
    companyForm.style.display = "none";    
});

backToOptionsJobseeker.addEventListener('click', () => {
    signupOptions.style.display = "block";  
    jobSeekerForm.style.display = "none";    
});

// Switch to login panel
signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
    signUpContainer.style.display = "none";    
    signInContainer.style.display = "block";   
});
