<?php 
    $current = "Checkout";
    include '../db.php'; 
    require_once '../qb.php';
    require_once '../layouts/header.php';

?>
<style>

.text-print{
    display: none;
}

@media print{
    body  {
        visibility: hidden;
    }

    .hide-print, .dataTables_paginate.paging_simple_numbers {
        display: none;
    }

    .text-print{
        display: block;
    }

    #print {
        visibility: visible;
        position: fixed;
        top:0;
        left:0;
        width: 100%;
    }
}

</style>

<div class="container">
    <!-- HERO SECTION-->
    <form method="post" action="checkout_act.php">
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Checkout</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="keranjang.php">Keranjang</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                    </nav>
                </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <!-- BILLING ADDRESS-->
            <h2 class="h5 text-uppercase mb-4">Identitas Penerima</h2>
                <div class="row">
                    <div class="col-lg-8">
                    <?php
                    $id = $_SESSION['user']['id'];
                    ?>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="firstName">Nama</label>
                                <input class="form-control form-control-lg" id="firstName" type="text" placeholder="Masukkan Nama" name="nama" value="<?= $_SESSION['user']['nama_konsumen'] ?>">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="phone">No Handphone</label>
                                <input class="form-control form-control-lg" id="phone" type="tel" placeholder="contoh 082298781167" value="<?= $_SESSION['user']['no_handphone'] ?>" name="hp">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="address">Alamat</label>
                                <textarea class="form-control" name="alamat" id="" cols="30" rows="3"><?= $_SESSION['user']['alamat'] ?></textarea>
                            </div>

                            </div>
                                <div class="col-lg-12 form-group">
                                    <button class="btn btn-primary" type="submit">Pesan</button>
                                </div>
                            </div>
                        <!-- ORDER SUMMARY-->
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-0 p-lg-4 bg-light">
                                <div class="card-body">
                                <h5 class="text-uppercase mb-4">Pesanan Kamu</h5>
                                <ul class="list-unstyled mb-0">
                                    <?php
                                    // cek apakah produk sudah ada dalam keranjang
                                    $jumlah_total = 0;
                                    $total = 0;
                                    $total_berat = 0;
                                    for($a = 0; $a < $jumlah_isi_keranjang; $a++){
                                        $id_produk = $_SESSION['keranjang'][$a]['produk'];
                                        $jml = $_SESSION['keranjang'][$a]['jumlah'];
                                        $isi = mysqli_query($conn, "SELECT *, (harga + 3000) as harga FROM tb_bahan_baku WHERE id='$id_produk'");
                                        $i = mysqli_fetch_assoc($isi);
                                        $harga = $i['harga'];
                                        $total = $harga * $jml;
                                        $jumlah_total += $total;
                                        ?>
                                        <li class="d-flex align-items-center justify-content-between"><strong class="small font-weight-bold"><?= $i['nama_bahan_baku'] ?> x <?= $jml ?></strong><span class="text-muted small"><?= "Rp. ".number_format($total) . " ,-"; ?></span></li>
                                        <li class="border-bottom my-2"></li>
                                    <?php
                                        $total = 0;
                                    }
                                    ?>
                                    <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Total Bayar</strong><span><?= "Rp. ".number_format($jumlah_total) . " ,-"; ?></span></li>
                                    <input type="hidden" name="total_bayar" value="<?= $jumlah_total ?>">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </form>
</div>

<?php
    require_once '../layouts/footer.php';
?>


