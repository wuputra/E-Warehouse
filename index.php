<?php

include "config/controller.php";
session_start();
$lg = new lsp();

if ($lg->sessionCheck() == "true") {
    if ($_SESSION['level'] == "Admin") {
        header("location:pageAdmin.php");
    } else if ($_SESSION['level'] == "Network Engineer") {
        header("location:pageNetwork.php");
    } else if ($_SESSION['level'] == "Hardware") {
        header("location:pageHardware.php");
    }
}

if (isset($_POST['btnLogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($response = $lg->login($username, $password)) {
        if ($response['response'] == "positive") {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['level'] = $response['level'];
            if ($response['level'] == "Admin") {
                $response = $lg->redirect("pageAdmin.php");
            } else if ($response['level'] == "Network Engineer") {
                $response = $lg->redirect("pageNetwork.php");
            } else if ($response['level'] == "Hardware") {
                $response = $lg->redirect("pageHardware.php");
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Page-->
    <title>LOGIN E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/sweet-alert.css">

</head>

<body style="background: url(images/background/background.png) no-repeat; background-size: cover;">
    <div class="page-wrapper">
        <div class="">
            <div class="container">
                <br><br>
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="http://localhost/whsimrs/index.php">
                                <img src="images/icon/logo-whsimrs.png" alt="E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input required class="au-input au-input--full" type="text" name="username"
                                        placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input required class="au-input au-input--full" type="password" name="password"
                                        placeholder="Password">
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label>
                                </div>
                                <br>
                                <button name="btnLogin" class="au-btn au-btn--block au-btn--green m-b-20"
                                    type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer style="padding: 50px 0; text-align: center; color: white; font-size: 16px;">
        <div class="container">
            <p>Copyright &copy; 2025 E-WAREHOUSE SIMRS. All rights reserved.</p>
            <p>Designed by SIMRS RSUD Mohammad Natsir</p>
        </div>
    </footer>


    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>
    <script src="js/sweetalert.min.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <?php include "config/alert.php"; ?>
</body>

</html>
<!-- end document-->