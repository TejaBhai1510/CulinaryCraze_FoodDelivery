<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>

        <?php

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //Displaying Session Message
            unset($_SESSION['add']); //Removing Session Message
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }

        if (isset($_SESSION['pswd-not-matched'])) {
            echo $_SESSION['pswd-not-matched'];
            unset($_SESSION['pswd-not-matched']);
        }

        if (isset($_SESSION['pswd-changed'])) {
            echo $_SESSION['pswd-changed'];
            unset($_SESSION['pswd-changed']);
        }

        ?>

        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>Sr No.</th>
                <th>Full Name</th>
                <th>UserName</th>
                <th>Actions</th>
            </tr>

            <?php
            //Query to get all Admin
            $sql = "SELECT * FROM tbl_admin";
            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Check Query is Executed or Not
            if ($res == TRUE) {
                //Count No of Rows to check do we have data in Database
                $count = mysqli_num_rows($res); //Function to get all rows in database

                $sn = 1;
                //Check the No of Rows
                if ($count > 0) {
                    //We have Data in Database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        //Get Individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        //Displaying the values in our Table
            ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php ?id=<?php $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php ?id=<?php $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php ?id=<?php $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>

            <?php
                    }
                } else {
                    //We don't have Data in Database
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include("partials/footer.php") ?>