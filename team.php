<html lang="en">
<?php 
include 'db_connection/connection.php';
include 'db_connection/team_config.php';

// Fetch Active Leaders
$leaders_query = "SELECT * FROM team_members WHERE type = 'leader' AND status = 1 ORDER BY created_at ASC";
$leaders_res = mysqli_query($conn, $leaders_query);

// Fetch Active Team Members
$members_query = "SELECT * FROM team_members WHERE type = 'team_member' AND status = 1 ORDER BY created_at ASC";
$members_res = mysqli_query($conn, $members_query);
?>

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
    <?php include 'Include/navbar.php'; ?>


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
                <?php 
                if(mysqli_num_rows($leaders_res) > 0):
                    while($leader = mysqli_fetch_assoc($leaders_res)):
                        $st = $leader['sub_type'] ?? '';
                        $roleLabel = getSubTypeLabel($st);
                        $img = !empty($leader['image']) ? $leader['image'] : './images/leader 1.avif';
                ?>
                <!-- Dynamic Leader Card -->
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden group">
                    <div class="flex flex-col md:flex-row h-full">
                        <!-- Image Section -->
                        <div class="md:w-2/5 relative">
                            <div class="w-full h-full">
                                <img src="./<?php echo $img; ?>" alt="<?php echo htmlspecialchars($leader['name']); ?>"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                <h3 class="text-2xl font-bold text-white"><?php echo htmlspecialchars($leader['name']); ?></h3>
                                <p class="text-blue-200 font-medium"><?php echo htmlspecialchars($roleLabel); ?></p>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="md:w-3/5 p-8">
                            <div class="flex space-x-4 mb-6">
                                <?php if($leader['twitter']): ?>
                                <a href="<?php echo htmlspecialchars($leader['twitter']); ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-twitter w-5 h-5"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($leader['linkedin']): ?>
                                <a href="<?php echo htmlspecialchars($leader['linkedin']); ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($leader['github']): ?>
                                <a href="<?php echo htmlspecialchars($leader['github']); ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                                <?php endif; ?>
                            </div>

                            <p class="text-gray-700 mb-6 leading-relaxed">
                                <?php echo htmlspecialchars($leader['description'] ?: 'Visionary leader driving innovation and excellence in our research initiatives.'); ?>
                            </p>

                            <?php if($leader['quote']): ?>
                            <div class="border-l-4 border-blue-500 pl-4 mb-6">
                                <p class="text-gray-600 italic">"<?php echo htmlspecialchars($leader['quote']); ?>"</p>
                            </div>
                            <?php endif; ?>

                            <div class="flex flex-wrap gap-2">
                                <?php if($leader['skill_1']): ?>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full"><?php echo htmlspecialchars($leader['skill_1']); ?></span>
                                <?php endif; ?>
                                <?php if($leader['skill_2']): ?>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full"><?php echo htmlspecialchars($leader['skill_2']); ?></span>
                                <?php endif; ?>
                                <?php if($leader['skill_3']): ?>
                                <span class="px-3 py-1 bg-[#103182] text-white text-sm rounded-full"><?php echo htmlspecialchars($leader['skill_3']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                <!-- Fallback Static Leaders (Removed for brevity but implied if DB empty) -->
                <p class="text-center col-span-2 text-gray-500 italic">Leadership information is being updated...</p>
                <?php endif; ?>
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
                <?php 
                if(mysqli_num_rows($members_res) > 0):
                    while($m = mysqli_fetch_assoc($members_res)):
                        $st = $m['sub_type'] ?? '';
                        $roleLabel = getSubTypeLabel($st);
                        $img = !empty($m['image']) ? $m['image'] : './images/team page member 1.avif';
                ?>
                <!-- Dynamic Team Member Card -->
                <div class="group relative bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                    <div class="h-72 overflow-hidden">
                        <img src="./<?php echo $img; ?>" alt="<?php echo htmlspecialchars($m['name']); ?>"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6 text-center">
                        <h3 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($m['name']); ?></h3>
                        <p class="text-blue-600 font-medium"><?php echo htmlspecialchars($roleLabel); ?></p>
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <?php if($m['skill_1']): ?>
                            <span class="px-2 py-0.5 bg-[#103182]/10 text-[#103182] text-[10px] font-bold rounded-full uppercase tracking-wider"><?php echo htmlspecialchars($m['skill_1']); ?></span>
                            <?php endif; ?>
                            <?php if($m['skill_2']): ?>
                            <span class="px-2 py-0.5 bg-[#103182]/10 text-[#103182] text-[10px] font-bold rounded-full uppercase tracking-wider"><?php echo htmlspecialchars($m['skill_2']); ?></span>
                            <?php endif; ?>
                            <?php if($m['skill_3']): ?>
                            <span class="px-2 py-0.5 bg-[#103182]/10 text-[#103182] text-[10px] font-bold rounded-full uppercase tracking-wider"><?php echo htmlspecialchars($m['skill_3']); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mt-5 flex justify-center space-x-3 text-sm border-t border-gray-100 pt-4">
                            <?php if($m['twitter']): ?>
                            <a href="<?php echo htmlspecialchars($m['twitter']); ?>" class="text-gray-400 hover:text-[#103182] transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <?php endif; ?>
                            <?php if($m['linkedin']): ?>
                            <a href="<?php echo htmlspecialchars($m['linkedin']); ?>" class="text-gray-400 hover:text-[#103182] transition-colors">
                                <i class="fab fa-linkedin-in text-base"></i>
                            </a>
                            <?php endif; ?>
                            <?php if($m['github']): ?>
                            <a href="<?php echo htmlspecialchars($m['github']); ?>" class="text-gray-400 hover:text-[#103182] transition-colors">
                                <i class="fab fa-github text-base"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-[#103182] bg-opacity-90 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-6 text-white text-center">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($m['name']); ?></h3>
                        <p class="text-blue-200 font-medium"><?php echo htmlspecialchars($roleLabel); ?></p>
                        <p class="mt-3 text-sm">
                            <?php echo htmlspecialchars($m['description'] ?: 'Committed researcher advancing our collective knowledge base.'); ?>
                        </p>
                        <div class="mt-5 flex space-x-4">
                            <?php if($m['twitter']): ?>
                            <a href="<?php echo htmlspecialchars($m['twitter']); ?>" class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-twitter w-4 h-4"></i>
                            </a>
                            <?php endif; ?>
                            <?php if($m['linkedin']): ?>
                            <a href="<?php echo htmlspecialchars($m['linkedin']); ?>" class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-linkedin-in text-sm"></i>
                            </a>
                            <?php endif; ?>
                            <?php if($m['github']): ?>
                            <a href="<?php echo htmlspecialchars($m['github']); ?>" class="bg-white text-blue-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fab fa-github text-sm"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                <div class="col-span-4 text-center py-10">
                    <p class="text-gray-500 italic text-lg">Our research team is growing! Stay tuned for updates.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- members end here -->




    <!-- CTA Section -->
    <?php include 'Include/CTAsection.php'?>

    <!-- Footer -->
    <?php include 'Include/Footer.php';?>





    <script src="./script.js"></script>
</body>

</html>