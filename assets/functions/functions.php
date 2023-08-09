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

// fungsi menghitung jumlah anggota
function jumlahAnggota()
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri pencarian data
    $jmlhAnggota = mysqli_query($koneksi, "SELECT COUNT(statusAktif) AS setatus  FROM anggota WHERE statusAktif = '1'");
    // rubah menjadi array assosiative
    $jmlAnggota = mysqli_fetch_assoc($jmlhAnggota);
    // ambil isi dari kolom status
    $jumlahAnggota = $jmlAnggota["setatus"];

    // jika variabel jumlahAnggota tidak kosong
    if ($jumlahAnggota != null) {
        // maka kembalikan nilainya
        return $jumlahAnggota;
        exit;
    } else {
        // selain itu kembalikan nilai nol
        return number_format(0);
        exit;
    }
}

// fungsi setor kas
function setorKas($data)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // amil data yang diinputkan user
    $idAnggota = htmlspecialchars($data["idAnggota"]);
    $nominal = htmlspecialchars($data["nominal"]);
    $bentuk = htmlspecialchars($data["bentuk"]);
    $tglSetor = $data["tglSetor"];

    // menghitung jumlah dana yang sudah masuk
    $jmlhDana = mysqli_query($koneksi, "SELECT COUNT(statusAktif) as setatus from kas WHERE statusAktif = '1'");
    // pecah data nya menjadi array assosiativ
    $jmlDana = mysqli_fetch_assoc($jmlhDana);
    // tampung kedalam variabel
    $jumlahDana = $jmlDana["setatus"];

    // jika jumlah dana kurang dari 500
    if ($jumlahDana < 500) {
        // maka lakukan inser data
        $query = "INSERT INTO kas (idAnggota,nominal,bentuk,tglSetor) VALUES
                    ($idAnggota,'$nominal','$bentuk','$tglSetor')
        ";
        mysqli_query($koneksi, $query);

        // kembalikan nilai hasil kueri
        return mysqli_affected_rows($koneksi);
        exit;
    } else {
        // selain itu kembalikan nilai mines satu
        $nilai = -1;
        return $nilai;
        exit;
    }
}

// fungsi cari kas
function cariKas($keyword)
{
    // lakukan kueri pencarian data berdasarkan keyword yang diinputkan user
    $query = "SELECT * FROM vwkas WHERE 
                namaAnggota LIKE '%$keyword%'
                OR nominal LIKE '%$keyword%'
                OR bentuk LIKE '%$keyword%'
    ";
    $result = query($query);

    // kembalikan nilai result
    return $result;
}

// fungsi cek kas
function cekKas($keyword)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri pencarian data berdasarkan keyword yang diinputkan user
    $query = "SELECT * FROM vwkas WHERE 
                namaAnggota LIKE '%$keyword%'
                OR nominal LIKE '%$keyword%'
                OR bentuk LIKE '%$keyword%'
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

// fungsi hapus kas
function hpsKas($id)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri hapus data
    mysqli_query($koneksi, "UPDATE kas SET statusAktif = '0' WHERE idKas = $id");

    // kembalikan nilai hasil kueri
    return mysqli_affected_rows($koneksi);
}

// fungsi menghitung jumlah kas
function jumlahKas()
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kuer penjumlahan dana kas
    $jmlhDanaKas = mysqli_query($koneksi, "SELECT SUM(nominal) AS danaKas FROM kas WHERE statusAktif = '1'");
    // ubah menjadi array assosiative
    $jmlDanaKas = mysqli_fetch_assoc($jmlhDanaKas);
    // simpan kedalam variabel
    $jumlahDanaKas = $jmlDanaKas["danaKas"];

    // lakukan kuer penjumlahan dana keluar
    $jmlhDanaKeluar = mysqli_query($koneksi, "SELECT SUM(nominal) AS danaKeluar FROM pengeluaran WHERE statusAktif = '1'");
    // ubah menjadi array assosiative
    $jmlDanaKeluar = mysqli_fetch_assoc($jmlhDanaKeluar);
    // simpan kedalam variabel
    $jumlahDanaKeluar = $jmlDanaKeluar["danaKeluar"];

    // tampung hasil pengurangan kedalam variabel result
    $result = $jumlahDanaKas - $jumlahDanaKeluar;

    // jika variabel result tidak kosong
    if ($result != null) {
        // maka kembalikan nilainya
        return number_format($result);
        exit;
    } else {
        // selain itu kembalikan nilai nol
        return number_format(0);
        exit;
    }
}

// fungsi catat pengeluaran
function catatPengeluaran($data)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // amil data yang diinputkan user
    $namaPengeluaran = htmlspecialchars($data["namaPengeluaran"]);
    $nominal = htmlspecialchars($data["nominal"]);
    $tglPengeluaran = $data["tglPengeluaran"];

    // menghitung jumlah dana yang sudah masuk
    $jmlhDanaIn = mysqli_query($koneksi, "SELECT SUM(nominal) as danaIn from kas WHERE statusAktif = '1'");
    // pecah data nya menjadi array assosiativ
    $jmlDanaIn = mysqli_fetch_assoc($jmlhDanaIn);
    // tampung kedalam variabel
    $jumlahDanaIn = $jmlDanaIn["danaIn"];

    // menghitung jumlah dana yang sudah masuk
    $jmlhDanaOut = mysqli_query($koneksi, "SELECT SUM(nominal) as danaOut from pengeluaran WHERE statusAktif = '1'");
    // pecah data nya menjadi array assosiativ
    $jmlDanaOut = mysqli_fetch_assoc($jmlhDanaOut);
    // tampung kedalam variabel
    $jumlahDanaOut = $jmlDanaOut["danaOut"];

    // jika jumlah nominal pengeluaran lebih besar dari dana kas
    if ($jumlahDanaOut >= $jumlahDanaIn or $nominal > $jmlDanaIn) {
        // maka set variabel nilai dengan mines satu
        $nilai = -1;

        // kembalikan variabel nilai
        return $nilai;
        exit;
    } else if ($jumlahDanaOut < $jumlahDanaIn or $nominal <= $jmlDanaIn) {
        // atau jika nominal pengeluaran kurang dari dana kas maka lakukan insert data
        $query = "INSERT INTO pengeluaran (namaPengeluaran,nominal,tglPengeluaran) VALUES
                    ('$namaPengeluaran','$nominal','$tglPengeluaran')
        ";
        mysqli_query($koneksi, $query);

        // kembalikan nilai hasil kueri
        return mysqli_affected_rows($koneksi);
        exit;
    } else {
        // selain itu kembalikan nilai nol
        return false;
        exit;
    }
}

// fungsi cari pengeluaran
function cariPengeluaran($keyword)
{
    // lakukan kueri pencarian data berdasarkan keyword yang diinputkan user
    $query = "SELECT * FROM pengeluaran WHERE 
                namaPengeluaran LIKE '%$keyword%'
                OR nominal LIKE '%$keyword%' AND statusAktif = '1';
    ";
    $result = query($query);

    // kembalikan nilai result
    return $result;
}

// fungsi cek pengeluaran
function cekPengeluaran($keyword)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri pencarian data berdasarkan keyword yang diinputkan user
    $query = "SELECT * FROM pengeluaran WHERE 
                namaPengeluaran LIKE '%$keyword%'
                OR nominal LIKE '%$keyword%' AND statusAktif = '1';
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

// fungsi hapus pengeluaran
function hpsPengeluaran($id)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukan kueri hapus data
    mysqli_query($koneksi, "UPDATE pengeluaran SET statusAktif = '0' WHERE idPengeluaran = $id");

    // kembalikan nilai hasil kueri
    return mysqli_affected_rows($koneksi);
}

// fungsi jumlah pengeluaran
function jumlahPengeluaran()
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // lakukakn kueri penjumlahan dana pengeluaran
    $jmlhDanaKeluar = mysqli_query($koneksi, "SELECT SUM(nominal) AS danaKeluar FROM pengeluaran WHERE statusAktif = '1'");
    // ubah menjadi array assosiativ
    $jmlDanaKeluar = mysqli_fetch_assoc($jmlhDanaKeluar);
    // simpan nilainya kedalam variabel
    $jumlahDanaKeluar = $jmlDanaKeluar["danaKeluar"];

    // jika variabel jumlahDanaKeluar tidak kosong
    if ($jumlahDanaKeluar != null) {
        // maka tampilkan isi nya
        return number_format($jumlahDanaKeluar);
        exit;
    } else {
        // selain itu tampilkan nilai nol
        return number_format(0);
        exit;
    }
}

// fungsi ubah profile
function ubahProfil($data)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // ambil data dari super globals post
    $id = $data["id_pengguna"];
    $nama = htmlspecialchars($data["nama_pengguna"]);

    // fungsi upload gambar tampung kedalam variabel gambar
    $gambar = upload();

    // jika fungsi gambar tidak mengembalikan nilai
    if (!$gambar) {
        // maka kembalikan nilai nol atau false
        return false;
    }

    // lakukan kueri update data dari data yang di inputkan si user
    $query = "UPDATE pengguna SET
                namaPengguna = '$nama',
                gambar = '$gambar'
                WHERE idPengguna  = $id
            ";
    mysqli_query($koneksi, $query);

    // lalu kembalikan nilai satu yang diperoleh dari fungsi dibawah ini
    return mysqli_affected_rows($koneksi);
}

// fungsi upload foto
function upload()
{

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $namaTmp = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload
    if ($error === 4) {
        // maka cetak
        echo "<script>
            alert('pilih gambar terlebih dahulu!');
        </script>";

        // kembalikan nilai false atau nol
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];

    // ambil ekstensi dari gambar yang diupload
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    // kalau yang diupload bukan gambar
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        // maka cetak
        echo "<script>
            alert('yang anda upload bukan gambar!');
        </script>";

        // kembalikan nilai false atau nol
        return false;
    }

    // cek jika ukuran nya terlalu besar
    if ($ukuranFile > 1000000) {
        // maka cetak
        echo "<script>
            alert('ukuran gambar terlalu besar!');
        </script>";

        // kembalikan nilai false atau nol
        return false;
    }

    // generate nama gambar baru
    $namaFileBaru = uniqid();

    // rangkai nama file 
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // gambar siap diupload
    move_uploaded_file($namaTmp, '../../assets/img/pengguna/' . $namaFileBaru);

    // kembalikan nama file baru
    return $namaFileBaru;
}

// fungsi ubah password
function ubahPassword($data)
{
    // ambil fungsi koneksi
    $koneksi = koneksi();

    // ambil data dari super globals post
    $id = $data["id_pengguna"];
    $passLama = htmlspecialchars($data["passLama"]);

    // lakukan kueri pencarian data
    $row = query("SELECT * FROM pengguna WHERE idPengguna = $id")[0];

    // jika password lama sama dengan data password
    if (password_verify($passLama, $row['password'])) {
        // maka ambil inputan password baru dari pengguna, lalu cocokan
        $passBaru = htmlspecialchars($data["passBaru"]);
        $confrmPass = htmlspecialchars($data["confrmPass"]);

        // jika password barunya tidak sama
        if ($passBaru != $confrmPass) {
            // set variabel nilai dengan nilai mines satu
            $nilai = -1;
            // maka kembalikan nilai 
            return $nilai;
        } else {
            // jika password barunya sama

            // maka hancurkan session
            $_SESSION = [];
            session_unset();
            session_destroy();

            // lalu enkripsi password barunya
            $password = password_hash($passBaru, PASSWORD_DEFAULT);

            // lakukan kueri pengubahan data
            $query = "UPDATE pengguna SET password = '$password' WHERE idPengguna = $id";
            mysqli_query($koneksi, $query);

            // jika berhasil maka dikembalikan nilai 1
            return mysqli_affected_rows($koneksi);
        }
    } else {
        // jika password lama tidak sama dengan data password, maka kembalikan nilai false atau nol
        return false;
    }
}
