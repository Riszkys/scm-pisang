<?php 
    require_once '../dompdf/autoload.inc.php';
    // reference the Dompdf namespace
    use Dompdf\Dompdf;

    require_once '../qb.php';

    $penjualan = get("tb_penjualan");

$html = '
 <div id="print">
                    <div class="text-center py-3 text-print">
                    <table width="100%">
                      <tr>
                       <td width="120px">
                        </td>
                        <td>
                        <h4>UD Jaya Tani</h4>
                        <p>JL. Prof.HM.Yamin, Kisaran Timur</p>
                        <p>Asahan Sumatera Utara - 21224</p>
                        <p>KISARAN Telp (0623) 41977 email :udjayatani@gmail.com</p>
                    
                        </td>
                            </tr>    
                                 <tr>
                                <td colspan="2">
                <hr>
                <h3>Laporan Produksi</h3>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-stripped" border="1" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>';
            if(count($penjualan) > 0):
                foreach($penjualan as $k => $p): 
                $html .= '
                <tr>
                    <td>'.++$k.'</td>
                    <td>'.$p['produk'].'</td>
                    <td>'.$p['jumlah'].'</td>
                    <td>'.$p['tanggal'].'</td>
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
        <b>Tumin</b>
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
$dompdf->stream("Laporan-Penjualan.pdf");