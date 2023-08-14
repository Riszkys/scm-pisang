<?php
$current = "data pisang";

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

require_once '../layouts/header.php';



if ($_SESSION['user']['level'] == 'admin' || $_SESSION['user']['level'] == 'pimpinan' || $_SESSION['user']['level'] == 'konsumen')

    $bahan_user = get1("tb_bahan_baku", "DISTINCT id, supplier_id, nama_bahan_baku, harga, stok, min_stok, total, gambar , keterangan");

elseif ($_SESSION['user']['level'] == 'supplier')
    $bahan = getBy("tb_bahan_baku", ['supplier_id' => $_SESSION['user']['id']]);

$bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];

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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<form action="cetak.php">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Laporan Pemakaian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="bulan" class="form-control" required="">
                            <option value="">- Pilih Bulan -</option>
                            <?php foreach ($bulan as $k => $v) : ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <select name="tahun" class="form-control" required="">
                            <option value="">- Pilih Tahun -</option>
                            <?php for ($i = 2020; $i >= 2000; $i--) : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary">Cetak</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Pisang</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active">Data Pisang</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php if ($_SESSION['user']['level'] == 'admin' || $_SESSION['user']['level'] == 'supplier' || $_SESSION['user']['level'] == 'pimpinan') { ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between py-3">
                                <h5>Data Pisang</h5>
                                <?php if ($_SESSION['user']['level'] == 'admin') : ?>
                                    <div>
                                        <a href="cetak-bahan-baku.php" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Cetak</a>
                                        <!-- <a href="create.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a> -->
                                        <!-- <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal"><i class="fa fa-print"></i> Laporan Pemakaian</a> -->
                                    </div>
                                <?php endif ?>
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
                                                <img src="../assets/PT-14.jpg" width="100%">
                                            </td>
                                            <td>
                                                <center>
                                                    <h4>PT. Hijau Surya Biotechindo</h4>
                                                    <p>JL. Besar Sei Renggas, Kel. Sei Renggas, Kec. Kisaran Barat</p>
                                                    <p>Asahan, Sumatera Utara - 21222</p>
                                                    <p>Telp 0852-6201-8889, email: tissueculture@hijausurya.com</p>
                                                </center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <hr>
                                                <h3>Data Pisang</h3>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="container mt-5">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th class="hide-print">Aksi</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nama_bahan_baku_set = array(); // Set untuk menyimpan nama unik
                                            foreach ($bahan as $bahan_baku) {
                                                if (!in_array($bahan_baku['nama_bahan_baku'], $nama_bahan_baku_set)) {
                                                    array_push($nama_bahan_baku_set, $bahan_baku['nama_bahan_baku']);
                                                    // Tampilkan baris data pertama dan dropdown berisi data lebih spesifik
                                                    echo '<tr>';
                                                    echo '<td>' . $bahan_baku['id'] . '</td>';
                                                    echo '<td>' . $bahan_baku['nama_bahan_baku'] . '</td>';
                                                    echo '<td><a class="btn btn-primary" data-toggle="collapse" href="#detail' . $bahan_baku['id'] . '" role="button" aria-expanded="false" aria-controls="detail' . $bahan_baku['id'] . '">Detail</a></td>';
                                                    echo '<td>' . $bahan_baku['keterangan'] . '</td>';
                                                    echo '</tr>';
                                                    echo '<tr>';
                                                    echo '<td colspan="4">';
                                                    echo '<div class="collapse" id="detail' . $bahan_baku['id'] . '">';
                                                    echo '<div class="card card-body">';

                                                    // Ambil data supplier berdasarkan nama_bahan_baku pada tb_bahan_baku
                                                    $suppliers = array();
                                                    $totalStok = 0; // Menyimpan total stok untuk bahan baku dengan nama yang sama
                                                    foreach ($bahan as $b) {
                                                        if ($b['nama_bahan_baku'] == $bahan_baku['nama_bahan_baku']) {
                                                            $suppliers[] = single("tb_supplier", $b["supplier_id"]);
                                                            $totalStok += $b['stok'];
                                                        }
                                                    }

                                                    foreach ($suppliers as $supplier) {
                                                        echo 'Nama Supplier: ' . $supplier['nama_supplier'] . ' <br>';
                                                    }

                                                    echo '<img src="upload/' . $bahan_baku["gambar"] . '" alt="" width="200px">';
                                                    echo 'Stok: ' . $totalStok . ' Sisir<br>'; // Tampilkan total stok
                                                    echo 'Harga: Rp. ' . number_format($bahan_baku["harga"] * $totalStok) . '<br>';

                                                    echo '<button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#detail' . $bahan_baku['id'] . '" aria-expanded="false" aria-controls="detail' . $bahan_baku['id'] . '">Close</button>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <center>
                                    <button class="btn btn-primary">
                                        <?php

                                        $total = 0;
                                        if (count($bahan) > 0) {
                                            foreach ($bahan as $bahan_baku) {
                                                $bg = '';
                                                $keterangan = 'Tersedia';

                                                if ($bahan_baku["stok"] <= $bahan_baku['min_stok'] && $bahan_baku['stok'] != 0) {
                                                    $bg = 'bg-warning';
                                                    $keterangan = 'Tersedia tetapi sudah hampir habis';
                                                } elseif ($bahan_baku['stok'] == 0) {
                                                    $keterangan = 'Stok Habis';
                                                    $bg = 'bg-danger';
                                                }

                                                $total += $bahan_baku["stok"];
                                            }
                                        }
                                        ?>

                                        <h3 class="my-0">Jumlah Stok : <?= $total ?> Sisir</h3>
                                    </button>
                                </center>
                                <div class="py-3 text-print">
                                    Di ketahui Oleh
                                    <br>
                                    Pemilik
                                    <br><br><br><br>
                                    <b>Bapak Budi Chandra</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>

            <div class="row">
                <?php
                $total = 0;
                if (count($bahan_user) > 0) :
                    foreach ($bahan_user as $bahan_baku_user) :
                        $bg = '';
                        $keterangan = 'Tersedia';
                        if ($bahan_baku_user["stok"] <= $bahan_baku_user['min_stok'] && $bahan_baku_user['stok'] != 0) {
                            $bg = 'bg-warning';
                            $keterangan = 'Tersedia tetapi sudah hampir habis';
                        } elseif ($bahan_baku_user['stok'] == 0) {
                            $keterangan = 'Stok Habis';
                            $bg = 'bg-danger';
                        }
                        $total += $bahan_baku_user["stok"];
                ?>

                        <div class="col-md-4">
                            <div class="card" style="width: 18rem;">
                                <img src="upload/<?= $bahan_baku_user['gambar'] ?>" class="card-img-top" alt="..." height="200" width="200">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold mb-2"><?= $bahan_baku_user['nama_bahan_baku'] ?></h5>
                                    <p class="card-text">Rp. <?= number_format($bahan_baku_user['harga']) ?></p>
                                    <p class="text-success">Stok <?= $bahan_baku_user['stok'] ?></p>
                                    <a href="add_keranjang.php?id=<?= $bahan_baku_user['id']; ?>&redirect=index" class="btn btn-primary">Beli <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-md-12 text-center">
                        <p>Tidak ada Data</p>
                    </div>
                <?php endif; ?>
            </div>

        <?php } ?>

        <?php
        require_once '../layouts/footer.php';
        ?>