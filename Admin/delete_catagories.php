<?php
// Include necessary files and establish database connection
include_once("Header.php");
include_once("../DB_Files/db.php");

// Check if category_id is provided via POST method
if(isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    
    // SQL to delete category based on provided category_id
    $sql = "DELETE FROM categories WHERE id='$category_id'";
    
    // Execute the deletion query
    if ($conn->query($sql) === TRUE) {
        // If deletion is successful, set success message
        $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Category deleted successfully</div>';
    } else {
        // If deletion fails, set error message
        $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Failed to delete category</div>';
    }
} else {
    // If category_id is not set, handle accordingly (though in this setup, it should always be set)
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">No category ID provided for deletion</div>';
}

// Redirect back to the main page after deletion
header("Location: add_categories.php");
exit();
?>
