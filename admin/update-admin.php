<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br>

        <?php if (isset($_SESSION['update'])) {  //Checking Session is Set or Not Set
            echo $_SESSION['update']; //Displaying the Session Message
            unset($_SESSION['update']); //Removing the Session Message
        } ?>

        <?php
        // 1.Get the ID of Selected Admin
        $id = $GET['id'];

        // 2.Crete SQL Query to get the Details & then Execute
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        // 3.Check whether th Query is Executed
        if ($res == TRUE) {
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                header('location' . SITEURL . 'admin/manage-admin.php');
            }
        }
        ?>

        <br><br><br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name ?>"></td>
                </tr>
                <tr>
                    <td>UserName: </td>
                    <td><input type="text" name="username" value="<?php echo $username ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">;
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php if (isset($_POST['submit'])) {
    //Get All the values from the form to Update
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    //Crete SQL Query to Update Admin & then Execute it
    $sql = "UPDATE tbl_admin SET full_name='$full_name', username='$username', WHERE id='$id'";
    $res = mysqli_query($conn, $sql);

    //Check Query Executed Successfully or not
    if ($res == TRUE) {
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
        header('location:' . SITEURL . 'admin/manage-admin.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin. Try Again Later.</div>";
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }
} ?>

<?php include("partials/footer.php") ?>