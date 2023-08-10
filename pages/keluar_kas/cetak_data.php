<?php
// sambungkan file ini dengan file functions.php
require '../../assets/functions/functions.php';
// sambungkan file ini dengan file autoload.php
require('../../assets/vendor/autoload.php');

// ambil data dari url
$awalData = $_GET["awalData"];
$jmlDataPerHlmn = $_GET["jmlDataPerHlmn"];

// lakukan kueri tampil data
$pengeluaran = query("SELECT * FROM pengeluaran WHERE statusAktif = '1' LIMIT $awalData, $jmlDataPerHlmn");

$mpdf = new \Mpdf\Mpdf();

$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../../assets/css/data-pengeluaran.css" rel="stylesheet">
    <title>Cetak Data Pengeluaran Kas</title>
</head>

<body>
    <h2>Daftar Pengeluaran</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pengeluaran</th>
                <th>Nominal</th>
                <th>Tanggal Pengeluaran</th>
            </tr>
        </thead>
        <tbody>';
$i = 1;
foreach ($pengeluaran as $keluar) {
    $html .= '<tr>
                    <td class="tengah">' . $i++ . '</td>
                    <td>' . $keluar["namaPengeluaran"] . '</td>
                    <td class="tengah">Rp' . number_format($keluar["nominal"]) . '</td>
                    <td class="tengah">' . $keluar["tglPengeluaran"] . '</td>
            </tr>';
}
$html .= '
        </tbody>
    </table>
</body>
</html>';


$mpdf->WriteHTML($html);
$mpdf->Output('cetak-data-pengeluaran.pdf', 'D');
