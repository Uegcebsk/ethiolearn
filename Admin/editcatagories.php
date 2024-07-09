<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

$msg = ''; // Initialize the message variable

// Edit Category
if(isset($_POST['editCategory'])) {
    // Check if the form is submitted and if the fields are set in $_POST
    if(isset($_POST['category_id'], $_POST['category_icon'], $_POST['category_name'], $_POST['category_description'])) {
        $category_id = $_POST['category_id'];
        $category_icon = $_POST['category_icon'];
        $category_name = $_POST['category_name'];
        $category_description = $_POST['category_description'];

        if(empty($category_name)) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Please enter category name</div>';
        } else {
            $sql = "UPDATE categories SET icon='$category_icon', catagorie_name='$category_name', description='$category_description' WHERE id='$category_id'";
            if ($conn->query($sql) === TRUE) {
                $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Category updated successfully</div>';
            } else {
                $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Failed to update category</div>';
            }
        }
    }
}

// Fetch category details for editing
if(isset($_POST['editCategory'])) {
    $category_id = $_POST['category_id'];
    $sql = "SELECT * FROM categories WHERE id='$category_id'";
    $result = $conn->query($sql);
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $category_icon = $row['icon'];
        $category_name = $row['catagorie_name'];
        $category_description = $row['description'];
    }
}
?>

<div class="container" style="padding:6%;">
    <div class="row">
        <div class="col-md-12">
            <!-- Edit Category Form -->
            <div class="col-sm-12 mt-5 jumbotron">
                <h3 class="text-center">Edit Category</h3>
                <form action="" method="POST">
                    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                    <div class="form-group">
                        <label for="category_icon">Icon</label>
                        <input type="text" class="form-control" id="category_icon" name="category_icon" value="<?php echo isset($category_icon) ? $category_icon : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="category_title">Category Name</label>
                        <input type="text" class="form-control" id="category_title" name="category_name" value="<?php echo isset($category_name) ? $category_name : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="category_description">Description</label>
                        <textarea class="form-control" id="category_description" name="category_description" rows="3"><?php echo isset($category_description) ? $category_description : ''; ?></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="editCategory">Update</button>
                    </div>
                </form>
                <?php if(isset($msg)) echo $msg; ?>
            </div>
            <?php
            echo "<a href='add_catagories.php'><button type='button' name='mainmenu' class='btn btn-danger text-light fw-bolder'>Main Menu</button></a>";

            ?>
        </div>
    </div>
</div>
