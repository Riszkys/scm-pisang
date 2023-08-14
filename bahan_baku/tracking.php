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
                <h1 class="m-0 text-dark">Tracking Pembelian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Tracking Pembelian</li>
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
                                        <label for="">ID Transaksi</label>
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
                            $beli = $conn->query("SELECT * FROM tb_transaksi,tb_konsumen WHERE tb_transaksi.id_konsumen=tb_konsumen.id AND tb_transaksi.id='$id_beli'")->fetch_array();

                            ?>
                            <?php if ($beli == NULL) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <p>ID Pemesanan yang anda inputkan tidak valid</p>
                                </div>
                            <?php endif; ?>
                            <?php if ($beli != NULL) : ?>
                                <table class="table table-bordered" width="100%">
                                    <tr>
                                        <th>Nama Pemesan : <?= $beli['nama_konsumen'] ?></th>
                                        <th>tanggal : <?= $beli['tanggal'] ?></th>
                                    </tr>

                                    <table class="table">
                                        <thead>
                                            <tr class="cart_menu">
                                                <td class="image">Produk</td>
                                                <td class="description"></td>
                                                <td class="price">Harga</td>
                                                <td class="quantity">Jumlah</td>
                                                <td class="total">Total</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            $transaksi = mysqli_query($conn, "select * from tb_transaksi_detail,tb_bahan_baku where id_bahan_baku=tb_bahan_baku.id and id_transaksi='$beli[0]'");
                                            while ($d = mysqli_fetch_array($transaksi)) {
                                                $total += $d['jumlah'] * $d[4];
                                                // print_r($d);
                                            ?>
                                                <tr>
                                                    <td class="cart_product">
                                                        <a href=""><img src="upload/<?= $d['gambar'] ?>" alt="" width="80"></a>
                                                    </td>
                                                    <td class="cart_description">
                                                        <h5><?= $d['nama_bahan_baku'] ?></h5>
                                                    </td>
                                                    <td class="cart_price">
                                                        <p><?php echo "Rp. " . number_format($d[4]) . " ,-"; ?></p>
                                                    </td>
                                                    <td class="cart_quantity">
                                                        <div class="cart_quantity_button">
                                                            <p><?= $d['jumlah'] ?></p>
                                                        </div>
                                                    </td>
                                                    <td class="cart_total">
                                                        <p class="cart_total_price"><?php echo "Rp. " . number_format($total) . " ,-"; ?></p>
                                                    </td>
                                                </tr>
                                            <?php
                                                $total = 0;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <table class="table table-condensed">
                                        <tr>
                                            <td colspan="4">&nbsp;</td>
                                            <td colspan="2">
                                                <table class="table table-condensed total-result">
                                                    <tr>
                                                        <td style="font-size:24px;"><b>Total Pembayaran</b></td>
                                                        <td style="font-size:24px;"><b><?php echo "Rp. " . number_format($beli['total']) . " ,-"; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:24px;"><b>Status Pengajuan Retur : </b></td>
                                                        <td style="font-size:24px;"><b><?php if ($beli['status'] == 0) : ?>
                                                                    <p>Menunggu</p>
                                                                <?php elseif ($beli['status'] == 1) : ?>
                                                                    <p>Menunggu</p>
                                                                <?php elseif ($beli['status'] == 6) : ?>
                                                                    <p>Menunggu Return</p>
                                                                <?php elseif ($beli['status'] == 8) : ?>
                                                                    <p>Diterima</p>
                                                                <?php elseif ($beli['status'] <= 5) : ?>
                                                                    <p>Tidak Ada Pengajuan Retur</p>
                                                                <?php elseif ($beli['status'] == 7) : ?>
                                                                    <p>Ditolak</p>
                                                                <?php endif; ?>
                                                            </b></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </table>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 col-md-12 hh-grayBox pt45 pb20">
                                            <div class="row justify-content-between">

                                                <div class="order-tracking
                                            <?php
                                            if ($beli['status'] >= 0) {
                                                echo 'completed';
                                            }
                                            ?>
                                            ">
                                                    <span class="is-complete"></span>
                                                    <p>Dipesan<br></p>
                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] >= 1) {
                                                echo 'completed';
                                            }
                                            ?>
                                            
                                            ">
                                                    <span class="is-complete"></span>


                                                    <p>Bukti Dikirim</p>

                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] >= 3) {
                                                echo 'completed';
                                            } elseif ($beli['status' == 2]) {
                                                echo 'completed';
                                            }
                                            ?>
                                            ">
                                                    <span class="is-complete" style="background-color: <?php
                                                                                                        if ($beli['status'] == 2) {
                                                                                                            echo 'succes';
                                                                                                        }
                                                                                                        ?>"></span>

                                                    <?php if ($beli['status'] == 0) : ?>
                                                        <p>Menunggu</p>
                                                    <?php elseif ($beli['status'] == 1) : ?>
                                                        <p>Menunggu</p>
                                                    <?php elseif ($beli['status'] == 2) : ?>
                                                        <p>Dikonfirmasi</p>
                                                    <?php elseif ($beli['status'] == 3) : ?>
                                                        <p>Ditolak</p>
                                                    <?php else : ?>
                                                        <p>Dikonfirmasi</p>

                                                    <?php endif; ?>

                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] >= 4) {
                                                echo 'completed';
                                            }
                                            ?>
                                            ">
                                                    <span class="is-complete"></span>
                                                    <p>Dikirim<br></p>
                                                </div>
                                                <div class="order-tracking 
                                            <?php
                                            if ($beli['status'] >= 5) {
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