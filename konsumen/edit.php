<?php 
    $current = "data konsumen";
    require_once '../layouts/header.php';

    $konsumen = single("tb_konsumen",$_GET['id']);

    if(isset($_POST["edit"])){
        unset($_POST["edit"]);
        $res = update("tb_konsumen",$_POST,$_GET['id']);
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
            <h1 class="m-0 text-dark">Edit konsumen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/konsumen/index.php">konsumen</a></li>              
              <li class="breadcrumb-item active">Edit konsumen</li>
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
                    <input type="hidden" name="id" class="form-control" value="<?=$konsumen['id']?>" readonly>
                    <div class="form-group">
                        <label>Nama konsumen</label>
                        <input type="text" name="nama_konsumen" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$konsumen['nama_konsumen']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="3" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control"><?=$konsumen['alamat']?></textarea>
                    </div>
                    <div class="form-group">
                        <label>No Handphone</label>
                        <input type="tel" maxlength="12" pattern="^(?=.*[0-9]).{12,}$" name="no_handphone" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$konsumen['no_handphone']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$konsumen['username']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$konsumen['email']?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" value="<?=$konsumen['password']?>"required>
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


