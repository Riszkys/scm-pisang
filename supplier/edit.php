<?php 
    $current = "data supplier";
    require_once '../layouts/header.php';

    $supplier = single("tb_supplier",$_GET['id']);

    if(isset($_POST["edit"])){
        unset($_POST["edit"]);
        $res = update("tb_supplier",$_POST,$_GET['id']);
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
            <h1 class="m-0 text-dark">Edit Supplier</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/supplier/index.php">Supplier</a></li>              
              <li class="breadcrumb-item active">Edit Supplier</li>
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
                    <input type="hidden" name="id" class="form-control" value="<?=$supplier['id']?>" readonly>
                    <div class="form-group">
                        <label>Nama Supplier</label>
                        <input type="text" name="nama_supplier" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$supplier['nama_supplier']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="3" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control"><?=$supplier['alamat']?></textarea>
                    </div>
                    <div class="form-group">
                        <label>No Handphone</label>
                        <input type="tel" maxlength="12" pattern="^(?=.*[0-9]).{12,}$" name="no_handphone" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$supplier['no_handphone']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$supplier['username']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$supplier['email']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$supplier['password']?>"required>
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


