<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>

        <?php if (isset($_SESSION['add'])) {  //Checking Session is Set or Not Set
            echo $_SESSION['add']; //Displaying the Session Message
            unset($_SESSION['add']); //Removing the Session Message
        } ?>

        <br><br><br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>UserName: </td>
                    <td><input type="text" name="username" placeholder="Your UserName"></td>
                </tr>
                <tr>
                    <td>Full Name: </td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php include("partials/footer.php") ?>

<?php
//Process the form & Save it to Database 
if (isset($_POST['submit'])) {
    // 1.Get Data from Form
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password'])); //Password Encryption with MD5

    // 2.SQL Query to save the data into database
    $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'";

    // 3.Executing Query & Saving Data into the Database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 4.Check whether Data is Inserted and if not display appropriate message
    if ($res == TRUE) {
        //Create a session Variable to Display Message
        $_SESSION['add'] = "Admin Added Successfully!!";
        //Redirect Page to Manage Admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        //Create a session Variable to Display Message
        $_SESSION['add'] = "Failed to Add Admin!!";
        //Redirect Page to Add Admin
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}

?>