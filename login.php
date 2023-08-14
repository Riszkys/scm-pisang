<?php
require_once 'functions.php';

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    if ($role == "admin" || $role == "pimpinan") {
        $sql = "SELECT * FROM `tb_user` WHERE `username` = '$username' AND `level` = '$password' AND `level` = '$role'";
        $resultadmin = $conn->query($sql);
        if ($resultadmin->num_rows > 0) {
            $admin_data = $resultadmin->fetch_assoc();

            // Jika status "Dikonfirmasi", maka login berhasil
            echo "<div class=\"alert alert-Success alert-dismissible fade show\" role=\"alert\">
                    <strong>Login Berhasil!</strong>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>";
            login($_POST);
        } else {
            // Jika data tidak ditemukan, tampilkan pesan kesalahan
            echo "<div style='margin-top : 16rem;' class=\"alert alert-warning alert-dismissible fade show fixed-top\" role=\"alert\">
                <strong>Login Gagal!</strong> Cek Username, password serta pastikan sesuai dengan Role Anda.
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>";
        }
    } elseif ($role == "supplier") {
        $sql = "SELECT * FROM `tb_supplier` WHERE `username` = '$username' AND `password` = '$password'";
        $result_sup = $conn->query($sql);
        if ($result_sup->num_rows > 0) {
            $sup_data = $result_sup->fetch_assoc();
            echo "<div class=\"alert alert-Success alert-dismissible fade show\" role=\"alert\">
                    <strong>Login Berhasil!</strong>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>";
            login($_POST);
        } else {
            echo "<div style='margin-top : 16rem;' class=\"alert alert-warning alert-dismissible fade show fixed-top\" role=\"alert\">
                <strong>Login Gagal!</strong> Cek Username, password serta pastikan sesuai dengan Role Anda.
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>";
        }

    } elseif ($role == "pelanggan") {
        $sql = "SELECT * FROM `tb_konsumen` WHERE `username` = '$username' AND `password` = '$password'";
        $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            $konsumen_data = $result->fetch_assoc();
            if ($konsumen_data['status_reg'] == "Dikonfirmasi") {
                // Jika status "Dikonfirmasi", maka login berhasil
                echo "<div class=\"alert alert-Success alert-dismissible fade show\" role=\"alert\">
                    <strong>Login Berhasil!</strong>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>";
                login($_POST);
            } else {
                // Jika status "Belum Dikonfirmasi", tampilkan pesan kesalahan
                echo "<div style='margin-top : 16rem;' class=\"alert alert-warning alert-dismissible fade show fixed-top\" role=\"alert\">
                    <strong>Login Gagal!</strong> Akun belum dikonfirmasi.
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>";
            }
        } else {
            // Jika data tidak ditemukan, tampilkan pesan kesalahan
            echo "<div style='margin-top : 16rem;' class=\"alert alert-warning alert-dismissible fade show fixed-top\" role=\"alert\">
                <strong>Login Gagal!</strong> Cek Username, password serta pastikan sesuai dengan Role Anda.
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>";
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> | Login</title>
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
    <style>
        .wrap-input100 {
            position: relative;
            width: 100%;
        }

        .wrap-input100 select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 50px;
            background-color: #f8f8f8;
            color: #333;
            font-size: 16px;
            appearance: none;
            /* Remove default arrow icon in Firefox */
            -webkit-appearance: none;
            /* Remove default arrow icon in Chrome */
            cursor: pointer;
        }

        .wrap-input100 select::-ms-expand {
            display: none;
            /* Remove default arrow icon in IE 10 and 11 */
        }

        .wrap-input100 select:focus {
            outline: none;
            border-color: #4CAF50;
            /* Add a different border color when the dropdown is focused */
        }
    </style>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/pisang.png');">
            <div class="wrap-login100 p-t-20 p-b-30">
                <form class="login100-form validate-form" method="post">
                    <div class="login100-form-avatar">

                    </div>

                    <span class="login100-form-title p-t-20 p-b-45">
                        PT. Hijau Surya Biotechindo <br> Login
                    </span>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
                        <input class="input100" type="text" name="username" placeholder="Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                        <select name="role" id="role" class="wrap-input100 validate-input m-b-10">
                            <option value="admin">admin</option>
                            <option value="pimpinan">pimpinan</option>
                            <option value="supplier">supplier</option>
                            <option value="pelanggan">pelanggan</option>
                        </select>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn" name="login">
                            Login
                        </button>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <a href="register.php" class="login100-form-btn">
                            Register
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