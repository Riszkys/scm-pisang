<?php 
    $current = "faktur pembelian";
    require_once '../layouts/header.php';

    $pembelian = [];

    // if(isset($_GET['filter'])){
        $pembelian = getFaktur($_SESSION['user']['id'],$_GET);
    // }
?>

<style>

.text-print{
    display: none;
}

@media print{
    body, .dataTables_paginate.paging_simple_numbers  {
        visibility: hidden;
    }

    .text-print{
        display: block;
    }

    .hide-print{
        display: none;
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

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Faktur</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/pembelian/index.php">Pembelian</a></li>              
              <li class="breadcrumb-item active">Faktur</li>
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
                <h5>Faktur Pembelian</h5>
                <form method="get" class="py-3 d-flex justify-content-start">    
                    <div class="form-group">
                        <label>Dari tanggal</label>
                        <input type="date" value="<?=@$_GET['from']?>" id="from" name="from" class="form-control">
                    </div>
                    <div class="form-group mx-3">
                        <label>Sampai tanggal</label>
                        <input type="date" value="<?=@$_GET['to']?>" id="to" name="to" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <br>
                        <button class="btn btn-info" name="filter"><i class="fa fa-search"></i> Cari</button>
                        <?php //if(count($pembelian)):?>
                            <a class="btn btn-success" href="javascript:void(0)" onclick="window.open('cetak-faktur.php?from='+from.value+'&to='+to.value)"><i class="fa fa-print"></i> Cetak</a>
                        <?php //endif ?>
                    </div>
                </form>
                 <div id="print">
                    <div class="text-center py-3 text-print">
                    <table width="100%">
                      <tr>
                       <td width="120px">
                    <img src="../assets/PT-14.jpg" width="120%">
                        </td>
                        <td>
                        <h4>PT SARI TANI JAYA SUMATERA</h4>
                        <p>JL. Prof.HM.Yamin, SH LK.1 NO.56, Kisaran Timur</p>
                        <p>Asahan Sumatera Utara - 21224</p>
                        <p>KISARAN Telp (0623) 41977 email :ptstjskisaran@gmail.com</p>
                    
                        </td>
                            </tr>    
                                 <tr>
                                <td colspan="2">
                                    <hr>
                                    <h3>Faktur Penjualan</h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pupuk</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Sub Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($pembelian) > 0): ?>
                                <?php $total=0; foreach($pembelian as $pem): $total += $pem['total'];?>
                                <tr>
                                    <td><?= $pem["id"] ?></td>
                                    <td>
                                        <b>Nama : <?= $pem["nama_bahan_baku"] ?></b>
                                        <br>
                                        <span>Harga : Rp. <?= number_format($pem["harga"]) ?></span>
                                        <br>
                                        <span>Tanggal : <?= $pem["tanggal"] ?></span>
                                    </td>
                                    <td><?= $pem["jumlah"] ?> Ton</td>
                                    <td>
                                    <?php if($pem['keterangan'] == 'checkout'): ?>
                                        <span class="badge badge-warning"><?= $pem["keterangan"] ?></span>
                                    <?php elseif($pem['keterangan']=='diterima'): ?>
                                        <span class="badge badge-info"><?= $pem["keterangan"] ?></span>
                                    <?php elseif($pem['keterangan']=='diterima'): ?>
                                        <span class="badge badge-danger"><?= $pem["keterangan"] ?></span>
                                    <?php elseif($pem['keterangan']=='selesai'): ?>
                                        <span class="badge badge-success"><?= $pem["keterangan"] ?></span>
                                    <?php elseif($pem['keterangan']=='ditolak'): ?>
                                        <span class="badge badge-danger"><?= $pem["keterangan"] ?></span>
                                    <?php endif ?>
                                    </td>
                                    <td>Rp. <?= number_format($pem["total"]*1000) ?></td>
                                    <td>
                                        <a class="btn btn-success" href="javascript:void(0)" onclick="window.open('cetak-faktur.php?id=<?=$pem['id']?>')"><i class="fa fa-print"></i> Cetak</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <tr>
                                    <td colspan="4"> <b> Total :  </b></td>
                                    <td>Rp. <b> <?=number_format($total*1000)?> </b> </td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <tr class="text-center">
                                    <td colspan="5">Tidak ada Data</td>
                                    <td></td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                    <div class="text-print pt-5">
                        <p class="mb-5">Diketahui Oleh</p>
                        <p><?=$_SESSION['user']['nama_supplier']?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    require_once '../layouts/footer.php';
?>


