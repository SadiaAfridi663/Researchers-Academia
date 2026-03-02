<?php
// Show a success or error message after the form is submitted
$status_message = '';
$status_type    = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $status_message = 'Your message has been sent successfully! We will get back to you within 24 hours.';
        $status_type    = 'success';
    } elseif ($_GET['status'] == 'error') {
        $status_message = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'Something went wrong. Please try again.';
        $status_type    = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>Contact Us</title>
    <style>
    /* Apply Outfit as the default font */
    body {
        font-family: 'Outfit', sans-serif;
    }
    </style>

    <style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .animate-slide-in {
        animation: slideIn 1s ease-out forwards;
    }
    </style>

</head>

<body>


    <!-- Header -->
    <?php include 'Include/navbar.php'?>

    <!-- header end -->

    <!-- Status Alert -->
    <?php if (!empty($status_message)): ?>
    <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-lg px-4">
        <div class="rounded-xl px-6 py-4 shadow-2xl flex items-center gap-4 <?php echo $status_type == 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'; ?>">
            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 <?php echo $status_type == 'success' ? 'bg-green-500' : 'bg-red-500'; ?>">
                <i class="fas <?php echo $status_type == 'success' ? 'fa-check' : 'fa-times'; ?> text-white"></i>
            </div>
            <p class="flex-1 text-sm font-medium <?php echo $status_type == 'success' ? 'text-green-800' : 'text-red-800'; ?>">
                <?php echo $status_message; ?>
            </p>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="px-5 lg:h-full "
        style="background: linear-gradient(135deg, rgba(16, 49, 130, 0.9) 0%, rgba(79, 197, 193, 0.85) 100%), 
                url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'%3E%3Ccircle cx=\'50\' cy=\'50\' r=\'2\' fill=\'%23ffffff\' fill-opacity=\'0.1\'/%3E%3C/svg%3E'),
                url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'120\' height=\'120\' viewBox=\'0 0 120 120\'%3E%3Cpath d=\'M20,20 L100,20 L100,100 L20,100 Z\' fill=\'none\' stroke=\'%23ffffff\' stroke-width=\'0.5\' stroke-opacity=\'0.2\'/%3E%3C/svg%3E');background-size: cover, 40px 40px, 120px 120px;background-position: center, 0 0, 60px 60px;position: relative;overflow: hidden;width: 100%;height: 100%;padding-top: 40px;padding-bottom: 40px;display: flex;align-items: center;justify-content: center;">
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="text-center lg:text-left lg:w-1/2">
                    <!-- Animated Heading -->
                    <h1 class="text-5xl md:text-6xl font-extrabold text-white animate-slide-in">
                        Research <span class="text-blue-300">Connect</span>
                    </h1>

                    <!-- Subtext -->
                    <p class="mt-6 text-lg md:text-xl text-blue-100 animate-fade-in delay-500">
                        Connecting brilliant minds for groundbreaking research and innovation.
                        Collaborate with experts across disciplines.
                    </p>

                    <!-- Stats -->
                    <div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-3 ">
                        <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px;"
                            class="p-4 text-center">
                            <div class="text-2xl font-bold text-white">250+</div>
                            <div class="text-blue-100 text-sm">Research Projects</div>
                        </div>
                        <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px;"
                            class="p-4 text-center">
                            <div class="text-2xl font-bold text-white">120+</div>
                            <div class="text-blue-100 text-sm">Experts</div>
                        </div>
                        <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px;"
                            class="p-4 text-center">
                            <div class="text-2xl font-bold text-white">15+</div>
                            <div class="text-blue-100 text-sm">Disciplines</div>
                        </div>
                    </div>

                    <!-- Button -->
                    <a href="#contact-form"
                        class="mt-8 inline-flex items-center px-8 py-3 bg-white text-blue-600 font-semibold rounded-xl shadow-lg hover:bg-blue-50 transition">
                        <span>Collaborate With Us</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="mt-12 lg:mt-0 lg:w-2/5">
                    <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px;"
                        class="p-6 animate-fade-in delay-1500">
                        <h3 class="text-xl font-semibold text-white mb-4">Latest Research Highlight</h3>
                        <div class="bg-white rounded-lg p-4 shadow-md">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-dna text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold">Genomic Data Analysis</h4>
                                    <p class="text-sm text-gray-500">Dr. Sarah Johnson</p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm">
                                Advanced machine learning techniques applied to genomic data, revealing new patterns in
                                gene expression...
                            </p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Biology</span>
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">AI</span>
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Data
                                    Science</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }
        </style>
    </section>





    <!-- Contact Form Section -->
    <section id="contact-form" class="py-16 bg-gradient-to-br from-blue-50 to-gray-50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800">Get In Touch With Us</h2>
                <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">Have questions or want to discuss a potential
                    collaboration? Our team is ready to assist you.</p>
            </div>

            <div class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Contact Information Side -->
                <div class="lg:w-2/5 bg-[#103182] to-blue-700 text-white p-12">
                    <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                    <p class="text-blue-100 mb-10">Fill out the form or contact us using the information below. Our team
                        will respond promptly.</p>

                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-white w-10 h-10 flex items-center justify-center mr-4 rounded-lg shadow">
                                <i class="fas fa-envelope text-[#103182] text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Email Us</h4>
                                <p class="text-blue-100 mt-1">contact@researchconnect.org</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-white w-10 h-10 flex items-center justify-center mr-4 rounded-lg shadow">
                                <i class="fas fa-phone text-lg text-[#103182]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Call Us</h4>
                                <p class="text-blue-100 mt-1">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-white w-10 h-10 flex items-center justify-center mr-4 rounded-lg shadow">
                                <i class="fas fa-map-marker-alt text-[#103182] text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Visit Us</h4>
                                <p class="text-blue-100 mt-1">123 Research Drive<br>Innovation City, IC 12345</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-white w-10 h-10 flex items-center justify-center mr-4 rounded-lg shadow">
                                <i class="fas fa-clock text-[#103182] text-lg"></i>
                            </div>

                            <div>
                                <h4 class="font-semibold">Office Hours</h4>
                                <p class="text-blue-100 mt-1">Mon-Fri: 9AM - 5PM<br>Sat: 10AM - 2PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-blue-500">
                        <h4 class="font-semibold mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="bg-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                                <i class="fab fa-twitter text-[#103182]"></i>
                            </a>
                            <a href="#"
                                class="bg-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                                <i class="fab fa-linkedin-in text-[#103182]"></i>
                            </a>
                            <a href="#"
                                class="bg-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                                <i class="fab fa-facebook-f text-[#103182]"></i>
                            </a>
                            <a href="#"
                                class="bg-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                                <i class="fab fa-instagram text-[#103182]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Side -->
                <div class="lg:w-3/5 p-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Send us a message</h3>
                    <p class="text-gray-600 mb-8">We typically respond within 24 hours</p>

                    <form action="contact_process.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div class="md:col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="name" name="name" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Your full name">
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="md:col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address
                                *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="your.email@example.com">
                            </div>
                        </div>

                        <!-- Phone Field -->
                        <div class="md:col-span-1">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" id="phone" name="phone"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="+1 (555) 000-0000">
                            </div>
                        </div>

                        <!-- Department Selection -->
                        <div class="md:col-span-1">
                            <label for="department"
                                class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                                <select id="department" name="department"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition appearance-none">
                                    <option value="">Select a department</option>
                                    <option value="research">Research Collaboration</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="partnership">Partnership Opportunities</option>
                                    <option value="general">General Inquiry</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Field -->
                        <div class="md:col-span-2">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input type="text" id="subject" name="subject" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="What is this regarding?">
                            </div>
                        </div>

                        <!-- Message Field -->
                        <div class="md:col-span-2">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <div class="relative">
                                <div class="absolute top-3 left-3">
                                    <i class="fas fa-comment text-gray-400"></i>
                                </div>
                                <textarea id="message" name="message" rows="5" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Tell us about your project or inquiry..."></textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="md:col-span-2 mt-4">
                            <button type="submit"
                                class="w-full md:w-auto px-8 py-4 bg-[#103182] text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- map -->
    <div class="w-full h-[400px] my-10  overflow-hidden shadow-lg">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3329.14470902057!2d73.0551!3d33.6844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df957fba3d1dcd%3A0x1234567890abcdef!2sIslamabad%2C%20Pakistan!5e0!3m2!1sen!2s!4v1694512345678"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>




    <!-- CTA Section -->
    <?php include 'Include/CTAsection.php'?>


    <!-- footer -->
    <?php include 'Include/Footer.php'?>



    <script src="./script.js"></script>
</body>

</html>