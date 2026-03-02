<?php
session_start();
include('db_connection/connection.php');

// Check for login error
$login_error = '';
if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Clear the error after displaying
}

// Signup errors (set by Admin/signup_form_process.php)
$signup_error = '';
if (isset($_SESSION['error'])) {
    $signup_error = $_SESSION['error'];
    unset($_SESSION['error']);
}

$signup_success = '';
if (isset($_SESSION['signup_success'])) {
    $signup_success = $_SESSION['signup_success'];
    unset($_SESSION['signup_success']);
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <!-- Tailwind CSS CDN -->
    <script src='https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4'></script>

    <!-- Font Awesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>

    <!-- Google Fonts: Outfit -->
    <link href='https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap' rel='stylesheet'>

    <title>Join Us</title>
    <style>
    /* Apply Outfit as the default font */
    body {
        font-family: 'Outfit', sans-serif;
    }

    html {
        scroll-behavior: smooth;
    }
    </style>
</head>

<body>

    <!-- header -->
    <?php include 'Include/navbar.php'; ?>

    <!-- header end -->

    <!-- hero section -->
    <section class='relative bg-gradient-to-r from-[#22d4ad] to-[#11327f] text-gray'>
        <div class='max-w-7xl mx-auto px-6 lg:px-12 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center'>

            <!-- Left Content -->
            <div class='space-y-6 text-center lg:text-left'>
                <h1 class='text-4xl md:text-5xl font-extrabold text-[#11327f] leading-tight'>
                    Join Our Research Community
                </h1>
                <p class='text-lg md:text-xl opacity-90 max-w-xl mx-auto lg:mx-0'>
                    Become part of a growing network of researchers, innovators, and learners.
                    Access exclusive resources, collaborate on projects, and shape the future together.
                </p>

                <!-- Buttons -->
                <div class='flex flex-col sm:flex-row gap-4 justify-center lg:justify-start'>
                    <a href='#form'
                        class='px-8 py-2 flex items-center bg-[#11327f] text-white rounded-lg font-semibold shadow-md hover:shadow-xl hover:bg-white hover:text-[#11327f] border-[#11327f] border-2 transition-all duration-300'>
                        Join Us
                    </a>

                    <a href='#learn-more'
                        class='px-8 py-2  rounded-lg border-[#11327f] border-2 text-[#11327f]  font-semibold hover:bg-[#11327f] hover:text-white transition-all duration-300'>
                        Learn More
                    </a>
                </div>

                <!-- Trust Signals -->
                <div class='flex items-center gap-4 pt-6 justify-center lg:justify-start'>
                    <div class='flex -space-x-3'>
                        <img class='w-10 h-10 rounded-full border-2 border-white' src='./images/team member 3.avif'
                            alt='Member'>
                        <img class='w-10 h-10 rounded-full border-2 border-white' src='./images/team page member 4.avif'
                            alt='Member'>
                        <img class='w-10 h-10 rounded-full border-2 border-white' src='./images/team member 1.avif'
                            alt='Member'>
                    </div>
                    <span class='text-sm opacity-90'>Trusted by 5k+ members</span>
                </div>
            </div>

            <!-- Right Image -->
            <div class='relative flex justify-center'>
                <div class='relative'>
                    <img src='./images/news image 3.avif' alt='Research Team'
                        class='rounded-2xl shadow-2xl w-[90%] lg:w-full object-cover'>
                    <div
                        class='absolute -bottom-6 -right-6 bg-white text-[#11327f] px-6 py-4 rounded-xl shadow-lg text-center'>
                        <h3 class='text-lg font-bold'>5000+</h3>
                        <p class='text-sm'>Active Members</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- hero end -->

    <!-- why us -->
    <section class='py-16 bg-gray-100'>
        <div class='max-w-7xl mx-auto px-4 sm:px-6 lg:px-8'>
            <div class='grid grid-cols-1 lg:grid-cols-2 gap-12 items-center'>
                <!-- Left Column - Benefits Content -->
                <div>
                    <h2 class='text-3xl md:text-4xl font-bold text-gray-900 mb-8'>Why Join Our Research Community?</h2>

                    <div class='space-y-4'>
                        <!-- Benefit 1 -->
                        <div class='flex items-start'>
                            <div class='flex-shrink-0'>
                                <div class='w-12 h-12 bg-[#103182] rounded-lg flex items-center justify-center'>
                                    <i class='fas fa-book text-white text-xl'></i>
                                </div>
                            </div>
                            <div class='ml-4'>
                                <h3 class='text-xl font-semibold text-gray-900 mb-2'>Access Knowledge</h3>
                                <p class='text-gray-600'>Explore a vast repository of research papers, journals, and
                                    academic resources.</p>
                            </div>
                        </div>

                        <!-- Benefit 2 -->
                        <div class='flex items-start'>
                            <div class='flex-shrink-0'>
                                <div class='w-12 h-12 bg-[#103182] rounded-lg flex items-center justify-center'>
                                    <i class='fas fa-users text-white text-xl'></i>
                                </div>
                            </div>
                            <div class='ml-4'>
                                <h3 class='text-xl font-semibold text-gray-900 mb-2'>Collaborate with Experts</h3>
                                <p class='text-gray-600'>Connect and collaborate with leading researchers and scholars
                                    worldwide.</p>
                            </div>
                        </div>

                        <!-- Benefit 3 -->
                        <div class='flex items-start'>
                            <div class='flex-shrink-0'>
                                <div class='w-12 h-12 bg-[#103182] rounded-lg flex items-center justify-center'>
                                    <i class='fas fa-graduation-cap text-white text-xl'></i>
                                </div>
                            </div>
                            <div class='ml-4'>
                                <h3 class='text-xl font-semibold text-gray-900 mb-2'>Enhance Skills</h3>
                                <p class='text-gray-600'>Participate in workshops, webinars, and courses to strengthen
                                    your research skills.</p>
                            </div>
                        </div>

                        <!-- Benefit 4 -->
                        <div class='flex items-start'>
                            <div class='flex-shrink-0'>
                                <div class='w-12 h-12 bg-[#103182] rounded-lg flex items-center justify-center'>
                                    <i class='fas fa-book-open text-white text-xl'></i>
                                </div>
                            </div>
                            <div class='ml-4'>
                                <h3 class='text-xl font-semibold text-gray-900 mb-2'>Early Research Access</h3>
                                <p class='text-gray-600'>Get early access to unpublished studies, datasets, and ongoing
                                    research projects.</p>
                            </div>
                        </div>
                    </div>

                    <div class='mt-10'>
                        <button onclick="document.getElementById('form').scrollIntoView({behavior: 'smooth'})"
                            class='bg-[#103182] hover:bg-[#103182]/80 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition duration-300'>
                            Join Our Community Today
                        </button>
                    </div>
                </div>

                <!-- Right Column - Single Research Image -->
                <div class='relative'>
                    <div class='rounded-2xl overflow-hidden shadow-lg'>
                        <img src='./images/join us.jpeg' alt='Research illustration'
                            class='w-full h-full object-cover rounded-2xl'>
                    </div>

                    <!-- Decorative element -->
                    <div class='absolute -z-10 top-6 -right-6 w-64 h-64 bg-blue-100 rounded-full opacity-30'></div>
                </div>
            </div>
        </div>
    </section>

    <!-- how it work end -->

    <!-- how it works -->
    <section class='py-16 bg-gradient-to-br from-gray-50 to-blue-50'>
        <div class='max-w-7xl mx-auto px-4 sm:px-6 lg:px-8'>
            <!--  Header -->
            <div class='text-center mb-16'>
                <h2 class='text-3xl md:text-4xl font-bold text-gray-900 mb-4'>How It Works</h2>
                <div class='w-20 h-1 bg-[#103182] mx-auto mb-4'></div>
                <p class='text-gray-600 mt-4 max-w-2xl mx-auto text-lg'>
                    Join our research community in a few simple steps and start contributing to cutting-edge studies.
                </p>
            </div>

            <div
                class='relative flex flex-col md:flex-row items-center justify-between space-y-12 md:space-y-0 md:space-x-6'>

                <!-- Step 1 -->
                <div
                    class='flex-1 relative bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2'>
                    <div class="absolute -top-8 inset-x-0 flex justify-center">
                        <div
                            class="w-16 h-16 bg-[#103182] text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg">
                            1
                        </div>
                    </div>

                    <div class='mt-8 text-center'>
                        <div
                            class='w-14 h-14 bg-[#103182] rounded-lg flex items-center justify-center mx-auto mb-4 text-blue-600'>
                            <i class='fas fa-file-alt text-2xl text-white'></i>
                        </div>
                        <h3 class='text-xl font-semibold text-gray-900 mb-2'>Fill the Form</h3>
                        <p class='text-gray-600'>Provide your details to create your profile and tell us about your
                            research interests.</p>
                    </div>
                </div>

                <!-- Arrow  -->
                <div class='hidden md:flex items-center justify-center flex-shrink-0'>
                    <div class='w-12 h-1 bg-[#103182]/80'></div>
                    <i class='fa-solid fa-chevron-right text-xl text-[#103182]/80 px-2'></i>
                    <div class='w-12 h-1 bg-[#103182]/80'></div>
                </div>

                <!-- Step 2  -->
                <div
                    class='flex-1 relative bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2'>
                    <div class="absolute -top-8 inset-x-0 flex justify-center">
                        <div
                            class='w-16 h-16 bg-[#103182] text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg'>
                            2
                        </div>
                    </div>
                    <div class='mt-8 text-center'>
                        <div class='w-14 h-14 bg-[#103182] rounded-lg flex items-center justify-center mx-auto mb-4'>
                            <i class='fa-solid fa-shield-halved text-white text-2xl'></i>
                        </div>
                        <h3 class='text-xl font-semibold text-gray-900 mb-2'>Verification</h3>
                        <p class='text-gray-600'>We verify your details to ensure authentic participation in our
                            exclusive research network.</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div class='hidden md:flex items-center justify-center flex-shrink-0'>
                    <div class='w-12 h-1 bg-[#103182]/80'></div>
                    <i class='fa-solid fa-chevron-right text-xl text-[#103182]/80 px-2'></i>
                    <div class='w-12 h-1 bg-[#103182]/80'></div>
                </div>

                <!-- Step 3 -->
                <div
                    class='flex-1 relative bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2'>
                    <div class="absolute -top-8 inset-x-0 flex justify-center">
                        <div
                            class='w-16 h-16 bg-[#103182] text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg'>
                            3
                        </div>
                    </div>
                    <div class='mt-8 text-center'>
                        <div
                            class='w-14 h-14 bg-[#103182] rounded-lg flex items-center justify-center mx-auto mb-4 text-blue-600'>
                            <i class='fas fa-users text-white text-2xl'></i>
                        </div>
                        <h3 class='text-xl font-semibold text-gray-900 mb-2'>Welcome to Community</h3>
                        <p class='text-gray-600'>Gain full access to research resources, tools, and collaborative
                            opportunities.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <div class='text-center mt-16'>
                <button onclick="document.getElementById('form').scrollIntoView({behavior: 'smooth'})"
                    class='bg-[#103182] hover:bg-[#103182]/80 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition duration-300 transform hover:-translate-y-1'>
                    Start Your Journey Today
                </button>
            </div>
        </div>
    </section>

    <!-- how it work end -->

    <!-- Join Form -->
    <section id='form' class='py-16 bg-white'>
        <div class='max-w-5xl mx-auto px-4 sm:px-6 lg:px-8'>
            <div class='bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg overflow-hidden'>
                <!-- Toggle Switch -->
                <div class='flex justify-center p-6 border-b border-gray-200'>
                    <div class='bg-gray-100 rounded-full p-1 flex space-x-1'>
                        <button id='signUpBtn'
                            class='px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo (empty($login_error)) ? 'bg-[#103182] text-white' : 'text-gray-700'; ?>'>
                            Sign Up
                        </button>
                        <button id='signInBtn'
                            class='px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo (!empty($login_error)) ? 'bg-[#103182] text-white' : 'text-gray-700'; ?>'>
                            Sign In
                        </button>
                    </div>
                </div>

                <div class='grid grid-cols-1 lg:grid-cols-2'>
                    <!-- Left Column - Content (Changes based on state) -->
                    <div id='contentLeft' class='bg-[#103182] p-10 text-white transition-all duration-500'>
                        <!-- Sign Up Content (Default) -->
                        <div id='signUpContent' class='<?php echo (!empty($login_error)) ? 'hidden' : ''; ?>'>
                            <h2 class='text-3xl font-bold mb-4'>Join Our Research Community Today</h2>
                            <p class='text-blue-100 mb-6'>Become part of a network of fitness professionals and
                                researchers dedicated to advancing health science.</p>

                            <ul class='space-y-3 mb-8'>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Access exclusive research content
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Connect with industry experts
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Reliable & Trusted Research
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Publish your own research papers
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Get research funding opportunities
                                </li>
                            </ul>

                            <div class='flex items-center mt-10'>
                                <div class='flex -space-x-2'>
                                    <img class='w-10 h-10 rounded-full border-2 border-blue-500'
                                        src='./images/leader1.avif' alt='Member'>
                                    <img class='w-10 h-10 rounded-full border-2 border-blue-500'
                                        src='./images/leader2.avif' alt='Member'>
                                    <img class='w-10 h-10 rounded-full border-2 border-blue-500'
                                        src='./images/leader3.avif' alt='Member'>
                                </div>
                                <p class='ml-4 text-blue-200'>Join 3,200+ research members</p>
                            </div>
                        </div>

                        <!-- Sign In Content (Hidden by default) -->
                        <div id='signInContent' class='<?php echo (empty($login_error)) ? 'hidden' : ''; ?>'>
                            <h2 class='text-3xl font-bold mb-4'>Welcome Back Researcher!</h2>
                            <p class='text-blue-100 mb-6'>Continue your research journey and access exclusive content.
                            </p>

                            <ul class='space-y-3 mb-8'>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Access your saved research papers
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Continue ongoing research projects
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Connect with your research team
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Track your publication status
                                </li>
                                <li class='flex items-center'>
                                    <i class='fa-solid fa-check text-white mr-3'></i>
                                    Access premium research tools
                                </li>
                            </ul>

                            <div class='mt-10 p-4 bg-blue-800/30 rounded-lg border border-blue-700/30'>
                                <div class='flex items-center'>
                                    <i class='fa-solid fa-shield-alt text-blue-300 text-xl mr-3'></i>
                                    <div>
                                        <p class='font-medium'>Secure & Private</p>
                                        <p class='text-blue-200 text-sm'>Your research data is protected with 256-bit
                                            encryption</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Form Container -->
                    <div id='formContainer' class='p-10 transition-all duration-500'>
                        <!-- Success/Error Messages -->
                        <?php
                        if (isset($_GET['success'])) {
                            echo '<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">' . htmlspecialchars($_GET['success']) . '</div>';
                        }
                        if (isset($_GET['error'])) {
                            echo '<div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                        
                        // Display login error if exists
                        if (!empty($login_error)) {
                            echo '<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                        <div>
                                            <p class="text-red-700 font-medium">Login Failed</p>
                                            <p class="text-red-600 text-sm mt-1">' . htmlspecialchars($login_error) . '</p>
                                        </div>
                                    </div>
                                  </div>';
                        }
                        ?>

                        <!-- Sign Up Form (Default - hidden if login error exists) -->
                        <?php if (!empty($signup_success)): ?>
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                <div>
                                    <p class="text-green-700 font-medium">Signup Successful</p>
                                    <p class="text-green-600 text-sm mt-1">
                                        <?php echo htmlspecialchars($signup_success); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($signup_error)): ?>
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <div>
                                    <p class="text-red-700 font-medium">Signup Failed</p>
                                    <p class="text-red-600 text-sm mt-1"><?php echo htmlspecialchars($signup_error); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <form id='signUpForm' action='./Admin/signup_form_process.php' method='POST'
                            class='space-y-6 <?php echo (!empty($login_error)) ? 'hidden' : ''; ?>'>
                            <div>
                                <h3 class='text-2xl font-semibold text-gray-900 mb-2'>Create Your Account</h3>
                                <p class='text-gray-600 mb-6'>Get started in just a few moments</p>
                            </div>

                            <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>
                                <div>
                                    <label for='firstName' class='block text-sm font-medium text-gray-700 mb-1'>First
                                        Name *</label>
                                    <input type='text' id='firstName' name='firstName' required
                                        class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200'
                                        placeholder='John'>
                                </div>

                                <div>
                                    <label for='lastName' class='block text-sm font-medium text-gray-700 mb-1'>Last Name
                                        *</label>
                                    <input type='text' id='lastName' name='lastName' required
                                        class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200'
                                        placeholder='Doe'>
                                </div>
                            </div>

                            <div>
                                <label for='signupEmail' class='block text-sm font-medium text-gray-700 mb-1'>Email
                                    Address *</label>
                                <input type='email' id='signupEmail' name='email' required
                                    class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200'
                                    placeholder='researcher@example.com'>
                            </div>

                            <div>
                                <label for='username' class='block text-sm font-medium text-gray-700 mb-1'>Username
                                    *</label>
                                <input type='text' id='username' name='username' required
                                    class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200'
                                    placeholder='john_researcher'>
                                <p class='text-xs text-gray-500 mt-1'>This will be your unique research profile ID</p>
                            </div>

                            <div>
                                <label for='password' class='block text-sm font-medium text-gray-700 mb-1'>Password
                                    *</label>
                                <div class='relative'>
                                    <input type='password' id='password' name='password' required
                                        class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200 pr-10'
                                        placeholder='Create a strong password'>
                                    <button type='button' onclick="togglePassword('password')"
                                        class='absolute right-3 top-3.5 text-gray-400 hover:text-gray-600'>
                                        <i class='fa-solid fa-eye'></i>
                                    </button>
                                </div>
                                <div class='mt-2 space-y-1'>
                                    <div class='flex items-center'>
                                        <i id='lengthCheck' class='fa-solid fa-circle text-gray-300 text-xs mr-2'></i>
                                        <span class='text-xs text-gray-600'>At least 8 characters</span>
                                    </div>
                                    <div class='flex items-center'>
                                        <i id='caseCheck' class='fa-solid fa-circle text-gray-300 text-xs mr-2'></i>
                                        <span class='text-xs text-gray-600'>Uppercase & lowercase letters</span>
                                    </div>
                                    <div class='flex items-center'>
                                        <i id='numberCheck' class='fa-solid fa-circle text-gray-300 text-xs mr-2'></i>
                                        <span class='text-xs text-gray-600'>At least one number</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for='confirmPassword'
                                    class='block text-sm font-medium text-gray-700 mb-1'>Confirm Password *</label>
                                <div class='relative'>
                                    <input type='password' id='confirmPassword' name='confirmPassword' required
                                        class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200 pr-10'
                                        placeholder='Confirm your password'>
                                    <button type='button' onclick="togglePassword('confirmPassword')"
                                        class='absolute right-3 top-3.5 text-gray-400 hover:text-gray-600'>
                                        <i class='fa-solid fa-eye'></i>
                                    </button>
                                </div>
                                <p id='passwordMatch' class='text-xs mt-1 hidden'></p>
                            </div>

                            <div class='flex items-start'>
                                <input id='terms' name='terms' type='checkbox' required
                                    class='h-4 w-4 text-[#103182] focus:ring-[#103182] border-gray-300 rounded mt-1'>
                                <label for='terms' class='ml-2 block text-sm text-gray-700'>
                                    I agree to the <a href='#' class='text-[#103182] hover:underline font-medium'>Terms
                                        of Service</a>,
                                    <a href='#' class='text-[#103182] hover:underline font-medium'>Privacy Policy</a>,
                                    and
                                    <a href='#' class='text-[#103182] hover:underline font-medium'>Research Ethics
                                        Guidelines</a>
                                </label>
                            </div>

                            <button type='submit'
                                class='w-full bg-[#103182] text-white py-3 px-4 rounded-lg font-medium hover:bg-[#0d2a6e] transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#103182] transform hover:-translate-y-0.5'>
                                <span class='flex items-center justify-center'>
                                    <i class='fa-solid fa-user-plus mr-2'></i>
                                    Create Research Account
                                </span>
                            </button>
                        </form>

                        <!-- Sign In Form (Visible if login error exists) -->
                        <form id='signInForm' action='./Admin/login_process.php' method='POST'
                            class='space-y-6 <?php echo (empty($login_error)) ? 'hidden' : ''; ?>'>
                            <div>
                                <h3 class='text-2xl font-semibold text-gray-900 mb-2'>Sign In to Your Account</h3>
                                <p class='text-gray-600 mb-6'>Access your research dashboard</p>
                            </div>

                            <div>
                                <label for='signinEmail' class='block text-sm font-medium text-gray-700 mb-1'>Email or
                                    Username</label>
                                <input type='text' id='signinEmail' name='email' required
                                    class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200'
                                    placeholder='researcher@example.com'
                                    value='<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>'>
                            </div>

                            <div>
                                <label for='signinPassword'
                                    class='block text-sm font-medium text-gray-700 mb-1'>Password</label>
                                <div class='relative'>
                                    <input type='password' id='signinPassword' name='password' required
                                        class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#103182] focus:border-[#103182] transition duration-200 pr-10'
                                        placeholder='Enter your password'>
                                    <button type='button' onclick="togglePassword('signinPassword')"
                                        class='absolute right-3 top-3.5 text-gray-400 hover:text-gray-600'>
                                        <i class='fa-solid fa-eye'></i>
                                    </button>
                                </div>
                            </div>

                            <div class='flex items-center justify-between'>
                                <div class='flex items-center'>
                                    <input id='remember' name='remember' type='checkbox'
                                        class='h-4 w-4 text-[#103182] focus:ring-[#103182] border-gray-300 rounded'>
                                    <label for='remember' class='ml-2 block text-sm text-gray-700'>
                                        Remember me
                                    </label>
                                </div>
                                <a href='./forgot_password.php'
                                    class='text-sm text-[#103182] hover:underline font-medium'>
                                    Forgot password?
                                </a>
                            </div>

                            <button type='submit'
                                class='w-full bg-[#103182] text-white py-3 px-4 rounded-lg font-medium hover:bg-[#0d2a6e] transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#103182] transform hover:-translate-y-0.5'>
                                <span class='flex items-center justify-center'>
                                    <i class='fa-solid fa-right-to-bracket mr-2'></i>
                                    Sign In to Dashboard
                                </span>
                            </button>

                            <div class='text-center pt-4 border-t border-gray-200'>
                                <p class='text-sm text-gray-600'>
                                    Don't have a research account?
                                    <button type='button' onclick='showSignUp()'
                                        class='text-[#103182] font-medium hover:underline'>
                                        Create one now
                                    </button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- join form end -->

    <!-- CTA Section -->
    <?php include 'Include/CTAsection.php'; ?>

    <!-- Footer -->
    <?php include 'Include/Footer.php'; ?>

    <script>
    // State management
    let isSignUp = <?php echo (empty($login_error)) ? 'true' : 'false'; ?>;

    // DOM Elements
    const signUpBtn = document.getElementById('signUpBtn');
    const signInBtn = document.getElementById('signInBtn');
    const signUpContent = document.getElementById('signUpContent');
    const signInContent = document.getElementById('signInContent');
    const signUpForm = document.getElementById('signUpForm');
    const signInForm = document.getElementById('signInForm');
    const contentLeft = document.getElementById('contentLeft');
    const formContainer = document.getElementById('formContainer');

    // Password toggle function
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password validation for sign up
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const lengthCheck = document.getElementById('lengthCheck');
    const caseCheck = document.getElementById('caseCheck');
    const numberCheck = document.getElementById('numberCheck');
    const passwordMatch = document.getElementById('passwordMatch');

    if (passwordInput) {
        passwordInput.addEventListener('input', validatePassword);
    }
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }

    function validatePassword() {
        const password = passwordInput.value;

        // Length check
        if (password.length >= 8) {
            lengthCheck.classList.remove('text-gray-300');
            lengthCheck.classList.add('text-green-500');
            lengthCheck.classList.replace('fa-circle', 'fa-check-circle');
        } else {
            lengthCheck.classList.remove('text-green-500');
            lengthCheck.classList.add('text-gray-300');
            lengthCheck.classList.replace('fa-check-circle', 'fa-circle');
        }

        // Case check
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
            caseCheck.classList.remove('text-gray-300');
            caseCheck.classList.add('text-green-500');
            caseCheck.classList.replace('fa-circle', 'fa-check-circle');
        } else {
            caseCheck.classList.remove('text-green-500');
            caseCheck.classList.add('text-gray-300');
            caseCheck.classList.replace('fa-check-circle', 'fa-circle');
        }

        // Number check
        if (/\d/.test(password)) {
            numberCheck.classList.remove('text-gray-300');
            numberCheck.classList.add('text-green-500');
            numberCheck.classList.replace('fa-circle', 'fa-check-circle');
        } else {
            numberCheck.classList.remove('text-green-500');
            numberCheck.classList.add('text-gray-300');
            numberCheck.classList.replace('fa-check-circle', 'fa-circle');
        }

        // Check password match
        checkPasswordMatch();
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmPasswordInput.value;

        if (confirm === '') {
            passwordMatch.classList.add('hidden');
            return;
        }

        passwordMatch.classList.remove('hidden');

        if (password === confirm) {
            passwordMatch.textContent = '✓ Passwords match';
            passwordMatch.className = 'text-xs mt-1 text-green-600';
            confirmPasswordInput.classList.remove('border-red-300');
            confirmPasswordInput.classList.add('border-green-300');
        } else {
            passwordMatch.textContent = '✗ Passwords do not match';
            passwordMatch.className = 'text-xs mt-1 text-red-600';
            confirmPasswordInput.classList.remove('border-green-300');
            confirmPasswordInput.classList.add('border-red-300');
        }
    }

    // Form switching functions
    function showSignUp() {
        isSignUp = true;

        // Update toggle buttons
        signUpBtn.classList.add('bg-[#103182]', 'text-white');
        signUpBtn.classList.remove('text-gray-700');
        signInBtn.classList.remove('bg-[#103182]', 'text-white');
        signInBtn.classList.add('text-gray-700');

        // Update left content with animation
        signUpContent.classList.remove('hidden');
        signInContent.classList.add('hidden');

        // Update forms with animation
        signUpForm.classList.remove('hidden');
        signInForm.classList.add('hidden');

        // Focus on first name field
        setTimeout(() => {
            const firstNameField = document.getElementById('firstName');
            if (firstNameField) {
                firstNameField.focus();
            }
        }, 100);

        // Add slide animation
        contentLeft.style.animation = 'slideInLeft 0.5s ease';
        formContainer.style.animation = 'slideInRight 0.5s ease';

        setTimeout(() => {
            contentLeft.style.animation = '';
            formContainer.style.animation = '';
        }, 500);
    }

    function showSignIn() {
        isSignUp = false;

        // Update toggle buttons
        signInBtn.classList.add('bg-[#103182]', 'text-white');
        signInBtn.classList.remove('text-gray-700');
        signUpBtn.classList.remove('bg-[#103182]', 'text-white');
        signUpBtn.classList.add('text-gray-700');

        // Update left content with animation
        signUpContent.classList.add('hidden');
        signInContent.classList.remove('hidden');

        // Update forms with animation
        signUpForm.classList.add('hidden');
        signInForm.classList.remove('hidden');

        // Focus on email field
        setTimeout(() => {
            const emailField = document.getElementById('signinEmail');
            if (emailField) {
                emailField.focus();
            }
        }, 100);

        // Add slide animation
        contentLeft.style.animation = 'slideInLeft 0.5s ease';
        formContainer.style.animation = 'slideInRight 0.5s ease';

        setTimeout(() => {
            contentLeft.style.animation = '';
            formContainer.style.animation = '';
        }, 500);
    }

    // Event listeners
    signUpBtn.addEventListener('click', showSignUp);
    signInBtn.addEventListener('click', showSignIn);

    // Form submission
    if (signUpForm) {
        signUpForm.addEventListener('submit', function(e) {
            // Basic validation
            if (!this.checkValidity()) {
                this.reportValidity();
                return;
            }

            // Check password match
            if (passwordInput.value !== confirmPasswordInput.value) {
                e.preventDefault();
                alert('Please make sure passwords match');
                return;
            }

            // Check terms agreement
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('Please agree to the terms and conditions');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Creating Account...';
            submitBtn.disabled = true;
        });
    }

    if (signInForm) {
        signInForm.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                this.reportValidity();
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Signing In...';
            submitBtn.disabled = true;
        });
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes shakeError {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);

    // Initialize form based on login error
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($login_error)): ?>
        // If there's a login error, ensure sign in form is shown
        setTimeout(() => {
            showSignIn();

            // Add shake animation to error message
            const errorDiv = formContainer.querySelector('.bg-red-50');
            if (errorDiv) {
                errorDiv.style.animation = 'shakeError 0.5s ease-in-out';
                setTimeout(() => {
                    errorDiv.style.animation = '';
                }, 500);
            }
        }, 100);
        <?php endif; ?>

        // Initialize password validation on load
        if (passwordInput) {
            validatePassword();
        }
    });
    </script>

    <style>
    /* Additional custom styles */
    #signUpBtn,
    #signInBtn {
        transition: all 0.3s ease;
    }

    #signUpBtn:hover,
    #signInBtn:hover {
        transform: translateY(-1px);
    }

    input:focus,
    select:focus {
        outline: none;
        --ring-width: 2px;
    }

    .fa-check-circle {
        animation: popIn 0.3s ease;
    }

    @keyframes popIn {
        0% {
            transform: scale(0.8);
        }

        70% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }
    </style>
</body>

</html>