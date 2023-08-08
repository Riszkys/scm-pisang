<?php 
    $current = "data pemesanan";
    require_once '../layouts/header.php';

    if(isset($_POST["create"])){
        unset($_POST["create"]);
        $bahan_baku = single("tb_bahan_baku",$_POST['bahan_baku']);
        $_POST['nama_bahan_baku'] = $bahan_baku['nama_bahan_baku'];
        $_POST['id_supplier'] = $bahan_baku['supplier_id'];
        unset($_POST['bahan_baku']);
        $res = insert("tb_pemesanan",$_POST);
        if($res){
            $success = true;
        }else{
            $failed = true;
        }
    }

    $bahan = get('tb_bahan_baku');
    $harga = 0;
?>

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Pemesanan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/pemesanan/index.php">Pemesanan</a></li>              
              <li class="breadcrumb-item active">Tambah Pemesanan</li>
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
                        <label>Nama Pisang</label>
                        <div id="bahan-baku" style="display:none;">
                            <?= json_encode($bahan) ?>
                        </div>
                        <select name="bahan_baku" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" onchange="showPrice(event)">
                            <option value="">- Pilih Pisang -</option>
                            <?php foreach($bahan as $bahan_baku): $harga = isset($_GET['bahan_baku']) && $_GET['bahan_baku'] == $bahan_baku['nama_bahan_baku'] ? $bahan_baku['harga'] : $harga; ?>
                                <option value="<?=$bahan_baku['id']?>" <?=isset($_GET['bahan_baku']) && $_GET['bahan_baku'] == $bahan_baku['nama_bahan_baku'] ? 'selected=""' : ''?>><?=$bahan_baku['nama_bahan_baku']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"></span>
                          </div>
                          <input type="number" name="jumlah" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
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
                          <input type="number" name="harga" value="<?=$harga?>" id="price" readonly oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                    </div>
                    <!-- <div class="form-group"> -->
                        <!-- <label>Keterangan</label> -->
                        <input type="hidden" name="keterangan" value="pesan" oninvalid="setCustomValidity('Field ini harus di isi')" oninput="setCustomValidity('')" class="form-control" required>
                    <!-- </div> -->
                    <button class="btn btn-success" name="create">Tambah</button>
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showPrice(e){
        let bahan = JSON.parse(document.querySelector("#bahan-baku").innerHTML)
        let name = e.target.value
        let bb = bahan.filter(b=>b.id == name)[0]
        let price = document.querySelector("#price")
        price.value = bb.harga
    }
</script>


<?php
    require_once '../layouts/footer.php';
?>



