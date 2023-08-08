<?php 
    $current = "data produksi";

    require_once '../qb.php';

    if(isset($_GET['delete'])){
        $res = delete('tb_produksi',$_GET['delete']);
        if($res){
            $success = true;
            unset($_GET);
            header("location:index.php");
        }else{
            $failed = true;
        }
    }

    require_once '../layouts/header.php';

    $produksi = get("tb_produksi");

?>

     <!-- Content Header (Page header) -->
     <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Barang Keluar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Barang Kelua</li>
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
                    <h5>Barang Keluar</h5>
                    <div>
                    <a href="cetak.php" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Cetak</a>
                    <a href="create.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                    <!-- <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal"><i class="fa fa-print"></i> Laporan Pemakaian</a> -->
                    </div>
                </div>
                <?php if(isset($success)): ?>
                    <div class="alert alert-success">Berhasil menghapus data</div>
                <?php elseif(isset($failed)): ?>
                    <div class="alert alert-danger">Gagal menghapus data</div>
                <?php endif ?>
                <div id="print">
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th class="hide-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($produksi) > 0): ?>
                                <?php foreach($produksi as $k => $p): ?>
                                <tr>
                                    <td><?= ++$k ?></td>
                                    <td>
                                        <?= $p['produk'] ?>
                                        <br>
                                        <?php
                                        $produksi_bahan_baku = getBy('tb_produksi_bahan_baku',['produk'=>$p['produk']]);
                                        foreach($produksi_bahan_baku as $b)
                                        {
                                            $bahan_baku = getBy('tb_bahan_baku',['nama_bahan_baku'=>$b['bahan_baku']])[0];
                                            $jumlah =  $b['jumlah'];
                                            echo "<b>".$b['bahan_baku']."</b> : ".$jumlah." Sisir<br>";
                                        }
                                        ?>
                                    </td>
                                    <td><?= $p['jumlah'] ?> Sisir</td>
                                    <td><?= $p['tanggal'] ?></td>
                                    <td class="hide-print">
                                        <a href="index.php?delete=<?=$p['id']?>" class="badge badge-danger hide-print"><i class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr class="text-center">
                                    <td colspan="5">Tidak ada Data</td>
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


