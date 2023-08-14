<?php 
require_once '../dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
$current = "data pupuk";

require_once '../qb.php';

$bulan = $_GET['bulan'] < 10 ? '0'.$_GET['bulan'] : $_GET['bulan'];
$clause = $_GET['tahun'].'-'.$bulan;

$pemakaian = raw("SELECT SUM(jumlah) as jlh, nama_bahan_baku FROM tb_pemakaian GROUP BY nama_bahan_baku");

$bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];

$html = '
<div id="print">
    <div class="text-center py-3 text-print">
        <table width="100%">
            <tr>
                <td width="120px">
                </td>
                <td>
                    <h4><text-center>PT. Hijau Surya Biotechindo</h4>
                    <p>JL. Besar Sei Renggas, Kel. Sei Renggas, Kec. Kisaran Barat</p>
                    <p>Asahan Sumatera Utara - 21224</p>
                    <p>Telp: 0852-6201-8889, email: tissueculture@hijausurya.com</p>
                </td>
            </tr>    
            <tr>
                <td colspan="2">
                    <hr>' . 'tissueculture@hijausurya.com' . $_GET['tahun'] . '</h3>
                </td>
            </tr>
        </table>
        <table class="table table-bordered table-stripped" border="1" cellpadding="5" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pisang</th>
                    <th>Jumlah </th>
                </tr>
            </thead>
            <tbody>';
            if (count($pemakaian) > 0):
                foreach ($pemakaian as $k => $p):
                    $html .= '
                    <tr>
                        <td>' . ++$k . '</td>
                        <td>' . $p['nama_bahan_baku'] . '</td>
                        <td>' . $p['jlh'] . ' Ton</td>
                    </tr>';
                endforeach;
            else:
                $html .= '
                <tr class="text-center">
                    <td colspan="4">Tidak ada Data</td>
                </tr>';
            endif;
$html .= '
        </tbody>
    </table>
    <div class="py-3 text-print">
        <br><br>
        Di ketahui Oleh
        <br>
        Pemilik
        <br><br><br><br>
        <b>Budi Chandra</b>
    </div>
</div>';

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("Laporan-DataPisang.pdf");
