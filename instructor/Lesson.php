<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");

// Retrieve instructor's ID from session
$l_id = $_SESSION['l_id'];

// Pagination settings
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 5; // Default items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset

// Retrieve lessons associated with the instructor's courses with pagination
if(isset($_POST['search_text'])) {
    $search_text = $_POST['search_text'];
    $sql_select_lessons = "SELECT l.lesson_id, l.lesson_name 
                            FROM lesson l 
                            INNER JOIN course c ON l.course_id = c.course_id 
                            WHERE c.lec_id = ?
                            AND l.lesson_name LIKE '%$search_text%'
                            ORDER BY l.lesson_id ASC
                            LIMIT $offset, $itemsPerPage";
} else {
    $sql_select_lessons = "SELECT l.lesson_id, l.lesson_name 
                            FROM lesson l 
                            INNER JOIN course c ON l.course_id = c.course_id 
                            WHERE c.lec_id = ?
                            ORDER BY l.lesson_id ASC
                            LIMIT $offset, $itemsPerPage";
}
$stmt_select_lessons = $conn->prepare($sql_select_lessons);
$stmt_select_lessons->bind_param("i", $l_id);
$stmt_select_lessons->execute();
$result_select_lessons = $stmt_select_lessons->get_result();

// Count total lessons for pagination
if(isset($_POST['search_text'])) {
    $search_text = $_POST['search_text'];
    $sql_count_lessons = "SELECT COUNT(*) AS total 
                            FROM lesson l 
                            INNER JOIN course c ON l.course_id = c.course_id 
                            WHERE c.lec_id = ?
                            AND l.lesson_name LIKE '%$search_text%'";
} else {
    $sql_count_lessons = "SELECT COUNT(*) AS total 
                            FROM lesson l 
                            INNER JOIN course c ON l.course_id = c.course_id 
                            WHERE c.lec_id = ?";
}
$stmt_count_lessons = $conn->prepare($sql_count_lessons);
$stmt_count_lessons->bind_param("i", $l_id);
$stmt_count_lessons->execute();
$totalItemsRow = $stmt_count_lessons->get_result()->fetch_assoc();
$totalItems = $totalItemsRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson Management</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- Load jQuery first -->
    <link rel="stylesheet" href="css/material.css"> <!-- Link to external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <script src="/ethioleant/instructor/js/coustom.js"></script>
    <style>
        .lesson-list table tbody tr td {
            color: black; /* Set the text color to black */
        }
    </style>
</head>
<body>
    <div class="container" style="padding: 5%;">
        <h2>Lesson Management</h2>
        <div class="search-bar">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group mb-3">
                    <select id="itemsPerPage" class="form-select">
                        <option value="5" <?php if($itemsPerPage == 5) echo 'selected'; ?>>5 per page</option>
                        <option value="10" <?php if($itemsPerPage == 10) echo 'selected'; ?>>10 per page</option>
                        <option value="20" <?php if($itemsPerPage == 20) echo 'selected'; ?>>20 per page</option>
                    </select>
                    <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Lesson Name" value="<?php echo isset($_POST['search_text']) ? $_POST['search_text'] : ''; ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="lesson-list">
            <table>
                <thead>
                    <tr>
                        <th>Lesson ID</th>
                        <th>Lesson Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_select_lessons->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['lesson_id']; ?></td>
                            <td><?php echo $row['lesson_name']; ?></td>
                            <td class="lesson-actions">
                                <a href="editLesson.php?lesson_id=<?php echo $row['lesson_id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                                <a href="deleteLesson.php?lesson_id=<?php echo $row['lesson_id']; ?>" onclick="return confirm('Are you sure you want to delete this lesson?')"><i class="fas fa-trash-alt"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="pagination">
            <?php if ($totalPages > 1): ?>
                <a href="?page=1&itemsPerPage=<?php echo $itemsPerPage; ?>">&laquo; First</a>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <a href="?page=<?php echo $i; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <a href="?page=<?php echo $totalPages; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>">Last &raquo;</a>
            <?php endif; ?>
        </div>
        <a href="addLesson.php" class="btn btn-primary" style="margin:10px";>Add Lesson</a>
    </div>
    <script>
        $(document).ready(function(){
            $('#itemsPerPage').change(function(){
                var itemsPerPage = $(this).val();
                var currentQuery = window.location.search;
                var newQuery = updateQueryStringParameter(currentQuery, 'itemsPerPage', itemsPerPage);
                window.location.search = newQuery;
            });

            function updateQueryStringParameter(uri , key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                } else {
                    return uri + separator + key + "=" + value;
                }
            }

            var debounceTimer;
            $('#search_text').keyup(function(){
                clearTimeout(debounceTimer);
                var txt = $(this).val();
                debounceTimer = setTimeout(function() {
                    if (txt != '') {
                        $.ajax({
                            url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                            type: "post",
                            data: {search_text: txt},
                            dataType: "html",
                            success: function (data) {
                                $('.lesson-list tbody').html($(data).find('.lesson-list tbody').html());
                            }
                        });
                    } else {
                        window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>";
                    }
                }, 500); // Adjust the delay as needed
            });
        });
    </script>
</body>
</html>
