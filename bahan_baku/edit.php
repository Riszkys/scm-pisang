<?php 
    $current = "data bahan baku";
    require_once '../layouts/header.php';

    $bahan_baku = single("tb_bahan_baku",$_GET['id']);
    $suppliers = get("tb_supplier");

    if(isset($_POST["edit"])){
        unset($_POST["edit"]);
        $rand = rand();
        $allowed =  array('gif','png','jpg','jpeg');
        $filename = $_FILES['gambar']['name'];

        if($filename != ""){
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if(in_array($ext,$allowed) ) {
              move_uploaded_file($_FILES['gambar']['tmp_name'], 'upload/'.$rand.'_'.$filename);
              $file_gambar = $rand.'_'.$filename;
              $_POST['gambar'] = $file_gambar;
          }
        }else{
          $_POST['gambar'] = $bahan_baku['gambar'];
        }
        $res = update("tb_bahan_baku",$_POST,$_GET['id']);
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
            <h1 class="m-0 text-dark">Edit Data Pupuk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/bahan_baku/index.php">Data Pupuk</a></li>              
              <li class="breadcrumb-item active">Edit Data Pupuk</li>
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
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" disabled value="<?=$bahan_baku['id']?>" class="form-control" required>
                    <div class="form-group">
                        <label>Supplier</label>
                        <select name="supplier_id" class="form-control">
                            <?php foreach($suppliers as $supplier): ?>
                                <?php if($bahan_baku['supplier_id'] == $supplier['id']) : ?>
                                    <option value="<?=$supplier['id']?>" selected><?=$supplier['nama_supplier']?></option>
                                <?php else: ?>
                                    <option value="<?=$supplier['id']?>"><?=$supplier['nama_supplier']?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Pupuk</label>
                        <input type="text" name="nama_bahan_baku" value="<?=$bahan_baku['nama_bahan_baku']?>" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"></span>
                          </div>
                          <input type="number" name="stok" value="<?=$bahan_baku['stok']?>" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">sisir</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Stok Minimal</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"></span>
                          </div>
                          <input type="number" name="min_stok" value="<?=$bahan_baku['min_stok']?>" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">sisir</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                          </div>
                          <input type="number" name="harga" value="<?=$bahan_baku['harga']?>" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" value="<?=$bahan_baku['keterangan']?>" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                        <img src="upload/<?=$bahan_baku['gambar']?>" alt="" height="100">
                    </div>
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


