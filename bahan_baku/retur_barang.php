<?php
$current = "data pembelian";

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

$sqlPembelian = mysqli_query($conn, "SELECT * FROM tb_transaksi,tb_konsumen WHERE tb_transaksi.id_konsumen=tb_konsumen.id AND id_konsumen='$id_konsumen'");
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
                    <h2>Detail Pesanan</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<a href="customer_pesanan.php" class="btn btn-sm btn-success ml-3">Kembali</a>
<br>
<br>
<?php
$id_transaksi = $_GET['id'];
$id_konsumen = $_SESSION['user']['id'];
$invoice = mysqli_query($conn, "select * from tb_transaksi,tb_konsumen where tb_transaksi.id_konsumen=tb_konsumen.id and tb_transaksi.id='$id_transaksi' order by tb_transaksi.id desc");
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
                                    <h6><?= $i['id'] ?></h6>
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
                                <form action="" style="padding-top: 2rem;">
                            <tr>
                                <td>Masukkan Gambar</td>
                                <td> <input type="file" name="gambar" id="gambar"></td>
                            </tr>
                            <td>Alasan Retur : </td>
                            <td> <textarea name="alasan" id="alasan" cols="50" rows="10" class="form-group"></textarea></td>
                            </form>
                </tr>
                <tr>
                    <td><button class="btn btn-sm btn-success ml-3">Ajukan Retur</button> </td>
                </tr>
            </table>
            </td>
            </tr>
            </table>
        </div>
    </div>
    <br>

    <section id="cart_items">
        <div class="table-responsive cart_info">
            <table class="table">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Produk</td>
                        <td class="description"></td>
                        <td class="price">Harga</td>
                        <td class="quantity">Jumlah</td>
                        <td class="total">Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $transaksi = mysqli_query($conn, "select * from tb_transaksi_detail,tb_bahan_baku where id_bahan_baku=tb_bahan_baku.id and id_transaksi='$i[0]'");
                    while ($d = mysqli_fetch_array($transaksi)) {
                        $total += $d['jumlah'] * $d[4];
                        // print_r($d);
                    ?>
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="upload/<?= $d['gambar'] ?>" alt="" width="80"></a>
                            </td>
                            <td class="cart_description">
                                <h5><?= $d['nama_bahan_baku'] ?></h5>
                            </td>
                            <td class="cart_price">
                                <p><?php echo "Rp. " . number_format($d[4]) . " ,-"; ?></p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <p><?= $d['jumlah'] ?></p>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price"><?php echo "Rp. " . number_format($total) . " ,-"; ?></p>
                            </td>
                        </tr>
                    <?php
                        $total = 0;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td style="font-size:24px;"><b>Total Pembayaran</b></td>
                                    <td style="font-size:24px;"><b><?php echo "Rp. " . number_format($i['total']) . " ,-"; ?></b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php } ?>
</div>