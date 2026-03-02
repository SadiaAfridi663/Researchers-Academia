<?php
include 'db_connection/connection.php';
if ( session_status() === PHP_SESSION_NONE ) {
    session_start();
}

// Determine login state
$isLoggedIn = isset( $_SESSION[ 'super_admin_id' ] ) || isset( $_SESSION[ 'user_id' ] );

// Determine display name: prefer super admin name, then full user name, then username
$userName = '';
if ( isset( $_SESSION[ 'super_admin_name' ] ) && !empty( $_SESSION[ 'super_admin_name' ] ) ) {
    $userName = $_SESSION[ 'super_admin_name' ];
} elseif ( isset( $_SESSION[ 'user_name' ] ) && !empty( $_SESSION[ 'user_name' ] ) ) {
    $userName = $_SESSION[ 'user_name' ];
} elseif ( isset( $_SESSION[ 'username' ] ) && !empty( $_SESSION[ 'username' ] ) ) {
    $userName = $_SESSION[ 'username' ];
}

function isFreeResource( $categoryName ) {
    return strtolower( trim( $categoryName ) ) === 'free resources' || strtolower( trim( $categoryName ) ) === 'free resource';
}

function getCategoryLink( $categoryId, $categoryName, $categorySlug, $isLoggedIn ) {
    if ( isFreeResource( $categoryName ) ) {
        return "research.php?category_id={$categoryId}&category={$categorySlug}";
    } else {
        if ( $isLoggedIn ) {
            return "research.php?category_id={$categoryId}&category={$categorySlug}";
        } else {
            return 'javascript:void(0);' . '" onclick="requireLogin()';
        }
    }
}

// Fetch categories
$categoriesQuery = 'SELECT id, name FROM add_categories ORDER BY name ASC';
$categoriesResult = mysqli_query( $conn, $categoriesQuery );

// Optional: check query
if ( !$categoriesResult ) {
    die( 'Query failed: ' . mysqli_error( $conn ) );
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <script src='https://cdn.tailwindcss.com'></script>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>

    <link href='https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap' rel='stylesheet'>
    <title>Document</title>
</head>

<body>
    <!-- Header -->
    <header class='flex justify-between items-center px-6 sm:px-10 shadow-xl py-3 sticky top-0 bg-white z-50'>
        <div>
            <img src='./images/LOGO.jpg' alt='Logo' class='w-[70px] sm:w-[120px]'>
        </div>

        <!-- Desktop Nav -->
        <nav class='hidden lg:block'>
            <ul class='flex justify-center items-center gap-10'>
                <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer'>
                    <a href='./index.php'>Home</a>
                </li>
                <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer'>
                    <a href='./about.php'>About</a>
                </li>
                <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer'>
                    <a href='./team.php'>Team</a>
                </li>
                <li class='relative group'>
                    <!-- Trigger -->
                    <div class='cursor-pointer py-2 px-4 rounded-lg transition-colors duration-200 flex items-center'>
                        <span class='text-gray-800 group-hover:text-[#444a96] text-lg font-semibold'>Research
                            Library</span>
                        <i
                            class='fas fa-chevron-down ml-2 text-xs transition-transform duration-200 group-hover:rotate-180'></i>
                    </div>

                    <!-- Dropdown -->
                    <div
                        class='absolute top-full left-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible transition-all duration-300 transform origin-top -translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50'>
                        <div class='py-2'>

                            <?php while ( $cat = mysqli_fetch_assoc( $categoriesResult ) ) {
    ?>

                            <?php
    // category name ko URL friendly banana
    $categoryName = $cat[ 'name' ];
    $categorySlug = strtolower( $categoryName );
    $categorySlug = str_replace( ' ', '-', $categorySlug );
    $isFree = isFreeResource( $categoryName );
    $href = getCategoryLink( $cat[ 'id' ], $categoryName, $categorySlug, $isLoggedIn );
    ?>

                            <div class='px-4 py-2 hover:bg-[#616ad6] cursor-pointer relative group'>
                                <a href="<?php echo $href; ?>"
                                    class='block text-gray-800 hover:text-white flex items-center justify-between'>

                                    <?php echo $categoryName;
    ?>
                                    <?php if ( !$isFree && !$isLoggedIn ): ?>
                                    <span class='text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded ml-2'
                                        title='Login required'>
                                        <i class='fas fa-lock text-xs'></i>
                                    </span>
                                    <?php endif;
    ?>
                                </a>
                            </div>

                            <?php }
    ?>

                        </div>
                    </div>
                </li>
                <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer'>
                    <a href='./contact_us.php'>Contact</a>
                </li>
            </ul>
        </nav>

        <div class='flex items-center gap-4'>
            <?php if ( $isLoggedIn ): ?>
            <!-- User Profile Dropdown ( Desktop ) -->
            <div class='hidden sm:block relative group'>
                <!-- Dropdown Button -->
                <button
                    class='flex items-center justify-center gap-2 rounded-md px-6 py-2 bg-gradient-to-r from-[#11327f] to-[#0a1f50] shadow-md text-white hover:shadow-lg transition-all duration-300 relative z-10'>
                    <i class='fas fa-user-circle text-lg'></i>
                    <span class='font-semibold'><?php echo htmlspecialchars( substr( $userName, 0, 10 ) );
    ?></span>
                    <i class='fas fa-chevron-down text-xs'></i>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class='absolute top-full right-0 mt-2 w-[190px] bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100 z-50'>
                    <!-- User Info -->
                    <div
                        class='px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-gray-50 rounded-t-lg'>
                        <p class='text-sm font-semibold text-gray-800'>Welcome back!</p>
                        <p class='text-xs text-gray-500 truncate' title="<?php echo htmlspecialchars($userName); ?>">
                            <?php echo htmlspecialchars( $userName );
    ?>
                        </p>
                    </div>

                    <div class='rounded-lg overflow-hidden'>
                        <!-- Logout -->
                        <a href='./logout.php'
                            class='flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200'>
                            <i class='fas fa-sign-out-alt mr-3 text-gray-400 group-hover:text-red-500'></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Join Us Button ( When not logged in ) -->
            <div class='group hidden sm:inline-block'>
                <a href='./join_us.php'
                    class='flex items-center justify-center gap-2 rounded-md px-6 py-2 bg-[#11327f] shadow-md text-white transition-all duration-300 hover:shadow-lg'>
                    Join Us
                    <img src='./images/arrow.png' alt=''
                        class='w-6 transform transition-transform duration-300 group-hover:translate-x-2'>
                </a>
            </div>
            <?php endif;
    ?>

            <button id='menu-btn' class='lg:hidden flex flex-col justify-between w-8 h-6 relative z-50'>
                <span id='line1' class='w-6 h-0.5 bg-gray-800 transition-all duration-300 origin-center'></span>
                <span id='line2' class='w-6 h-0.5 bg-gray-800 transition-all duration-300 origin-center'></span>
                <span id='line3' class='w-6 h-0.5 bg-gray-800 transition-all duration-300 origin-center'></span>
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id='mobile-overlay' class='fixed inset-0 bg-black bg-opacity-70 hidden lg:hidden z-40'></div>

        <!-- Mobile Menu -->
        <div id='mobile-menu'
            class='fixed top-0 left-0 w-full  bg-white shadow-lg transform -translate-y-full transition-transform duration-500 ease-in-out lg:hidden z-40 overflow-y-auto'>
            <div class='py-6 px-10 pt-16'>

                <ul class='flex flex-col gap-4'>
                    <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer py-2'>
                        <a href='./index.php' class='block' onclick='closeMobileMenu()'>Home</a>
                    </li>
                    <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer py-2'>
                        <a href='./about.php' class='block' onclick='closeMobileMenu()'>About</a>
                    </li>
                    <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer py-2'>
                        <a href='./team.php' class='block' onclick='closeMobileMenu()'>Team</a>
                    </li>

                    <!-- Research Library with Submenu -->
                    <li class='text-gray-800 text-lg font-semibold py-2'>
                        <div class='flex items-center justify-between cursor-pointer' onclick='toggleSubmenu()'>
                            <span>Research Library</span>
                            <i id='submenu-arrow'
                                class='fas fa-chevron-down text-xs transition-transform duration-300'></i>
                        </div>
                        <ul id='research-submenu' class='pl-6 mt-2 overflow-hidden max-h-0 transition-all duration-300'>
                            <?php
    // Fetch categories again for mobile menu ( reset cursor )
    $categoriesQuery = 'SELECT id, name FROM add_categories ORDER BY name ASC';
    $categoriesResult = mysqli_query( $conn, $categoriesQuery );

    while ( $cat = mysqli_fetch_assoc( $categoriesResult ) ) {
        $categoryName = $cat[ 'name' ];
        $categorySlug = strtolower( $categoryName );
        $categorySlug = str_replace( ' ', '-', $categorySlug );
        $isFree = isFreeResource( $categoryName );
        $href = getCategoryLink( $cat[ 'id' ], $categoryName, $categorySlug, $isLoggedIn );
        ?>
                            <li class='py-2'>
                                <a href='<?php echo $href; ?>'
                                    class='text-gray-600 hover:text-[#444a96] block flex items-center justify-between'
                                    onclick='closeMobileMenu()'>
                                    <span><?php echo $categoryName;
        ?></span>
                                    <?php if ( !$isFree && !$isLoggedIn ): ?>
                                    <span class='text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded ml-2'>
                                        <i class='fas fa-lock text-xs'></i>
                                    </span>
                                    <?php endif;
        ?>
                                </a>
                            </li>
                            <?php }
        ?>
                        </ul>
                    </li>

                    <li class='text-gray-800 hover:text-[#444a96] text-lg font-semibold cursor-pointer py-2'>
                        <a href='./contact.php' class='block' onclick='closeMobileMenu()'>Contact</a>
                    </li>
                    <li class='pt-4'>
                        <?php if ( $isLoggedIn ): ?>
                        <div class='space-y-2'>
                            <div class='px-4 py-3 bg-gray-100 rounded-lg'>
                                <p class='text-sm font-semibold text-gray-800'>Logged in as</p>
                                <p class='text-xs text-gray-600'><?php echo htmlspecialchars( $userName );
        ?></p>
                            </div>
                            <a href='./logout.php'
                                class='w-full px-6 py-3 bg-red-600 text-white rounded-lg font-semibold shadow-md hover:bg-red-700 transition block text-center'>
                                <i class='fas fa-sign-out-alt mr-2'></i>Logout
                            </a>
                        </div>
                        <?php else: ?>
                        <button
                            class='w-full px-6 py-3 bg-[#11327f] text-white rounded-lg font-semibold shadow-md hover:shadow-xl transition'>
                            <a href='./join_us.php'>Join Us</a>
                        </button>
                        <?php endif;
        ?>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- header end -->

    <script>
    // Function to handle login requirement
    function requireLogin() {
        alert('This resource requires login. Please sign up or log in to access it.');
        window.location.href = './join_us.php';
    }

    // Wrap in IIFE to avoid re-declaring const variables that script.js also uses
    (function() {
        var _menuBtn = document.getElementById('menu-btn');
        var _mobileMenu = document.getElementById('mobile-menu');
        var _mobileOverlay = document.getElementById('mobile-overlay');
        var _line1 = document.getElementById('line1');
        var _line2 = document.getElementById('line2');
        var _line3 = document.getElementById('line3');

        function _openMenu() {
            if (_mobileMenu) _mobileMenu.classList.remove('-translate-y-full');
            if (_mobileOverlay) _mobileOverlay.classList.remove('hidden');
            if (_line1) { _line1.classList.add('rotate-45'); _line1.classList.add('translate-y-2'); }
            if (_line2) _line2.classList.add('opacity-0');
            if (_line3) { _line3.classList.add('-rotate-45'); _line3.classList.add('-translate-y-2'); }
        }

        function _closeMenu() {
            if (_mobileMenu) _mobileMenu.classList.add('-translate-y-full');
            if (_mobileOverlay) _mobileOverlay.classList.add('hidden');
            if (_line1) { _line1.classList.remove('rotate-45'); _line1.classList.remove('translate-y-2'); }
            if (_line2) _line2.classList.remove('opacity-0');
            if (_line3) { _line3.classList.remove('-rotate-45'); _line3.classList.remove('-translate-y-2'); }
        }

        if (_menuBtn) {
            _menuBtn.addEventListener('click', function() {
                var isOpen = _mobileMenu && !_mobileMenu.classList.contains('-translate-y-full');
                if (isOpen) { _closeMenu(); } else { _openMenu(); }
            });
        }

        if (_mobileOverlay) {
            _mobileOverlay.addEventListener('click', _closeMenu);
        }

        // Expose globally needed functions
        window.closeMobileMenu = _closeMenu;

        window.toggleSubmenu = function() {
            var submenu = document.getElementById('research-submenu');
            var arrow = document.getElementById('submenu-arrow');
            if (!submenu || !arrow) return;
            if (submenu.style.maxHeight === '0px' || submenu.style.maxHeight === '') {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                arrow.classList.add('rotate-180');
            } else {
                submenu.style.maxHeight = '0';
                arrow.classList.remove('rotate-180');
            }
        };
    })();
    </script>

</body>

</html>