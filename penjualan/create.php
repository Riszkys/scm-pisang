<?php 
    $current = "data penjualan";
    require_once '../layouts/header.php';

    $produk = get("tb_produk");

    if(isset($_POST["create"])){
        unset($_POST["create"]);
        $_produk = getBy("tb_produk",['nama'=>$_POST['produk']])[0];
        if($_produk['jumlah'] < $_POST['jumlah'])
            $failed = true;
        else
        {
            $_produk = getBy("tb_produk",['nama'=>$_POST['produk']])[0];
            $_produk['jumlah'] -= $_POST['jumlah'];
            update('tb_produk',$_produk,$_produk['id']);
            $res = insert("tb_penjualan",$_POST);
            print_r($res);
            if($res){
                $success = true;
            }else{
                $failed = true;
            }
        }
    }
?>

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/penjualan/index.php">Penjualan</a></li>              
              <li class="breadcrumb-item active">Tambah Penjualan</li>
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
                        <select oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required name="produk">
                          <option value="">- Pilih -</option>
                          <?php foreach($produk as $p): ?>
                          <option><?=$p['nama']?></option>
                          <?php endforeach ?>
                        </select>
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
                        <label>Tanggal</label>
                        <div class="input-group mb-3">
                          <input type="date" name="tanggal" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
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


