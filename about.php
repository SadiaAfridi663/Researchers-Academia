<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>About</title>

    <style>
    /* Apply Outfit as the default font */
    body {
        font-family: 'Outfit', sans-serif;
    }

    .font-newyork {
        font-family: 'New York', serif;
    }

    @keyframes slideInLeft {
        0% {
            opacity: 0;
            transform: translateX(-50px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        0% {
            opacity: 0;


            transform: translateX(50px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slide-left {
        animation: slideInLeft 1s ease-out forwards;
    }

    .animate-slide-right {
        animation: slideInRight 1s ease-out forwards;
    }


    /* Default lines */
    #menu-btn span {
        background-color: #333;
    }

    #menu-btn.open #line1 {
        transform: rotate(45deg) translate(5px, 5px);
    }

    #menu-btn.open #line2 {
        opacity: 0;
    }

    #menu-btn.open #line3 {
        transform: rotate(-45deg) translate(5px, -5px);
    }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include 'Include/navbar.php'?>


    <!-- Hero Section -->
    <section
        class="relative w-full min-h-[500px] flex items-center justify-center bg-gray-900 text-white overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="./images/about hero bg.avif" alt="Research Background"
                class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- Content -->
        <div class="relative container mx-auto px-6 lg:px-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center z-10">
            <!-- Left Content -->
            <div class="animate-slide-left">
                <span class="text-sm font-semibold tracking-widest uppercase">
                    Since 2020
                </span>

                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mt-2 
                    bg-gradient-to-r from-[#103182] to-[#4fc5c1] 
                    bg-clip-text text-transparent">
                    Advancing Knowledge Through Research
                </h1>


                <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mt-2"></div>

                <p class="mt-4 text-lg md:text- text-gray-200 max-w-xl leading-relaxed ">
                    Exploring innovative solutions to global challenges through <span
                        class="font-semibold text-blue-400">collaboration</span> and <span
                        class="font-semibold text-[#4fc5c1]">discovery</span>.
                </p>

                <!-- Stats -->
                <div class="mt-4 grid grid-cols-2 gap-6 max-w-md">
                    <div class="stats-card p-5 rounded-xl text-center "
                        style=" backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.08);border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h3 class="text-3xl font-bold text-blue-400">50+</h3>
                        <p class="text-sm text-gray-300">Research Papers</p>
                    </div>
                    <div class="stats-card p-5 rounded-xl text-center"
                        style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h3 class="text-3xl font-bold text-purple-400">12+</h3>
                        <p class="text-sm text-gray-300">Global Partners</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#"
                        class="bg-gradient-to-r from-[#103182] to-[#4fc5c1] hover:from-[#4fc5c1] hover:to-[#103182] transition-all transform hover:scale-105 px-7 py-3.5 rounded-xl shadow-xl font-medium flex items-center group">
                        Explore Research
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="#"
                        class="border border-gray-500 hover:border-blue-400 transition-all px-7 py-3.5 rounded-xl font-medium text-gray-200 hover:text-white flex items-center group">
                        Learn More
                        <i class="fas fa-chevron-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="animate-slide-right flex justify-center">
                <img src="./images/about hero man.png" alt="Research Illustration" class="w-72 md:w-96 drop-shadow-2xl">
            </div>
        </div>
    </section>


    <!-- Join the Cause Section -->
    <div class="max-w-7xl mx-auto px-6 lg:px-10 font-newyork my-16">
        <div class="flex flex-col lg:flex-row justify-center items-center gap-10">


            <div class="flex-shrink-0">
                <img src="./images/team member 4.avif" alt="Join the Cause"
                    class="w-64 h-auto rounded-xl shadow-md object-cover">
            </div>

            <!-- Content -->
            <div class="max-w-2xl text-center lg:text-right space-y-6">
                <h2 class="text-4xl font-bold leading-snug">
                    Join The <span class="text-[#103182]">Cause</span>
                </h2>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Our mission is to make research accessible, impactful, and collaborative.
                    By supporting our initiative, you contribute to groundbreaking discoveries,
                    empower young researchers, and help transform knowledge into real-world solutions.
                </p>
                <div class="flex justify-center lg:justify-end">
                    <a href="#donate"
                        class="bg-[#103182] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#0c2560] transition">
                        Donate Now
                    </a>
                </div>
            </div>

        </div>
    </div>


    <!-- Mission & Vision Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50/30 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-full h-full opacity-5">
            <div
                class="absolute top-10 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse-slow">
            </div>
            <div
                class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse-slow animation-delay-2000">
            </div>
        </div>

        <div class="container mx-auto px-6 lg:px-20 relative z-10">
            <!-- Heading -->
            <div class="text-center mb-16">
                <span class="text-sm font-semibold tracking-widest text-blue-500 uppercase">Our Guiding
                    Principles</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-3">Our Mission & Vision</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-500 mx-auto rounded-full mt-4"></div>
                <p class="mt-5 text-gray-600 max-w-3xl mx-auto text-lg">
                    We are committed to advancing knowledge through impactful research and long-term innovation that
                    transforms lives.
                </p>
            </div>

            <!-- mission cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Mission -->
                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 p-8 lg:p-10 relative overflow-hidden group transition-all duration-500">

                    <!-- Decorative corner -->
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full transition-colors duration-500 group-hover:bg-[#103182]/40">
                    </div>

                    <!-- hover overlay -->
                    <div
                        class="absolute inset-0 bg-[#103182]/80 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl z-0">
                    </div>

                    <div class="mb-6 relative z-10">
                        <div
                            class="w-14 h-14 bg-[#103182] rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-clock text-white text-2xl"></i>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 group-hover:text-white relative z-10">Our Mission
                    </h3>
                    <p class="text-gray-600 leading-relaxed text-lg group-hover:text-white relative z-10">
                        To make research more accessible, collaborative, and impactful by creating a platform
                        that empowers researchers and inspires innovation across the globe.
                    </p>

                    <div class="mt-6 space-y-2 relative z-10">
                        <div class="flex items-center">
                            <i class="fa-solid fa-check text-[#103182] mr-2 group-hover:text-white"></i>
                            <span class="text-gray-700 group-hover:text-white">Democratizing research access</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-check text-[#103182] mr-2 group-hover:text-white"></i>
                            <span class="text-gray-700 group-hover:text-white">Fostering global collaboration</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-check text-[#103182] mr-2 group-hover:text-white"></i>
                            <span class="text-gray-700 group-hover:text-white">Empowering researchers</span>
                        </div>
                    </div>
                </div>






                <!--vission -->
                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 lg:p-10 relative overflow-hidden group transition-all duration-500">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-bl-full transition-colors duration-500 group-hover:bg-[#103182]/40">
                    </div>

                    <!-- Hover overlay  -->
                    <div
                        class="absolute inset-0 bg-[#103182]/80 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl">
                    </div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <div class="mb-6">
                            <div
                                class="w-14 h-14 bg-[#103182] rounded-xl flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                                <i class="fa-solid fa-arrow-trend-up text-white text-2xl"></i>
                            </div>
                        </div>

                        <h3
                            class="text-2xl font-bold text-gray-800 mb-4 transition-colors duration-500 group-hover:text-white">
                            Our Vision
                        </h3>
                        <p
                            class="text-gray-600 leading-relaxed text-lg transition-colors duration-500 group-hover:text-white">
                            To become a leading global hub where knowledge transforms into real-world
                            solutions, fostering progress and shaping a sustainable future for
                            generations to come.
                        </p>

                        <!-- Vision highlights -->
                        <div class="mt-6 space-y-2">
                            <div class="flex items-center">
                                <i
                                    class="fas fa-check text-[#103182] mr-2 transition-colors duration-500 group-hover:text-white"></i>
                                <span
                                    class="text-gray-700 transition-colors duration-500 group-hover:text-white">Creating
                                    real-world solutions</span>
                            </div>
                            <div class="flex items-center">
                                <i
                                    class="fas fa-check text-[#103182] mr-2 transition-colors duration-500 group-hover:text-white"></i>
                                <span
                                    class="text-gray-700 transition-colors duration-500 group-hover:text-white">Fostering
                                    global progress</span>
                            </div>
                            <div class="flex items-center">
                                <i
                                    class="fas fa-check text-[#103182] mr-2 transition-colors duration-500 group-hover:text-white"></i>
                                <span
                                    class="text-gray-700 transition-colors duration-500 group-hover:text-white">Building
                                    sustainable futures</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Our Values -->

            <div class="max-7xl mx-auto my-15">




                <div class="max-w-2xl mx-auto text-center space-y-2">
                    <h2 class="text-3xl font-semibold">OUR VALUES</h2>
                    <h2 class="uppercase text-[#22d4ad] font-bold">What drives us</h2>
                    <p class="text-md text-gray-500 mt-2">
                        We believe research should be open, collaborative, and impactful. Our work is guided by a
                        commitment to
                        knowledge sharing, innovation, and integrity—ensuring that science serves society.
                    </p>
                    <p class="text-gray-600">
                        Our foundation rests on four key principles that shape everything we do.
                    </p>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                    <!-- TRUST -->
                    <div
                        class="relative p-8 shadow-md border border-gray-200 rounded-lg text-center hover:shadow-xl transition overflow-hidden">

                        <div
                            class="absolute inset-0 bg-gradient-to-br from-transparent  to-[#103182]/20 pointer-events-none">
                        </div>

                        <div class="relative">
                            <div
                                class="w-14 h-14 mx-auto mb-4 flex items-center justify-center bg-[#103182] rounded-full">
                                <i class="fa-solid fa-handshake text-white text-2xl"></i>
                            </div>
                            <h2 class="text-lg font-semibold">TRUST</h2>
                            <p class="text-gray-500 mt-2">We prioritize transparency and honesty in everything we do.
                            </p>
                        </div>
                    </div>

                    <!-- ACCESSIBILITY -->
                    <div
                        class="relative p-8 shadow-md border border-gray-200 rounded-lg text-center hover:shadow-xl transition overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-transparent  to-[#103182]/20 pointer-events-none">
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 mx-auto mb-4 flex items-center justify-center bg-[#103182] rounded-full">
                                <i class="fa-solid fa-universal-access text-white text-2xl"></i>
                            </div>
                            <h2 class="text-lg font-semibold uppercase">Accessibility</h2>
                            <p class="text-gray-500 mt-2">Making research and opportunities accessible to all.</p>
                        </div>
                    </div>

                    <!-- INNOVATION -->
                    <div
                        class="relative p-8 shadow-md border border-gray-200 rounded-lg text-center hover:shadow-xl transition overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-transparent  to-[#103182]/20 pointer-events-none">
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 mx-auto mb-4 flex items-center justify-center bg-[#103182] rounded-full">
                                <i class="fa-solid fa-lightbulb text-white text-2xl"></i>
                            </div>
                            <h2 class="text-lg font-semibold">INNOVATION</h2>
                            <p class="text-gray-500 mt-2">Driving progress with creative and innovative solutions.</p>
                        </div>
                    </div>

                    <!-- GLOBAL REACH -->
                    <div
                        class="relative p-8 shadow-md border border-gray-200 rounded-lg text-center hover:shadow-xl transition overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-transparent  to-[#103182]/20 pointer-events-none">
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 mx-auto mb-4 flex items-center justify-center bg-[#103182] rounded-full">
                                <i class="fa-solid fa-globe text-white text-2xl"></i>
                            </div>
                            <h2 class="text-lg font-semibold">GLOBAL REACH</h2>
                            <p class="text-gray-500 mt-2">Connecting with people and ideas across the globe.</p>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </section>


    <!-- Our Achievemnets -->
    <section class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center my-16 px-6">

        <!-- Achievements Text -->
        <div class="max-w-md mx-auto">
            <h2 class="text-2xl font-semibold text-[#103182] uppercase text-center md:text-left">
                Our Achievements
            </h2>
            <h3 class="text-gray-400 font-md text-center md:text-left">
                Recognizing the milestones that define our research journey
            </h3>

            <!-- Achievement Items -->
            <div class="space-y-5 mt-6">
                <!-- Achievement Item -->
                <div class="flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center bg-[#103182] text-white rounded-full shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <p class="text-gray-700">Published <span class="font-semibold">20+ research papers</span> in reputed
                        international journals.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center bg-[#103182] text-white rounded-full shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <p class="text-gray-700">Successfully presented findings at <span class="font-semibold">5+
                            international conferences</span>.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center bg-[#103182] text-white rounded-full shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <p class="text-gray-700">Collaborated with <span class="font-semibold">leading universities and
                            institutions</span> worldwide.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center bg-[#103182] text-white rounded-full shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <p class="text-gray-700">Research work cited in <span class="font-semibold">100+ academic
                            studies</span> globally.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center bg-[#103182] text-white rounded-full shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <p class="text-gray-700">Developed <span class="font-semibold">innovative solutions</span>
                        addressing real-world challenges.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center bg-[#103182] text-white rounded-full shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <p class="text-gray-700">Guided <span class="font-semibold">undergraduate & graduate students</span>
                        in impactful research projects.</p>
                </div>
            </div>

        </div>

        <!-- Achievements Image -->
        <div class="flex justify-center">
            <img src="./images/research achivement.jpg" alt="Research Achievements"
                class="max-w-lg h-[500px] object-cover rounded-lg shadow-md">
        </div>

    </section>




    <!-- CTA Section -->
    <?php include 'Include/CTAsection.php'?>


    <!-- footer -->
    <?php include 'Include/Footer.php'?>





    <script src="./script.js"></script>
</body>

</html>