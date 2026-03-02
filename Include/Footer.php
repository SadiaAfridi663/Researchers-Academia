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
    <footer class="bg-[#0b1633] text-white pt-20 pb-10 px-6 overflow-hidden relative">
        <!-- Background decorative elements -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/10 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-secondary/5 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand Column -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center shadow-2xl shadow-primary/20">
                            <i class="fas fa-microscope text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight text-white leading-none">Research</h2>
                            <p class="text-[10px] font-black text-secondary uppercase tracking-[0.2em] mt-1">Academia</p>
                        </div>
                    </div>

                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                        Pushing the boundaries of human knowledge through rigorous academic research, innovative methodologies, and global collaboration.
                    </p>

                    <div class="flex items-center gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white hover:border-primary hover:-translate-y-1 transition-all duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white hover:border-primary hover:-translate-y-1 transition-all duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white hover:border-primary hover:-translate-y-1 transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white hover:border-primary hover:-translate-y-1 transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Research Areas (Dynamic) -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-8 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        Research Areas
                    </h4>
                    <ul class="space-y-4">
                        <li>
                            <a href="research.php" class="group flex items-center text-gray-400 hover:text-white text-sm transition-all">
                                <span class="w-0 group-hover:w-3 h-[1px] bg-secondary mr-0 group-hover:mr-2 transition-all"></span>
                                All Research
                            </a>
                        </li>
                        <?php 
                        // Fetch Categories for Footer
                        if(isset($conn)) {
                            $footer_cat_query = "SELECT id, name FROM add_categories ORDER BY name ASC LIMIT 5";
                            $footer_cat_res = mysqli_query($conn, $footer_cat_query);
                            if($footer_cat_res && mysqli_num_rows($footer_cat_res) > 0) {
                                while($f_cat = mysqli_fetch_assoc($footer_cat_res)) {
                        ?>
                        <li>
                            <a href="research.php?category_id=<?php echo $f_cat['id']; ?>" class="group flex items-center text-gray-400 hover:text-white text-sm transition-all">
                                <span class="w-0 group-hover:w-3 h-[1px] bg-secondary mr-0 group-hover:mr-2 transition-all"></span>
                                <?php echo htmlspecialchars($f_cat['name']); ?>
                            </a>
                        </li>
                        <?php 
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>

                <!-- Column 3: Resources -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-8 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        Resources
                    </h4>
                    <ul class="space-y-4">
                        <li><a href="research.php" class="group flex items-center text-gray-400 hover:text-white text-sm transition-all"><span class="w-0 group-hover:w-3 h-[1px] bg-secondary mr-0 group-hover:mr-2 transition-all"></span>Publications Library</a></li>
                        <li><a href="research.php" class="group flex items-center text-gray-400 hover:text-white text-sm transition-all"><span class="w-0 group-hover:w-3 h-[1px] bg-secondary mr-0 group-hover:mr-2 transition-all"></span>Open Research</a></li>
                        <li><a href="join_us.php" class="group flex items-center text-gray-400 hover:text-white text-sm transition-all"><span class="w-0 group-hover:w-3 h-[1px] bg-secondary mr-0 group-hover:mr-2 transition-all"></span>Join Our Team</a></li>
                        <li><a href="team.php" class="group flex items-center text-gray-400 hover:text-white text-sm transition-all"><span class="w-0 group-hover:w-3 h-[1px] bg-secondary mr-0 group-hover:mr-2 transition-all"></span>Research Ethics</a></li>
                        <li><a href="contact.php" class="group flex items-center text-gray-400 hover:text-white text-sm transition-all"><span class="w-0 group-hover:w-3 h-[1px] bg-secondary mr-0 group-hover:mr-2 transition-all"></span>Contact Support</a></li>
                    </ul>
                </div>

                <!-- Column 4: Newsletter -->
                <div class="bg-white/5 rounded-3xl p-8 border border-white/5 backdrop-blur-sm self-start">
                    <h4 class="text-white font-bold text-lg mb-4">Stay Informed</h4>
                    <p class="text-gray-400 text-xs leading-relaxed mb-6">
                        Get the latest research breakthroughs delivered to your inbox.
                    </p>
                    <form class="space-y-3">
                        <div class="relative">
                            <input type="email" placeholder="Your email address" 
                                class="w-full bg-[#16213e] border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all placeholder:text-gray-600">
                        </div>
                        <button type="submit" 
                            class="w-full bg-primary hover:bg-blue-800 text-white font-bold py-3 rounded-xl transition-all duration-300 shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                            <span>Subscribe</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </form>
                    <div class="flex items-center gap-2 mt-6 p-3 bg-white/5 rounded-xl">
                        <i class="fas fa-lock text-secondary text-[10px]"></i>
                        <p class="text-[10px] text-gray-500">Your privacy is our priority.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Divider -->
            <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent mb-8"></div>

            <!-- Bottom Footer -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <p class="text-gray-500 text-xs">
                        &copy; <?php echo date('Y'); ?> <span class="font-bold text-gray-400">Research Academia</span>. All rights reserved.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-gray-500 hover:text-white text-[10px] transition-colors uppercase tracking-widest font-bold">Privacy</a>
                        <a href="#" class="text-gray-500 hover:text-white text-[10px] transition-colors uppercase tracking-widest font-bold">Terms</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-500 text-[10px] font-medium uppercase tracking-widest px-3 py-1 bg-white/5 rounded-full border border-white/5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                        Systems Operational
                    </span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>