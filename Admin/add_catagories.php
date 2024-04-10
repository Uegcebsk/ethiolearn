<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

// Add Category
if(isset($_POST['addCategory'])) {
    $category_icon = $_POST['category_icon'];
    $catagorie_name = $_POST['catagorie_name']; // Corrected variable name
    $category_description = $_POST['category_description'];

    if(empty($catagorie_name)) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Please enter category name</div>';
    } else {
        $sql = "INSERT INTO categories (icon, catagorie_name, description) VALUES ('$category_icon', '$catagorie_name', '$category_description')";
        if ($conn->query($sql) === TRUE) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Category added successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Failed to add category</div>';
        }
    }
}

// Edit Category
if(isset($_POST['editCategory'])) {
    $category_id = $_POST['category_id'];
    $category_icon = $_POST['category_icon'];
    $catagorie_name = $_POST['catagorie_name']; // Corrected variable name
    $category_description = $_POST['category_description'];

    if(empty($catagorie_name)) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Please enter category name</div>';
    } else {
        $sql = "UPDATE categories SET icon='$category_icon', catagorie_name='$catagorie_name', description='$category_description' WHERE id='$category_id'";
        if ($conn->query($sql) === TRUE) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Category updated successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Failed to update category</div>';
        }
    }
}

// Delete Category
if(isset($_POST['deleteCategory'])) {
    $category_id = $_POST['category_id'];
    $sql = "DELETE FROM categories WHERE id='$category_id'";
    if ($conn->query($sql) === TRUE) {
        $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Category deleted successfully</div>';
    } else {
        $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Failed to delete category</div>';
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <!-- Add Category Form -->
            <div class="col-sm-12 mt-5 jumbotron">
                <h3 class="text-center">Add Category</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="category_icon">Icon</label>
                        <input type="text" class="form-control" id="category_icon" name="category_icon">
                    </div>
                    <div class="form-group">
                        <label for="category_title">Category Name</label>
                        <input type="text" class="form-control" id="category_title" name="catagorie_name">
                    </div>
                    <div class="form-group">
                        <label for="category_description">Description</label>
                        <textarea class="form-control" id="category_description" name="category_description" rows="3"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger" name="addCategory">Add</button>
                    </div>
                </form>
                <?php if(isset($msg)) echo $msg; ?>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Manage Categories Table -->
            <div class="col-sm-12 mt-5">
                <h3 class="text-center">Manage Categories</h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM categories";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['icon'] . "</td>";
                                echo "<td>" . $row['catagorie_name'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>
                                        <form method='post'>
                                            <input type='hidden' name='category_id' value='" . $row['id'] . "'>
                                            <button type='submit' class='btn btn-primary' name='editCategory'>Edit</button>
                                            <button type='submit' class='btn btn-danger' name='deleteCategory'>Delete</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No categories found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
