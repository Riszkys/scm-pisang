<?php
require_once 'functions.php';

if (isset($_POST["register"])) {
    unset($_POST["register"]);
    $res = insert("tb_konsumen",$_POST);
    if($res){
        header("location:login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PT. Hijau Surya Biotechindo  | Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/gambar-01.jpeg');">
            <div class="wrap-login100 p-t-0 p-b-30">
                <form class="login100-form validate-form" method="post">
                    <div class="login100-form-avatar">
                        
                    </div>

                    <span class="login100-form-title p-t-0 p-b-45">
                        PT. Hijau Surya Biotechindo <br> Register
                    </span>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Nama is required">
                        <input class="input100" type="text" name="nama_konsumen" placeholder="Nama">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">

                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Alamat is required">
                        <input class="input100" type="text" name="alamat" placeholder="Alamat">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">

                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="No Handphone is required">
                        <input class="input100" type="text" name="no_handphone" placeholder="No Handphone">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">

                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
                        <input class="input100" type="text" name="username" placeholder="Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">

                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Email is required">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">

                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">

                        </span>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn" name="register">
                            Register
                        </button>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <a href="login.php" class="login100-form-btn">
                            Login
</a>
                    </div>

                    <!-- <div class="text-center w-full p-t-25 p-b-230">
                        <a href="#" class="txt1">
                            Forgot Username / Password?
                        </a>
                    </div> -->

                    <!-- <div class="text-center w-full">
                        <a class="txt1" href="#">
                            Create new account
                            <i class="fa fa-long-arrow-right"></i>                      
                        </a>
                    </div> -->
                </form>
            </div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>