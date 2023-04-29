<?php 
    include('../config/constraints.php');

    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        // 1.Get ID & Image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2.Remove the Image if Available
        if($image_name != ''){
            $path = "../images/food/".$image_name;
            $remove = unlink($path);

            if($remove == false){
                $_SESSION['upload'] = "<div class='error'>Failed to Delete Image file</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();  // Abort the Deleting process
            }
        }
        // 3.Delete Food from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res == TRUE){
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else{
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food. Please Try Again</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else{
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>
