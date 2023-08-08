<?php 
    $current = "data produksi";
    require_once '../layouts/header.php';

    $produk = get("tb_produk");

    if(isset($_POST["create"])){
        unset($_POST["create"]);
        $fail = [];
        $produksi_bahan_baku = getBy('tb_produksi_bahan_baku',['produk'=>$_POST['produk']]);
        foreach($produksi_bahan_baku as $b)
        {
            $bahan_baku = getBy('tb_bahan_baku',['nama_bahan_baku'=>$b['bahan_baku']])[0];
            $jumlah = $_POST['jumlah'];
            if($bahan_baku['stok']  < $jumlah)
            {
                $bahan_baku['dibutuhkan'] = $jumlah - $bahan_baku['stok'];
                $fail[] = $bahan_baku;
            }
        }
        if(empty($fail))
        {
            $produksi_bahan_baku = getBy('tb_produksi_bahan_baku',['produk'=>$_POST['produk']]);
            foreach($produksi_bahan_baku as $b)
            {
                $bahan_baku = getBy('tb_bahan_baku',['nama_bahan_baku'=>$b['bahan_baku']])[0];
                $jumlah = $_POST['jumlah'];
                $bahan_baku['stok'] = $bahan_baku['stok'] - $jumlah;
                update("tb_bahan_baku",$bahan_baku,$bahan_baku['id']);
            }

            $_produk = getBy("tb_produk",['nama'=>$_POST['produk']])[0];
            $_produk['jumlah'] += $_POST['jumlah'];
            update('tb_produk',$_produk,$_produk['id']);

            $res = insert("tb_produksi",$_POST);
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
            <h1 class="m-0 text-dark">Tambah Produksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/produksi/index.php">Produksi</a></li>              
              <li class="breadcrumb-item active">Tambah Produksi</li>
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
                <?php if(!empty($fail)): ?>
                <div class="alert alert-danger">
                    <b>Terdapat Pupuk yang Kekurangan Stok</b>
                    <ul>
                        <?php foreach($fail as $b): ?>
                        <li><?=$b['nama_bahan_baku']?> (Stok : <?=$b['stok']?> Ton, Dibutuhkan <?=$b['dibutuhkan']?> Ton)</li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <?php endif ?>
                <form method="post">
                    <input type="hidden" name="status" value="produksi">
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


