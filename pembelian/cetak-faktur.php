<?php 
    require_once '../dompdf/autoload.inc.php';
    // reference the Dompdf namespace
    use Dompdf\Dompdf;
    require_once '../qb.php';
    $current = "faktur pembelian";
    $pembelian = getFaktur($_SESSION['user']['id'],$_GET);
    $html = '

      <div id="print">
                    <div class="text-center py-3 text-print">
                    <table width="100%">
                      <tr>
                       <td width="120px">
                        </td>
                        <td>
                        <h4>PT. Hijau Surya Biotechindo</h4>
                        <p>JL. Besar Sei Renggas, Kel. Sei Renggas, Kec. Kisaran Barat</p>
                        <p>Asahan, Sumatera Utara - 21222</p>
                        <p>Telp 0852-6201-8889, email: utissueculture@hijausurya.com</p>
                    
                        </td>
                            </tr>    
                                 <tr>
                                <td colspan="2">
                                    <hr>
                                    <h3 align="center">Faktur Pembelian</h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table class="table table-stripped" cellpadding="5" border="1" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pisang</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>';
                            if(count($pembelian) > 0):
                                $total=0; foreach($pembelian as $pem): $total += $pem['total'];
                                $html .= '
                                <tr>
                                    <td>'.$pem["id"].'</td>
                                    <td>
                                        <b>Nama : '.$pem["nama_bahan_baku"].'</b>
                                        <br>
                                        <span>Harga : Rp. '.number_format($pem["harga"]).'</span>
                                        <br>
                                        <span>Tanggal : '.$pem["tanggal"].'</span>
                                    </td>
                                    <td>'.$pem["jumlah"].' Ton</td>
                                    <td>'.$pem["keterangan"].'</td>
                                    <td>Rp. '.number_format($pemtotal = $pem["jumlah"]*$pem["harga"]).'</td>
                                </tr>';
                                endforeach;
                                $html .= '
                                <tr>
                                    <td colspan="4"> <b> Total :  </b></td>
                                    <td>Rp. <b> '.number_format($total*1000).' </b> </td>
                                </tr>';
                            else:
                                $html .= '
                                <tr class="text-center">
                                    <td colspan="5">Tidak ada Data</td>
                                </tr>';
                            endif;
                            $html .= '
                        </tbody>
                    </table>
                    <div class="text-print pt-5">
                        <p class="mb-5">Diketahui Oleh</p>
                        <br>
                        <p>'.$_SESSION['user']['nama_supplier'].'</p>
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
$dompdf->stream("Faktur-Pembelian.pdf");

