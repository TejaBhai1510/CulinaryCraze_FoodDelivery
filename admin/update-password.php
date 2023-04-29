<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Old Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">;
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    //Get the date from Form
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $current_password = mysqli_real_escape_string($conn, md5($_POST['current_password']));
    $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

    //Check whether the user with Current ID & Password Exists and Execute the Query
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
    $res = mysqli_query($conn, $res);

    if ($res == TRUE) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            if ($new_password == $confirm_password) {
                //Update the Password
                $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";

                //Execute the Query
                $res2 = mysqli_query($conn, $res);

                //Check whether Query Executed or not
                if ($res2 == TRUE) {
                    $_SESSION['pswd-changed'] = "<div class='success'>Password Changed Successfully.</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    $_SESSION['pswd-changed'] = "<div class='error'>Failed to Update Password.</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                $_SESSION['pswd-not-matched'] = "<div class='error'>Password did not Match.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }
}
?>

<?php include("partials/footer.php") ?>
