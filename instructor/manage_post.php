<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Define how many records to display per page
$records_per_page = 10;

// Check if the current page is set, otherwise set it to 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($current_page - 1) * $records_per_page;

// Fetch total number of notices
$sql_total = "SELECT COUNT(*) AS total FROM notices WHERE lecturer_id = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $_SESSION['l_id']);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Fetch notices for the current page
$sql = "SELECT * FROM notices WHERE lecturer_id = ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $_SESSION['l_id'], $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container" style="padding-left:6%; margin-top:5%;">
    <h2>Manage Notices</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                    <td>
                        <a href="edit_posts.php?id=<?php echo $row['notice_id']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a href="?action=delete&id=<?php echo $row['notice_id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- Pagination links -->
    <ul class="pagination">
        <?php if ($current_page > 1) { ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page - 1; ?>">Previous</a></li>
        <?php } ?>
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?php echo ($current_page == $i) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
        <?php if ($current_page < $total_pages) { ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a></li>
        <?php } ?>
    </ul>
</div>

<?php
include_once("Footer.php");
?>
