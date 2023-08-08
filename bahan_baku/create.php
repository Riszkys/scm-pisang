<?php 
    $current = "data bahan baku";
    require_once '../layouts/header.php';

    $suppliers = get("tb_supplier");

    if(isset($_POST["create"])){
        unset($_POST["create"]);
        // $res = insert("tb_bahan_baku",$_POST);
        // $supplier_id = $_POST['supplier_id'];
        // $nama_bahan_baku = $_POST['nama_bahan_baku'];
        // $harga = $_POST['harga'];
        // $stok = $_POST['stok'];
        // $min_stok = $_POST['min_stok'];
        // $total = 0;
        // $keterangan = $_POST['keterangan'];
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
          $_POST['gambar'] = $filename;
        }
        // $res = $conn->query("INSERT INTO tb_bahan_baku(supplier_id,nama_bahan_baku,harga,stok,min_stok,total,keterangan) VALUE ('$supplier_id','$nama_bahan_baku','$harga','$stok','$min_stok','$total','$keterangan')");
        $res = insert("tb_bahan_baku",$_POST);
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
            <h1 class="m-0 text-dark">Tambah Data Pisang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/bahan_baku/index.php">Data Pisang</a></li>              
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
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Supplier</label>
                        <select name="supplier_id" class="form-control">
                            <option value="-" disabled selected> - Pilih Supplier - </option>
                            <?php foreach($suppliers as $supplier): ?>
                                <option value="<?=$supplier['id']?>"><?=$supplier['nama_supplier']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Pisang</label>
                        <input type="text" name="nama_bahan_baku" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"></span>
                          </div>
                          <input type="number" name="stok" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">Sisir</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Stok Minimal</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"></span>
                          </div>
                          <input type="number" name="min_stok" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">Sisir</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                          </div>
                          <input type="number" name="harga" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
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


