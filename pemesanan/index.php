<?php
$current = "data pemesanan";

require_once '../qb.php';
// require_once '../db.php';

if (isset($_GET['delete'])) {
    $res = delete('tb_pemesanan', $_GET['delete']);
    if ($res) {
        $success = true;
        unset($_GET);
        header("location:index.php");
    } else {
        $failed = true;
    }
}

$pemesanan = get("tb_pemesanan");

$supplier = get("tb_supplier");

if (isset($_GET['checkout'])) {

    unset($_GET['checkout']);
    $id_suppliers = [];
    foreach ($pemesanan as $pem) {
        if (in_array($pem['id_supplier'], $id_suppliers)) continue;
        $id_suppliers[] = $pem['id_supplier'];
    }

    $id_orders = [];
    foreach ($id_suppliers as $id => $value) {
        $id_orders[$id] = insert('tb_order', [
            'id_supplier' => $value,
            'status'      => 0,
            'bukti'       => '',
            'tanggal'     => date('Y-m-d')
        ]);
        // $tgl = date('Y-m-d'); 
        // $a = $conn->query("INSERT INTO tb_order(id_supplier,status,bukti,tanggal) VALUE ('$id_suppliers[$id]',0,'','$tgl')");
    }


    foreach ($pemesanan as $key => $pem) {
        unset($pem['id']);
        $pesan['id_supplier'] = $pem['id_supplier'];
        $pesan['id_order'] = $id_orders[$key];
        $pesan['nama_bahan_baku'] = $pem['nama_bahan_baku'];
        $pesan['tanggal'] = $pem['tanggal'];
        $pesan['jumlah'] = $pem['jumlah'];
        $pesan['harga'] = $pem['harga'];
        $pesan['keterangan'] = 'checkout';
        $pesan['total'] = $pem['harga'] * $pem['jumlah'];
        $ins = insert('tb_pembelian', $pesan);
    }
    //  var_dump ($pesan);
    // die();
    $trun = truncate('tb_pemesanan');
    if ($trun) {
        header("location:index.php");
    }
}

require_once '../layouts/header.php';

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pemesanan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active">Pemesanan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <form method="post">
            <div class="modal fade" id="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="id_supplier" class="form-control">
                                    <option value="">- Pilih Supplier -</option>
                                    <?php foreach ($supplier as $supp) : ?>
                                        <option value="<?= $supp['id'] ?>"><?= $supp['nama_supplier'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" name="checkout">Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between py-3">
                            <h5>Data Pemesanan</h5>
                            <div>
                                <?php if (count($pemesanan)) : ?>
                                    <a href="?checkout=true" class="btn btn-primary btn-sm">
                                        Order
                                    </a>
                                <?php endif ?>
                                <a href="create.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success">Berhasil menghapus data</div>
                        <?php elseif (isset($failed)) : ?>
                            <div class="alert alert-danger">Gagal menghapus data</div>
                        <?php endif ?>
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <!-- <th>ID Admin</th> -->
                                    <th>Nama Pisang</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Harga / Kg</th>
                                    <th>Keterangan</th>
                                    <th>Sub Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($pemesanan) > 0) : $total = 0; ?>
                                    <?php foreach ($pemesanan as $pem) : $subtotal = $pem["jumlah"] * $pem["harga"];
                                        $total += $subtotal; ?>
                                        <tr>
                                            <td><?= $pem["id"] ?></td>
                                            <!-- <td><?= $pem["id_admin"] ?></td> -->
                                            <td><?= $pem["nama_bahan_baku"] ?></td>
                                            <td><?= $pem["tanggal"] ?></td>
                                            <td><?= $pem["jumlah"] ?> Sisir</td>
                                            <td>Rp. <?= number_format($pem["harga"]) ?></td>
                                            <td> <span class="badge badge-warning"> <?= $pem["keterangan"] ?></span></td>
                                            <td>Rp. <?= number_format($subtotal) ?></td>
                                            <td>
                                                <a href="edit.php?id=<?= $pem['id'] ?>" class="badge badge-warning"><i class="fa fa-pencil"></i> Edit</a>
                                                <a href="index.php?delete=<?= $pem['id'] ?>" class="badge badge-danger"><i class="fa fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr class="text-center">
                                        <td colspan="8">Tidak ada Data</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                            <tfoot>
                                <?php if (count($pemesanan) > 0) : ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total</b></td>
                                        <td>Rp. <?= number_format($total) ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif ?>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php
        require_once '../layouts/footer.php';
        ?>