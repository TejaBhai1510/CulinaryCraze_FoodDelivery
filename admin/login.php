<?php include('../config/constraints.php') ?>

<html>

<head>
    <title>Login - CulinaryCraze</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br><br>

        <form action="" method="POST">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login">
            <br><br>
        </form>

        <p class="text-center">Created By - <a href="www.tejasbhandvalkar.com">Tejas Bhandvalkar</a></p>
    </div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    // 1.Get the data from Login Form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // 2.SQL to check whether User Exists or not & then Execute the Query
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    // 3.Count Rows to check whether user Exists
    $count = mysqli_num_rows($res);
    if ($count == 1) {
        $_SESSION['login'] = "<div class='success'>Login Successfull.</div>";
        $_SESSION['user'] = $username; //Checking user is Logged In or Not
        header('location:' . SITEURL . 'admin/');
    } else {
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        header('location:' . SITEURL . 'admin/login.php');
    }
}
?>