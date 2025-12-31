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

    <title>News</title>
    <style>
        /* Apply Outfit as the default font */
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>

</head>

<body>



  <!-- Header -->
    <!-- Header -->
       <?php include 'include/navbar.php'?>

    <!-- header end -->

    <!-- HERO -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800">Research News & Insights</h2>
                <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                    Stay updated with the latest breakthroughs, innovations, and discoveries shaping the future of
                    science
                </p>
            </div>

            <div class="flex flex-col lg:flex-row justify-center items-start gap-8">
                <!-- Left Image -->
                <div class="lg:w-1/2">
                    <div
                        class="relative overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-[1.02]">
                        <img src="./images/news image 4.avif" alt="Research Spotlight"
                            class="w-full h-[500px] object-cover">


                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-[#103182] text-white text-sm font-semibold rounded-full">FEATURED</span>
                        </div>

                        <!-- Text Overlay -->
                        <div
                            class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-6 text-white">
                            <div class="flex items-center text-sm mb-2">
                                <span class="bg-blue-500 rounded-full w-2 h-2 mr-2"></span>
                                <span>October 15, 2023</span>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Research Spotlight</h3>
                            <p class="text-sm leading-relaxed mb-4">
                                Highlighting breakthrough studies, ongoing projects, and innovative solutions
                                shaping the future of science and technology.
                            </p>
                            <a href="#"
                                class="inline-flex items-center text-sm font-semibold text-white hover:text-[#103182] transition">
                                Read Full Story
                                <i class="fa-solid fa-arrow-right ml-2"></i>

                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Side Content -->
                <div class="lg:w-1/2 flex flex-col gap-6">
                    <div
                        class="relative overflow-hidden rounded-2xl shadow-lg transition-transform duration-300 hover:scale-[1.02]">
                        <img src="./images/news image 1.avif" alt="Technology & Innovation"
                            class="w-full h-[240px] object-cover">

                        <div
                            class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-5 text-white">
                            <div class="flex items-center text-xs mb-1">
                                <span class="bg-green-500 rounded-full w-2 h-2 mr-2"></span>
                                <span>October 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">Technology & Innovation</h3>
                            <p class="text-xs leading-snug mb-3">
                                Exploring emerging tools, AI-driven solutions, and digital platforms
                                that empower researchers and institutions.
                            </p>
                            <a href="#"
                                class="text-xs font-semibold text-white hover:text-[#103182] transition flex items-center">
                                Read More
                                <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Bottom Images -->
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div
                            class="relative overflow-hidden rounded-2xl shadow-lg transition-transform duration-300 hover:scale-[1.02] sm:w-1/2">
                            <img src="./images/new slide 2.avif" alt="Health Research"
                                class="w-full h-[240px] object-cover">

                            <div
                                class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-4 text-white">
                                <div class="flex items-center text-xs mb-1">
                                    <span class="bg-purple-500 rounded-full w-2 h-2 mr-2"></span>
                                    <span>October 10, 2023</span>
                                </div>
                                <h3 class="text-lg font-semibold">Health & Medicine</h3>
                                <p class="text-xs mt-1 leading-snug mb-2">
                                    Advancements in medical research, wellness studies,
                                    and data-driven healthcare approaches.
                                </p>
                                <a href="#"
                                    class="text-xs font-semibold text-white hover:text-[#103182] transition flex items-center">
                                    Read More
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Second Small Image -->
                        <div
                            class="relative overflow-hidden rounded-2xl shadow-lg transition-transform duration-300 hover:scale-[1.02] sm:w-1/2">
                            <img src="./images/news image 3.avif" alt="Global Studies"
                                class="w-full h-[240px] object-cover ">

                            <div
                                class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/50 to-transparent p-4 text-white">
                                <div class="flex items-center text-xs mb-1">
                                    <span class="bg-orange-500 rounded-full w-2 h-2 mr-2"></span>
                                    <span>October 8, 2023</span>
                                </div>
                                <h3 class="text-lg font-semibold">Global Research</h3>
                                <p class="text-xs mt-1 leading-snug mb-2">
                                    Insights into global challenges, sustainability, and
                                    collaborative projects shaping tomorrow's world.
                                </p>
                                <a href="#"
                                    class="text-xs font-semibold text-white hover:text-[#103182] transition flex items-center">
                                    Read More
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Research Highlights Row Slider -->
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto overflow-hidden py-5 ">
            <!-- Title -->
            <button class="bg-[#11327f] text-white p-2 rounded-t-xl ml-5">
                Breaking News
            </button>

            <!-- Track -->
            <div id="row-track" class="flex  items-center  transition-transform duration-500 ease-in-out">

                <!-- Slide 1 -->
                <div class="w-full sm:w-1/2 lg:w-1/3 px-4  flex-shrink-0">
                    <a href="./blog_detail.html">
                        <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start h-full min-h-[140px]">
                            <img src="./images/news slide 1.avif"
                                class="w-[140px] h-24 object-cover rounded-md flex-shrink-0" alt="Legal Research">
                            <div class="flex flex-col justify-between">
                                <h3 class="text-md md:text-lg font-bold text-gray-800">Legal Case Analysis</h3>
                                <p class="text-gray-600 text-sm md:text-base">
                                    Research-driven approach to strengthen legal arguments & precedents.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Slide 2 -->
                <div class="w-full sm:w-1/2 lg:w-1/3 px-4 flex-shrink-0">
                    <a href="./blog_detail.html">
                        <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start h-full min-h-[140px]">
                            <img src="./images/new slide 2.avif"
                                class="w-[140px] h-24 object-cover rounded-md flex-shrink-0" alt="Forensic Research">
                            <div class="flex flex-col justify-between">
                                <h3 class="text-md md:text-lg font-bold text-gray-800">Forensic Investigation</h3>
                                <p class="text-gray-600 text-sm md:text-base">
                                    Scientific techniques used in solving crimes and presenting evidence.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Slide 3 -->
                <div class="w-full sm:w-1/2 lg:w-1/3 px-4 flex-shrink-0">
                    <a href="./blog_detail.html">
                        <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start h-full min-h-[140px]">
                            <img src="./images/news slide 3.avif"
                                class="w-[140px] h-24 object-cover rounded-md flex-shrink-0" alt="Medical Research">
                            <div class="flex flex-col justify-between">
                                <h3 class="text-md md:text-lg font-bold text-gray-800">Medical Legal Studies</h3>
                                <p class="text-gray-600 text-sm md:text-base">
                                    Exploring connections between healthcare, ethics & law enforcement.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Slide 4 -->
                <div class="w-full sm:w-1/2 lg:w-1/3 px-4 flex-shrink-0">
                    <a href="./blog_detail.html">
                        <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start h-full min-h-[140px]">
                            <img src="./images/news slide 4.avif"
                                class="w-[140px] h-24 object-cover rounded-md flex-shrink-0" alt="Criminology">
                            <div class="flex flex-col justify-between">
                                <h3 class="text-md md:text-lg font-bold text-gray-800">Criminology Insights</h3>
                                <p class="text-gray-600 text-sm md:text-base">
                                    Research on criminal behavior patterns to support justice systems.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Slide 5 -->
                <div class="w-full sm:w-1/2 lg:w-1/3 px-4 flex-shrink-0">
                    <a href="./blog_detail.html">
                        <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start h-full min-h-[140px]">
                            <img src="./images/news slide 5.avif"
                                class="w-[140px] h-24 object-cover rounded-md flex-shrink-0" alt="Courtroom Analysis">
                            <div class="flex flex-col justify-between">
                                <h3 class="text-md md:text-lg font-bold text-gray-800">Judicial Case Studies</h3>
                                <p class="text-gray-600 text-sm md:text-base">
                                    In-depth analysis of courtroom proceedings, and legal outcomes.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Slide 6 -->
                <div class="w-full sm:w-1/2 lg:w-1/3 px-4 flex-shrink-0">
                    <a href="./blog_detail.html">
                        <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start h-full min-h-[140px]">
                            <img src="./images/news slide 6.avif"
                                class="w-[140px] h-24 object-cover rounded-md flex-shrink-0" alt="Legal Tech">
                            <div class="flex flex-col justify-between">
                                <h3 class="text-md md:text-lg font-bold text-gray-800">Legal Technology</h3>
                                <p class="text-gray-600 text-sm md:text-base">
                                    AI & data-driven tools supporting legal & medical research.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>



    <!-- Research Blog Section -->
    <div class="max-w-7xl mx-auto lg:pt-16 pt-6 pb-8 lg:px-10 px-4">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800">Research Insights & Publications</h2>
            <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                Discover the latest research findings, case studies, and academic publications from our team
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Blog Categories / Filters -->
                <div class="flex flex-wrap gap-3 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <button
                        class="px-5 py-2 rounded-lg bg-[#103182] text-white text-sm font-medium shadow-md transition hover:bg-blue-700 flex items-center">
                        <i class="fa-solid fa-globe w-4 h-4 mr-2"></i>
                        All Research
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium border border-gray-200 transition hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 flex items-center">
                        <i class="fa-solid fa-shield-halved w-4 h-4 mr-2"></i>

                        Legal Research
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium border border-gray-200 transition hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 flex items-center">
                        <i class="fa-solid fa-droplet text-base mr-2" aria-hidden="true"></i>
                        Forensic
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium border border-gray-200 transition hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 flex items-center">
                        <i class="fa-solid fa-gear w-4 h-4 mr-2"></i>
                        Medical-Legal
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium border border-gray-200 transition hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 flex items-center">
                        <i class="fa-solid fa-chart-simple w-4 h-4 mr-2"></i>
                        Criminology
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium border border-gray-200 transition hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 flex items-center">
                        <i class="fa-solid fa-file-lines w-4 h-4 mr-2"></i>
                        Case Studies
                    </button>
                </div>

                <!-- blog 1 ADMIN -->
                <div
                    class="bg-white rounded-2xl shadow-lg overflow-hidden transition-transform duration-300 hover:shadow-xl">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0 md:w-1/2">
                            <img src="./images/blog 1.avif" alt="Featured Research"
                                class="h-64 w-full md:h-full object-cover">
                        </div>
                        <a href="./blog_detail.html">
                            <div class="p-8">
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                        Featured Research
                                    </span>
                                    <span class="ml-3 text-xs text-gray-500">Sept 10, 2025</span>
                                </div>
                                <h2 class="mt-4 text-2xl font-bold text-gray-800">AI in Legal Research: Transforming
                                    Case
                                    Analysis</h2>
                                <p class="mt-3 text-gray-600 leading-relaxed">
                                    Discover how Artificial Intelligence is reshaping courtroom strategies and
                                    accelerating
                                    research processes for lawyers and students. Our latest study demonstrates a 47%
                                    improvement in case analysis efficiency.
                                </p>
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-800 font-semibold">A</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Admin</p>
                                            <p class="text-xs text-gray-500">Research Team Lead</p>
                                        </div>
                                    </div>
                                    <a href="#"
                                        class="inline-flex items-center text-[#103182] font-medium hover:text-blue-800 transition">
                                        Read Study
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Resear BLOGS -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Blog Card 1 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                        <div class="relative">
                            <img src="./images/blog 2.avif" class="w-full h-48 object-cover" alt="Courtroom Psychology">
                            <span
                                class="absolute top-4 left-4 bg-white/90 text-gray-800 text-xs px-2 py-1 rounded-md font-medium">
                                Legal Research
                            </span>
                        </div>
                        <a href="./blog_detail.html">
                            <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Courtroom Psychology</h3>
                            <p class="text-sm text-gray-600 mb-4">Understanding jury behavior and witness credibility in
                                trials through cognitive research methodologies.</p>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-500">
                                    <i class="fa-regular fa-clock w-4 h-4 mr-1 text-gray-500"></i>
                                    <span>5 min read</span>
                                </div>
                                <a href="#" class="text-[#103182] font-medium hover:text-[#103182]/90 transition">Read
                                    More</a>
                            </div>
                        </div>
                        </a>
                    </div>

                    <!-- Blog Card 2 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                        <div class="relative">
                            <img src="./images/blog 3.avif" class="w-full h-48 object-cover" alt="Forensic Evidence">
                            <span
                                class="absolute top-4 left-4 bg-white/90 text-gray-800 text-xs px-2 py-1 rounded-md font-medium">
                                Forensic
                            </span>
                        </div>
                        <a href="./blog_detail.html">
                            <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Forensic Evidence in Criminal Trials</h3>
                            <p class="text-sm text-gray-600 mb-4">How DNA and digital forensics help strengthen justice
                                systems and improve conviction accuracy.</p>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-500">
                                    <i class="fa-regular fa-clock w-4 h-4 mr-1 text-gray-500"></i>
                                    <span>7 min read</span>
                                </div>
                                <a href="#" class="text-[#103182] font-medium hover:text-[#103182]/90 transition">Read
                                    More</a>
                            </div>
                        </div>
                        </a>
                    </div>

                    <!-- Blog Card 3 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                        <div class="relative">
                            <img src="./images/blog 4.avif" class="w-full h-48 object-cover" alt="Medical-Legal Ethics">
                            <span
                                class="absolute top-4 left-4 bg-white/90 text-gray-800 text-xs px-2 py-1 rounded-md font-medium">
                                Medical-Legal
                            </span>
                        </div>
                        <a href="./blog_detail.html">
                            <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Medical-Legal Ethics</h3>
                            <p class="text-sm text-gray-600 mb-4">Exploring ethical challenges at the intersection of
                                medicine and law through contemporary case studies.</p>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-500">
                                    <i class="fa-regular fa-clock w-4 h-4 mr-1 text-gray-500"></i>
                                    <span>6 min read</span>
                                </div>
                                <a href="#" class="text-[#103182] font-medium hover:text-[#103182]\90 transition">Read
                                    More</a>
                            </div>
                        </div>
                        </a>
                    </div>

                    <!-- Blog Card 4 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                        <div class="relative">
                            <img src="./images/blog 5.avif" class="w-full h-48 object-cover"
                                alt="Cybercrime Case Studies">
                            <span
                                class="absolute top-4 left-4 bg-white/90 text-gray-800 text-xs px-2 py-1 rounded-md font-medium">
                                Case Studies
                            </span>
                        </div>
                        <a href="./blog_detail.html">
                            <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Cybercrime Case Studies</h3>
                            <p class="text-sm text-gray-600 mb-4">Analyzing real-world cybercrime cases and judicial
                                responses to emerging digital threats.</p>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-500">
                                    <i class="fa-regular fa-clock w-4 h-4 mr-1 text-gray-500"></i>
                                    <span>8 min read</span>
                                </div>
                                <a href="#" class="text-[#103182] font-medium hover:text-[#103182]/90 transition">Read
                                    More</a>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center items-center gap-2 mt-10">
                    <button
                        class="h-10 w-10 flex items-center justify-center bg-white border border-gray-200 rounded-md text-gray-600 hover:bg-gray-50 transition">
                        <i class="fa-solid fa-chevron-left w-4 h-4"></i>


                        </svg>
                    </button>
                    <button
                        class="h-10 w-10 flex items-center justify-center bg-[#103182] text-white rounded-md font-medium">1</button>
                    <button
                        class="h-10 w-10 flex items-center justify-center bg-white border border-gray-200 rounded-md text-gray-600 hover:bg-gray-50 transition">2</button>
                    <button
                        class="h-10 w-10 flex items-center justify-center bg-white border border-gray-200 rounded-md text-gray-600 hover:bg-gray-50 transition">3</button>
                    <button
                        class="h-10 w-10 flex items-center justify-center bg-white border border-gray-200 rounded-md text-gray-600 hover:bg-gray-50 transition">
                        <i class="fa-solid fa-chevron-right w-4 h-4"></i>

                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-white  p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Search Research</h3>
                    <div class="relative ">
                        <input type="text" placeholder="Search publications..."
                            class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <button
                            class="absolute right-2 top-1 bg-[#103182] text-white p-2 rounded-md hover:bg-blue-700 transition">
                            <i class="fa-solid fa-magnifying-glass w-4 h-4"></i>

                        </button>
                    </div>
                </div>

                <!-- Research Categories -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Research Categories</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <a href="#" class="text-gray-700 hover:text-[#103182] transition">Legal Research</a>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">12</span>
                        </li>
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <a href="#" class="text-gray-700 hover:text-[#103182] transition">Forensic Studies</a>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">8</span>
                        </li>
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <a href="#" class="text-gray-700 hover:text-[#103182] transition">Medical-Legal</a>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">5</span>
                        </li>
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <a href="#" class="text-gray-700 hover:text-[#103182] transition">Criminology</a>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">9</span>
                        </li>
                        <li class="flex items-center justify-between py-2">
                            <a href="#" class="text-gray-700 hover:text-[#103182] transition">Case Studies</a>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">15</span>
                        </li>
                    </ul>
                </div>

                <!-- Recent Publications -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Recent Publications</h3>
                    <div class="space-y-4">

                        <!-- Publication 1 -->
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-[#103182] rounded-lg flex items-center justify-center mr-4">
                                <i class="fa-solid fa-scale-balanced text-white text-xl"></i>
                            </div>
                            <div>
                                <a href="#" class="font-medium text-gray-800 hover:text-[#103182] transition">
                                    Courtroom Psychology Insights
                                </a>
                                <p class="text-sm text-gray-500 mt-1">Sept 5, 2025</p>
                            </div>
                        </div>

                        <!-- Publication 2 -->
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-[#103182] rounded-lg flex items-center justify-center mr-4">
                                <i class="fa-solid fa-fingerprint text-white text-xl"></i>
                            </div>
                            <div>
                                <a href="#" class="font-medium text-gray-800 hover:text-[#103182] transition">
                                    Digital Forensics in Law
                                </a>
                                <p class="text-sm text-gray-500 mt-1">Aug 25, 2025</p>
                            </div>
                        </div>

                        <!-- Publication 3 -->
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-[#103182] rounded-lg flex items-center justify-center mr-4">
                                <i class="fa-solid fa-user-doctor text-white text-xl"></i>
                            </div>
                            <div>
                                <a href="#" class="font-medium text-gray-800 hover:text-[#103182] transition">
                                    Medical-Legal Ethics Cases
                                </a>
                                <p class="text-sm text-gray-500 mt-1">Aug 18, 2025</p>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Subscribe Now -->
                <div class="bg-[#103182] text-white p-6 rounded-2xl shadow-lg">
                    <div class="text-center mb-2">
                        <i class="fa-solid fa-envelope text-white text-3xl mb-2"></i>
                        <h3 class="font-bold text-lg mb-1">Research Updates</h3>
                        <p class="text-blue-100 text-sm">Subscribe to our research newsletter</p>
                    </div>
                    <div class="mt-4">
                        <input type="email" placeholder="Your email address"
                            class="w-full px-4 py-3 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <button
                            class="w-full mt-3 bg-gray-100 text-[#103182] py-3 rounded-lg font-medium hover:bg-gray-200 hover:text-[#103182] transition">
                            Subscribe Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- CTA Section -->
    <?php include 'include/CTAsection.php'?>


    <!-- footer -->
    <?php include 'include/footer.php'?>


    <script src="./script.js"></script>
</body>

</html>