<?php
$current = "data pembelian";

require_once '../qb.php';

$id = $_GET['id'];

if (isset($id)) {
    $pems = getBy('tb_pembelian', ['id_order' => $id]);
    if ($pems) {
        echo "Bukti Transaksi dengan ID: $id";
    } else {
        echo "ID Transaksi tidak ditemukan!";
    }
} else {
    echo "ID tidak ditemukan!";
}
require_once '../layouts/header.php';
$sqlpembelian = mysqli_query($conn, "SELECT tp.id, tp.tanggal, tp.nama_bahan_baku, tp.jumlah, tp.total, tor.status, tor.bukti, tor.lokasi_barang 
                                    FROM tb_order tor 
                                    JOIN tb_pembelian tp ON tor.id = tp.id_order where tp.id = $id");

$sqlfoto = mysqli_query($conn, "SELECT tp.id_order FROM tb_pembelian tp JOIN tb_order tor ON tp.id_order = tor.id WHERE tor.id = '$id'");




?>

<style>
    .text-print {
        display: none;
    }

    @media print {
        body {
            visibility: hidden;
        }

        .no-print,
        .dataTables_paginate.paging_simple_numbers {
            display: none;
        }

        .text-print {
            display: block;
        }

        #print {
            visibility: visible;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
        }
    }
</style>
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(assets/img/bg-img/breadcumb.jpg);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Detail Pesanan</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<a href="index.php" class="btn btn-sm btn-success ml-3">Kembali</a>
<br>
<br>
<?php

// $id_konsumen = $_SESSION['user']['id'];
$invoice = mysqli_query($conn, "select * from tb_order,tb_pembelian where tb_pembelian.id='$id'");
while ($i = mysqli_fetch_array($sqlpembelian)) { ?>
    <div class="col-md-6">
        <div class="table-responsive cart_info">
            <table class="tables">
                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td colspan="2">
                        <table class="tables total-result">
                            <tr>
                                <td>
                                    <h6>ID Transaksi: </h6>
                                </td>
                                <td>
                                    <h6><?= $i['id'] ?></h6>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal: </td>
                                <td><?= $i['tanggal'] ?></td>
                            </tr>
                            <tr>
                                <td>Nama Bahan Baku : </td>
                                <td><?= $i['nama_bahan_baku'] ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah : </td>
                                <td><?= $i['jumlah'] ?></td>
                            </tr>
                            <tr>
                                <td>Bukti: </td>
                                <td><img src="../uploads/<?php echo $i['bukti']; ?>" width="300px" ></td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>


<?php } ?>

</div>