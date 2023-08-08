<?php 
    $current = "data produk";
    require_once '../layouts/header.php';

    $suppliers = get("tb_produk");

    if(isset($_POST["create"])){
        unset($_POST["create"]);
        $res = insert("tb_produk",$_POST);
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
            <h1 class="m-0 text-dark">Tambah Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/produk/index.php">Produk</a></li>              
              <li class="breadcrumb-item active">Tambah Produk</li>
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
                    <div class="alert alert-success">Berhasil menambah data</div>
                <?php elseif(isset($failed)): ?>
                    <div class="alert alert-danger">Gagal menambah data</div>
                <?php endif ?>
                <form method="post">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <div class="input-group mb-3">
                          <input type="number" name="jumlah" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">Sisir</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berat Bersih</label>
                        <div class="input-group mb-3">
                          <input type="number" name="berat bersih" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">Kg</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <div class="input-group mb-3">
                          <div class="input-group-preppend">
                            <span class="input-group-text">Rp</span>
                          </div>
                          <input type="number" name="harga" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                        </div>
                    </div>
                    
                    <button class="btn btn-success" name="create">Tambah</button>
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once '../layouts/footer.php';
?>


