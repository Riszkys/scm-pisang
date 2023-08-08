<?php 
    $current = "data produk";

    require_once '../qb.php';

    if(isset($_GET['delete'])){
        
        $produksi = single("tb_produksi_bahan_baku",$_GET['delete']);
        $produk = getBy("tb_produk",['nama'=>$produksi['produk']]);

        $res = delete('tb_produksi_bahan_baku',$_GET['delete']);
        if($res){
            $success = true;
            unset($_GET);
            header("location:bahan_baku.php?id=".$produk[0]['id']);
        }else{
            $failed = true;
        }
    }

    require_once '../layouts/header.php';

    $produk = single("tb_produk",$_GET['id']);
    $bahan_baku = getBy("tb_produksi_bahan_baku",['produk'=>$produk['nama']]);

?>

     <!-- Content Header (Page header) -->
     <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="index.php">Produk</a></li>
              <li class="breadcrumb-item active"><?=$produk['nama']?></li>
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
                    <h5>Data Produk <?=$produk['nama']?></h5>
                    <div>
                        <a href="tambah_bahan_baku.php?id=<?=$_GET['id']?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <?php if(isset($success)): ?>
                    <div class="alert alert-success">Berhasil menambah Produk</div>
                <?php elseif(isset($failed)): ?>
                    <div class="alert alert-danger">Gagal menambah Produk</div>
                <?php endif ?>
                <div id="print">
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th class="hide-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($bahan_baku) > 0): ?>
                                <?php foreach($bahan_baku as $k => $b): ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$k ?></td>
                                    <td><?= $b['bahan_baku'] ?></td>
                                    <td><?= $b['jumlah']?> Kg</td>
                                    <td class="hide-print">
                                        <a href="bahan_baku.php?delete=<?=$b['id']?>" class="badge badge-danger hide-print"><i class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr class="text-center">
                                    <td colspan="4">Tidak ada Data</td>
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


