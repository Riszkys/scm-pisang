<?php
$current = "data transaksi";

require_once '../qb.php';

if (isset($_GET['delete'])) {
    $res = delete('tb_transaksi', $_GET['delete']);
    if ($res) {
        $success = true;
        unset($_GET);
        header("location:index.php");
    } else {
        $failed = true;
    }
}

require_once '../layouts/header.php';

$sqlKonsumen = mysqli_query($conn, "SELECT tt.id, tt.tanggal, tk.nama_konsumen, tt.alamat, tt.hp, tt.total, td.jumlah, tt.status, tt.bukti 
FROM tb_transaksi tt 
JOIN tb_konsumen tk ON tt.id_konsumen = tk.id
JOIN tb_transaksi_detail td ON tt.id = td.id_transaksi");

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
<style>
    .checkmark.selected {
        font-weight: bold;
        /* Atau ubah sesuai gaya visual yang Anda inginkan */
        color: green;
        /* Atau ubah warna yang diinginkan */
    }
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Transaksi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
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
                            <h5>Data Transaksi</h5>
                            <div>
                                <a class="btn btn-primary btn-sm" href="cetak.php" target="_blank"><i class="fa fa-print"></i> Cetak</a>
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
                                            <h3>Data transaksi</h3>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <table id="printTable" class="table table-bordered table-stripped">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Nomor Handphone</th>
                                        <th>Total</th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Status</th>
                                        <th class="hide-print">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = mysqli_fetch_array($sqlKonsumen)) { ?>
                                        <tr>
                                            <td><?= $data["id"] ?></td>
                                            <td><?= $data["tanggal"] ?></td>
                                            <td><?= $data["nama_konsumen"] ?></td>
                                            <td><?= $data["alamat"] ?></td>
                                            <td><?= $data["hp"] ?></td>
                                            <td>Rp. <?= number_format($data["total"]) ?></td>
                                            <td><?= $data["jumlah"] ?></td>
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
                                                } elseif ($data['status'] == 7) {
                                                    echo "<span class='badge badge-danger'>Retur Ditolak</span>";
                                                } elseif ($data['status'] == 8) {
                                                    echo "<span class='badge badge-success'>Retur Disetujui</span>";
                                                }
                                                ?>
                                            </td>
                                            <td class="hide-print">
                                                <?php if ($data['status'] == 1) { ?>
                                                    <button type="button" class="badge badge-primary hide-print" data-toggle="modal" data-target="#myModal<?= $data[0] ?>">
                                                        Lihat Bukti
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal<?= $data[0] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">Lihat Bukti</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <img src="../bahan_baku/bukti/<?= $data['bukti'] ?>" alt=".." height="400">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <img src="admin/bukti/<?= $i['bukti'] ?>" alt="" width="80">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <?php if ($data['status'] < 2) { ?>
                                                                        <a href="transaksi_status.php?id_transaksi=<?= $data[0]; ?>&status=2" onclick="return confirm('Terima Pesanan?');" class='btn btn-success'>Terima</a>
                                                                        <a href="transaksi_status.php?id_transaksi=<?= $data[0]; ?>&status=3" onclick="return confirm('Batalkan Pesanan?');" class='btn btn-danger'>Tolak</a>
                                                                    <?php } ?>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } elseif ($data['status'] == 2) { ?>
                                                    <a href="transaksi_status.php?id_transaksi=<?= $data[0]; ?>&status=4" class="badge badge-success hide-print">Kirim</a>
                                                <?php } ?>
                                                <a class='badge badge-info hide-print' href="transaksi_detail.php?id=<?php echo $data[0]; ?>">Detail</a>
                                                <?php if ($data['status'] >= 6) { ?>
                                                    <a class='badge badge-info hide-print' href="return_detail.php?id=<?php echo $data[0]; ?>">Detail Retur</a>
                                                <?php } ?>
                                                <a class='badge badge-info hide-print' href="cetak_detail.php?id=<?php echo $data[0]; ?>">Print</a>
                                                <!-- <a href="edit.php?id=<?= $data['id'] ?>" class="badge badge-warning hide-print"><i class="fa fa-pencil"></i> Edit</a> -->

                                                <a href="index.php?delete=<?= $data['id'] ?>" class="badge badge-danger hide-print"><i class="fa fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>

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
        <!-- <script>
            function printTable(selectedID) {
                // Cari elemen tabel
                var table = document.getElementById("printTable");

                // Cari baris dengan ID data yang dipilih
                var selectedRow = table.querySelector("tr[data-id='" + selectedID + "']");

                // Buat tabel baru yang hanya berisi baris data terpilih
                var newTable = "<table class='table table-bordered table-stripped'>";
                newTable += "<thead>" + table.querySelector("thead").outerHTML + "</thead>";
                newTable += "<tbody>" + selectedRow.outerHTML + "</tbody>";
                newTable += "</table>";

                // Buka jendela cetak
                var win = window.open('', '_blank');

                // Tampilkan konten tabel dalam jendela cetak
                win.document.write('<html><head><title>Cetak Tabel</title></head><body>');
                win.document.write(newTable);
                win.document.write('</body></html>');

                // Cetak
                win.print();

                // Tutup jendela cetak
                win.close();
            }
        </script> -->

        <?php
        require_once '../layouts/footer.php';
        ?>