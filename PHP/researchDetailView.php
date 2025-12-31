<?php
session_start();

include '../db_connection/connection.php';

$detail_id = isset( $_GET[ 'id' ] ) ? intval( $_GET[ 'id' ] ) : 0;

if ( $detail_id <= 0 ) {
    header( 'Location: researchdetailtable.php' );
    exit();
}

$query = "SELECT rd.*, c.name as category_name, sc.name as sub_category_name
          FROM research_detail rd
          LEFT JOIN add_categories c ON rd.category_id = c.id
          LEFT JOIN sub_categories sc ON rd.sub_category_id = sc.id
          WHERE rd.id = ?";

$stmt = mysqli_prepare( $conn, $query );
mysqli_stmt_bind_param( $stmt, 'i', $detail_id );
mysqli_stmt_execute( $stmt );
$result = mysqli_stmt_get_result( $stmt );
$detail = mysqli_fetch_assoc( $result );

if ( !$detail ) {
    header( 'Location: researchdetailtable.php' );
    exit();
}

$updateQuery = 'UPDATE research_detail SET downloads = downloads + 1 WHERE id = ?';
$updateStmt = mysqli_prepare( $conn, $updateQuery );
mysqli_stmt_bind_param( $updateStmt, 'i', $detail_id );
mysqli_stmt_execute( $updateStmt );
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php echo htmlspecialchars( $detail[ 'title' ] );
?> | Research Academia</title>
    <script src='https://cdn.tailwindcss.com'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    <style>
    :root {
        --primary: #103182;
        --secondary: #4fc5c1;
    }

    .card-shadow {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .content-section {
        padding: 1.5rem;
        border-left: 4px solid var(--secondary);
        background-color: #f8fafc;
        border-radius: 0.5rem;
    }

    .content-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.75rem;
        font-size: 1.125rem;
    }

    .content-text {
        color: #475569;
        line-height: 1.75;
    }

    .stat-box {
        padding: 1.25rem;
        background: linear-gradient(135deg, var(--primary), #2e5090);
        border-radius: 0.75rem;
        color: white;
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }
    </style>
</head>

<body class='bg-gradient-to-br from-gray-50 to-blue-50'>

    <!-- Navigation -->
    <?php include '../include/navbar.php';
?>

    <!-- Breadcrumb -->
    <div class='bg-white border-b border-gray-200'>
        <div class='container mx-auto px-4 py-4'>
            <div class='flex items-center space-x-2 text-sm'>
                <a href='index.php' class='text-primary hover:underline'>Home</a>
                <i class='fas fa-chevron-right text-gray-400 text-xs'></i>
                <a href='research.php' class='text-primary hover:underline'>Research</a>
                <i class='fas fa-chevron-right text-gray-400 text-xs'></i>
                <span class='text-gray-600 font-medium'>Research Detail</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class='py-12'>
        <div class='container mx-auto px-4 max-w-4xl'>

            <!-- Header Section -->
            <div class='bg-white rounded-2xl card-shadow p-8 md:p-12 border border-gray-100 mb-8'>

                <!-- Category Badge -->
                <div class='flex flex-wrap gap-3 mb-6'>
                    <span
                        class='inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-secondary text-white'>
                        <i class='fas fa-folder-open mr-2'></i>
                        <?php echo htmlspecialchars( $detail[ 'category_name' ] ?? 'Uncategorized' );
?>
                    </span>
                    <span
                        class='inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-200 text-blue-900'>
                        <i class='fas fa-tag mr-2'></i>
                        <?php echo htmlspecialchars( $detail[ 'sub_category_name' ] ?? 'Not assigned' );
?>
                    </span>
                </div>

                <!-- Title -->
                <h1 class='text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight'>
                    <?php echo htmlspecialchars( $detail[ 'title' ] );
?>
                </h1>

                <!-- Meta Information -->
                <div class='grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 pt-6 border-t border-gray-200'>
                    <!-- Published Date -->
                    <div class='flex items-center space-x-2'>
                        <i class='fas fa-calendar-alt text-secondary text-lg'></i>
                        <div>
                            <p class='text-xs text-gray-500 font-medium uppercase'>Published Date</p>
                            <p class='text-sm font-semibold text-gray-900'>
                                <?php
echo $detail[ 'published_date' ] ? date( 'M d, Y', strtotime( $detail[ 'published_date' ] ) ) : '—';
?>
                            </p>
                        </div>
                    </div>

                    <!-- Pages -->
                    <div class='flex items-center space-x-2'>
                        <i class='fas fa-file-lines text-secondary text-lg'></i>
                        <div>
                            <p class='text-xs text-gray-500 font-medium uppercase'>Pages</p>
                            <p class='text-sm font-semibold text-gray-900'>
                                <?php echo $detail[ 'pages' ] ?? '—';
?>
                            </p>
                        </div>
                    </div>

                    <!-- Downloads -->
                    <div class='flex items-center space-x-2'>
                        <i class='fas fa-download text-secondary text-lg'></i>
                        <div>
                            <p class='text-xs text-gray-500 font-medium uppercase'>Downloads</p>
                            <p class='text-sm font-semibold text-gray-900'>
                                <?php echo $detail[ 'downloads' ];
?>
                            </p>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class='flex items-center space-x-2'>
                        <i class='fas fa-clock text-secondary text-lg'></i>
                        <div>
                            <p class='text-xs text-gray-500 font-medium uppercase'>Added</p>
                            <p class='text-sm font-semibold text-gray-900'>
                                <?php echo date( 'M d, Y', strtotime( $detail[ 'created_at' ] ) );
?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- PDF Download Button -->
                <?php if ( !empty( $detail[ 'pdf_file' ] ) && file_exists( '../' . $detail[ 'pdf_file' ] ) ): ?>
                <div class='flex flex-col md:flex-row gap-4 pt-6 border-t border-gray-200'>
                    <a href="../<?php echo htmlspecialchars($detail['pdf_file']); ?>" download
                        class='inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg'>
                        <i class='fas fa-download mr-2'></i>
                        Download PDF ( <?php echo $detail[ 'pages' ];
?> pages )
                    </a>
                    <a href='researchdetailtable.php'
                        class='inline-flex items-center justify-center px-8 py-4 bg-gray-100 text-gray-900 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300'>
                        <i class='fas fa-arrow-left mr-2'></i>
                        Back to Research
                    </a>
                </div>
                <?php endif;
?>

            </div>

            <!-- Content Sections -->
            <!-- Abstract -->
            <?php if ( !empty( $detail[ 'abstract' ] ) ): ?>
            <div class='mb-8'>
                <div class='content-section'>
                    <h2 class='content-title'>
                        <i class='fas fa-lightbulb mr-2'></i>Abstract
                    </h2>
                    <p class='content-text'>
                        <?php echo nl2br( htmlspecialchars( $detail[ 'abstract' ] ) );
?>
                    </p>
                </div>
            </div>
            <?php endif;
?>

            <!-- Introduction -->
            <?php if ( !empty( $detail[ 'introduction' ] ) ): ?>
            <div class='mb-8'>
                <div class='content-section'>
                    <h2 class='content-title'>
                        <i class='fas fa-arrow-right mr-2'></i>Introduction
                    </h2>
                    <p class='content-text'>
                        <?php echo nl2br( htmlspecialchars( $detail[ 'introduction' ] ) );
?>
                    </p>
                </div>
            </div>
            <?php endif;
?>

            <!-- Methodology -->
            <?php if ( !empty( $detail[ 'methodology' ] ) ): ?>
            <div class='mb-8'>
                <div class='content-section'>
                    <h2 class='content-title'>
                        <i class='fas fa-flask mr-2'></i>Methodology
                    </h2>
                    <p class='content-text'>
                        <?php echo nl2br( htmlspecialchars( $detail[ 'methodology' ] ) );
?>
                    </p>
                </div>
            </div>
            <?php endif;
?>

            <!-- Conclusion -->
            <?php if ( !empty( $detail[ 'conclusion' ] ) ): ?>
            <div class='mb-8'>
                <div class='content-section'>
                    <h2 class='content-title'>
                        <i class='fas fa-check-circle mr-2'></i>Conclusion
                    </h2>
                    <p class='content-text'>
                        <?php echo nl2br( htmlspecialchars( $detail[ 'conclusion' ] ) );
?>
                    </p>
                </div>
            </div>
            <?php endif;
?>

            <!-- Admin Actions -->
            <div class='mt-12 pt-8 border-t border-gray-200'>
                <div class='flex flex-col md:flex-row gap-4'>
                    <a href="researchdetailedit.php?id=<?php echo $detail['id']; ?>"
                        class='inline-flex items-center justify-center px-6 py-3 bg-green-50 text-green-700 font-semibold rounded-lg hover:bg-green-100 transition'>
                        <i class='fas fa-edit mr-2'></i>
                        Edit Research Detail
                    </a>
                    <button onclick="confirmDelete(<?php echo $detail['id']; ?>)"
                        class='inline-flex items-center justify-center px-6 py-3 bg-red-50 text-red-700 font-semibold rounded-lg hover:bg-red-100 transition'>
                        <i class='fas fa-trash-alt mr-2'></i>
                        Delete Research Detail
                    </button>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <?php include '../include/Footer.php';
?>

    <script>
    function confirmDelete(detailId) {
        if (confirm('Are you sure you want to delete this research detail? This action cannot be undone.')) {
            window.location.href = 'researchdetaildelete_process.php?delete_id=' + detailId;
        }
    }
    </script>

</body>

</html>