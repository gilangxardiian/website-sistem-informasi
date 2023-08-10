<?php
// sambungkan file ini dengan file functions.php
require '../../assets/functions/functions.php';
// sambungkan file ini dengan file autoload.php
require('../../assets/vendor/autoload.php');

// ambil data dari url
$awalData = $_GET["awalData"];
$jmlDataPerHlmn = $_GET["jmlDataPerHlmn"];

// lakukan kueri tampil data
$danaKas = query("SELECT * FROM vwkas LIMIT $awalData, $jmlDataPerHlmn");

$mpdf = new \Mpdf\Mpdf();

$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../../assets/css/data-pemasukan.css" rel="stylesheet">
    <title>Cetak Data Pemasukan Kas</title>
</head>

<body>
    <h2>Daftar Pemasukan</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Anggota</th>
                <th>Nominal</th>
                <th>Bentuk</th>
                <th>Tanggal Setor</th>
            </tr>
        </thead>
        <tbody>';
$i = 1;
foreach ($danaKas as $dana) {
    $html .= '<tr>
                    <td class="tengah">' . $i++ . '</td>
                    <td>' . $dana["namaAnggota"] . '</td>
                    <td class="tengah">Rp' . number_format($dana["nominal"]) . '</td>
                    <td class="tengah">' . $dana["bentuk"] . '</td>
                    <td class="tengah">' . $dana["tglSetor"] . '</td>
            </tr>';
}
$html .= '
        </tbody>
    </table>
</body>
</html>';


$mpdf->WriteHTML($html);
$mpdf->Output('cetak-data-pemasukan.pdf', 'D');
