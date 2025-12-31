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
    <title>Document</title>
</head>
<body>
    
    <!-- footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8 px-10">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Brand Column -->
                <div class="lg:col-span-1">
                    <img src="./images/ralogo.webp" alt="Logo" class="w-[70px] sm:w-[180px]">

                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Advancing knowledge through cutting-edge research and innovation. Join our community of
                        researchers and professionals.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Research Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 relative inline-block">
                        Research Areas
                        <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-blue-400"></span>
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Data Science</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Artificial
                                Intelligence</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Biotechnology</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Renewable Energy</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Neuroscience</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 relative inline-block">
                        Quick Links
                        <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-blue-400"></span>
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Publications</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Research Grants</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Events &
                                Conferences</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>


                <!-- Contact & Newsletter -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 relative inline-block">
                        Stay Updated
                        <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-blue-400"></span>
                    </h4>
                    <p class="text-gray-400 mb-4">Subscribe to our newsletter for the latest research updates.</p>
                    <form class="mb-4">
                        <div class="flex w-full max-w-md">
                            <input type="email" placeholder="Your email address"
                                class="px-4 py-3 w-full rounded-l-lg border border-white text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400" />
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-5 rounded-r-lg border border-white border-l-0  transition-colors flex items-center justify-center">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>

                    </form>
                    <div class="flex items-start mt-6">
                        <div class="text-blue-400 mr-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <p class="text-gray-400 text-sm">145 Research Park Drive, Innovation City, IC 12345</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-500 text-sm mb-4 md:mb-0">
                        © 2023 ResearchHub. All rights reserved.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Privacy Policy</a>
                        <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Terms of
                            Service</a>
                        <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>