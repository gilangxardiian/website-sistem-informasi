<?php
session_start();

// fungsi koneksi ke database
function koneksi()
{
    $host = "localhost";
    $username = "root";
    $password = "Solved6ilan9*";
    $databasse = "db_mankas";
    $port = "3306";

    // lakukan kueri koneksi dan tampung kedalam variabel
    $conn = mysqli_connect($host, $username, $password, $databasse, $port);

    // kembalikan variabel conn
    return $conn;
}
