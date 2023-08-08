<?php 
    $current = "data pemesanan";
    require_once '../layouts/header.php';

    $pemesanan = single("tb_pemesanan",$_GET['id']);

    if(isset($_POST["edit"])){
        unset($_POST["edit"]);
        $res = update("tb_pemesanan",$_POST,$_GET['id']);
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
            <h1 class="m-0 text-dark">Edit Pemesanan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/pemesanan/index.php">Pemesanan</a></li>              
              <li class="breadcrumb-item active">Edit Pemesanan</li>
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
                    <input type="hidden" name="id_admin" value="<?=$pemesanan['id_admin']?>" required>
                    <input type="hidden" name="id" class="form-control" disabled value="<?=$pemesanan['id']?>" required>
                    <div class="form-group">
                        <label>Nama Pemesanan</label>
                        <input type="text" name="nama_bahan_baku" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$pemesanan['nama_bahan_baku']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$pemesanan['tanggal']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Ton</span>
                          </div>
                          <input type="number" name="jumlah" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$pemesanan['jumlah']?>" required>
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                          </div>
                          <input type="number" name="harga" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$pemesanan['harga']?>" required>
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                    </div>
                    <!-- <div class="form-group"> -->
                        <!-- <label>Keterangan</label> -->
                        <input type="hidden" name="keterangan" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$pemesanan['keterangan']?>" required>
                    <!-- </div> -->
                    <button class="btn btn-success" name="edit">Edit</button>
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once '../layouts/footer.php';
?>


