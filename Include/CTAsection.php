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
    <section class="py-20 relative"
        style="background-image: url(./images/cta\ bg.avif); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

                <!-- Left Column -->
                <div class=" flex-1 text-center lg:text-left text-white">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        Shape Your Digital <br class="hidden md:block">Future Today
                    </h2>
                    <p class="text-lg md:text-xl mb-8 opacity-90 leading-relaxed max-w-xl">
                        Explore trusted research, insights, and innovation. Take the first step to enhance your
                        knowledge and shape your digital future with us.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button
                            class="px-8 py-4 bg-white text-[#11327f] rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            Explore Free Resources
                        </button>
                        <button
                            class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-xl font-semibold hover:bg-white hover:text-[#11327f] transition-all duration-300">
                            Join Our Membership
                        </button>
                    </div>
                </div>

                <!-- Right Column (Testimonial) -->
                <div
                    class="flex-1 relative max-w-md w-full rounded-2xl overflow-hidden shadow-2xl transform hover:scale-[1.02] transition-transform duration-300">

                    <!-- Content with glass effect -->
                    <div class="bg-white/20 backdrop-blur-md p-8 text-gray-800 flex flex-col gap-6">
                        <!-- Icon at Top -->
                        <div class="text-4xl text-[#11327f]">
                            <i class="fas fa-quote-right text-white"></i>
                        </div>

                        <!-- Testimonial Text -->
                        <blockquote class="text-lg italic text-white leading-relaxed">
                            "This platform transformed how I access and share research. The insights are top-notch and
                            helped me innovate faster than ever!"
                        </blockquote>

                        <!-- Author Info -->
                        <div class="flex items-center gap-4 mt-4">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-r from-[#22d4ad] to-[#11327f] p-0.5">
                                <img src="./images/team member 5.avif" alt="James Cooper"
                                    class="w-full h-full rounded-full object-cover border-2 border-white">
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-white">James Cooper</h3>
                                <p class="text-sm text-white">Chief Executive Officer</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</body>
</html>