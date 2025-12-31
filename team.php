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

    <title>Team</title>

    <style>
        /* Apply Outfit as the default font */
        body {
            font-family: 'Outfit', sans-serif;
        }

        /* Default lines */
        #menu-btn span {
            background-color: #333;
            /* dark for white bg */
        }

        /* Open (Cross) state */
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
    <!-- header -->
    <?php include 'include/navbar.php'; ?>


    <!-- hero section -->

    <div class="  bg-gradient-to-br from-white to-gray-50">
        <section class="relative max-w-7xl mx-auto px-2 lg:px-20 py-5 lg:py-10 md:py-0  rounded-2xl  overflow-hidden">

            <div class="flex flex-col lg:flex-row justify-center items-center  z-10">
                <!-- Left Content -->
                <div class=" text-center lg:text-left space-y-5 lg:w-2/5  lg:mb-0">
                    <h2 class="text-5xl md:text-6xl font-bold text-gray-800 tracking-tight">
                        MEET <span class="text-5xl md:text-6xl italic font-semibold text-[#103182] tracking-tight">
                            OUR</span></h2>

                    <h2 class="text-5xl md:text-6xl font-bold text-gray-800 tracking-tight">
                        TEAM</h2>

                    <div class="h-1 w-20 bg-[#103182] mx-auto lg:mx-0 my-6"></div>

                    <p class="text-lg text-gray-600 max-w-md leading-relaxed">
                        Our creative and passionate team members are the backbone of our
                        success.
                        Get to know the talented professionals behind our innovative work.
                    </p>

                    <button
                        class="mt-8 px-8 py-3 bg-[#103182] hover:bg-[#103182]/90 cursor-pointer text-white font-medium rounded-lg transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                        Explore Team
                    </button>
                </div>

                <!-- Right Stacked Slider -->
                <div class="relative mx-auto flex items-center justify-center w-full lg:w-1/2 h-96 lg:h-[500px]">
                    <div id="stackedSlider" class="relative flex items-center justify-center">
                        <!-- Team member 1 -->
                        <div
                            class="team-slide absolute w-64 h-80 md:w-72 md:h-96 transition-all duration-700 ease-out rounded-xl overflow-hidden">
                            <img src="./images/team  1.avif" alt="Team Member 1" class="w-full h-full object-cover">
                        </div>

                        <!-- member 2 -->
                        <div
                            class="team-slide absolute w-64 h-80 md:w-72 md:h-96 transition-all duration-700 ease-out rounded-xl overflow-hidden">
                            <img src="./images/team 2.avif" alt="Team Member 2" class="w-full h-full object-cover">
                        </div>

                        <!-- member 3 -->
                        <div
                            class="team-slide absolute w-64 h-80 md:w-72 md:h-96 transition-all duration-700 ease-out rounded-xl overflow-hidden">
                            <img src="./images/team 3.avif" alt="Team Member 3" class="w-full h-full object-cover">
                        </div>

                        <!--member 4 -->
                        <div
                            class="team-slide absolute w-64 h-80 md:w-72 md:h-96 transition-all duration-700 ease-out rounded-xl overflow-hidden">
                            <img src="./images/team 4.avif" alt="Team Member 4" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <!-- hero ends here -->



    <!-- LEADERS start here -->

    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800">Our Leadership</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Visionary leaders guiding our company towards
                    innovation and excellence.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Founder 1 -->
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden group">
                    <div class="flex flex-col md:flex-row h-full">

                        <!-- Image Section -->
                        <div class="md:w-2/5 relative">
                            <div class="w-full h-full">
                                <img src="./images/leader 1.avif" alt="Robert Johnson"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                <h3 class="text-2xl font-bold text-white">Robert Johnson</h3>
                                <p class="text-blue-200 font-medium">Founder & CEO</p>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="md:w-3/5 p-8">
                            <div class="flex space-x-4 mb-6">
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-twitter w-5 h-5"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                            </div>

                            <p class="text-gray-700 mb-6 leading-relaxed">
                                With over 15 years of industry experience, Robert founded our company with a vision to
                                revolutionize the digital landscape. His strategic leadership has guided our growth from
                                a startup to a market leader.
                            </p>

                            <div class="border-l-4 border-blue-500 pl-4 mb-6">
                                <p class="text-gray-600 italic">
                                    "Innovation is not about saying yes to everything. It's about saying no to all but
                                    the most crucial features."
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Strategic
                                    Vision</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Leadership</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Innovation</span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Founder 2 -->
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden group">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-2/5 relative">
                            <div class="h-80 md:h-full overflow-hidden">
                                <img src="./images/leader 2.avif" alt="Sarah Williams"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                <h3 class="text-2xl font-bold text-white">Sarah Williams</h3>
                                <p class="text-blue-200 font-medium">Co-Founder & CTO</p>
                            </div>
                        </div>

                        <div class="md:w-3/5 p-8">
                            <div class="flex space-x-4 mb-6">
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-twitter w-5 h-5"></i>
                                </a>

                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>

                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                            </div>

                            <p class="text-gray-700 mb-6 leading-relaxed">
                                Sarah brings technical excellence and innovation to our leadership team. With a PhD in
                                Computer Science and numerous patents to her name, she drives our technological vision
                                and R&D initiatives.
                            </p>

                            <div class="border-l-4 border-blue-500 pl-4 mb-6">
                                <p class="text-gray-600 italic">"Technology should serve humanity, not the other way
                                    around. We build tools that empower people to achieve more."</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Technical
                                    Innovation</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Research &
                                    Development</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Product
                                    Strategy</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Senior Leader 1 -->
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden group">
                    <div class="flex flex-col md:flex-row h-full">
                        <div class="md:w-2/5 relative">
                            <div class="h-80 md:h-full overflow-hidden">
                                <img src="./images/leader 3.avif" alt="Michael Chen"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                <h3 class="text-2xl font-bold text-white">Michael Chen</h3>
                                <p class="text-blue-200 font-medium">Chief Operations Officer</p>
                            </div>
                        </div>

                        <div class="md:w-3/5 p-8">
                            <div class="flex space-x-4 mb-6">
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-twitter w-5 h-5"></i>
                                </a>

                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>

                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                            </div>

                            <p class="text-gray-700 mb-6 leading-relaxed">
                                Michael oversees our global operations with a focus on efficiency and scalability. His
                                expertise in process optimization has been instrumental in our international expansion
                                and operational excellence.
                            </p>

                            <div class="border-l-4 border-blue-500 pl-4 mb-6">
                                <p class="text-gray-600 italic">"Excellence is not a skill, it's an attitude. We pursue
                                    operational perfection in everything we do."</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Operations</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Global
                                    Expansion</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Process
                                    Optimization</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Senior Leader 2 -->
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden group">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-2/5 relative">
                            <div class="h-80 md:h-full overflow-hidden">
                                <img src="./images/leader 4.avif" alt="Jessica Martinez"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                <h3 class="text-2xl font-bold text-white">Jessica Martinez</h3>
                                <p class="text-blue-200 font-medium">Chief Marketing Officer</p>
                            </div>
                        </div>

                        <div class="md:w-3/5 p-8">
                            <div class="flex space-x-4 mb-6">
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-twitter w-5 h-5"></i>
                                </a>

                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>

                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                            </div>

                            <p class="text-gray-700 mb-6 leading-relaxed">
                                Jessica leads our global marketing strategy with a data-driven approach. Her innovative
                                campaigns have significantly increased our brand recognition and market share across all
                                regions.
                            </p>

                            <div class="border-l-4 border-blue-500 pl-4 mb-6">
                                <p class="text-gray-600 italic">"Great marketing doesn't feel like marketing. It feels
                                    like a genuine conversation with someone who understands your needs."</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Brand
                                    Strategy</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Digital
                                    Marketing</span>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full">Growth
                                    Hacking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- LEADERS ends here -->



    <!-- member start here -->

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800">Our Creative Team</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Meet the talented professionals who make our
                    vision a reality with their expertise and dedication.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Team Member 1 -->
                <div
                    class="group relative bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                    <div class="h-72 overflow-hidden">
                        <img src="./images/team page member 1.avif" alt="Sarah Johnson"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Sarah Johnson</h3>
                        <p class="text-blue-600 font-medium">Creative Director</p>
                        <p class="mt-3 text-gray-600">Leads our creative vision with 10+ years of experience in branding
                            and visual design.</p>

                        <div class="mt-5 flex space-x-3">

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Hover overlay -->
                    <div
                        class="absolute inset-0 bg-[#103182] bg-opacity-90 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-6 text-white">
                        <h3 class="text-xl font-semibold">Sarah Johnson</h3>
                        <p class="text-blue-200 font-medium">Creative Director</p>
                        <p class="mt-3 text-center">Leads our creative vision with 10+ years of experience in branding
                            and visual design across multiple industries.</p>
                        <div class="mt-5 flex space-x-4">
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div
                    class="group relative bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                    <div class="h-72 overflow-hidden">
                        <img src="./images/team page member 2.avif" alt="Michael Chen"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Michael Chen</h3>
                        <p class="text-blue-600 font-medium">Lead Developer</p>
                        <p class="mt-3 text-gray-600">Full-stack developer specializing in React, Node.js, and cloud
                            architecture solutions.</p>

                        <div class="mt-5 flex space-x-3">

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Hover overlay -->
                    <div
                        class="absolute inset-0 bg-[#103182] bg-opacity-90 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-6 text-white">
                        <h3 class="text-xl font-semibold">Michael Chen</h3>
                        <p class="text-blue-200 font-medium">Lead Developer</p>
                        <p class="mt-3 text-center">Full-stack developer with expertise in React, Node.js, and cloud
                            architecture. Passionate about creating scalable solutions.</p>
                        <div class="mt-5 flex space-x-4">
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div
                    class="group relative bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                    <div class="h-72 overflow-hidden">
                        <img src="./images/team member 5.avif" alt="Emma Rodriguez"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Emma Rodriguez</h3>
                        <p class="text-blue-600 font-medium">Marketing Strategist</p>
                        <p class="mt-3 text-gray-600">Develops data-driven marketing campaigns that drive growth and
                            engagement.</p>

                        <div class="mt-5 flex space-x-3">

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>

                        </div>
                    </div>

                    <!-- Hover overlay -->
                    <div
                        class="absolute inset-0 bg-[#103182] bg-opacity-90 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-6 text-white">
                        <h3 class="text-xl font-semibold">Emma Rodriguez</h3>
                        <p class="text-blue-200 font-medium">Marketing Strategist</p>
                        <p class="mt-3 text-center">Specializes in data-driven marketing campaigns with expertise in
                            SEO, content strategy, and social media marketing.</p>
                        <div class="mt-5 flex space-x-4">
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div
                    class="group relative bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                    <div class="h-72 overflow-hidden">
                        <img src="./images/team page member 4.avif" alt="David Wilson"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">David Wilson</h3>
                        <p class="text-blue-600 font-medium">Project Manager</p>
                        <p class="mt-3 text-gray-600">Ensures projects are delivered on time, within scope, and
                            exceeding expectations.</p>

                        <div class="mt-5 flex space-x-3">

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>

                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Hover overlay -->
                    <div
                        class="absolute inset-0 bg-[#103182] bg-opacity-90 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-6 text-white">
                        <h3 class="text-xl font-semibold">David Wilson</h3>
                        <p class="text-blue-200 font-medium">Project Manager</p>
                        <p class="mt-3 text-center">Experienced in Agile methodologies with a track record of delivering
                            complex projects on time and within budget.</p>
                        <div class="mt-5 flex space-x-4">
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-twitter w-5 h-5"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            <a href="#"
                                class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- members end here -->



   
    <!-- CTA Section -->
      <?php include 'include/CTAsection.php'?>

        <!-- Footer -->
        <?php include 'include/footer.php';?>





    <script src="./script.js"></script>
</body>

</html>