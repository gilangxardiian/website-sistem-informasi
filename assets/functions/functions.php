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

// fungsi mengamil data dari dataase
function query($query)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri pencarian data
    $result = mysqli_query($koneksi, $query);
    // array penampungan
    $rows = [];

    // selagi ada data array assosiatve
    while ($row = mysqli_fetch_assoc($result)) {
        // maka masukan data tersebut ke dalam array penampungan
        $rows[] = $row;
    }

    // kembalikan array penampungan
    return $rows;
}

function masuk($username, $password)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri untuk menemukan username yang sesuai di database
    $result = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username = '$username'");

    // mengecek username ketemu atau tidak
    if (mysqli_num_rows($result) > 0) {
        // jika ketemu cek passwordnya sesuai atau tidak
        $row = mysqli_fetch_assoc($result);

        // lakukan pemecahan enkripsi
        if (password_verify($password, $row["password"])) {
            // mengirimkan id menggunakan session
            $_SESSION["id"] = $row["idPengguna"];
            // mengirimkan info login menggunakan session
            $_SESSION["login"] = true;

            // jika password sesuai maka arahkan
            $arahkan = header("Location: ../../index.php");
            return $arahkan;
            exit;
        } else {
            // jika tidak sesuai maka set variable error sama dengan satu
            global $error;
            $error = true;

            return $error;
        }
    }
}
