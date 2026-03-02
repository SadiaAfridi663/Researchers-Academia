<?php 
include 'db_connection/connection.php'; 

$video_query = "SELECT * FROM research_videos ORDER BY created_at DESC LIMIT 3";
$video_result = mysqli_query($conn, $video_query);

$research_query = "SELECT rv.*, c.name as category_name, IFNULL(rd.downloads, 0) as downloads 
                  FROM research_videos rv 
                  LEFT JOIN add_categories c ON rv.category_id = c.id
                  LEFT JOIN research_detail rd ON rv.id = rd.id
                  ORDER BY IFNULL(rd.downloads, 0) DESC, rv.created_at DESC LIMIT 3";
$research_result = mysqli_query($conn, $research_query);

$about_video_query = "SELECT * FROM research_videos ORDER BY views DESC LIMIT 1";
$about_video_result = mysqli_query($conn, $about_video_query);
$about_video = mysqli_fetch_assoc($about_video_result);

// Fetch Team Members for Homepage (Limit 4, only type='team_member')
include 'db_connection/team_config.php';
$team_homepage_query = "SELECT * FROM team_members WHERE status = 1 AND type = 'team_member' ORDER BY created_at ASC LIMIT 4";
$team_homepage_res = mysqli_query($conn, $team_homepage_query);
?>
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

    <title>Home</title>

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

<body class="">

    <!-- header -->
    <?php include('Include/navbar.php'); ?>


    <!-- HERO SECTION -->

    <div class="relative w-full h-screen overflow-hidden">
        <!-- Background Video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="./images/hero video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative z-10 flex items-center justify-center min-h-[80vh] text-center text-white">
            <div class="max-w-5xl mx-auto px-4">

                <div
                    class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mt-12  text-sm font-medium">
                    Trusted by Researchers Worldwide
                </div>

                <h2 class=" text-4xl md:text-6xl lg:text-5xl font-bold leading-tight lg:mt-6"><span
                        class="">Researcher</span> Academia</h2>

                <h1 class="text-4xl md:text-6xl lg:text-5xl font-bold leading-tight lg:mt-2">
                    Discover Insights & <span class="">Advance Research</span>

                </h1>

                <p class="mt-6 text-lg md:text-xl lg:text-xl max-w-3xl mx-auto leading-relaxed">
                    Explore authentic research papers, latest studies, and innovative ideas from experts across diverse
                    fields.
                    Stay informed, learn, and contribute to the world of knowledge.
                </p>

                <!-- Stats Section -->
                <div class="flex justify-center items-center mt-8 gap-6 md:gap-10 flex-wrap">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold">500+</div>
                        <div class="text-sm opacity-80">Research Papers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold">200+</div>
                        <div class="text-sm opacity-80">Expert Contributors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold">50+</div>
                        <div class="text-sm opacity-80">Research Categories</div>
                    </div>
                </div>
                <!-- cta -->
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        class="px-8 py-4 bg-[#11327f] text-white rounded-full cursor-pointer transition-all duration-300 transform font-semibold text-lg shadow-lg border border-transparent hover:bg-white hover:text-[#11327f]">
                        Free Resources
                    </button>
                    <button
                        class="px-8 py-4 bg-transparent text-white border border-white rounded-full cursor-pointer transition-all duration-300 font-semibold text-lg hover:bg-[#11327f] hover:border-[#11327f] hover:text-white">
                        Explore Research
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- About section -->
    <div class="max-w-7xl mx-auto lg:mt-20 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Heading Badge -->
            <div class="mt-5 text-center md:text-left">
                <h2
                    class="inline-block px-4 py-1 border-2 border-[#11327f] hover:text-white hover:bg-[#11327f] rounded-full shadow-xl text-sm sm:text-base md:text-lg font-semibold">
                    About Us
                </h2>
            </div>

            <!-- Main Heading -->
            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-center mt-3 mb-12 text-center md:text-left">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-semibold text-[#39ddaf] leading-snug">
                        Explore <span class="text-[#11327f]">Research, News & Ideas</span>
                    </h2>
                </div>
                <div>
                    <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
                        Welcome to a space where awareness meets innovation.
                        We bring together news, research, and showcase groundbreaking projects.
                        Our mission is to make knowledge accessible, engaging, and beneficial for all.
                    </p>
                </div>
                <div>
                    <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
                        Our Research Hub spreads awareness, shares the latest insights, and showcases innovative work.
                        We provide reliable updates that empower learners, professionals, and communities with knowledge
                        that matters.
                    </p>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8 items-start mt-3 mb-12">
                <div
                    class="flex flex-col sm:flex-row justify-center items-center gap-3 p-6 shadow-lg rounded-lg bg-white text-center hover:shadow-xl transition">
                    <div class="mb-4 sm:mb-0 text-[#11327f]">
                        <i class="fas fa-lightbulb text-4xl md:text-5xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-semibold mb-2">Spreading Awareness</h2>
                        <p class="text-gray-600 text-sm md:text-base">
                            We provide authentic insights to keep you informed and aware of key research topics.
                        </p>
                    </div>
                </div>

                <div
                    class="flex flex-col sm:flex-row justify-center items-center gap-3 p-6 shadow-lg rounded-lg bg-white text-center hover:shadow-xl transition">
                    <div class="mb-4 sm:mb-0 text-[#11327f]">
                        <i class="fas fa-flask text-4xl md:text-5xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-semibold mb-2">Research Updates</h2>
                        <p class="text-gray-600 text-sm md:text-base">
                            Stay updated with the latest studies, projects, and innovations from diverse fields.
                        </p>
                    </div>
                </div>

                <div
                    class="flex flex-col sm:flex-row justify-center items-center gap-3 p-6 shadow-lg rounded-lg bg-white text-center hover:shadow-xl transition">
                    <div class="mb-4 sm:mb-0 text-[#11327f]">
                        <i class="fas fa-users text-4xl md:text-5xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-semibold mb-2">Professional Network</h2>
                        <p class="text-gray-600 text-sm md:text-base">
                            Connecting learners, researchers, and professionals to share impactful knowledge.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Image + Video -->
            <!-- Image + Video -->
            <div class="relative w-full mb-10 flex justify-start">
                <!-- Image -->
                <img src="./images/about image.avif" alt="About Us"
                    class="w-full md:w-[70%] lg:w-[65%] rounded-lg shadow-lg object-cover">

                <?php 
                // Determine the embed URL safely using the same logic as Recent Showcase
                $about_embed = "https://www.youtube.com/embed/mV0bUQpz468"; // Professional fallback
                if ($about_video) {
                    $about_url = $about_video['video_url'];
                    if (strpos($about_url, 'youtube.com') !== false || strpos($about_url, 'youtu.be') !== false) {
                        if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $about_url, $matches)) {
                            $about_embed = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $matches[1] . '&controls=0&modestbranding=1';
                        }
                    } elseif (strpos($about_url, 'vimeo.com') !== false) {
                        if (preg_match('/vimeo\.com\/(\d+)/', $about_url, $matches)) {
                            $about_embed = 'https://player.vimeo.com/video/' . $matches[1] . '?autoplay=1&muted=1&loop=1&background=1';
                        }
                    } elseif (preg_match('/\.(mp4|webm|ogg|mov|avi)$/i', $about_url)) {
                        $about_embed = htmlspecialchars($about_url);
                    }
                }
                
                // If it's a direct mp4 file, use a <video> tag, otherwise use <iframe>
                $is_direct_video = preg_match('/\.(mp4|webm|ogg|mov|avi)$/i', $about_embed);
                ?>

                <!-- Video element -->
                <?php if ($is_direct_video): ?>
                    <!-- Small & Medium Screens -->
                    <div class="w-full mt-6 lg:hidden flex justify-center">
                        <video src="<?php echo $about_embed; ?>" autoplay muted loop playsinline class="w-full max-w-sm sm:max-w-md h-[200px] sm:h-[250px] md:h-[300px] rounded-lg shadow-xl border-4 border-white object-cover"></video>
                    </div>
                    <!-- Large Screens -->
                    <video src="<?php echo $about_embed; ?>" autoplay muted loop playsinline class="hidden lg:block absolute top-[70px] right-[-10px] w-[280px] md:w-[450px] lg:w-[500px] h-[250px] md:h-[300px] aspect-video rounded-lg shadow-xl border-4 border-white object-cover"></video>
                <?php else: ?>
                    <!-- Small & Medium Screens -->
                    <div class="w-full mt-6 lg:hidden flex justify-center">
                        <iframe class="w-full max-w-sm sm:max-w-md h-[200px] sm:h-[250px] md:h-[300px] rounded-lg shadow-xl border-4 border-white"
                            src="<?php echo $about_embed; ?>" title="Video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe>
                    </div>
                    <!-- Large Screens -->
                    <iframe class="hidden lg:block absolute top-[70px] right-[-10px] w-[280px] md:w-[450px] lg:w-[500px] h-[250px] md:h-[300px] aspect-video rounded-lg shadow-xl border-4 border-white"
                        src="<?php echo $about_embed; ?>" title="Video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                    </iframe>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <!-- Recent Research Showcase -->
    <div class="max-w-7xl mx-auto my-10 lg:px-0 px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-[#11327f]">Recent Research Showcase</h2>
            <p class="text-gray-600 mt-2">Explore featured research videos that highlight innovation, awareness, and
                impactful ideas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <?php 
            if(mysqli_num_rows($video_result) > 0):
                while($video = mysqli_fetch_assoc($video_result)):
                    $video_url = $video['video_url'];
                    $thumbnail = !empty($video['thumbnail']) ? './images/thumbnails/' . $video['thumbnail'] : '';
            ?>
            <!-- Dynamic Card -->
            <div class="relative group rounded-lg overflow-hidden shadow-lg">
                <?php
                // Check if it's a YouTube URL
                if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                    $video_id = '';
                    if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video_url, $matches)) {
                        $video_id = $matches[1];
                    }
                    if ($video_id) {
                        echo '<iframe src="https://www.youtube.com/embed/' . $video_id . '?autoplay=1&mute=1&loop=1&playlist=' . $video_id . '&controls=0&modestbranding=1" class="w-full h-[250px] object-cover rounded-lg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
                    }
                } 
                // Check if it's a Vimeo URL
                elseif (strpos($video_url, 'vimeo.com') !== false) {
                    $video_id = '';
                    if (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                        $video_id = $matches[1];
                    }
                    if ($video_id) {
                        echo '<iframe src="https://player.vimeo.com/video/' . $video_id . '?autoplay=1&muted=1&loop=1&background=1" class="w-full h-[250px] object-cover rounded-lg" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                    }
                }
                // Check if it's a direct video file
                elseif (preg_match('/\.(mp4|webm|ogg|mov|avi)$/i', $video_url)) {
                    echo '<video src="' . htmlspecialchars($video_url) . '" autoplay muted loop playsinline class="w-full h-[250px] object-cover rounded-lg"></video>';
                }
                // Fallback to thumbnail or placeholder
                else {
                    $fallback_img = !empty($thumbnail) ? $thumbnail : './images/about image.avif';
                    echo '<img src="' . $fallback_img . '" class="w-full h-[250px] object-cover rounded-lg" alt="Video Placeholder">';
                }
                ?>

                <a href="researchDetail.php?id=<?php echo $video['id']; ?>"
                    class="absolute bottom-0 left-0 w-full bg-[#11327f]/90 text-white text-center py-3 font-semibold flex items-center justify-center gap-2 translate-y-full group-hover:translate-y-0 transition-all duration-500 cursor-pointer">
                    <i class="fas fa-video"></i> Go to Video
                </a>
            </div>
            <?php 
                endwhile;
            else:
                // Show static content as fallback if no data in database
            ?>
            <!-- Card 1 -->
            <div class="relative group rounded-lg overflow-hidden shadow-lg">
                <video src="./images/home video 1.mp4" autoplay muted loop playsinline
                    class="w-full h-[250px] object-cover rounded-lg">
                </video>

                <div
                    class="absolute bottom-0 left-0 w-full bg-[#11327f]/90 text-white text-center py-3 font-semibold flex items-center justify-center gap-2 translate-y-full group-hover:translate-y-0 transition-all duration-500 cursor-pointer">
                    <i class="fas fa-video"></i> Go to Video
                </div>
            </div>

            <div class="relative group rounded-lg overflow-hidden shadow-lg">
                <video src="./images/home video 2.mp4" autoplay muted loop playsinline
                    class="w-full h-[250px] object-cover rounded-lg cursor-pointer">
                </video>

                <div
                    class="absolute bottom-0 left-0 w-full bg-[#11327f]/90 text-white text-center py-3 font-semibold flex items-center justify-center gap-2 translate-y-full group-hover:translate-y-0 transition-all duration-500">
                    <i class="fas fa-search"></i> Explore Research
                </div>
            </div>

            <div class="relative group rounded-lg overflow-hidden shadow-lg">
                <video src="./images/home video 3.mp4" autoplay muted loop playsinline
                    class="w-full h-[250px] object-cover rounded-lg cursor-pointer">
                </video>

                <div
                    class="absolute bottom-0 left-0 w-full bg-[#11327f]/90 text-white text-center py-3 font-semibold flex items-center justify-center gap-2 translate-y-full group-hover:translate-y-0 transition-all duration-500">
                    <i class="fas fa-book-open"></i> Watch Insights
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>



    <!-- Featured Research Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto lg:px-15 px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Featured <span
                        class="text-[#11327f]">Research</span></h2>
                <p class="mt-3 text-lg text-gray-600">Explore our latest and most impactful research projects</p>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                if(mysqli_num_rows($research_result) > 0):
                    $fallback_images = ["./images/feature 2.avif", "./images/feature 3.avif"];
                    $idx = 0;
                    while($research = mysqli_fetch_assoc($research_result)):
                        $img_path = !empty($research['thumbnail']) ? "./images/thumbnails/" . $research['thumbnail'] : $fallback_images[$idx % 2];
                        $idx++;
                        
                        $authors = [];
                        if(!empty($research['research_leader'])) $authors[] = $research['research_leader'];
                        if(!empty($research['co_leader'])) $authors[] = $research['co_leader'];
                        $author_text = !empty($authors) ? implode(", ", $authors) : "Research Academy";
                ?>
                <!-- Research Card -->
                <div
                    class="research-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($research['title']); ?>"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-[#11327f] text-white text-xs font-medium px-2.5 py-0.5 rounded">
                                <?php echo htmlspecialchars($research['category_name'] ?? 'Research'); ?>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2"><?php echo htmlspecialchars($research['title']); ?></h3>
                        <p class="text-gray-600 mb-4 text-sm"><?php echo htmlspecialchars($author_text); ?></p>
                        <p class="text-gray-700 mb-5 line-clamp-3">
                            <?php echo htmlspecialchars(substr($research['description'] ?? '', 0, 150)) . (strlen($research['description'] ?? '') > 150 ? '...' : ''); ?>
                        </p>
                        <div class="flex justify-between items-center">
                            <a href="researchDetail.php?id=<?php echo $research['id']; ?>"
                                class="text-[#11327f] font-medium hover:text-blue-800 transition-colors flex items-center gap-1">
                                Read More
                                <i class="fas fa-arrow-right"></i>
                            </a>

                            <div class="flex flex-wrap items-center text-gray-500 text-xs gap-3">
                                <div class="flex items-center">
                                    <i class="far fa-eye mr-1"></i>
                                    <span><?php echo number_format($research['views'] ?? 0); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-download mr-1"></i>
                                    <span><?php echo number_format($research['downloads'] ?? 0); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <span><?php echo date('M Y', strtotime($research['created_at'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                <!-- Research Card 1 (Fallback) -->
                <div
                    class="research-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="./images/feature 3.avif" alt="Data Visualization"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-[#11327f] text-white text-xs font-medium px-2.5 py-0.5 rounded">Data
                                Science</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Machine Learning Applications in Climate
                            Science</h3>
                        <p class="text-gray-600 mb-4 text-sm">Dr. Sarah Johnson, Dr. Michael Chen</p>
                        <p class="text-gray-700 mb-5">Exploring how predictive algorithms can enhance climate modeling
                            accuracy and improve long-term forecasting.</p>
                        <div class="flex justify-between items-center">
                            <a href="#"
                                class="text-[#11327f] font-medium hover:text-blue-800 transition-colors flex items-center gap-1">
                                Read More
                                <i class="fas fa-arrow-right"></i>
                            </a>

                            <div class="flex flex-wrap items-center text-gray-500 text-xs gap-3">
                                <div class="flex items-center">
                                    <i class="far fa-eye mr-1"></i>
                                    <span>24.5k</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-download mr-1"></i>
                                    <span>12.3k</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <span>Oct 2023</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Research Card 2 (Fallback) -->
                <div
                    class="research-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="./images/feature 2.avif" alt="Neuroscience Research"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span
                                class="bg-[#11327f] text-white text-xs font-medium px-2.5 py-0.5 rounded">Neuroscience</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Cognitive Impacts of Digital Media Consumption
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm">Dr. Emily Rodriguez, Prof. James Wilson</p>
                        <p class="text-gray-700 mb-5">A longitudinal study examining the effects of prolonged digital
                            exposure on attention span and memory formation.</p>
                        <div class="flex justify-between items-center">
                            <a href="#"
                                class="text-[#11327f] font-medium hover:text-blue-800 transition-colors flex items-center gap-1">
                                Read More
                                <i class="fas fa-arrow-right"></i>
                            </a>

                            <div class="flex flex-wrap items-center text-gray-500 text-xs gap-3">
                                <div class="flex items-center">
                                    <i class="far fa-eye mr-1"></i>
                                    <span>18.2k</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-download mr-1"></i>
                                    <span>8.5k</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <span>Sep 2023</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Research Card 3 (Fallback) -->
                <div
                    class="research-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="./images/feature 3.avif" alt="Renewable Energy"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span
                                class="bg-[#11327f] text-white text-xs font-medium px-2.5 py-0.5 rounded">Sustainability</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Advanced Photovoltaic Materials for Urban
                            Environments</h3>
                        <p class="text-gray-600 mb-4 text-sm">Dr. Robert Kim, Dr. Lisa Anderson</p>
                        <p class="text-gray-700 mb-5">Developing next-generation solar cells with improved efficiency in
                            low-light conditions for city applications.</p>
                        <div class="flex justify-between items-center">
                            <a href="#"
                                class="text-[#11327f] font-medium hover:text-blue-800 transition-colors flex items-center gap-1">
                                Read More
                                <i class="fas fa-arrow-right"></i>
                            </a>

                            <div class="flex flex-wrap items-center text-gray-500 text-xs gap-3">
                                <div class="flex items-center">
                                    <i class="far fa-eye mr-1"></i>
                                    <span>32.1k</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-download mr-1"></i>
                                    <span>15.7k</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <span>Aug 2023</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- button -->
            <div class="text-center mt-12">
                <a href="research.php"
                    class="group inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#11327f] hover:bg-[#11327f]/90 transition-colors duration-300">
                    View All Research
                    <i
                        class="fas fa-arrow-right ml-2 transform transition-transform duration-300 group-hover:translate-x-2"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- Country MAp -->
    <section class="relative  w-full"
        style="background-image: url('./images/map.avif'); background-size: cover; background-position: center;">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-white/80 w-full "></div>
        <div
            class="relative max-w-7xl flex flex-col justify-center   mx-auto w-full lg:h-[600px]  shadow-xl overflow-hidden">



            <div class="absolute top-10 left-0 right-0 max-w-3xl mx-auto text-center z-10">
                <h2 class="text-lg text-[#08cea0] font-bold uppercase tracking-wider">OUR LOCATIONS</h2>
                <h2 class="text-4xl md:text-5xl  text-[#11327f] mt-2">
                    Support across 18+ countries worldwide
                </h2>
            </div>

            <div
                class="relative z-10 mt-56 mb-12 lg:mb-0 flex flex-col md:flex-row justify-center items-center gap-14 md:gap-12  px-6">
                <!-- Card 1 -->
                <!-- <div
                    class="relative max-w-sm w-full md:w-[400px] text-center shadow-xl bg-white rounded-xl pt-16 pb-8 px-6 transition-all duration-300 hover:-translate-y-2">
                    <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                        <img src="./images/map office.avif" alt="US Office"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    </div>

                    <div class="mt-6">
                        <h2 class="text-md text-[#08cea0] font-semibold uppercase tracking-wide">UNITED STATES</h2>
                        <h2 class="text-xl font-bold text-[#11327f] mt-1">Rochester, New York</h2>
                        <p class="text-gray-600 text-md py-4 leading-relaxed">
                            145 Elmgrove Park Rochester, NY 14624, USA <br> +1 866 405 0400
                        </p>
                        <a href="mailto:us-office@example.com"
                            class="inline-flex items-center text-[#11327f] font-medium hover:text-[#08cea0] transition-colors duration-300 group">
                            Send Email
                            <svg class="w-4 h-4 ml-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform -translate-x-1 group-hover:translate-x-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div> -->

                <!-- Card 2 -->
                <div
                    class="relative max-w-sm w-full md:w-[400px] text-center shadow-xl bg-white rounded-xl pt-16 pb-8 px-6 transition-all duration-300 hover:-translate-y-2">
                    <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                        <img src="./images/map office 2.avif" alt="Europe Office"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    </div>
                    <div class="mt-6">
                        <h2 class="text-md text-[#08cea0] font-semibold uppercase tracking-wide">UNITED KINGDOM</h2>
                        <h2 class="text-xl font-bold text-[#11327f] mt-1">London, England</h2>
                        <!-- <p class="text-gray-600 text-md py-4 leading-relaxed">
                            123 Innovation Drive London, EC1A 1BB, UK <br> +44 20 7946 0958
                        </p> -->
                        <a href="mailto:uk-office@example.com"
                            class="inline-flex items-center text-[#11327f] font-medium hover:text-[#08cea0] transition-colors duration-300 group">
                            Send Email
                            <svg class="w-4 h-4 ml-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform -translate-x-1 group-hover:translate-x-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Premium Membership Section -->
    <section class="py-20 bg-white text-black relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-20 left-20 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-indigo-600 rounded-full filter blur-3xl"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block bg-[#11327f] text-white text-sm font-semibold px-4 py-2 rounded-full mb-4">
                    EXCLUSIVE ACCESS
                </span>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Premium Research Membership</h2>
                <p class="text-xl max-w-2xl mx-auto opacity-90">Unlock the full potential of our research platform with
                    exclusive content, tools, and resources</p>
            </div>

            <!-- Membership Tiers -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Basic Tier -->
                <div
                    class="bg-white/5 backdrop-blur-md shadow-2xl rounded-2xl p-8 border border-white/10 hover:border-blue-400/30 transition-all duration-500 hover:-translate-y-2">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-semibold mb-2">Research Explorer</h3>
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-bold">$5</span>
                            <span class="text-gray-400 ml-2">/month</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>Access to basic research library</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>Monthly research summaries</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>Community forum access</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-times-circle mr-3"></i>
                            <span>Premium content</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-times-circle mr-3"></i>
                            <span>Expert webinars</span>
                        </li>
                    </ul>
                    <button class="w-full py-3 rounded-xl font-medium text-[#11327f] border-2 border-[#11327f] 
                        hover:bg-[#11327f] hover:text-white 
                        transition-all duration-300">
                        Get Started
                    </button>

                </div>

                <!-- Premium Tier (Featured) -->
                <div
                    class="bg-[#11327f]  text-white rounded-2xl p-8 border border-blue-400/50 relative overflow-hidden transform hover:-translate-y-2 transition-all duration-500">
                    <div class="absolute top-5 right-5">
                        <span class="bg-white text-blue-700 text-xs font-bold px-3 py-1 rounded-full">POPULAR</span>
                    </div>
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-semibold mb-2">Research Pro</h3>
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-bold">$10</span>
                            <span class="text-blue-200 ml-2">/month</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-white mr-3"></i>
                            <span>Full research library access</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-white mr-3"></i>
                            <span>Weekly research briefings</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-white mr-3"></i>
                            <span>Exclusive video content</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-white mr-3"></i>
                            <span>Live expert webinars</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-white mr-3"></i>
                            <span>Research tools & datasets</span>
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 bg-white text-blue-700 hover:bg-blue-50 rounded-xl font-bold transition-all duration-300 shadow-lg">
                        Start Premium Trial
                    </button>
                </div>

                <!-- Enterprise Tier -->
                <div
                    class="bg-white/5 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/10 hover:border-indigo-400/30 transition-all duration-500 hover:-translate-y-2">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-semibold mb-2">Research Enterprise</h3>
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-bold">$15</span>
                            <span class="text-gray-400 ml-2">/month</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>All Pro features</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>Custom research reports</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>Dedicated research support</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>Team management tools</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-400 mr-3"></i>
                            <span>API access</span>
                        </li>
                    </ul>
                    <button class="w-full py-3 rounded-xl font-medium text-[#11327f] border-2 border-[#11327f] 
         hover:bg-[#11327f] hover:text-white 
         transition-all duration-300">
                        Contact Sales
                    </button>

                </div>
            </div>

            <!-- Additional Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#11327f] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock-open text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cancel Anytime</h3>
                    <p class="opacity-80">No long-term commitment, cancel your subscription whenever you need</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-[#11327f] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-download text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Offline Access</h3>
                    <p class="opacity-80">Download research papers and content for offline reading</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-[#11327f] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Priority Support</h3>
                    <p class="opacity-80">Get help from our dedicated research support team</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team Section -->
    <section class="py-16 bg-gray-50 ">
        <div class="max-w-7xl mx-auto lg:px-20 px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800">Meet Our <span
                        class="text-[#11327f]">Team</span></h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Dedicated professionals working together to
                    drive innovation and excellence in research.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                if(mysqli_num_rows($team_homepage_res) > 0):
                    while($tm = mysqli_fetch_assoc($team_homepage_res)):
                        $st = $tm['sub_type'] ?? '';
                        $roleLabel = getSubTypeLabel($st);
                        $img = !empty($tm['image']) ? $tm['image'] : './images/team member 1.avif';
                ?>
                <!-- Dynamic Member Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1 text-center p-6">
                    <div class="relative inline-block">
                        <img src="./<?php echo $img; ?>" alt="<?php echo htmlspecialchars($tm['name']); ?>"
                            class="rounded-full w-40 h-40 object-cover object-top mx-auto border-4 border-[#11327f]">
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-[#11327f] text-white text-[10px] font-semibold px-3 py-1 rounded-full whitespace-nowrap">
                            <?php echo htmlspecialchars($roleLabel); ?>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mt-6"><?php echo htmlspecialchars($tm['name']); ?></h3>
                    <p class="text-gray-600 mt-2 text-sm line-clamp-2"><?php echo htmlspecialchars($tm['description'] ?: 'Dedicated to research excellence'); ?></p>
                    <div class="mt-4 flex justify-center space-x-3">
                        <?php if($tm['linkedin']): ?>
                        <a href="<?php echo htmlspecialchars($tm['linkedin']); ?>" class="text-gray-400 hover:text-[#11327f] transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <?php endif; ?>
                        <?php if($tm['github']): ?>
                        <a href="<?php echo htmlspecialchars($tm['github']); ?>" class="text-gray-400 hover:text-[#11327f] transition-colors">
                            <i class="fab fa-github"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                <p class="text-center col-span-4 text-gray-400 italic">Our team members are being featured soon.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <?php include('Include/CTAsection.php');?>

    <!-- Footer -->
    <?php include('Include/Footer.php');?>



    <script src="./script.js"></script>



</body>

</html>