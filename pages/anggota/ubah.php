<?php
// sambungkan file ini dengan file functions.php
require '../../assets/functions/functions.php';

// jika session login belum diset
if (!isset($_SESSION["login"])) {
    // maka alihkan ke file login
    header("Location: pages/proses/login.php");
    exit;
}

// Menonaktifkan semua jenis error
error_reporting(0);
// Menonaktifkan tampilan error
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/logo/my-logo-32x32.png" />

    <title>Mankas · Ubah Anggota</title>

    <!-- Custom fonts for this template-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-solid fa-wallet"></i>
                </div>
                <div class="sidebar-brand-text mx-3">MANKAS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen Data
            </div>

            <!-- Nav Item - Manajemen Anggota Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnggota" aria-expanded="true" aria-controls="collapseAnggota">
                    <i class="fas fa-users"></i>
                    <span>Manajemen Anggota</span>
                </a>
                <div id="collapseAnggota" class="collapse" aria-labelledby="headingAnggota" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="pages/anggota/tambah.php">Tambah Anggota</a>
                        <a class="collapse-item" href="pages/anggota/data.php">Data Anggota</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen Keuangan
            </div>

            <!-- Nav Item - Pemasukan Kas Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetorKas" aria-expanded="true" aria-controls="collapseSetorKas">
                    <i class="fas fa-coins"></i>
                    <span>Manajemen Kas</span>
                </a>
                <div id="collapseSetorKas" class="collapse" aria-labelledby="headingSetorKas" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../pages/masuk_kas/tambah.php">Setor Kas</a>
                        <a class="collapse-item" href="../pages/masuk_kas/data.php">Data Kas</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Catat Pengeluaran Kas Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengeluaranKas" aria-expanded="true" aria-controls="collapsePengeluaranKas">
                    <i class="fas fa-coins"></i>
                    <span>Manajemen Pengeluaran</span>
                </a>
                <div id="collapsePengeluaranKas" class="collapse" aria-labelledby="headingPengeluaranKas" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../pages/keluar_kas/tambah.php">Catat Pengeluaran</a>
                        <a class="collapse-item" href="../pages/keluar_kas/data.php">Data Pengeluaran</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand sticky-nav navbar-light bg-white topbar mb-4 shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <?php
                        // tangkap data yang berada di variabel super globals 
                        $id = $_SESSION["id"];

                        // cari data pengguna berdasarkan id
                        $koneksi = koneksi();
                        $idUsers = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE idPengguna = '$id'");

                        // jadikan data yang telah diambil menjadi array
                        $infUsers = mysqli_fetch_assoc($idUsers);

                        // jika ketemu dan sudah dipecah menjadi array assosiative
                        if ($infUsers) { ?>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $infUsers["namaPengguna"]; ?></span>
                                    <img class="img-profile rounded-circle" src="assets/img/pengguna/<?= $infUsers["gambar"]; ?>">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="pages/pengguna/profile.php">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profil
                                    </a>
                                    <a class="dropdown-item" href="pages/pengguna/ubah_profile.php?id_pengguna=<?= $infUsers["idPengguna"]; ?>">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Pengaturan
                                    </a>
                                    <a class="dropdown-item" href="pages/pengguna/ubah_password.php?id_pengguna=<?= $infUsers["idPengguna"]; ?>">
                                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Ganti Password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Keluar
                                    </a>
                                </div>
                            </li>
                        <?php  } ?>
                    </ul>
                    <!-- akhir topbar navbar -->
                </nav>
                <!-- akhir topbar -->

                <!-- page konten -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ubah Data Anggota:</h6>
                        </div>
                        <!-- card body -->
                        <div class="card-body">
                            <?php if (isset($_GET["id_anggota"])) { ?>
                                <?php
                                // ambil data dari url dan tampung ke dalam variabel id
                                $id = $_GET["id_anggota"];
                                // lakukan kueri berdasarkan id
                                $anggotas = query("SELECT * FROM anggota WHERE idAnggota = $id")[0];

                                // jika variabel id url sama dengan id yang di database
                                if ($id === $anggotas["idAnggota"]) { ?>
                                    <form method="post" name="edit">
                                        <div class="row">
                                            <input type="hidden" name="idAnggota" value="<?= $anggotas["idAnggota"]; ?>" />
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="namaAnggota">Nama Anggota :</label>
                                                    <input class="form-control mb-3" type="text" name="namaAnggota" id="namaAnggota" value="<?= $anggotas["namaAnggota"]; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="jenisKelamin">Jenis Kelamin :</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jenisKelamin" id="laki-laki" value="laki-laki" required />
                                                        <label class="form-check-label mr-4" for="laki-laki">Laki-laki</label>
                                                        <input class="form-check-input" type="radio" name="jenisKelamin" id="perempuan" value="perempuan" required />
                                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="tglLahir">Tanggal Lahir :</label>
                                                    <input class="form-control mb-3" type="date" name="tglLahir" id="tglLahir" value="<?= $anggotas["tglLahir"]; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="pekerjaan">Pekerjaan :</label>
                                                    <input class="form-control mb-3" type="text" name="pekerjaan" id="pekerjaan" value="<?= $anggotas["pekerjaan"]; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="telepon">Nomor Handphone :</label>
                                                    <input class="form-control mb-3" type="text" name="telepon" id="telepon" value="<?= $anggotas["telepon"]; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email :</label>
                                                    <input class="form-control mb-3" type="email" name="email" id="email" value="<?= $anggotas["email"]; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat :</label>
                                                    <input class="form-control mb-3" type="alamat" name="alamat" id="alamat" value="<?= $anggotas["alamat"]; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-info" name="ubah">Simpan</button>
                                                <a href="data.php">
                                                    <button type="button" class="btn btn-success">Kembali</button>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="alert alert-danger" role="alert">
                                                <p>
                                                    <center>Data Tidak Diketahui!</center>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                            <a href="data.php">
                                                <button type="button" class="btn btn-success">Kembali Lagi</button>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                // cek apakah tombol submit sudah ditekan atau belum
                                if (isset($_POST["ubah"])) { ?>
                                    <?php
                                    // apakah data berhasil diubah atau tidak
                                    if (ubahAnggota($_POST) > 0) { ?>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-10 offset-md-1 mt-3">
                                                <div class="alert alert-primary" role="alert">
                                                    <p>
                                                        <center>Berhasil Mengubah Data!</center>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else if (ubahAnggota($_POST) === -1) { ?>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-10 offset-md-1 mt-3">
                                                <div class="alert alert-warning" role="alert">
                                                    <p>
                                                        <center>Data Telah Tersedia!</center>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-10 offset-md-1">
                                                <div class="alert alert-warning" role="alert">
                                                    <p>
                                                        <center>Gagal Mengubah Data!</center>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12">
                                        <div class="alert alert-danger" role="alert">
                                            <p>
                                                <center>Data Tidak Diketahui!</center>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                        <a href="data.php">
                                            <button type="button" class="btn btn-success">Kembali Lagi</button>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- akhir card-body -->
                    </div>
                </div>
                <!-- akhir page konten -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Mankas 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin Mau Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih Option "Keluar" Untuk Keluar Dan Pilih Option "Batal" Untuk Membatalkan
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="../proses/logout.php">Keluar</a>
                </div>
            </div>
        </div>
    </div>

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