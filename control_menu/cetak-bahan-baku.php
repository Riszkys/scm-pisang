<?php 
    require_once '../dompdf/autoload.inc.php';
    // reference the Dompdf namespace
    use Dompdf\Dompdf;
    $current = "data bahan baku";

    require_once '../qb.php';

    if(isset($_GET['delete'])){
        $res = delete('tb_bahan_baku',$_GET['delete']);
        if($res){
            $success = true;
            unset($_GET);
            header("location:index.php");
        }else{
            $failed = true;
        }
    }

    if($_SESSION['user']['level'] == 'admin')
        $bahan = get("tb_bahan_baku");
    else
        $bahan = getBy("tb_bahan_baku",['supplier_id'=>$_SESSION['user']['id']]);

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
                    <h3>Data Pupuk</h3>
                </td>
            </tr>
        </table>
    </div>
    <table class="table table-bordered table-stripped" width="100%" border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Supplier</th>
                <th>Nama</th>
                <th>Stok</th>
                 <th>Harga</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>';
            if(count($bahan) > 0):
                foreach($bahan as $bahan_baku): 
                    $bg = '';
                    $keterangan = 'Tersedia';
                    if($bahan_baku["stok"] <= $bahan_baku['min_stok'] && $bahan_baku['stok'] != 0)
                    {
                        $bg = 'bg-warning';
                        $keterangan = 'Tersedia tetapi sudah hampir habis';
                    }
                    elseif($bahan_baku['stok'] == 0)
                    {
                        $keterangan = 'Stok Habis';
                        $bg = 'bg-danger';
                    }
                $html .= '
                <tr class="'.$bg.'">
                    <td>'.$bahan_baku["id"].'</td>
                    <td>'.single("tb_supplier",$bahan_baku["supplier_id"])["nama_supplier"].'</td>
                    <td>'.$bahan_baku["nama_bahan_baku"].'</td>
                     <td> '.$bahan_baku["stok"].' Ton</td>
                    <td>Rp. '.number_format($bahan_baku["harga"] = $bahan_baku['harga']*$bahan_baku['stok']*1000).'</td>
                    <td>'.$keterangan.'</td>
                </tr>';
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
$dompdf->stream("Laporan-Pemakaian.pdf");