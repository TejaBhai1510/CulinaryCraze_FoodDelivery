<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Get all the Details through SQL Query & Execute it
            $sql = "SELECT * FROM tbl_category WHERE id = $id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['current_image'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                $_SESSION['no-category-found'] = "<div class='error'>Category not found</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            header('location:' . SITEURL . '/admin/manage-category.php');
        }
        ?>

        <br><br>
        <form method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                        ?>

                            <img src="<?php echo SITEURL; ?> images/category/<?php echo $current_image; ?>" width="200px">

                        <?php
                        } else {
                            echo "<div class='error'>Image not Added</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // 1.Get all the values from our Form
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $current_image = mysqli_real_escape_string($conn, $_POST['title']);
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // 2.Updating New Image if selected
            // Check whether image is selected or not
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    // A.Upload new image
                    // Auto-Rename the image
                    // Get the Extension of the Image (i.e. jpg,png,gif,etc.) e.g."specialfood1.jpg"
                    $ext = end(explode('.', $image_name));
                    // Rename the Image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext; // e.g."Food_Category_456.jpg"

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;

                    // Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // check whether image is Uploaded
                    if ($upload == FALSE) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        header('location:' . SITEURL . 'admin/manage-category.php');
                        die(); // Stop the Process
                    }

                    // B.Remove current image if Available
                    if ($current_image != "") {
                        $remove_path = "../images/category/" . $current_image;
                        $remove = unlink($remove_path);

                        // Check whether the image is Removed
                        if ($remove == FALSE) {
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die();
                        }
                    }
                }
            } else {
                $image_name = $current_image;
            }

            // 3.Update the Database & Execute the Query
            $sql2 = "UPDATE tbl_category SET title = '$title', image_name = '$image_name', featured = '$featured', active = '$active' WHERE id=$id";
            $res2 = mysqli_query($conn, $sql2);

            // 4.Redirect to Manage Category with Message
            if ($res2 == TRUE) {
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Category</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }
        ?>
    </div>
</div>

<?php include("partials/footer.php") ?>
