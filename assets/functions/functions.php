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

// fungsi masuk
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

// fungsi tambah anggota
function tambahAnggota($data)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // amil data yang diinputkan user
    $namaAnggota = htmlspecialchars($data["namaAnggota"]);
    $jenisKelamin = $data["jenisKelamin"];
    $tglLahir = $data["tglLahir"];
    $pekerjaan = htmlspecialchars($data["pekerjaan"]);
    $telepon = htmlspecialchars($data["telepon"]);
    $email = htmlspecialchars($data["email"]);
    $alamat = htmlspecialchars($data["alamat"]);

    // cek apakah nama sudah tersedia atau elum
    $seleksi = mysqli_query($koneksi, "SELECT * FROM anggota WHERE namaAnggota = '$namaAnggota' AND statusAktif = '1'");

    // jika ketemu kecocokan data
    if (mysqli_num_rows($seleksi) > 0) {
        // set variael nilai dengan angka minus 1
        $nilai = -1;
        // kemalikan variabel nilai
        return $nilai;
        exit;
    } else {
        // lakukan kueri penjumlahan
        $jmlAnggota = mysqli_query($koneksi, "SELECT COUNT(statusAktif) AS setatus FROM anggota WHERE statusAktif = '1'");
        // tampung hasilnya dan jadikan array assosiativ
        $jmlhAnggota = mysqli_fetch_assoc($jmlAnggota);
        // tampung kedalam variabel
        $jumlahAnggota = $jmlhAnggota['setatus'];

        // jika database data pengelola kurang dari tiga
        if ($jumlahAnggota < 30) {
            // maka lakukan kueri insert data
            $query = "INSERT INTO anggota (namaAnggota,jenisKelamin,tglLahir,pekerjaan,telepon,email,alamat) VALUES 
                    ('$namaAnggota','$jenisKelamin','$tglLahir','$pekerjaan','$telepon','$email','$alamat')";
            mysqli_query($koneksi, $query);

            // kembalikan nilai hasil insert data
            return mysqli_affected_rows($koneksi);
            exit;
        } else {
            // selain itu maka set variabel nilai dengan angka mines dua
            $nilai = -2;

            // kembalikan variabel nilai
            return $nilai;
            exit;
        }
    }
}

// fungsi cari anggota
function cariAnggota($keyword)
{
    // lakukan kueri pencarian data berdasarkan keyword yang diinputkan user
    $query = "SELECT * FROM anggota WHERE
                (namaAnggota LIKE '%$keyword%'
                OR jenisKelamin LIKE '%$keyword%'
                OR tglLahir LIKE '%$keyword%'
                OR pekerjaan LIKE '%$keyword%'
                OR telepon LIKE '%$keyword%'
                OR email LIKE '%$keyword%'
                OR alamat LIKE '%$keyword%') AND statusAktif = '1'
    ";
    $result = query($query);

    // kembalikan nilai result
    return $result;
}

// fungsi cek anggota
function cekAnggota($keyword)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri pencarian data berdasarkan keyword yang diinputkan user
    $query = "SELECT * FROM anggota WHERE
                (namaAnggota LIKE '%$keyword%'
                OR jenisKelamin LIKE '%$keyword%'
                OR tglLahir LIKE '%$keyword%'
                OR pekerjaan LIKE '%$keyword%'
                OR telepon LIKE '%$keyword%'
                OR email LIKE '%$keyword%'
                OR alamat LIKE '%$keyword%') AND statusAktif = '1'
    ";
    $result = mysqli_query($koneksi, $query);

    // jika ketemu kecocokan data atau mengembalikan nilai lebih dari nol
    if (mysqli_num_rows($result) > 0) {
        // maka kembalikan nilai satu
        return true;
        exit;
    } else {
        // atau jika tidak ketemu maka kembalikan nilai nol
        return false;
        exit;
    }
}

// fungsi ubah anggota
function ubahAnggota($data)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // amil data yang diinputkan user
    $idAnggota = $data["idAnggota"];
    $namaAnggota = htmlspecialchars($data["namaAnggota"]);
    $jenisKelamin = $data["jenisKelamin"];
    $tglLahir = $data["tglLahir"];
    $pekerjaan = htmlspecialchars($data["pekerjaan"]);
    $telepon = htmlspecialchars($data["telepon"]);
    $email = htmlspecialchars($data["email"]);
    $alamat = htmlspecialchars($data["alamat"]);

    // seleksi data inputan dari user
    $seleksi = mysqli_query($koneksi, "SELECT * FROM anggota WHERE namaAnggota = '$namaAnggota' AND statusAktif = '1'");

    // jika ketemu dengan data yang sudah ada di database
    if (mysqli_num_rows($seleksi) > 0) {
        // jadikan data yang di database menjadi array assosiative
        $row = mysqli_fetch_assoc($seleksi);
        $nama_anggota = $row["namaAnggota"];

        // jika nama nya merge maka kembalikan nilai mines satu
        if ($namaAnggota === $nama_anggota) {
            // set nilai mines satu dan tampung ke dalam variabel nilai
            $nilai = -1;
            // kembalikan variabel nilai
            return $nilai;
            exit;
        }
    } else {
        // jika tidak ketemu dengan data yang sama maka lakukan kueri update
        $query = "UPDATE anggota SET
                namaAnggota = '$namaAnggota',
                jenisKelamin = '$jenisKelamin',
                tglLahir = '$tglLahir',
                pekerjaan = '$pekerjaan',
                telepon = '$telepon',
                email = '$email',
                alamat = '$alamat' WHERE idAnggota = $idAnggota
         ";
        mysqli_query($koneksi, $query);

        // kembalikan nilai hasil kueri
        return mysqli_affected_rows($koneksi);
        exit;
    }
}

// fungsi hapus anggota
function hpsAnggota($id)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri hapus data
    mysqli_query($koneksi, "UPDATE anggota SET statusAktif = '0' WHERE idAnggota = $id");

    // kembalikan nilai hasil kueri
    return mysqli_affected_rows($koneksi);
}
