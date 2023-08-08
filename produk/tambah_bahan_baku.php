<?php 
    $current = "data produk";
    require_once '../layouts/header.php';

    $bahan_baku = get("tb_bahan_baku");
    $produk = single("tb_produk",$_GET['id']);

    if(isset($_POST["create"])){
        unset($_POST["create"]);
        $res = insert("tb_produksi_bahan_baku",$_POST);
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
            <h1 class="m-0 text-dark">Tambah Pisang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/produk/index.php">Pisang</a></li>              
              <li class="breadcrumb-item"><a href="/produk/bahan_baku.php?id=<?=$_GET['id']?>"><?=$produk['nama']?></a></li>              
              <li class="breadcrumb-item active">Tambah Pisang</li>
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
                    <input type="hidden" name="produk" value="<?=$produk['nama']?>">
                    <div class="form-group">
                        <label>Produk</label>
                        <select oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required name="bahan_baku">
                          <option value="">- Pilih -</option>
                          <?php foreach($bahan_baku as $b): ?>
                          <option><?=$b['nama_bahan_baku']?></option>
                          <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <div class="input-group mb-3*">
                          <input type="number" name="jumlah" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">Kg</span>
                          </div>
                        </div>
                    </div>
                    <button class="btn btn-success" name="create">Tambah</button>
                    <a href="bahan_baku.php?id=<?=$_GET['id']?>" class="btn btn-warning">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once '../layouts/footer.php';
?>


