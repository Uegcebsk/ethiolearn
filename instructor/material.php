<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");
// Assuming $l_id holds the ID of the intended instructor
$l_id = $_SESSION['l_id']; // Assuming you store the logged-in instructor's ID in session

// Pagination settings
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 5; // Default items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset

// Retrieve materials associated with the instructor's courses with pagination
if(isset($_POST['search_text'])) {
    $search_text = $_POST['search_text'];
    $sql_select_materials = "SELECT m.*, c.course_name 
                            FROM materials m
                            JOIN course c ON m.course_id = c.course_id 
                            WHERE c.lec_id = ?
                            AND m.material_name LIKE '%$search_text%'
                            ORDER BY m.upload_date DESC
                            LIMIT $offset, $itemsPerPage";
} else {
    $sql_select_materials = "SELECT m.*, c.course_name 
                            FROM materials m
                            JOIN course c ON m.course_id = c.course_id 
                            WHERE c.lec_id = ?
                            ORDER BY m.upload_date DESC
                            LIMIT $offset, $itemsPerPage";
}
$stmt_select_materials = $conn->prepare($sql_select_materials);
$stmt_select_materials->bind_param("i", $l_id);
$stmt_select_materials->execute();
$result_select_materials = $stmt_select_materials->get_result();

// Count total materials for pagination
if(isset($_POST['search_text'])) {
    $sql_count_materials = "SELECT COUNT(*) AS total 
                            FROM materials m 
                            JOIN course c ON m.course_id = c.course_id 
                            WHERE c.lec_id = ?
                            AND m.material_name LIKE '%$search_text%'";
} else {
    $sql_count_materials = "SELECT COUNT(*) AS total 
                            FROM materials m 
                            JOIN course c ON m.course_id = c.course_id 
                            WHERE c.lec_id = ?";
}
$stmt_count_materials = $conn->prepare($sql_count_materials);
$stmt_count_materials->bind_param("i", $l_id);
$stmt_count_materials->execute();
$totalItemsRow = $stmt_count_materials->get_result()->fetch_assoc();
$totalItems = $totalItemsRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Management</title>
    <script src="/ethiolearn/js/jquery-3.3.1.min.js"></script> <!-- Load jQuery first -->
    <script src="/ethioleant/instructor/js/coustom.js"></script>
    <style>
        .material-list table tbody tr td {
    color: black; /* Set the text color to black */
}
.container
{
    padding: 3%;
}
    </style>
</head>
<body>
    <div class="container ">
        <h2>Material Management</h2>
        <div class="search-bar">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group mb-3">
                    <select id="itemsPerPage" class="form-select">
                        <option value="5" <?php if($itemsPerPage == 5) echo 'selected'; ?>>5 per page</option>
                        <option value="10" <?php if($itemsPerPage == 10) echo 'selected'; ?>>10 per page</option>
                        <option value="20" <?php if($itemsPerPage == 20) echo 'selected'; ?>>20 per page</option>
                    </select>
                    <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Material Name" value="<?php echo isset($_POST['search_text']) ? $_POST['search_text'] : ''; ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="material-list">
            <table>
                <thead>
                    <tr>
                        <th>Material Name</th>
                        <th>Course Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_select_materials->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['material_name']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['material_type']; ?></td>
                            <td class="material-actions">
                                <a href="editmaterial.php?material_id=<?php echo $row['material_id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                                <a href="delete_material.php?material_id=<?php echo $row['material_id']; ?>" onclick="return confirm('Are you sure you want to delete this material?')"><i class="fas fa-trash-alt"></i> Delete</a>
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
        <a href="add material.php" class="btn btn-primary" style="margin:10px";>Add Material</a>
      
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
                        $('.material-list tbody').html($(data).find('.material-list tbody').html());
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

