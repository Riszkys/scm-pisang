<?php 
   $current = "Tracking";

    require_once '../qb.php';


    require_once '../layouts/header.php';

   
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tracking Order</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Tracking Order</li>
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
                            <div class="col-md-4">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="">ID Pemesanan</label>
                                        <input type="text" name="id_pembelian" id="" class="form-control">

                                    </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">-</label>
                                    <!-- <button type="submit" class="btn btn-primary mt-4">tracking</button> -->
                                    <input type="submit" value="Tracking Pesanan" id="" class="form-control btn btn-primary btn-block">
                                </div>
                            </div>
                            </form>


                        </div>
                        <hr style="border: 1px solid grey;">
                        <!-- isi tracking -->
                        <?php if (isset($_POST['id_pembelian'])) : ?>
                            <?php
                            require_once '../db.php';
                            $id_beli = $_POST['id_pembelian'];
                            $beli = $conn->query("SELECT * FROM tb_pembelian JOIN tb_order ON tb_pembelian.id_order=tb_order.id JOIN tb_supplier ON tb_pembelian.id_supplier=tb_supplier.id WHERE tb_pembelian.id='$id_beli'")->fetch_array();

                            ?>
                            <?php if ($beli == NULL) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <p>ID Pemesanan yang anda inputkan tidak valid</p>
                                </div>
                            <?php endif; ?>
                            <?php if ($beli != NULL) : ?>
                                <table class="table table-bordered" width="100%">
                                    <tr>
                                        <th>Supplier : <?= $beli['nama_supplier'] ?></th>
                                        <th>tanggal : <?= $beli['tanggal'] ?></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <p>Nama : <?= $beli['nama_bahan_baku'] ?></p>
                                            <p>Harga : <?= $beli['harga'] ?></p>
                                            <p>Tanggal : <?= $beli['tanggal'] ?></p>
                                        </td>
                                        <td>
                                            <p>Jumlah : <?= $beli['jumlah'] ?> Ton</p>
                                            <p>lokasi Saat Ini :

                                                <?php if ($beli['status'] == 0 && $beli['keterangan'] == 'diterima') : ?>
                                                    <span class="badge badge-danger">dikirim setelah bukti di konfirmasi supplier</span>
                                                <?php endif; ?>
                                                <?php if ($beli['status'] == 1 && $beli['keterangan'] == 'diterima') : ?>
                                                    <span class="badge badge-danger">dikirim setelah bukti di konfirmasi supplier</span>
                                                <?php endif; ?>
                                                <?php if ($beli['status'] == 2 && $beli['keterangan'] == 'diterima') : ?>
                                                    <span class="badge badge-primary"><?= $beli['lokasi_barang'] == NULL ? 'Gudang' : $beli['lokasi_barang'] ?></span>
                                                <?php endif; ?>
                                                <?php if ($beli['status'] == 2 && $beli['keterangan'] == 'selesai') : ?>
                                                    <span class="badge badge-success">barang sudah diterima</span>
                                                <?php endif; ?>
                                            </p>
                                        </td>
                                    </tr>

                                </table>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 col-md-12 hh-grayBox pt45 pb20">
                                            <div class="row justify-content-between">

                                                <div class="order-tracking
                                            <?php
                                            if ($beli['status'] == 0 && $beli['keterangan'] == 'ditolak') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 0 && $beli['keterangan'] == 'checkout') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 0 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 1 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 2 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 2 && $beli['keterangan'] == 'selesai') {
                                                echo 'completed';
                                            }
                                            ?>
                                            ">
                                                    <span class="is-complete"></span>
                                                    <p>Checkout<br></p>
                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] == 0 && $beli['keterangan'] == 'ditolak') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 0 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 1 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 2 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 2 && $beli['keterangan'] == 'selesai') {
                                                echo 'completed';
                                            }
                                            ?>
                                            
                                            ">
                                                    <span class="is-complete" style="background-color: <?php
                                                                                                        if ($beli['status'] == 0 && $beli['keterangan'] == 'ditolak') {
                                                                                                            echo 'red';
                                                                                                        }
                                                                                                        ?>"></span>

                                                    <?php
                                                    if ($beli['status'] == 0 && $beli['keterangan'] == 'ditolak') : ?>
                                                        <p>Ditolak</p>
                                                    <?php else : ?>
                                                        <p>Konfirmasi Supplier</p>
                                                    <?php endif; ?>

                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] == 1 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 2 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 2 && $beli['keterangan'] == 'selesai') {
                                                echo 'completed';
                                            }
                                            ?>
                                            ">
                                                    <span class="is-complete"></span>
                                                    <p>Upload Bukti<br></p>
                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] == 2 && $beli['keterangan'] == 'diterima') {
                                                echo 'completed';
                                            } elseif ($beli['status'] == 2 && $beli['keterangan'] == 'selesai') {
                                                echo 'completed';
                                            }
                                            ?>
                                            ">
                                                    <span class="is-complete"></span>
                                                    <p>Konfirmasi Bukti oleh Supplier<br></p>
                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] == 2 && $beli['keterangan'] == 'selesai') {
                                                echo 'completed';
                                            }
                                            ?>
                                            ">
                                                    <span class="is-complete"></span>
                                                    <p>Barang diterima<br></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;  ?>



                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php
require_once '../layouts/footer.php';
?>