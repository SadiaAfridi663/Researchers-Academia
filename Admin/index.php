<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Research Academia</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
    * {
        font-family: 'Inter', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #102068ff 0%, #ddd9e4ff 100%);
        min-height: 100vh;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .gradient-bg {
        background: linear-gradient(135deg, #103182 0%, #0d0781ff 100%);
    }



    .pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4">



    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-md">

        <!-- Login Card -->
        <div class="login-card overflow-hidden">

            <!-- Header Section -->
            <div class="gradient-bg text-white p-8 text-center relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div
                        class="absolute top-0 left-0 w-32 h-32 border-4 border-white rounded-full -translate-x-1/2 -translate-y-1/2">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-40 h-40 border-4 border-white rounded-full translate-x-1/2 translate-y-1/2">
                    </div>
                </div>

                <!-- Logo -->
                <div class="relative z-10">
                    <h1 class="text-2xl font-bold mb-2">Research Academia</h1>
                    <p class="text-white/80">Admin Dashboard Access</p>
                </div>
            </div>

            <!-- Login Form -->
            <div class="p-8">
                <!-- Alert Messages -->
                <div id="errorAlert" class="hidden mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span id="errorMessage" class="text-red-700 text-sm"></span>
                    </div>
                </div>

                <div id="successAlert" class="hidden mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span id="successMessage" class="text-green-700 text-sm"></span>
                    </div>
                </div>

                <form id="loginForm" action="superadminlogin_process.php" method="POST">
                    <!-- Email Input -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent outline-none transition duration-200"
                                placeholder="admin@example.com" required>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-gray-700 text-sm font-medium" for="password">
                                Password
                            </label>
                            <a href="forgot-password.php" class="text-sm text-blue-800 hover:text-blue-800 transition">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent outline-none transition duration-200"
                                placeholder="••••••••" required>
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6 flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me for 30 days
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="loginButton"
                        class="w-full gradient-bg text-white py-3 px-4 rounded-lg font-medium hover:opacity-90 transition duration-200 flex items-center justify-center">
                        <span id="buttonText">Sign In</span>
                        <div id="loadingSpinner" class="hidden ml-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </button>
                </form>




            </div>
        </div>

        <!-- Security Note -->
        <div class="mt-6 text-center">
            <p class="text-sm text-white/80">
                <i class="fas fa-shield-alt mr-2"></i>
                Your credentials are secured with 256-bit SSL encryption
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
    // DOM Elements
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const errorAlert = document.getElementById('errorAlert');
    const successAlert = document.getElementById('successAlert');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');

    // Toggle Password Visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ?
            '<i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>' :
            '<i class="fas fa-eye-slash text-gray-400 hover:text-gray-600 cursor-pointer"></i>';
    });

    // Form Validation
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Reset alerts
        hideAlerts();

        // Get form values
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        // Validation
        if (!email || !password) {
            showError('Please fill in all fields');
            return;
        }

        if (!isValidEmail(email)) {
            showError('Please enter a valid email address');
            return;
        }

        // Show loading state
        setLoading(true);

        // Submit form to server
        loginForm.submit();
    });

    // Email validation
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Show error message
    function showError(message) {
        errorMessage.textContent = message;
        errorAlert.classList.remove('hidden');
        // Add shake animation
        errorAlert.classList.add('animate__animated', 'animate__headShake');
        setTimeout(() => {
            errorAlert.classList.remove('animate__animated', 'animate__headShake');
        }, 1000);
    }

    // Show success message
    function showSuccess(message) {
        successMessage.textContent = message;
        successAlert.classList.remove('hidden');
    }

    // Hide alerts
    function hideAlerts() {
        errorAlert.classList.add('hidden');
        successAlert.classList.add('hidden');
    }

    // Set loading state
    function setLoading(isLoading) {
        if (isLoading) {
            loginButton.disabled = true;
            buttonText.textContent = 'Signing In...';
            loadingSpinner.classList.remove('hidden');
            loginButton.classList.add('opacity-75');
        } else {
            loginButton.disabled = false;
            buttonText.textContent = 'Sign In';
            loadingSpinner.classList.add('hidden');
            loginButton.classList.remove('opacity-75');
        }
    }

    // Social login function
    function socialLogin(provider) {
        setLoading(true);
        showSuccess(`Connecting with ${provider}...`);
        setTimeout(() => {
            setLoading(false);
            showError(`${provider} login is currently unavailable. Please use email login.`);
        }, 1500);
    }

    // Check for URL parameters
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('logout')) {
            showSuccess('You have been successfully logged out.');
        }

        if (urlParams.has('expired')) {
            showError('Your session has expired. Please login again.');
        }

        // Handle error codes from PHP
        if (urlParams.has('error')) {
            const errorCode = urlParams.get('error');
            let errorMsg = 'Login failed. Please try again.';
            
            switch(errorCode) {
                case 'empty_fields':
                    errorMsg = 'Please fill in all fields';
                    break;
                case 'invalid_email':
                    errorMsg = 'Invalid email address or email not found';
                    break;
                case 'invalid_password':
                    errorMsg = 'Invalid password. Please try again.';
                    break;
                case 'database_error':
                    errorMsg = 'Database error. Please contact support.';
                    break;
                default:
                    errorMsg = 'Login failed. Please check your credentials.';
            }
            showError(errorMsg);
        }

        // Auto-focus email field
        document.getElementById('email').focus();

        // Check for remembered email
        const rememberedEmail = localStorage.getItem('rememberedEmail');
        const rememberCheckbox = document.getElementById('remember');

        if (rememberedEmail) {
            document.getElementById('email').value = rememberedEmail;
            rememberCheckbox.checked = true;
        }

        // Save email if remember is checked
        rememberCheckbox.addEventListener('change', function() {
            const email = document.getElementById('email').value;
            if (this.checked && email) {
                localStorage.setItem('rememberedEmail', email);
            } else {
                localStorage.removeItem('rememberedEmail');
            }
        });
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            loginForm.dispatchEvent(new Event('submit'));
        }

        // Escape to clear
        if (e.key === 'Escape') {
            loginForm.reset();
            hideAlerts();
        }
    });
    </script>

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</body>

</html>