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
                            LIMIT ?, ?";
} else {
    $sql_select_lessons = "SELECT l.lesson_id, l.lesson_name 
                            FROM lesson l 
                            INNER JOIN course c ON l.course_id = c.course_id 
                            WHERE c.lec_id = ?
                            ORDER BY l.lesson_id ASC
                            LIMIT ?, ?";
}
$stmt_select_lessons = $conn->prepare($sql_select_lessons);
$stmt_select_lessons->bind_param("iii", $l_id, $offset, $itemsPerPage);
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ethiolearn/Font awesome/webfonts/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        body {
            padding: 2%;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        .search-bar .input-group {
            max-width: 600px;
            margin: auto;
        }
        .lesson-list table {
            width: 100%;
            margin-top: 20px;
        }
        .lesson-list th, .lesson-list td {
            padding: 10px;
            text-align: left;
        }
        .lesson-actions a {
            margin-right: 10px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 20px;
            border: 1px solid #ddd;
            color: #007bff;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lesson Management</h2>
        <div class="search-bar">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group mb-3">
                    <select id="itemsPerPage" class="form-control">
                        <option value="5" <?php if($itemsPerPage == 5) echo 'selected'; ?>>5 per page</option>
                        <option value="10" <?php if($itemsPerPage == 10) echo 'selected'; ?>>10 per page</option>
                        <option value="20" <?php if($itemsPerPage == 20) echo 'selected'; ?>>20 per page</option>
                    </select>
                    <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Lesson Name" value="<?php echo isset($_POST['search_text']) ? $_POST['search_text'] : ''; ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="lesson-list">
            <table class="table table-striped">
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
                            <td>
                                <a href="editLesson.php?lesson_id=<?php echo $row['lesson_id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <a href="delete_Lesson.php?lesson_id=<?php echo $row['lesson_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this lesson?')"><i class="fas fa-trash-alt"></i> Delete</a>
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
        <a href="addLesson.php" class="btn btn-primary mt-3">Add Lesson</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
