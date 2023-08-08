<?php
$current = "data pembelian";
$id_transaksi = $_GET['id'];
require_once '../qb.php';

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

if (isset($_GET['confirm'])) {
    $pem = single('tb_pembelian', $_GET['confirm']);
    $pem['keterangan'] = 'selesai';
    $res = update('tb_pembelian', $pem, $pem['id']);

    if ($res) {
        $bahan = singleBahan($pem['nama_bahan_baku']);
        $bahan['stok'] += $pem['jumlah'];
        $res = updateBahan($bahan, $bahan['nama_bahan_baku']);
        if ($res) {
            unset($_GET);
            update('tb_order', ['status' => 2], $pem['id_order']);
            header("location:index.php");
        }
    }
}

if (isset($_FILES['bukti'])) {
    $file = $_FILES['bukti'];
    $target_dir = "/upload/";
    $target_file = $target_dir . $file["name"];

    if (copy($file["tmp_name"], $target_file)) {
        if (update('tb_transaksi', ['bukti' => $file['name'], 'status' => '1'], $_POST['id'])) {
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

$sqlReturn = mysqli_query($conn, "SELECT tr.alasan_return, tr.gambar
                                  FROM tb_return tr
                                  JOIN tb_transaksi t ON tr.id_pembelian = t.id
                                  WHERE t.id = '$id_transaksi'");
while ($row = mysqli_fetch_assoc($sqlReturn)) {
    $alasan_return = $row['alasan_return'];
    $gambar_return = $row['gambar'];
}
// $sqlReturn = mysqli_query($conn, "SELECT * FROM tb_return");
$invoice = mysqli_query($conn, "SELECT t.*, k.*, dt.*, t.status 
                               FROM tb_transaksi t
                               JOIN tb_konsumen k ON t.id_konsumen = k.id
                               JOIN tb_transaksi_detail dt ON t.id = dt.id_transaksi
                               WHERE t.id = '$id_transaksi'
                               ORDER BY t.id DESC");

while ($row = mysqli_fetch_assoc($invoice)) {
    $status = $row['status'];
    // Lakukan sesuatu dengan nilai $status
}
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
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Detail Return</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<?php $id_transaksi = $_GET['id']; ?>
<a href="index.php" class="btn btn-sm btn-primary ml-3">Kembali</a>
<?php if ($status <= 6) { ?>
    <a class="btn btn-sm btn-success ml-3" href="terima_return.php?id_transaksi=<?= $id_transaksi; ?>&status=8" onclick="return confirm('Terima Pesanan?');" class='btn btn-success'>Terima Ajuan Return</a>
    <a class="btn btn-sm btn-danger ml-3" href="transaksi_status.php?id_transaksi=<?= $id_transaksi; ?>&status=7" onclick="return confirm('Batalkan Pesanan?');" class='btn btn-danger'>Tolak Ajuan Return</a>
<?php } ?>



<!-- <form action="konfirmasi_return.php" method="post">
    <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
    <a href="index.php" class="btn btn-sm btn-warning ml-3">Konfirmasi Return</a>
</form> -->
<br>
<br>
<?php
$id_konsumen = $_SESSION['user']['id'];
$invoice = mysqli_query($conn, "SELECT t.*, k.*, dt.*, t.status 
                               FROM tb_transaksi t
                               JOIN tb_konsumen k ON t.id_konsumen = k.id
                               JOIN tb_transaksi_detail dt ON t.id = dt.id_transaksi
                               WHERE t.id = '$id_transaksi'
                               ORDER BY t.id DESC");

while ($i = mysqli_fetch_array($invoice)) { ?>
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
                                    <h6><?= $id_transaksi ?></h6>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal: </td>
                                <td><?= $i['tanggal'] ?></td>
                            </tr>
                            <tr>
                                <td>Nama: </td>
                                <td><?= $i['nama_konsumen'] ?></td>
                            </tr>
                            <tr>
                                <td>Alamat: </td>
                                <td><?= $i['alamat'] ?></td>
                            </tr>
                            <tr>
                                <td>No Handphone: </td>
                                <td><?= $i['hp'] ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah Pembelian: </td>
                                <td><?= $i['jumlah'] ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <section>
        <?php

        $jumlahbeli = $i['jumlah'];
        $_SESSION['jumlahbeli'] = $jumlahbeli;
       
        ?>

        <table class="tables total-result">
            <?php $dataReturn = mysqli_fetch_array($sqlReturn) ?>
            <tr>
                <td>
                    <h6>Alasan Retur : </h6>
                </td>
                <td>
                    <h6><?php echo $alasan_return ?></h6>
                </td>
            </tr>
            <tr>
                <td>Bukti Retur : </td>
                <td>
                    <?php
                    // Checking if the 'gambar' field is not empty
                    if (!empty($gambar_return)) {
                        echo '<img src="../bahan_baku/bukti_return/' . $gambar_return . '" alt="Bukti Retur" style="max-width: 200px;">';
                    } else {
                        echo 'Tidak ada gambar retur.';
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
        </table>


    </section>