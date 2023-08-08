<?php 
    $current = "data Pupuk";
    require_once '../layouts/header.php';

    $bahan_baku = single("tb_bahan_baku",$_GET['id']);

    if(isset($_POST["simpan"])){
        unset($_POST["simpan"]);
        $_POST['tanggal'] = date("Y-m-d");
        $res = insert("tb_pemakaian",$_POST);
        updateBahan('Jumlah Stok' : <?=$total?>)
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
            <h1 class="m-0 text-dark">Pemakaian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/bahan_baku/index.php">Pupuk</a></li>              
              <li class="breadcrumb-item active">Pemakaian</li>
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
                    <div class="alert alert-success">Berhasil meyimpan data</div>
                <?php elseif(isset($failed)): ?>
                    <div class="alert alert-danger">Gagal meyimpan data</div>
                <?php endif ?>
                <form method="post">
                    <div class="form-group">
                        <label>Nama Pupuk</label>
                        <input type="text" name="nama_bahan_baku" readonly="" value="<?=$bahan_baku['nama_bahan_baku']?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Ton</span>
                          </div>
                          <input type="number" name="jumlah" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" value="" class="form-control" required>
                    </div>
                    <button class="btn btn-success" name="simpan">Simpan</button>
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once '../layouts/footer.php';
?>


