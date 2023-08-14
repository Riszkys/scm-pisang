<?php
$current = "data produk";

require_once '../qb.php';

if (isset($_GET['delete'])) {
    $res = delete('tb_produk', $_GET['delete']);
    if ($res) {
        $success = true;
        unset($_GET);
        header("location:index.php");
    } else {
        $failed = true;
    }
}

require_once '../layouts/header.php';

$produk = get("tb_produk");

?>
<style>
    .text-print {
        display: none;
    }

    @media print {
        body {
            visibility: hidden;
        }

        .hide-print,
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

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Produk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active">Produk</li>
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
                        <div class="d-flex justify-content-between py-3">
                            <h5>Data Produk</h5>
                            <div>
                                <a href="cetak.php" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Cetak</a>
                                <a href="create.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                                <!-- <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal"><i class="fa fa-print"></i> Laporan Pemakaian</a> -->
                            </div>
                        </div>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success">Berhasil menghapus data</div>
                        <?php elseif (isset($failed)) : ?>
                            <div class="alert alert-danger">Gagal menghapus data</div>
                        <?php endif ?>
                        <div id="print">
                            <table class="table table-bordered table-stripped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                        <th>Berat Bersih</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                        <th>Data Produk</th>
                                        <th class="hide-print">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($produk) > 0) : ?>
                                        <?php foreach ($produk as $k => $p) : ?>
                                            <tr class="<?= $bg ?>">
                                                <td><?= ++$k ?></td>
                                                <td><?= $p['nama'] ?></td>
                                                <td><?= $p['jumlah'] ?> Sisir</td>
                                                <td><?= $p['berat_bersih'] ?> Kg</td>
                                                <td>Rp. <?= number_format($p['harga']) ?></td>
                                                <td>Rp. <?= number_format($ptotal_harga = $p['jumlah'] * $p['harga']); ?></td>
                                                <td>
                                                    <a href="bahan_baku.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat Data Produk</a>
                                                </td>
                                                <td class="hide-print">
                                                    <a href="edit.php?id=<?= $p['id'] ?>" class="badge badge-warning hide-print"><i class="fa fa-pencil"></i> Edit</a>
                                                    <a href="index.php?delete=<?= $p['id'] ?>" class="badge badge-danger hide-print"><i class="fa fa-trash"></i> Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <tr class="text-center">
                                            <td colspan="6">Tidak ada Data</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        require_once '../layouts/footer.php';
        ?>