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
$id_konsumen = $_SESSION['user']['id'];
$sqlPembelian = mysqli_query($conn, "
    SELECT
        tt.*,
        tk.*,
        ttd.*
    FROM
        tb_transaksi tt
    INNER JOIN
        tb_konsumen tk ON tt.id_konsumen = tk.id
    INNER JOIN
        tb_transaksi_detail ttd ON tt.id = ttd.id_transaksi
    WHERE
        tt.id_konsumen = '$id_konsumen'
");


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
                        <?php
                        if (isset($_GET['alert'])) {
                            if ($_GET['alert'] == "gagal") {
                                echo "<div class='alert alert-danger'>Bukti gagal diupload!</div>";
                            } elseif ($_GET['alert'] == "sukses") {
                                echo "<div class='alert alert-success'>Pesanan berhasil dibuat, silahkan melakukan pembayaran!</div>";
                            } elseif ($_GET['alert'] == "upload") {
                                echo "<div class='alert alert-success'>Berhasil Upload Bukti !</div>";
                            } elseif ($_GET['alert'] == "selesai") {
                                echo "<div class='alert alert-success'>Transaksi selesai</div>";
                            } elseif ($_GET['alert'] == "retur") {
                                echo "<div class='alert alert-success'>Permintaan return barang anda sedang di proses, mohon menunggu. Terima Kasih</div>";
                            } elseif ($_GET['alert'] == "batal") {
                                echo "<div class='alert alert-danger'>Transaksi anda dibatalkan karena tidak melakukan transfer dalam waktu yang ditentukan!</div>";
                            }
                        }
                        ?>
                        <div id="print">
                            <table class="table table-bordered table-stripped" width="100%">
                                <tbody>
                                    <?php while ($data = mysqli_fetch_array($sqlPembelian)) { ?>
                                        <tr class="bg-light">
                                            <td colspan="3"><b>Nama Penerima : <?= $data['nama_konsumen'] ?></b></td>
                                            <td><b>Tanggal : <?= $data['tanggal'] ?></b></td>
                                            <td>

                                                <?php
                                                if ($data['status'] == 0) {
                                                    echo "<span class='badge badge-secondary'>dipesan</span>";
                                                } elseif ($data['status'] == 1) {
                                                    echo "<span class='badge badge-warning'>Bukti telah dikirim</span>";
                                                } elseif ($data['status'] == 2) {
                                                    echo "<span class='badge badge-info'>Dikonfirmasi</span>";
                                                } elseif ($data['status'] == 3) {
                                                    echo "<span class='badge badge-danger'>Ditolak</span>";
                                                } elseif ($data['status'] == 4) {
                                                    echo "<span class='badge badge-primary'>Dikirim</span>";
                                                } elseif ($data['status'] == 5) {
                                                    echo "<span class='badge badge-success'>Selesai</span>";
                                                } elseif ($data['status'] == 6) {
                                                    echo "<span class='badge badge-success'>Sedang Retur</span>";
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>ID : <?= $data[0] ?></b>
                                                <br>
                                                <b>Alamat : <?= $data['alamat'] ?></b>
                                                <br>
                                                <b>No Handphone : <?= $data['hp'] ?></b>
                                            </td>
                                            <td>
                                                <?php
                                                $sqlDetail = mysqli_query($conn, "SELECT * FROM tb_transaksi_detail,tb_bahan_baku WHERE tb_transaksi_detail.id_bahan_baku=tb_bahan_baku.id AND id_transaksi='$data[0]'");
                                                while ($d = mysqli_fetch_array($sqlDetail)) { ?>
                                                    <p><?= $d['nama_bahan_baku'] ?> x <?= $d['jumlah'] ?></p>
                                                <?php } ?>
                                            </td>
                                            <td>Rp. <?= number_format($data['total']) ?></td>
                                            <td class="no-print">
                                                <?php if ($data['status'] == "0") { ?>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal<?= $data[0] ?>">
                                                        Upload Bukti
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal<?= $data[0] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">Upload Bukti</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <form action="customer_pembayaran_act.php" method="post" enctype="multipart/form-data">
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="id" value="<?php echo $data[0]; ?>">
                                                                                    <label style="color:#0A0224;">Upload Bukti</label>
                                                                                    <input type="file" name="bukti" required="required">
                                                                                    <small style="color:#0A0224;" class="text-muted">Note: File Hanya format JPG atau JPEG</small>
                                                                                </div>
                                                                                <input style="" type="submit" value="Upload" class="btn btn-primary">
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <img src="admin/bukti/<?= $i['bukti'] ?>" alt="" width="80">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } elseif ($data['status'] == "1") { ?>
                                                    <img src="bukti/<?= $data['bukti'] ?>" alt="" height="100">
                                                <?php } elseif ($data['status'] == "4") { ?>
                                                    <a style="background-color:green;color:white;" onclick="return confirm('Apakah anda sudah menerima pesanan?');" class='btn btn-sm btn-default' href="customer_update.php?id=<?php echo $data[0]; ?>">Konfirmasi Pesanan</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a class='btn btn-sm btn-info' href="transaksi_detail.php?id=<?php echo $data[0]; ?>">Detail</a>
                                                <!-- Button trigger modal Return -->
                                                <?php if ($data['status'] == 5) :  ?>
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#myModal2<?= $data[0] ?>">
                                                        Return
                                                    </button>
                                                <?php endif ?>
                                                <!-- Modal return -->
                                                <div class="modal fade" id="myModal2<?= $data[0] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">Pengajuan Return
                                                                </h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body" style="width: 400px;">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <form class="container" action="customer_return_act.php" method="post" enctype="multipart/form-data">
                                                                            <div class="input-group">
                                                                                <label style="color:#0A0224;">Upload
                                                                                    Barang return</label>
                                                                                <input class="" type="file" name="bukti" required="required">
                                                                                <input type="hidden" name="id_pembelian" value="<?php echo $data[0]; ?>">
                                                                                <input type="hidden" name="id_konsumen" value="<?php echo $id_konsumen; ?>">
                                                                                <span class="input-group-text" style="width: 10rem;">Alasan Return
                                                                                    :</span>
                                                                                <textarea class="form-control" name="alasan" aria-label="Isi" required></textarea>
                                                                                <small style="color:#0A0224;" class="text-muted">Note: Berikan alasan
                                                                                    yang dapat diterima oleh admin</small>
                                                                                <span style="margin-top: 15px;">Jumlah Return</span>
                                                                                <input type="number" style="margin-top: 15px;" name="jumlah_return" value="<?= $data['jumlah'] ?>" max="<?= $data['jumlah'] ?>">
                                                                            </div>
                                                                            <input type="submit" value="submit" class="btn btn-primary">
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            </td>
                                        </tr>
                                    <?php } ?>
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