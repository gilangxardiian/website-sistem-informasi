<?php
// sambungkan file ini dengan file functions.php
require '../../assets/functions/functions.php';
// sambungkan file ini dengan file autoload.php
require('../../assets/vendor/autoload.php');

// ambil data dari url
$awalData = $_GET["awalData"];
$jmlDataPerHlmn = $_GET["jmlDataPerHlmn"];

// lakukan kueri tampil data
$anggotas = query("SELECT * FROM anggota LIMIT $awalData, $jmlDataPerHlmn");

$mpdf = new \Mpdf\Mpdf();

$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../../assets/css/data-anggota.css" rel="stylesheet">
    <title>Cetak Data Anggota</title>
</head>

<body>
    <h2>Daftar Anggota</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Pekerjaan</th>
                <th>Nomor Handphone</th>
                <th>Email</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>';
$i = 1;
foreach ($anggotas as $anggota) {
    $html .= '<tr>
                    <td class="tengah">' . $i++ . '</td>
                    <td>' . $anggota["namaAnggota"] . '</td>
                    <td class="tengah">' . $anggota["jenisKelamin"] . '</td>
                    <td class="tengah">' . $anggota["tglLahir"] . '</td>
                    <td class="tengah">' . $anggota["pekerjaan"] . '</td>
                    <td class="tengah">' . $anggota["telepon"] . '</td>
                    <td class="tengah">' . $anggota["email"] . '</td>
                    <td>' . $anggota["alamat"] . '</td>
            </tr>';
}
$html .= '
        </tbody>
    </table>
</body>
</html>';


$mpdf->WriteHTML($html);
$mpdf->Output('cetak-data-anggota.pdf', 'D');
