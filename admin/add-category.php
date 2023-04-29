<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br> <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <br><br>
        <form method="POST" action="" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="YNo">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // 1.Get the value from the form
            $title = mysqli_real_escape_string($conn, $_POST['title']);

            // Check whether the image is selected or not
            //print_r($_FILES['image']); die();
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                // Upload the image only if image is selected
                if ($image_name != "") {
                    // Auto-Rename the image
                    // Get the Extension of the Image (i.e. jpg,png,gif,etc.) e.g."specialfood1.jpg"
                    $ext = end(explode(".", $image_name));
                    // Rename the Image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;  // e.g."Food_Category_456.jpg"

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;

                    // Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // check whether image is Uploaded
                    if ($upload == FALSE) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        header('location:' . SITEURL . 'admin/add-category.php');
                        die(); // Stop the Process
                    }
                }
            } else {
                $image_name = "";
            }

            // For Radio Input, we need to check button is selected or not
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }

            // 2.Create SQL Query To Insert & Execute It
            $sql = "INSERT INTO tbl_category SET title='$title', image_name='$image_name', featured='$featured', active='$active'";
            $res = mysqli_query($conn, $sql);

            // 3. Check whether Query Executed or Not
            if ($res == TRUE) {
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }
        ?>
    </div>
</div>

<?php include("partials/footer.php") ?>