<?php 
    require_once '../dompdf/autoload.inc.php';
    // reference the Dompdf namespace
    use Dompdf\Dompdf;
    $current = "data pembelian";

    require_once '../qb.php';

    $pembelian = $_SESSION['user']['level'] == 'supplier' ? getForSupplier($_SESSION['user']['id']) : get("tb_pembelian");

    $orders = $_SESSION['user']['level'] == 'supplier' ? getForSupplier($_SESSION['user']['id']) : get('tb_order');

    
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
                    <h3>Laporan Pembelian</h3>
                    <div style="text-align: left">
                    <b>Tanggal Awal :</b> '.(isset($_GET['from']) && $_GET['from'] != "" ? $_GET['from'] : '-').'<br>
                    <b>Tanggal Akhir :</b> '.(isset($_GET['to']) && $_GET['to'] != "" ? $_GET['to'] : '-').'<br>
                    <b>Status :</b> '.(isset($_GET['status']) && $_GET['status'] != "" ? $_GET['status'] : '-').'<br>
                    </div>
                </td>
            </tr>
        </table>
        
    </div>
    <table border="1" width="100%">
        <tbody>';
            if(count($orders) > 0): 
                foreach($orders as $ord):
                	$pems = getPembelianFilter($_GET,$ord['id']);
                    if(empty($pems)) continue;
                    $suppl = single('tb_supplier',$ord['id_supplier']);
                    $is_checkout = false;
                    $is_cancel   = false;
                    foreach($pems as $pem){
                        if($pem['keterangan'] == 'ditolak')
                        {
                            $is_cancel = true;
                        }

                        if($pem['keterangan'] == 'checkout')
                        {
                            $is_cancel = false;
                            $is_checkout = true;
                            break;
                        }
                    }
                $html .= '
                <tr class="bg-light">
                    <td colspan="3"><b>Supplier : '.$suppl['nama_supplier'].'</b></td>
                    <td><b>Tanggal : '.$ord['tanggal'].'</b></td>';
                    if($ord['bukti'] == null && $_SESSION['user']['level'] != 'supplier' && $is_checkout == false && $is_cancel == false):
                        $html .= '';
                    else:
                        $html .= '
                        <td>';
                            if($is_checkout == false && $is_cancel == false):
                            $html .= '
                            <span class="badge badge-info">
                                ';
                                if($_SESSION['user']['level'] != 'supplier'){
                                    if($ord['status'] == 1){
                                        $html .= "Bukti telah dikirim";
                                    }elseif($ord['status'] == 2){
                                        $html .= "Dikonfirmasi";
                                    }elseif($ord['status'] == 3){
                                        $html .= "Ditolak";
                                    }elseif($ord['status'] == 4){
                                        $html .= "Selesai";
                                    }
                                }else{
                                    if($ord['status'] == 1){
                                        $html .= "<a href='/pembelian/index.php?confirm-payment=true&id=".$ord['id']."' style='color:#FFF'>Konfirmasi Bukti</a>";
                                    }elseif($ord['status'] == 2){
                                        $html .= "Dikonfirmasi";
                                    }elseif($ord['status'] == 3){
                                        $html .= "Ditolak";
                                    }else{
                                        $html .= "Bukti belum dikirim";
                                    }
                                }
                            $html .= '
                            </span>';
                            elseif($is_cancel):
                            $html .= '
                            <span class="badge badge-danger">Di tolak</span>';
                            endif;
                            if($_SESSION['user']['level'] == 'supplier'){ 
                                if($ord['status'] == 1){
                                    $html .= "<br><a href='/uploads/".$ord['bukti']."'>Lihat Bukti</a>";
                                }
                            } 
                        $html .= '
                        </td>';
                    endif;
                $html .= '
                </tr>';
                foreach($pems as $pem):
                $html .= '
                <tr>
                    <td>
                        <b>Nama : '.$pem["nama_bahan_baku"].'</b>
                        <br>
                        <span>Harga : Rp. '.number_format($pem["harga"]).'</span>
                        <br>
                        <span>Tanggal : '.$pem["tanggal"].'</span>
                    </td>
                    <td>'.$pem["jumlah"].' Ton</td>
                    <td>';
                    if($pem['keterangan'] == 'checkout'):
                        $html .= '<span class="badge badge-warning">Sedang di Proses</span>';
                    else:
                        $html .= $pem["keterangan"];
                    endif;

                    $html .= '
                    </td>
                    <td>Rp. '.number_format($pem["total"]*1000).'</td>
                    <td></td>
                </tr>';
                endforeach;
            endforeach;
            else:
                $html .= '
                <tr class="text-center">
                    <td colspan="6">Tidak ada Data</td>
                </tr>';
            endif;
        $html .= '
        </tbody>
    </table>
    <br><br>
    Kisaran, '.date("d-m-Y").'<br>
    <b>Diketahui Oleh</b>

    <br><br><br><br><br>
    <b>Tumin</b>
</div>';

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("Laporan-Pembelian.pdf");