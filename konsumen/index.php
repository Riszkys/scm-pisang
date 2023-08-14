<?php
$current = "data konsumen";

require_once '../qb.php';

if (isset($_GET['delete'])) {
    $res = delete('tb_konsumen', $_GET['delete']);
    if ($res) {
        $success = true;
        unset($_GET);
        header("location:index.php");
    } else {
        $failed = true;
    }
}

require_once '../layouts/header.php';

$konsumen = get("tb_konsumen");
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
                <h1 class="m-0 text-dark">konsumen</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active">konsumen</li>
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
                            <h5>Data konsumen</h5>
                            <div>
                                <a class="btn btn-primary btn-sm" href="cetak.php" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                <a href="create.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success">Berhasil menghapus data</div>
                        <?php elseif (isset($failed)) : ?>
                            <div class="alert alert-danger">Gagal menghapus data</div>
                        <?php endif ?>
                        <div id="print">
                            <div class="text-center py-3 text-print">
                                <table width="100%">
                                    <tr>
                                        <td width="100px">
                                            <img src="../assets/logo.jpeg" width="100%">
                                        </td>
                                        <td>
                                            <center>
                                                <h4>UD Jaya Tani</h4>
                                                <p>JL. Prof.HM.Yamin, SH LK.1 NO.56, Kisaran Timur</p>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                            <h3>Data konsumen</h3>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <table class="table table-bordered table-stripped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Nomor Handphone</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th class="hide-print">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($konsumen) > 0) : ?>
                                        <?php foreach ($konsumen as $supp) : ?>
                                            <tr>
                                                <td><?= $supp["id"] ?></td>
                                                <td><?= $supp["nama_konsumen"] ?></td>
                                                <td><?= $supp["alamat"] ?></td>
                                                <td><?= $supp["no_handphone"] ?></td>
                                                <td><?= $supp["username"] ?></td>
                                                <td><?= $supp["email"] ?></td>
                                                <td><?= $supp["status_reg"] ?></td>
                                                <td class="hide-print">
                                                    <a href="edit.php?id=<?= $supp['id'] ?>" class="badge badge-warning hide-print"><i class="fa fa-pencil"></i> Edit</a>
                                                    <a href="index.php?delete=<?= $supp['id'] ?>" class="badge badge-danger hide-print"><i class="fa fa-trash"></i> Hapus</a>
                                                    <?php
                                                    if ($supp['status_reg'] === 'Belum Dikonfirmasi') {
                                                        echo '<a href="konfirmasi.php?konfirmasi=' . $supp['id'] . '" class="badge badge-warning hide-print"><i class="fa fa-check"></i> Konfirmasi</a>';
                                                    }
                                                    ?>
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
                            <div class="py-3 text-print">
                                Di ketahui Oleh
                                <br><br><br><br>
                                <b>Suhariyono</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        require_once '../layouts/footer.php';
        ?>