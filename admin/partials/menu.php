<?php include('../config/constraints.php'); ?>

<?php
//Authorization - Access Control
//Check whether the user is Logged in or not
if (!isset($_SESSION['user'])) {  //If user session is not set
    $_SESSION['no-login-message'] = "<div class='error text-center'>Login to Access Admin Panel</div>";
    header('location:' . SITEURL . 'admin/login.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Food order Website - Home Page</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="manage-admin.php">Admin</a></li>
                <li><a href="manage-category.php">Category</a></li>
                <li><a href="manage-food.php">Food</a></li>
                <li><a href="manage-order.php">Order</a></li>
                <li><a href="logout.php">Order</a></li>
            </ul>
        </div>
    </div>