<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Get all the Details through SQL Query & Execute it
            $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);

            if ($count2 == 1) {
                $row2 = mysqli_fetch_assoc($res2);
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_name'];
                $current_category = $row2['category_id'];
                $featured = $row2['featured'];
                $active = $row2['active'];
            } else {
                $_SESSION['no-food-found'] = "<div class='error'>Food not found</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        } else {
            header('location:' . SITEURL . '/admin/manage-food.php');
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
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                        ?>
                            <img src="<?php echo SITEURL; ?> images/food/<?php echo $current_image; ?>" width="200px">
                        <?php
                        } else {
                            echo "<div class='error'>Image not Added</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // Display all active categories from Database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                                }
                            } else {
                                ?>
                                <option value="0">No Category Found</option>
                            <?php
                            }
                            ?>
                        </select>
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
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // 1.Get all the values from our Form
            $id = $_POST['id'];
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['description']);
            $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);
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
                    $image_name = "Food_Name_" . rand(000, 999) . '.' . $ext; // e.g."Food_Name_456.jpg"

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/food/" . $image_name;

                    // Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // check whether image is Uploaded
                    if ($upload == FALSE) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image</div>";
                        header('location:' . SITEURL . 'admin/manage-food.php');
                        die(); // Stop the Process
                    }

                    // B.Remove current image if Available
                    if ($current_image != "") {
                        $remove_path = "../images/food/" . $current_image;
                        $remove = unlink($remove_path);

                        // Check whether the image is Removed
                        if ($remove == FALSE) {
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                            header('location:' . SITEURL . 'admin/manage-food.php');
                            die();
                        }
                    } else {
                        $image_name = $current_image; // Default image when Image is not Selected
                    }
                }
            } else {
                $image_name = $current_image; // Default image when Button is not Clicked
            }

            // 3.Update the Database & Execute the Query
            $sql3 = "UPDATE tbl_food SET 
                title = '$title', 
                description = '$description', 
                price = $price, 
                image_name = '$image_name', 
                category_id = '$category', 
                featured = '$featured', 
                active = '$active' 
                WHERE id=$id";
            $res3 = mysqli_query($conn, $sql3);

            // 4.Redirect to Manage Category with Message
            if ($res3 == TRUE) {
                $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Food</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        }
        ?>
    </div>
</div>

<?php include("partials/footer.php") ?>