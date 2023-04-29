<?php 
    include('../config/constraints.php');

    // Check whether ID & Image_name are set
    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the Image File if Present
        if($image_name != ""){
            $path = "../images/category/".$image_name;
            // Remove the Image
            $remove = unlink($path);
            // If Image not Removed, add error message & stop the Process
            if($remove == FALSE){
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }
        }
        // Delete Data from Database by SQL Query & then Execute it
        $sql = "DELETE FROM tbl_category WHERE id =$id";
        $res = mysqli_query($conn, $sql);

        // Check if Data is Deleted from the Database
        if($res == TRUE){
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else{
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category. Please Try Again</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else{
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>