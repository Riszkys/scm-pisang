<?php 
    require_once '../dompdf/autoload.inc.php';
    // reference the Dompdf namespace
    use Dompdf\Dompdf;

    require_once '../qb.php';

    $produk = get("tb_produk");

$html = '
 <div id="print">
                    <div class="text-center py-3 text-print">
                    <table width="100%">
                      <tr>
                       <td width="120px"
                        </td>
                        <td>
                        <h4>PT. Hijau Surya Biotechindo</h4>
                        <p>Jl. Besar Sei Renggas, Sei Renggas, Kec. Kota Kisaran Barat</p>
                        <p>Kab. Asahan, Sumatera Utara - 21263</p>
                        <p>Phone: 0852-6201-8889 email: hsb@gmail.com</p>
                    
                        </td>
                            </tr>    
                                 <tr>
                                <td colspan="2">
                <hr>
                <h3>Laporan Data Produk</h3>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-stripped" border="1" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Berat Bersih</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>';
            if(count($produk) > 0):
                foreach($produk as $k => $p): 
                $html .= '
                <tr>
                    <td>'.++$k.'</td>
                    <td>'.$p['nama'].'</td>
                    <td>'.$p['jumlah'].' Karung</td>
                    <td> '.$p['berat_bersih'].' Kg</td>
                    <td>Rp. '.number_format($p['harga']).'</td>
                    <td>Rp. '.number_format($ptotal_harga = $p['jumlah']*$p['harga']).'</td>
                </tr>';
                endforeach;
            else:
                $html .= '
                <tr class="text-center">
                    <td colspan="3">Tidak ada Data</td>
                </tr>';
            endif;
        $html .= '
        </tbody>
    </table>
    <div class="py-3 text-print">
        <br><br>
        Di Ketahui Oleh
        <br>
        Pimpinan
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
$dompdf->stream("Laporan-Produk.pdf");