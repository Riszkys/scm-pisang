<?php
require_once 'db.php';
$current = "dashboard";
require_once 'layouts/header.php';

$bahan_baku = getCount("tb_bahan_baku");
$supplier = getCount("tb_supplier");
$pemesanan = getCount("tb_pemesanan");
$pembelian = getCount("tb_pembelian");
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
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
            <div class="col-sm-12">
                <?php
                if ($_SESSION['user']['level'] == 'supplier' && $current == "dashboard") {
                    $bahan = get("tb_bahan_baku");
                    foreach ($bahan as $bb) :
                        if ($bb['stok'] > $bb['min_stok']) continue;
                ?>
                        <div class="alert alert-warning" role="alert">
                            Stok Pisang <?= $bb['nama_bahan_baku'] ?> sudah habis dan harus di pesan.
                            Silahkan klik <a href="/pemesanan/create.php?bahan_baku=<?= $bb['nama_bahan_baku'] ?>">disini</a>
                            untuk memesan pupuk.
                        </div>
                    <?php endforeach; ?>


            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $bahan_baku ?></h3>

                        <p>Data Pisang</p>
                    </div>
                    <a href="bahan_baku/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            <?php }; ?>
            </div>
        </div>

        <?php if ($_SESSION['user']['level'] == 'admin') : ?>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $bahan_baku ?></h3>

                            <p>Data Pisang</p>
                        </div>
                        <a href="bahan_baku/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $supplier ?></h3>

                            <p>Data Supplier</p>
                        </div>
                        <a href="supplier/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $pemesanan ?></h3>

                            <p>Data Pemesanan</p>
                        </div>
                        <a href="pemesanan/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $pembelian ?></h3>

                            <p>Data Pembelian</p>
                        </div>
                        <a href="pembelian/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <!-- /.row -->
        <?php endif ?>

        <?php if ($_SESSION['user']['level'] == 'pimpinan') : ?>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $bahan_baku ?></h3>

                            <p>Data Pisang</p>
                        </div>
                        <a href="bahan_baku/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $supplier ?></h3>

                            <p>Data Supplier</p>
                        </div>
                        <a href="supplier/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $pemesanan ?></h3>

                            <p>Data Pemesanan</p>
                        </div>
                        <a href="pemesanan/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $pembelian ?></h3>

                            <p>Data Pembelian</p>
                        </div>
                        <a href="pembelian/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        <?php endif ?>

        <?php if ($_SESSION['user']['level'] == 'konsumen') : ?>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <!-- <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $bahan_baku ?></h3>

                            <p>Data Pisang</p>
                        </div>
                        <a href="bahan_baku/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div> -->
                </div>



            </div>
            <!-- /.row -->
        <?php endif ?>
        <!--
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 align="center">Nama Pupuk</h4>
                                <p></p>
                                <div class="gallery" style="overflow: auto;height: 160px;margin:auto;width: 560px">
                                    <?php
                                    $items = [
                                        "",
                                        "Data Pisang"


                                    ];
                                    for ($i = 1; $i <= 4; $i++) { ?>
                                        <div class="gallery-item" style="width: 130px;float: left;height: 130px;margin-right: 10px">
                                            <img src="/assets/bahan-baku-1.jpeg" width="100%" height="100%" style="object-fit: cover;">
                                            <center>
                                                <span>
                                                </span>
                                            </center>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div style="display: block;">
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-text">Data Bahan Baku</span>
                            </div>
                            <div class="card-body">
                            <?= getCount("tb_bahan_baku") ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-text">Data Supplier</span>
                            </div>
                            <div class="card-body">
                                <?= getCount("tb_supplier") ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-text">Data Pemesanan</span>
                            </div>
                            <div class="card-body">
                                <?= getCount("tb_pemesanan") ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-text">Data Pembelian</span>
                            </div>
                            <div class="card-body">
                                <?= getCount("tb_pembelian") ?>
                            </div>
                        </div>
                    </div>
                </div> -->
    </div>
    </div>
    </div>
    </div>
    ->
    <?php
    require_once 'layouts/footer.php';
    ?>