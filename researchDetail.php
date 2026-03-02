<?php
session_start();
include 'db_connection/connection.php';

// Get ID from URL
$detail_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($detail_id <= 0) {
    header('Location: research.php');
    exit();
}

// Fetch video details with category names
$sql = "SELECT v.*, 
               c.name as category_name, 
               s.name as sub_category_name
        FROM research_videos v
        LEFT JOIN add_categories c ON v.category_id = c.id
        LEFT JOIN sub_categories s ON v.sub_category_id = s.id
        WHERE v.id = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $detail_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$video = mysqli_fetch_assoc($res);

if (!$video) {
    header('Location: research.php');
    exit();
}

// Fetch research details from research_details table
$research_sql = "SELECT * FROM research_detail WHERE id = ? LIMIT 1";
$research_stmt = mysqli_prepare($conn, $research_sql);
mysqli_stmt_bind_param($research_stmt, 'i', $detail_id);
mysqli_stmt_execute($research_stmt);
$research_res = mysqli_stmt_get_result($research_stmt);
$research_detail = mysqli_fetch_assoc($research_res);

// If no research details found in research_details table, 
// show video data with default research content
if (!$research_detail) {
    $research_detail = [
        'abstract' => $video['description'] ?? 'No abstract available.',
        'introduction' => 'This research study examines important aspects of ' . htmlspecialchars($video['title']) . '.',
        'methodology' => 'The methodology involves comprehensive analysis and data collection techniques relevant to this field.',
        'conclusion' => 'This research provides valuable insights into ' . htmlspecialchars($video['title']) . '.',
        'published_date' => $video['created_at'] ?? date('Y-m-d'),
        'pages' => 25,
        'downloads' => $video['views'] ?? 0,
        'pdf_file' => null
    ];
}



// Fetch related videos (same category)
$related_sql = "SELECT v.*, c.name as category_name 
                FROM research_videos v
                LEFT JOIN add_categories c ON v.category_id = c.id
                WHERE v.id != ? AND v.category_id = ?
                ORDER BY v.created_at DESC 
                LIMIT 2";

$related_stmt = mysqli_prepare($conn, $related_sql);
mysqli_stmt_bind_param($related_stmt, 'ii', $detail_id, $video['category_id']);
mysqli_stmt_execute($related_stmt);
$related_result = mysqli_stmt_get_result($related_stmt);
$related_videos = [];
while($row = mysqli_fetch_assoc($related_result)) {
    $related_videos[] = $row;
}

// If not enough related videos, get latest videos
if (count($related_videos) < 2) {
    $fallback_sql = "SELECT v.*, c.name as category_name 
                     FROM research_videos v
                     LEFT JOIN add_categories c ON v.category_id = c.id
                     WHERE v.id != ?
                     ORDER BY v.created_at DESC 
                     LIMIT " . (2 - count($related_videos));
    
    $fallback_stmt = mysqli_prepare($conn, $fallback_sql);
    mysqli_stmt_bind_param($fallback_stmt, 'i', $detail_id);
    mysqli_stmt_execute($fallback_stmt);
    $fallback_result = mysqli_stmt_get_result($fallback_stmt);
    
    while($row = mysqli_fetch_assoc($fallback_result)) {
        $related_videos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="<?php echo htmlspecialchars(substr($video['description'] ?? 'Research study', 0, 150)); ?>">
    <meta name="keywords"
        content="research, <?php echo htmlspecialchars($video['category_name'] ?? ''); ?>, <?php echo htmlspecialchars($video['title']); ?>">

    <!-- Tailwind CSS CDN -->
    <script src='https://cdn.tailwindcss.com'></script>

    <!-- Font Awesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' />

    <!-- Google Fonts: Outfit -->
    <link href='https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap'
        rel='stylesheet' />

    <title><?php echo htmlspecialchars($video['title']); ?> | Research Details</title>

    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#103182',
                    secondary: '#4fc5c1',
                },
            },
        },
    };
    </script>

    <style>
    /* Apply Outfit as the default font */
    body {
        font-family: 'Outfit', sans-serif;
    }

    /* Custom styling for content sections */
    .content-section {
        line-height: 1.8;
    }

    .content-section h3 {
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .content-section ul,
    .content-section ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .content-section li {
        margin-bottom: 0.5rem;
    }

    .highlight-box {
        border-left: 4px solid #4fc5c1;
        background-color: rgba(79, 197, 193, 0.05);
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0 0.5rem 0.5rem 0;
    }
    </style>
</head>

<body class='bg-gray-50'>
    <!-- header -->
    <?php include 'include/navbar.php'; ?>

    <!-- Breadcrumb -->
    <div class='max-w-7xl mx-auto px-4 lg:px-8 pt-6'>
        <nav class='flex' aria-label='Breadcrumb'>
            <ol class='inline-flex items-center space-x-1 md:space-x-3'>
                <li class='inline-flex items-center'>
                    <a href='index.php' class='text-gray-700 hover:text-primary text-sm'>Home</a>
                </li>
                <li>
                    <div class='flex items-center'>
                        <i class='fas fa-chevron-right text-gray-400 text-xs mx-2'></i>
                        <a href='research.php' class='text-gray-700 hover:text-primary text-sm'>Research Library</a>
                    </div>
                </li>
                <li>
                    <div class='flex items-center'>
                        <i class='fas fa-chevron-right text-gray-400 text-xs mx-2'></i>
                        <a href='#' class='text-gray-700 hover:text-primary text-sm'>
                            <?php echo htmlspecialchars($video['category_name'] ?? 'Research'); ?>
                        </a>
                    </div>
                </li>
                <li aria-current='page'>
                    <div class='flex items-center'>
                        <i class='fas fa-chevron-right text-gray-400 text-xs mx-2'></i>
                        <span class='text-primary font-medium text-sm truncate max-w-[200px]'>
                            <?php echo htmlspecialchars($video['title']); ?>
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div id='content' class='max-w-7xl mx-auto px-4 lg:px-8 py-8 md:py-12'>
        <div class='flex flex-col lg:flex-row gap-6'>
            <!-- Left Column - Research Details -->
            <div class='lg:w-1/3'>
                <div class='bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:sticky lg:top-24'>
                    <div class='flex flex-col items-center text-center mb-6'>
                        <!-- Video Thumbnail -->
                        <div class='mb-4 w-full'>
                            <?php if (!empty($video['thumbnail'])): ?>
                            <img src='/images/thumbnails/<?php echo htmlspecialchars($video['thumbnail']); ?>'
                                class='w-full h-48 object-cover rounded-lg'
                                alt='<?php echo htmlspecialchars($video['title']); ?>'>
                            <?php else: ?>
                            <div
                                class='w-full h-48 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-lg flex items-center justify-center'>
                                <i class='fas fa-video text-primary text-4xl'></i>
                            </div>
                            <?php endif; ?>
                        </div>

                        <h1 class='text-2xl font-bold text-primary mb-2'>
                            <?php echo htmlspecialchars($video['title']); ?>
                        </h1>
                        <p class='text-gray-600 text-sm'>Published:
                            <?php echo date('M d, Y', strtotime($research_detail['published_date'])); ?>
                        </p>
                    </div>

                    <div class='space-y-6'>
                        <!-- Authors Section -->
                        <div>
                            <h3 class='text-lg font-semibold text-primary mb-3'>Research Team</h3>
                            <div class='space-y-4'>
                                <?php if (!empty($video['research_leader'])): ?>
                                <div class='flex items-center'>
                                    <div class='w-12 h-12 rounded-full bg-gray-200 mr-4 overflow-hidden flex-shrink-0'>
                                        <div class='w-full h-full bg-primary/10 flex items-center justify-center'>
                                            <i class='fas fa-user text-primary'></i>
                                        </div>
                                    </div>
                                    <div class='min-w-0'>
                                        <p class='font-medium truncate'>
                                            <?php echo htmlspecialchars($video['research_leader']); ?></p>
                                        <p class='text-sm text-gray-600'>Research Leader</p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($video['co_leader'])): ?>
                                <div class='flex items-center'>
                                    <div class='w-12 h-12 rounded-full bg-gray-200 mr-4 overflow-hidden flex-shrink-0'>
                                        <div class='w-full h-full bg-secondary/10 flex items-center justify-center'>
                                            <i class='fas fa-user text-secondary'></i>
                                        </div>
                                    </div>
                                    <div class='min-w-0'>
                                        <p class='font-medium truncate'>
                                            <?php echo htmlspecialchars($video['co_leader']); ?></p>
                                        <p class='text-sm text-gray-600'>Co-Researcher</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Research Details -->
                        <div>
                            <h3 class='text-lg font-semibold text-primary mb-3'>Research Details</h3>
                            <div class='space-y-3'>
                                <div class='flex justify-between py-2 border-b border-gray-100'>
                                    <span class='text-gray-600'>Category:</span>
                                    <span class='font-medium'>
                                        <?php echo htmlspecialchars($video['category_name'] ?? 'Uncategorized'); ?>
                                    </span>
                                </div>

                                <?php if (!empty($video['sub_category_name'])): ?>
                                <div class='flex justify-between py-2 border-b border-gray-100'>
                                    <span class='text-gray-600'>Sub Category:</span>
                                    <span class='font-medium'>
                                        <?php echo htmlspecialchars($video['sub_category_name']); ?>
                                    </span>
                                </div>
                                <?php endif; ?>

                                <div class='flex justify-between py-2 border-b border-gray-100'>
                                    <span class='text-gray-600'>Pages:</span>
                                    <span class='font-medium'>
                                        <?php echo $research_detail['pages'] ?? 'N/A'; ?>
                                    </span>
                                </div>

                                <div class='flex justify-between py-2 border-b border-gray-100'>
                                    <span class='text-gray-600'>Downloads:</span>
                                    <span class='font-medium' id='download-count-text'>
                                        <?php echo number_format($research_detail['downloads'] ?? 0); ?>
                                    </span>
                                </div>

                                <div class='flex justify-between py-2'>
                                    <span class='text-gray-600'>Views:</span>
                                    <span class='font-medium'>
                                        <?php echo number_format($video['views'] ?? 0); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class='pt-4 border-t border-gray-200'>
                            <!-- Video Link Button -->
                            <a href='<?php echo htmlspecialchars($video['video_url']); ?>' target='_blank'
                                class='block w-full bg-secondary text-white py-3 rounded-lg font-medium mb-3 hover:bg-teal-600 transition flex items-center justify-center'>
                                <i class='fas fa-play mr-2'></i> Watch Research Video
                            </a>

                            <!-- Share Button with copy link functionality -->
                            <button onclick='shareResearch()'
                                class='w-full border border-primary text-primary py-3 rounded-lg font-medium mb-3 hover:bg-primary/5 transition flex items-center justify-center'>
                                <i class='fas fa-share-alt mr-2'></i> Share Research
                            </button>

                            <a href='download_research.php?id=<?php echo $detail_id; ?>'
                                id='download-btn'
                                class='block w-full bg-[#11327f] text-white py-3 rounded-lg font-medium mb-3 hover:bg-blue-800 transition flex items-center justify-center shadow-md'>
                                <i class='fas fa-file-download mr-2'></i> Download Research File
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Research Content -->
            <div class='lg:w-2/3'>
                <div class='bg-white rounded-xl shadow-md p-5 md:p-6 lg:p-8 content-section'>
                    <!-- Abstract Section -->
                    <div class='mb-8'>
                        <h2 class='text-2xl font-bold text-primary mb-4'>Abstract</h2>
                        <p class='text-gray-700 leading-relaxed'>
                            <?php 
                            if (!empty($research_detail['abstract'])) {
                                echo nl2br(htmlspecialchars($research_detail['abstract']));
                            } elseif (!empty($video['description'])) {
                                echo nl2br(htmlspecialchars($video['description']));
                            } else {
                                echo 'No abstract available for this research.';
                            }
                            ?>
                        </p>
                    </div>

                    <!-- Introduction Section -->
                    <?php if (!empty($research_detail['introduction'])): ?>
                    <div class='mb-8'>
                        <h2 class='text-2xl font-bold text-primary mb-4'>Introduction</h2>
                        <div class='text-gray-700 leading-relaxed'>
                            <?php echo nl2br(htmlspecialchars($research_detail['introduction'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Methodology Section -->
                    <?php if (!empty($research_detail['methodology'])): ?>
                    <div class='mb-8'>
                        <h2 class='text-2xl font-bold text-primary mb-4'>Methodology</h2>
                        <div class='text-gray-700 leading-relaxed'>
                            <?php echo nl2br(htmlspecialchars($research_detail['methodology'])); ?>
                        </div>

                        <!-- Sample Data Visualization -->
                        <div class='mt-8 p-4 bg-gray-50 rounded-lg'>
                            <h3 class='text-lg font-semibold text-primary mb-4 text-center'>Research Data Overview</h3>
                            <div class='h-64 flex items-end justify-center space-x-6'>
                                <div class='flex flex-col items-center'>
                                    <div class='w-12 bg-primary rounded-t-lg transition-all duration-300 hover:h-64'
                                        style='height: <?php echo min(180, ($video['views'] ?? 0) * 2); ?>px;'></div>
                                    <span class='mt-2 text-sm font-medium'>Views</span>
                                    <span class='text-xs text-gray-600'><?php echo $video['views'] ?? 0; ?></span>
                                </div>
                                <div class='flex flex-col items-center'>
                                    <div class='w-12 bg-secondary rounded-t-lg transition-all duration-300 hover:h-64'
                                        style='height: <?php echo min(150, ($research_detail['downloads'] ?? 0) * 3); ?>px;'>
                                    </div>
                                    <span class='mt-2 text-sm font-medium'>Downloads</span>
                                    <span id='download-chart-count'
                                        class='text-xs text-gray-600'><?php echo $research_detail['downloads'] ?? 0; ?></span>
                                </div>
                                <div class='flex flex-col items-center'>
                                    <div class='w-12 bg-teal-500 rounded-t-lg transition-all duration-300 hover:h-64'
                                        style='height: <?php echo min(120, ($research_detail['pages'] ?? 0) * 4); ?>px;'>
                                    </div>
                                    <span class='mt-2 text-sm font-medium'>Pages</span>
                                    <span
                                        class='text-xs text-gray-600'><?php echo $research_detail['pages'] ?? 0; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Key Findings Section -->
                    <div class='mb-8'>
                        <div class='highlight-box'>
                            <h3 class='text-xl font-semibold text-primary mb-3'>Key Findings</h3>
                            <ul class='list-disc pl-5 text-gray-700 space-y-2'>
                                <li>Comprehensive analysis of research data and methodologies</li>
                                <li>Significant contributions to the field of
                                    <?php echo htmlspecialchars($video['category_name'] ?? 'research'); ?></li>
                                <li>Practical implications for real-world applications</li>
                                <li>Foundation for future research directions</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Conclusion Section -->
                    <?php if (!empty($research_detail['conclusion'])): ?>
                    <div class='mb-8'>
                        <h2 class='text-2xl font-bold text-primary mb-4'>Conclusion</h2>
                        <div class='text-gray-700 leading-relaxed'>
                            <?php echo nl2br(htmlspecialchars($research_detail['conclusion'])); ?>
                        </div>

                        <div class='mt-6 p-4 bg-primary/5 border border-primary/20 rounded-lg'>
                            <h4 class='text-lg font-semibold text-primary mb-2'>Research Impact</h4>
                            <p class='text-gray-700'>
                                This research provides valuable insights and contributes significantly to the
                                understanding of
                                <strong><?php echo htmlspecialchars($video['title']); ?></strong>.
                                The findings have practical applications and open new avenues for future studies.
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- References Section -->
                    <div class='mb-8'>
                        <h2 class='text-2xl font-bold text-primary mb-4'>References</h2>
                        <ol class='list-decimal pl-5 text-gray-700 space-y-3'>
                            <li>
                                <?php echo htmlspecialchars($video['research_leader'] ?? 'Research Team'); ?>.
                                (<?php echo date('Y', strtotime($research_detail['published_date'])); ?>).
                                <span class='italic'><?php echo htmlspecialchars($video['title']); ?></span>.
                            </li>
                            <li>
                                Research Academia. (<?php echo date('Y'); ?>).
                                Comprehensive Research Database.
                            </li>
                            <li>
                                Academic Standards Committee. (2023).
                                <span class='italic'>Research Methodology Guidelines</span>,
                                5th Edition.
                            </li>
                            <?php if (!empty($video['category_name'])): ?>
                            <li>
                                <?php echo htmlspecialchars($video['category_name']); ?> Research Association.
                                (<?php echo date('Y'); ?>).
                                Annual Research Review.
                            </li>
                            <?php endif; ?>
                        </ol>
                    </div>

                    <!-- Citation Section -->
                    <div class='border-t border-gray-200 pt-6'>
                        <h3 class='text-lg font-semibold text-primary mb-4'>Cite This Research</h3>
                        <div class='bg-primary/5 p-4 rounded-lg'>
                            <p class='text-sm text-gray-700'>
                                <?php echo htmlspecialchars($video['research_leader'] ?? 'Research Team'); ?>,
                                &amp;
                                <?php echo htmlspecialchars($video['co_leader'] ?? 'Research Academy'); ?>.
                                (<?php echo date('Y', strtotime($research_detail['published_date'])); ?>).
                                <span class='italic'><?php echo htmlspecialchars($video['title']); ?></span>.
                                Research Academia.
                                https://researchacademia.edu/<?php echo $video['id']; ?>
                            </p>
                            <button onclick='copyCitation()'
                                class='mt-3 text-primary text-sm font-medium flex items-center hover:text-blue-800'>
                                <i class='fas fa-copy mr-2'></i> Copy Citation
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Related Research Section -->
                <?php if (!empty($related_videos)): ?>
                <div class='mt-8'>
                    <h2 class='text-2xl font-bold text-primary mb-6'>Related Research</h2>
                    <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                        <?php foreach($related_videos as $related): ?>
                        <div class='bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300'>
                            <span class='bg-primary/10 text-primary text-xs px-3 py-1 rounded-full'>
                                <?php echo htmlspecialchars($related['category_name'] ?? 'Research'); ?>
                            </span>
                            <h3 class='text-lg font-semibold mt-3 mb-2 line-clamp-2'>
                                <?php echo htmlspecialchars($related['title']); ?>
                            </h3>
                            <p class='text-gray-600 text-sm mb-3'>
                                <?php echo htmlspecialchars($related['research_leader'] ?? 'Research Team'); ?> •
                                <?php echo date('M Y', strtotime($related['created_at'])); ?>
                            </p>
                            <p class='text-gray-700 text-sm line-clamp-2 mb-4'>
                                <?php echo htmlspecialchars(substr($related['description'] ?? 'Research study', 0, 100)); ?>...
                            </p>
                            <a href='research_details.php?id=<?php echo $related['id']; ?>'
                                class='text-primary text-sm font-medium inline-flex items-center hover:text-blue-800'>
                                View Research
                                <i class='fas fa-arrow-right ml-2 text-xs'></i>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'Include/Footer.php'; ?>

    <script>
    // Share Research Functionality
    function shareResearch() {
        const url = window.location.href;
        const title = '<?php echo addslashes($video['title']); ?>';

        if (navigator.share) {
            navigator.share({
                    title: title,
                    text: 'Check out this research: ' + title,
                    url: url,
                })
                .then(() => console.log('Shared successfully'))
                .catch((error) => console.log('Sharing failed:', error));
        } else {
            // Fallback for browsers that don't support Web Share API
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied to clipboard!');
            }).catch(err => {
                prompt('Copy this URL:', url);
            });
        }
    }

    // Copy Citation Functionality
    function copyCitation() {
        const citation = document.querySelector('.bg-primary\\/5 p').textContent;
        navigator.clipboard.writeText(citation).then(() => {
            alert('Citation copied to clipboard!');
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Dynamic JS increment for download count when button is clicked
    document.addEventListener('DOMContentLoaded', function() {
        const downloadBtn = document.getElementById('download-btn');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function(e) {
                // Update text count
                const downloadCountElem = document.getElementById('download-count-text');
                if (downloadCountElem) {
                    let currentCount = parseInt(downloadCountElem.innerText.replace(/,/g, ''));
                    if (!isNaN(currentCount)) {
                        downloadCountElem.innerText = (currentCount + 1).toLocaleString();
                    }
                }
                
                // Update chart label count
                const chartCountElem = document.getElementById('download-chart-count');
                if (chartCountElem) {
                    let currentCount = parseInt(chartCountElem.innerText.replace(/,/g, ''));
                    if (!isNaN(currentCount)) {
                        chartCountElem.innerText = (currentCount + 1).toLocaleString();
                    }
                }
                // The actual backend increment and file download is handled by download_research.php
            });
        }
    });
    </script>
</body>

</html>