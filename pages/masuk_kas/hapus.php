<?php
// sambungkan file ini dengan file functions.php
require '../../assets/functions/functions.php';

// jika session login belum diset
if (!isset($_SESSION["login"])) {
    // maka alihkan ke file login
    header("Location: pages/proses/login.php");
    exit;
}

// ambil id dari url dan tampung kedalam variabel
$id = $_GET["id_kas"];

// jika fungsi mengembalikan nilai lebih dari nol
if (hpsKas($id) > 0) {
    // maka kirim get sukses
    header("Location: data.php?hapus=sukses");
} else {
    // maka kirim get gagal
    header("Location: data.php?hapus=gagal");
}
