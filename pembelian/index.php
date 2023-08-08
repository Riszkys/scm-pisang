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

if (isset($_GET['unavailable'])) {
    $pem = single('tb_pembelian', $_GET['unavailable']);
    $pem['keterangan'] = 'ditolak';
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
// if(isset($_GET['filter'])){
//     $pembelian = getPembelianFilter($_GET);
// }

$orders = $_SESSION['user']['level'] == 'supplier' ? getForSupplier($_SESSION['user']['id']) : get('tb_order');
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
                        <h5>Data Pembelian</h5>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success">Berhasil menghapus data</div>
                        <?php elseif (isset($failed)) : ?>
                            <div class="alert alert-danger">Gagal menghapus data</div>
                        <?php endif ?>
                        <?php if ($_SESSION['user']['level'] == 'admin') : ?>
                            <form method="get" class="py-3 d-flex justify-content-start">
                                <div class="form-group">
                                    <label>Dari tanggal</label>
                                    <input type="date" value="<?= @$_GET['from'] ?>" name="from" class="form-control">
                                </div>
                                <div class="form-group mx-3">
                                    <label>Sampai tanggal</label>
                                    <input type="date" value="<?= @$_GET['to'] ?>" name="to" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">- Status -</option>
                                        <option value="ditolak" <?= isset($_GET['status']) && $_GET['status'] == 'ditolak' ? 'selected=""' : '' ?>>Di Tolak</option>
                                        <option value="diterima" <?= isset($_GET['status']) && $_GET['status'] == 'diterima' ? 'selected=""' : '' ?>>Di Terima</option>
                                        <option value="selesai" <?= isset($_GET['status']) && $_GET['status'] == 'selesai' ? 'selected=""' : '' ?>>Selesai</option>
                                    </select>
                                </div>
                                <div class="form-group mx-3">
                                    <label>&nbsp;</label>
                                    <br>
                                    <button class="btn btn-info" name="filter"><i class="fa fa-search"></i> Cari</button>
                                    <?php // if(count($pembelian)):
                                    ?>
                                    <a href="/pembelian/cetak.php?from=<?= @$_GET['from'] ?>&to=<?= @$_GET['to'] ?>&status=<?= @$_GET['status'] ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                    <?php // endif 
                                    ?>
                                </div>
                            </form>
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
                                                <h4>CV. Jaya Tani</h4>
                                                <p>JL. Prof.HM.Yamin, SH LK.1 NO.56, Kisaran Timur</p>
                                                <p>Asahan Sumatera Utara - 21224</p>
                                                <p>KISARAN Telp (0623) 41977 email :cvjayatani@gmail.com</p>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                            <h3>Laporan Pembelian</h3>
                                            <div style="text-align: left">
                                                <b>Tanggal Awal :</b> <?= isset($_GET['from']) && $_GET['from'] != "" ? $_GET['from'] : '-' ?><br>
                                                <b>Tanggal Akhir :</b> <?= isset($_GET['to']) && $_GET['to'] != "" ? $_GET['to'] : '-' ?><br>
                                                <b>Status :</b> <?= isset($_GET['status']) && $_GET['status'] != "" ? $_GET['status'] : '-' ?><br>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <table class="table table-bordered table-stripped" width="100%">
                                <tbody>
                                    <?php if (count($orders) > 0) :
                                        foreach ($orders as $ord) :
                                            $pems = getBy('tb_pembelian', ['id_order' => $ord['id']]);
                                            if (isset($_GET['filter']))
                                                $pems = getPembelianFilter($_GET, $ord['id']);

                                            if (empty($pems)) continue;
                                            $suppl = single('tb_supplier', $ord['id_supplier']);
                                            $is_checkout = false;
                                            $is_cancel   = false;
                                            foreach ($pems as $pem) {
                                                if ($pem['keterangan'] == 'ditolak') {
                                                    $is_cancel = true;
                                                }

                                                if ($pem['keterangan'] == 'checkout') {
                                                    $is_cancel = false;
                                                    $is_checkout = true;
                                                    break;
                                                }
                                            }
                                    ?>
                                            <tr class="bg-light">
                                                <td colspan="3"><b>Supplier : <?= $suppl['nama_supplier'] ?></b></td>
                                                <td><b>Tanggal : <?= $ord['tanggal'] ?></b></td>
                                                <?php if ($ord['bukti'] == null && $_SESSION['user']['level'] != 'supplier' && $is_checkout == false && $is_cancel == false) : ?>
                                                    <form action="" method="post" enctype="multipart/form-data" id="upload" style="display:none">
                                                        <input type="hidden" name="id" value="<?= $ord['id'] ?>">
                                                        <input type="file" style="display:none" name="bukti" id="bukti">
                                                    </form>
                                                    <td>
                                                        <button class="btn btn-info btn-sm" onclick="upload()">Upload Bukti</button>
                                                    </td>
                                                <?php else : ?>

                                                    <td>
                                                        <?php if ($is_checkout == false && $is_cancel == false) : ?>
                                                            <span class="badge badge-info">
                                                                <?php
                                                                if ($_SESSION['user']['level'] != 'supplier') {
                                                                    if ($ord['status'] == 1) {
                                                                        echo "<span class=\"badge badge-info\"> Bukti telah dikirim</span>";
                                                                    } elseif ($ord['status'] == 2) {
                                                                        echo "<span class=\"badge badge-info\">Dikonfirmasi</span>";
                                                                    } elseif ($ord['status'] == 3) {
                                                                        echo "<span class=\"badge badge-info\">Ditolak</span>";
                                                                    } elseif ($ord['status'] == 4) {
                                                                        echo "<span class=\"badge badge-info\">Selesai</span>";
                                                                    }
                                                                } else {
                                                                    if ($ord['status'] == 1) {
                                                                        echo "<button type=\"button\" class=\"btn btn-info badge hide-print\"
                                                                        data-toggle=\"modal\" data-target=\"#myModal" . $ord['id'] . "\">Lihat
                                                Bukti</button>";
                                                                    } elseif ($ord['status'] == 2) {
                                                                        echo "<span class=\"badge badge-info\">Dikonfirmasi</span>";
                                                                    } elseif ($ord['status'] == 3) {
                                                                        echo "<span class=\"badge badge-info\">Ditolak</span>";
                                                                    } else {
                                                                        echo "<span class=\"badge badge-info\">Bukti belum dikirim</span>";
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="modal fade" <?= "id=\"myModal" . $ord['id'] . "\"" ?> tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="myModalLabel">Lihat Bukti
                                                                                </h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <img src="../uploads/<?= $ord['bukti'] ?>" alt=".." height="400">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <?php if ($ord['status'] < 2) { ?>
                                                                                    <a href="pembelian_status.php?id_transaksi=<?= $ord['id']; ?>&status=2" onclick="return confirm('Terima Pesanan?');" class='btn btn-success'>Terima</a>
                                                                                    <a href="pembelian_status.php?id_transaksi=<?= $ord['id']; ?>&status=3" onclick="return confirm('Batalkan Pesanan?');" class='btn btn-danger'>Tolak</a>
                                                                                <?php } ?>
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>


                                                        <?php
                                                        elseif ($is_cancel) :
                                                        ?>
                                                            <span class="badge badge-danger">Di tolak</span>
                                                        <?php
                                                        endif;
                                                          //aslinya supplier rolenya
                                                            if ($ord['status'] == 1) {
                                                                echo "<br><a class=\"btn btn-md btn-primary\" href=\"detail_pembelian.php?id=" . $pem['id'] . "\">Detail Pembelian</a>";
                                                            }
                                                        
                                                        ?>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php
                                            foreach ($pems as $pem) :
                                            ?>
                                                <tr>
                                                    <td>
                                                        <b>ID : <?= $pem["id"] ?></b>
                                                        <br>
                                                        <b>Nama : <?= $pem["nama_bahan_baku"] ?></b>
                                                        <br>
                                                        <span>Harga : Rp. <?= number_format($pem["harga"]) ?></span>
                                                        <br>
                                                        <span>Tanggal : <?= $pem["tanggal"] ?></span>
                                                    </td>
                                                    <td><?= $pem["jumlah"] ?> Kg</td>
                                                    <td>
                                                        <?php if ($pem['keterangan'] == 'checkout') : ?>
                                                            <span class="badge badge-warning">Sedang di Proses</span>
                                                        <?php elseif ($pem['keterangan'] == 'diterima') : ?>
                                                            <span class="badge badge-info"><?= $pem["keterangan"] ?></span>
                                                        <?php elseif ($pem['keterangan'] == 'diterima') : ?>
                                                            <span class="badge badge-danger"><?=
                                                                 $pem["keterangan"] ?></span>
                                                        <?php elseif ($pem['keterangan'] == 'selesai') : ?>
                                                            <span class="badge badge-success"><?= $pem["keterangan"] ?></span>
                                                        <?php elseif ($pem['keterangan'] == 'ditolak') : ?>
                                                            <span class="badge badge-danger"><?= $pem["keterangan"] ?></span>
                                                        <?php endif ?>
                                                    </td>
                                                    <td>Rp. <?= number_format($pem["total"]) ?></td>
                                                    <?php if ($_SESSION['user']['level'] == 'supplier' && $pem['keterangan'] == 'checkout') : ?>
                                                        <td class="no-print">
                                                            <a href="index.php?available=<?= $pem['id'] ?>" class="badge badge-success">Pisang tersedia</a>
                                                            <a href="index.php?unavailable=<?= $pem['id'] ?>" class="badge badge-danger">Pisang tidak tersedia</a>
                                                        </td>
                                                    <?php elseif ($_SESSION['user']['level'] == 'admin' && $pem['keterangan'] == 'diterima' && $ord['status'] == 2) : ?>
                                                        <td class="no-print">
                                                            <a href="index.php?confirm=<?= $pem['id'] ?>" class="badge badge-success">Konfirmasi</a>
                                                        </td>
                                                    <?php else : ?>
                                                        <td class="no-print">Tidak ada aksi</td>
                                                    <?php endif ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
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

        <script>
            function upload() {
                var bukti = $("#bukti")
                var upload = $("#upload")
                bukti.trigger('click')

                bukti.change(function() {
                    upload.trigger('submit')
                })
            }
        </script>