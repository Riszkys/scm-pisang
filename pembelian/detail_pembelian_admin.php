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
$sqlpembelian = mysqli_query($conn, "SELECT tb_pembelian.id, tb_pembelian.tanggal, tb_pembelian.nama_bahan_baku, tb_pembelian.jumlah, tb_pembelian.total, tb_order.status, tb_order.bukti, tb_order.lokasi_barang 
                                        FROM tb_order
                                        JOIN tb_pembelian ON tb_order.id = tb_pembelian.id_order 
                                        WHERE tb_pembelian.id = $id");

$sqlfoto = mysqli_query($conn, "SELECT tp.id_order FROM tb_pembelian tp JOIN tb_order tor ON tp.id_order = tor.id WHERE tor.id = '$id'");


if (isset($_GET['delete'])) {
    $res = delete('tb_bahan_baku', $_GET['delete']);
    if ($res) {
        $success = true;
        unset($_GET);
        header("location:index.php");
    } else {
        $failed = true;
    }
}

if (isset($_GET['available'])) {
    $pem = single('tb_pembelian', $_GET['available']);
    $pem['keterangan'] = 'diterima';
    $res = update('tb_pembelian', $pem, $pem['id']);
    if ($res) {
        unset($_GET);
        header("location:index.php");
    }
}

if (isset($_GET['dikirim'])) {
    $pem = single('tb_pembelian', $_GET['dikirim']);
    $pem['keterangan'] = 'dikirim';
    $res = update('tb_pembelian', $pem, $pem['id']);
    if ($res) {
        unset($_GET);
        header("location:index.php");
    }
}

if (isset($_GET['ditolak_pimpinan'])) {
    $pem = single('tb_pembelian', $_GET['ditolak_pimpinan']);
    $pem['keterangan'] = 'ditolak pimpinan';
    $res = update('tb_pembelian', $pem, $pem['id']);
    if ($res) {
        unset($_GET);
        header("location:index.php");
    }
}

// if (isset($_GET['lolos_check'])) {
//     $pem = single('tb_pembelian', $_GET['lolos_check']);
//     $pem['keterangan'] = 'lolos check';
//     $res = update('tb_pembelian', $pem, $pem['id']);
// }



if (isset($_FILES['bukti'])) {
    $file = $_FILES['bukti'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . $file["name"];

    if (copy($file["tmp_name"], $target_file)) {
        if (update('tb_order', ['bukti' => $file['name'], 'status' => 1], $_POST['id'])) {
            header("location:index.php");
        }
    }
}

if (isset($_GET['confirm-payment'])) {
    if (update('tb_order', ['status' => 2], $_GET['id'])) {
        header("location:index.php");
    }
}

require_once '../layouts/header.php';

$pembelian = $_SESSION['user']['level'] == 'supplier' ? getForSupplier($_SESSION['user']['id']) : get("tb_pembelian");


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
        <form action="konfirmasipimpinan.php" method="GET" name="lolos_check">
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
                                <td>Keterangan : </td>
                                <td>
                                    <input type="checkbox" id="kualitas" name="keterangan[]" value="kualitas">
                                    <label for="kualitas">Kualitas</label>
                                    <input type="checkbox" id="kuantitas" name="keterangan[]" value="kuantitas">
                                    <label for="kuantitas">Kuantitas</label>
                                    <input type="checkbox" id="fisik" name="keterangan[]" value="fisik">
                                    <label for="fisik">Fisik</label>
                                </td>
                            </tr>
                            <tr>
                                <td>Aksi : </td>
                                <input type="hidden" value="<?= $i['id'] ?>" name="id_pembelian">
                                <input type="hidden" value="<?= $i['nama_bahan_baku'] ?>" name="nama_bahan_baku">
                                <td>
                                    <button type="submit" name="submit" class="badge badge-success">Konfirmasi</button>
                                    <a href="index.php?ditolak_pimpinan=<?= $pem['id'] ?>"
                                        class="badge badge-success">Tolak</a>
                                </td>
                            </tr>

                    </td>
                </tr>

                <!-- <tr>
                        <td>Bukti: </td>
                        <td><img src="../uploads/<?php echo $i['bukti']; ?>" width="300px"></td>
                        
                    </tr> -->
            </table>
        </form>
        </td>
        </tr>
        </table>
    </div>
</div>
<br>


<?php } ?>

</div>