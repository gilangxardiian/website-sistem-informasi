<?php
// sambungkan denga file functions
require '../../assets/functions/functions.php';

// jika sudah di set session login
if (isset($_SESSION["login"])) {
    // maka alihkan ke file index
    header("Location: ../../index.php");
    exit;
}

// jika tombol masuk ditekan 
if (isset($_POST["masuk"])) {

    // ambil data yang dimasukan pengguna
    $username = $_POST["username"];
    $password = $_POST["password"];

    // jalankan fungsi masuk
    masuk($username, $password);

    // set variabel error dengan nilai 0 atau false
    $error = false;
}

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/logo/my-logo-32x32.png" />

    <title>Mankas · Login</title>

    <!-- custom font start-bootstrap -->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- custom style start-bootstrap -->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <!-- external css -->
    <link rel="stylesheet" href="../../assets/css/style-me.css" />
</head>

<body class="bg-gradient-primary">
    <!-- page wrapper -->
    <div class="page-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <!-- konten -->
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <!-- card -->
                    <div class="card">
                        <div class="card-body col-12 col-sm-10 offset-sm-1">
                            <div class="row">
                                <div class="col-12">
                                    <p class="judul text-gray-900 text-center">
                                        Selamat Datang Admin!
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="username">Masukan username</label>
                                            <input type="text" name="username" class="form-control form-control-user" id="username" required autocomplete="off" />
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Masukan password</label>
                                            <input type="password" name="password" class="form-control form-control-user" id="password" required autocomplete="off" />
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" name="masuk">
                                            Masuk
                                        </button>
                                        <hr />
                                    </form>
                                </div>
                                <?php if (isset($error)) : ?>
                                    <div class="col-12">
                                        <div class="bg-danger text-white gagal">
                                            Gagal Masuk Sebagai Admin
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($_GET["ubah"])) : $status = addslashes($_GET["ubah"]); ?>
                                    <?php if ($status == "berhasil") : ?>
                                        <div class="col-12">
                                            <div class="bg-primary text-white sukses">
                                                Sukses Mengganti Password
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- akhir card -->
                </div>
                <!-- akhir konten -->
            </div>
        </div>
    </div>
    <!-- akhir page wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/chart-area-demo.js"></script>
    <script src="../../assets/js/demo/chart-pie-demo.js"></script>
</body>

</html>