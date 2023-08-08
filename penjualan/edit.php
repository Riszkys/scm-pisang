<?php 
    $current = "data produk";
    require_once '../layouts/header.php';

    $produk = single("tb_produk",$_GET['id']);

    if(isset($_POST["edit"])){
        unset($_POST["edit"]);
        $res = update("tb_produk",$_POST,$_GET['id']);
        $produk = single("tb_produk",$_GET['id']);
        if($res){
            $success = true;
        }else{
            $failed = true;
        }
    }
?>

<!-- Content Header (Page header) -->
     <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Barang Keluar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/produk/index.php">Barang Keluar</a></li>              
              <li class="breadcrumb-item active">Edit Barang Keluar</li>
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
                <?php if(isset($success)): ?>
                    <div class="alert alert-success">Berhasil mengedit data</div>
                <?php elseif(isset($failed)): ?>
                    <div class="alert alert-danger">Gagal mengedit data</div>
                <?php endif ?>
                <form method="post">
                    <input type="hidden" name="id" disabled value="<?=$produk['id']?>" class="form-control" required>
                    <div class="form-group">
                        <label>Nama Pupuk</label>
                        <input type="text" name="nama" value="<?=$produk['nama']?>" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <div class="input-group mb-3">
                          <input type="number" name="jumlah" value="<?=$produk['jumlah']?>" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">Karung</span>
                          </div>
                        </div>
                    </div>
                    <button class="btn btn-success" name="edit">Tambah</button>
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once '../layouts/footer.php';
?>


