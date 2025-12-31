<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <title>Blog Detail</title>
</head>

<body class="font-[Outfit] bg-gray-50 text-gray-800">
     <!-- Header -->
       <?php include 'include/navbar.php'?>

    <!-- header end -->

    <!-- Hero Section -->
    <section class="w-full h-[220px] bg-[#103182] flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-[#103182] to-[#2a4db3] opacity-90"></div>
        <h1 class="text-4xl md:text-5xl font-bold text-white tracking-wide relative z-10">Research Blog Detail</h1>
    </section>

    <!-- Blog Detail Wrapper -->
    <main class="max-w-6xl mx-auto px-4 md:px-8 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left (Blog Content) -->
        <article class="lg:col-span-2 space-y-8">
            <header class="space-y-4">
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <a href="#" class="hover:text-[#103182]">Home</a>
                    <span>/</span>
                    <a href="#" class="hover:text-[#103182]">Blog</a>
                    <span>/</span>
                    <span>Article</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    The Role of Artificial Intelligence in Modern Research
                </h2>
                <p class="text-sm text-gray-500 font-medium">
                    By <span class="font-semibold text-gray-700">Dr. Sarah Ahmed</span> ·
                    <span class="text-[#103182]">April 20, 2025</span> ·
                    <span><i class="far fa-clock mr-1"></i>7 min read</span>
                </p>
            </header>

            <div class="relative">
                <img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&auto=format&fit=crop&w=1080&q=80"
                    alt="AI research concept"
                    class="rounded-2xl shadow-lg w-full h-[300px] md:h-[400px] object-cover" />
                <div class="absolute bottom-4 left-4 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-lg">
                    <p class="text-sm text-gray-700">Source: Unsplash</p>
                </div>
            </div>

            <section class="space-y-6">
                <h3 class="text-2xl font-semibold text-[#103182]">Welcome To Our Research Blog!</h3>
                <p class="text-gray-600 leading-relaxed">
                    Artificial Intelligence (AI) is transforming the way research is conducted across multiple
                    disciplines.
                    From data analysis to predictive modeling, AI provides tools that help researchers accelerate
                    discoveries and gain deeper insights.
                </p>
            </section>

            <!-- Blog Body -->
            <section class="space-y-8">
                <div>
                    <h3 class="text-xl font-semibold mb-3 flex items-center">
                        <span
                            class="bg-[#103182] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">1</span>
                        <span>Data Analysis</span>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        AI enables researchers to analyze massive datasets efficiently. Machine learning algorithms can
                        identify
                        hidden patterns, trends, and correlations that would be impossible to detect manually.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-3 flex items-center">
                        <span
                            class="bg-[#103182] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">2</span>
                        <span>Automation of Experiments</span>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Automated systems powered by AI reduce human error and allow researchers to conduct repetitive
                        experiments
                        faster and more accurately, saving valuable time in the lab.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-3 flex items-center">
                        <span
                            class="bg-[#103182] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">3</span>
                        <span>Predictive Modeling</span>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        AI-driven predictive models can forecast outcomes in areas such as climate change, disease
                        progression, and
                        even social sciences. These insights help policymakers and scientists make informed decisions.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-3 flex items-center">
                        <span
                            class="bg-[#103182] text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">4</span>
                        <span>Interdisciplinary Impact</span>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        AI is not limited to computer science—it plays a crucial role in medicine, physics, biology, and
                        even education.
                        Collaborative research that integrates AI leads to groundbreaking innovations.
                    </p>
                </div>
            </section>

            <!-- Tags and Social Sharing -->
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pt-8 border-t border-gray-200">
                <div>
                    <span class="font-medium mr-2">Tags:</span>
                    <a href="#"
                        class="inline-block bg-gray-100 hover:bg-[#103182] hover:text-white text-gray-700 px-3 py-1 rounded-full text-sm mr-2 transition-colors">Artificial
                        Intelligence</a>
                    <a href="#"
                        class="inline-block bg-gray-100 hover:bg-[#103182] hover:text-white text-gray-700 px-3 py-1 rounded-full text-sm mr-2 transition-colors">Research</a>
                    <a href="#"
                        class="inline-block bg-gray-100 hover:bg-[#103182] hover:text-white text-gray-700 px-3 py-1 rounded-full text-sm transition-colors">Technology</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="font-medium">Share:</span>
                    <a href="#" class="text-gray-500 hover:text-[#103182]"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-500 hover:text-[#103182]"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-500 hover:text-[#103182]"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-gray-500 hover:text-[#103182]"><i class="fab fa-researchgate"></i></a>
                </div>
            </div>

            <!-- Related Posts -->
            <div class="pt-12">
                <h3 class="text-2xl font-bold text-[#103182] border-b-2 border-[#103182] pb-2 mb-6">Related Posts</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                        <img src="./images/news slide 5.avif" alt="Big data in research"
                            class="w-full h-48 object-cover" />
                        <div class="p-4">
                            <p class="text-sm text-gray-500">April 15, 2025</p>
                            <h4 class="font-semibold mt-2 hover:text-[#103182]">Big Data Analytics in Academic Research
                            </h4>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                        <img src="./images/news image 3.avif" alt="Future of education"
                            class="w-full h-48 object-cover" />
                        <div class="p-4">
                            <p class="text-sm text-gray-500">March 28, 2025</p>
                            <h4 class="font-semibold mt-2 hover:text-[#103182]">The Future of Education with AI Tools
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Right (Sidebar) -->
        <aside class="space-y-12 mt-46">

            <!-- Author Box -->
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <img src="./images/leader 3.avif" alt="Author"
                    class="w-20 h-20 rounded-full mx-auto mb-4 object-cover" />
                <h3 class="text-lg font-semibold">Dr. Sarah Ahmed</h3>
                <p class="text-gray-500 text-sm">AI Researcher & Author</p>
                <p class="text-gray-600 text-sm mt-3">Dr. Sarah specializes in applying machine learning techniques to
                    interdisciplinary research, bridging gaps between technology and academia.</p>

                <div class="flex justify-center gap-4 mt-4 text-[#103182] text-lg">
                    <a href="#" class="hover:text-[#0c2569]"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-[#0c2569]"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-[#0c2569]"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="hover:text-[#0c2569]"><i class="fab fa-researchgate"></i></a>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <h3 class="text-2xl font-bold text-[#103182] border-b-2 border-[#103182] pb-2 mb-4">
                    Categories
                </h3>
                <ul class="space-y-3 text-gray-700 font-medium">
                    <li class="pb-2 border-b border-gray-100">
                        <a href="#" class="hover:text-[#103182] flex justify-between items-center">
                            <span>Artificial Intelligence</span>
                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">24</span>
                        </a>
                    </li>
                    <li class="pb-2 border-b border-gray-100">
                        <a href="#" class="hover:text-[#103182] flex justify-between items-center">
                            <span>Data Science</span>
                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">18</span>
                        </a>
                    </li>
                    <li class="pb-2 border-b border-gray-100">
                        <a href="#" class="hover:text-[#103182] flex justify-between items-center">
                            <span>Education</span>
                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">15</span>
                        </a>
                    </li>
                    <li class="pb-2 border-b border-gray-100">
                        <a href="#" class="hover:text-[#103182] flex justify-between items-center">
                            <span>Innovation</span>
                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">9</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Popular Posts -->
            <div>
                <h3 class="text-2xl font-bold text-[#103182] border-b-2 border-[#103182] pb-2 mb-4">
                    Popular Posts
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <img src="./images/blog 3.avif" alt="Research lab" class="w-16 h-16 object-cover rounded-lg" />
                        <div>
                            <a href="#" class="font-medium hover:text-[#103182]">Top 10 AI Applications in Academic
                                Research</a>
                            <p class="text-sm text-gray-500">April 12, 2025</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <img src="./images/news slide 5.avif" alt="Students working"
                            class="w-16 h-16 object-cover rounded-lg" />
                        <div>
                            <a href="#" class="font-medium hover:text-[#103182]">How Technology is Shaping Higher
                                Education</a>
                            <p class="text-sm text-gray-500">March 30, 2025</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <img src="./images/team page member 1.avif" class="w-16 h-16 object-cover rounded-lg" />
                        <div>
                            <a href="#" class="font-medium hover:text-[#103182]">AI and Healthcare Research: A New
                                Era</a>
                            <p class="text-sm text-gray-500">March 18, 2025</p>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>
    </main>

     <!-- CTA Section -->
    <?php include 'include/CTAsection.php'?>


    <!-- footer -->
    <?php include 'include/footer.php'?>


    <script src="./script.js"></script>

</body>

</html>