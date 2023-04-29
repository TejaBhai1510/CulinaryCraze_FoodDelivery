<?php 
    include('../config/constraints.php');

    // 1.Get the ID of Admin to be Deleted
    $id = $_GET['id'];

    // 2.Create SQL Query to Delete the Admin & then Execute
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    // 3.Check the Executed Query is successfull or not
    if($res==true){
        // echo "Admin Deleted";
        // Creating Session Variable to Display the Message & redirecting it to Manage admin Page
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        // echo "Failed to Delete Admin";
        // Creating Session Variable to Display the Message & redirecting it to Manage admin Page
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
?>