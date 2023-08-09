<?php
// memluai session
session_start();

// set session menjadi array kosong
$_SESSION = [];

// menghapus semua variabel di session
session_unset();

// menghancurkan semua variabel di session
session_destroy();

// arahkan ke halaman login
header("Location: login.php");

// keluar
exit;
