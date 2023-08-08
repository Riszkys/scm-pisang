<?php

$current = "Tracking";

    require_once '../qb.php';
    require_once '../layouts/header.php';

$id_supplier = $_SESSION["user"]["id"];
$supplier_status = $conn->query("SELECT * FROM tb_pembelian JOIN tb_supplier ON tb_pembelian.id_supplier=tb_supplier.id JOIN tb_order ON tb_pembelian.id_order=tb_order.id WHERE tb_pembelian.id_supplier='$id_supplier' AND keterangan='diterima' AND tb_order.status='2' ORDER BY tb_pembelian.id DESC");

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pembelian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Pembelian</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered" width="100%">
                                <?php foreach ($supplier_status as $s => $ss) : ?>
                                    <tr>
                                        <th>Supplier : <?= $ss['nama_supplier'] ?> </th>
                                        <th>tanggal : <?= $ss['nama_supplier'] ?></th>
                                        <th style="width: 30%;"> <i class="text-danger text-small">(update lokasi barang)</i></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <p>Nama : <?= $ss['nama_bahan_baku'] ?></p>
                                            <p>Harga : <?= $ss['harga'] ?></p>
                                            <p>Tanggal : <?= $ss['tanggal'] ?></p>
                                        </td>
                                        <td>
                                            <p><?= $ss['jumlah'] ?> Ton</p>
                                        </td>
                                        <td>
                                            <form action="update_track.php" method="POST">
                                                <input type="hidden" name="id_order" value="<?= $ss['id'] ?>">
                                                <div class="form-group">
                                                    <textarea name="lokasi_barang" id="" cols="40" rows="3" class="form-control"><?= $ss['lokasi_barang'] == NULL ? '' : $ss['lokasi_barang'] ?></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm">update lokasi</button>
                                            </form>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>



<?php
require_once '../layouts/footer.php';
?>