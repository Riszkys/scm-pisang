<?php $current == "dashboard" || $current == "login" ? require_once 'functions.php' : require_once '../functions.php';
if ($current != "login") {
  if (!isset($_SESSION['user'])) {
    header("location:login.php");
  }
}

?>
<?php
//admin
$cek_status = $conn->query("SELECT * FROM tb_pembelian JOIN tb_supplier ON tb_pembelian.id_supplier=tb_supplier.id JOIN tb_order ON tb_pembelian.id_order=tb_order.id WHERE keterangan='diterima' AND tb_order.status='2' ORDER BY tb_pembelian.id DESC");
$jumlah_notif = $cek_status->num_rows;
//supplier
$id_supplier = $_SESSION["user"]["id"];
$supplier_status = $conn->query("SELECT * FROM tb_pembelian JOIN tb_supplier ON tb_pembelian.id_supplier=tb_supplier.id JOIN tb_order ON tb_pembelian.id_order=tb_order.id WHERE tb_pembelian.id_supplier='$id_supplier' AND keterangan='checkout' OR keterangan='diterima' ORDER BY tb_pembelian.id DESC");
$jumlah_notif_supplier = $supplier_status->num_rows;

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PT. Hijau Surya Biotechindo</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $current == "dashboard" || $current == "login" ? "plugins/fontawesome-free/css/all.min.css" : '../plugins/fontawesome-free/css/all.min.css'; ?> ">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $current == "dashboard" || $current == "login" ? "dist/css/adminlte.min.css" : "../dist/css/adminlte.min.css"  ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= $current == "dashboard" || $current == "login" ? "plugins/overlayScrollbars/css/OverlayScrollbars.min.css" : '../plugins/overlayScrollbars/css/OverlayScrollbars.min.css'; ?> ">
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= $current == "dashboard" || $current == "login" ? "plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" : "../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" ?>">
  <link rel="stylesheet" href="<?= $current == "dashboard" || $current == "login" ? "plugins/datatables-responsive/css/responsive.bootstrap4.min.css" : "../plugins/datatables-responsive/css/responsive.bootstrap4.min.css" ?>">

  <style>
    .hh-grayBox {
      background-color: #F8F8F8;
      margin-bottom: 20px;
      padding: 35px;
      margin-top: 20px;
    }

    .pt45 {
      padding-top: 45px;
    }

    .order-tracking {
      text-align: center;
      width: 20%;
      position: relative;
      display: block;
    }

    .order-tracking .is-complete {
      display: block;
      position: relative;
      border-radius: 50%;
      height: 30px;
      width: 30px;
      border: 0px solid #AFAFAF;
      background-color: #f7be16;
      margin: 0 auto;
      transition: background 0.25s linear;
      -webkit-transition: background 0.25s linear;
      z-index: 2;
    }

    .order-tracking .is-complete:after {
      display: block;
      position: absolute;
      content: '';
      height: 14px;
      width: 7px;
      top: -2px;
      bottom: 0;
      left: 5px;
      margin: auto 0;
      border: 0px solid #AFAFAF;
      border-width: 0px 2px 2px 0;
      transform: rotate(45deg);
      opacity: 0;
    }

    .order-tracking.completed .is-complete {
      border-color: #27aa80;
      border-width: 0px;
      background-color: #27aa80;
    }

    .order-tracking.completed .is-complete:after {
      border-color: #fff;
      border-width: 0px 3px 3px 0;
      width: 7px;
      left: 11px;
      opacity: 1;
    }

    .order-tracking p {
      color: #A4A4A4;
      font-size: 16px;
      margin-top: 8px;
      margin-bottom: 0;
      line-height: 20px;
    }

    .order-tracking p span {
      font-size: 14px;
    }

    .order-tracking.completed p {
      color: #000;
    }

    .order-tracking::before {
      content: '';
      display: block;
      height: 3px;
      width: calc(100% - 40px);
      background-color: #f7be16;
      top: 13px;
      position: absolute;
      left: calc(-50% + 20px);
      z-index: 0;
    }

    .order-tracking:first-child:before {
      display: none;
    }

    .order-tracking.completed:before {
      background-color: #27aa80;
    }

    [class*="sidebar-dark-"] {
      background: -webkit-linear-gradient(bottom, #000000, #000000);
      background: -o-linear-gradient(bottom, #000000, #000000);
      background: -moz-linear-gradient(bottom, #000000, #000000);
      background: linear-gradient(bottom, #000000, #000000);
    }

    [class*="sidebar-dark-"] .sidebar a {
      color: white;
    }

    .content-wrapper {
      background: url('');
    }

    .content-wrapper {
      background: url('');
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->

      </ul>
      <!-- Right navbar links -->
      <?php if ($_SESSION["user"]["level"] == "admin") : ?>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown mr-5">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-primary navbar-badge"><?= $jumlah_notif ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header"><?= $jumlah_notif ?> Notifications</span>
              <div class="dropdown-divider"></div>
              <?php foreach ($cek_status as $c => $cc) : ?>
                <a href="/pembelian/index.php" class="dropdown-item">
                  <i class="fas fa-envelope mr-2"></i><?php echo ucfirst($cc['nama_supplier']) . '/' . $cc['tanggal'] ?>
                  <span class="float-right badge badge-danger"><?= $cc['lokasi_barang'] ?></span>
                </a>
              <?php endforeach; ?>

            </div>
          </li>
        </ul>
      <?php endif; ?>
      <?php if ($_SESSION["user"]["level"] == "konsumen") : ?>
        <?php
        // 
        if (isset($_SESSION['keranjang'])) {
          $jumlah_isi_keranjang = count($_SESSION['keranjang']);
        } else {
          $jumlah_isi_keranjang = 0;
        }
        ?>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown mr-5">
            <a class="nav-link" href="keranjang.php">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
              <span class="badge badge-primary navbar-badge"><?= $jumlah_isi_keranjang ?></span>
            </a>
          </li>
        </ul>
      <?php endif; ?>

      <?php if ($_SESSION["user"]["level"] == "supplier") : ?>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown mr-5">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-primary navbar-badge">
                <?= $jumlah_notif_supplier ?>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header"><?= $jumlah_notif_supplier ?> Notifications</span>
              <div class="dropdown-divider"></div>
              <?php foreach ($supplier_status as $e => $ee) : ?>
                <?php if ($ee['status'] == 0 && $ee['keterangan'] == 'checkout') : ?>
                  <a href="/pembelian/index.php" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> Notif Pembelian
                    <span class="float-right badge badge-primary"><?= $ee['keterangan'] ?></span>
                  </a>
                <?php endif; ?>
                <?php if ($ee['status'] == 0 && $ee['keterangan'] == 'diterima') : ?>
                  <a href="/pembelian/index.php" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> Diterima
                    <span class="float-right badge badge-primary">menunggu upload bukti</span>
                  </a>
                <?php endif; ?>
                <?php if ($ee['status'] == 1 && $ee['keterangan'] == 'diterima') : ?>
                  <a href="/pembelian/index.php" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>Supplier : <?php echo ucfirst($ee['nama_supplier']) ?>
                    <span class="float-right badge badge-primary">cek bukti bayar</span>
                  </a>
                <?php endif; ?>
                <?php if ($ee['status'] == 2 && $ee['keterangan'] == 'diterima') : ?>
                  <a href="/pembelian/index.php" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>Pesanan
                    <span class="float-right badge badge-primary">tunggu konfirmasi diterima</span>
                  </a>
                <?php endif; ?>
                <?php if ($ee['status'] == 2 && $ee['keterangan'] == 'selesai') : ?>
                  <a href="/pembelian/index.php" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>pesanan <?= $ee['tanggal'] ?>
                    <span class="float-right badge badge-success"><?= $ee['keterangan'] ?></span>
                  </a>
                <?php endif; ?>
              <?php endforeach; ?>

            </div>
          </li>
        </ul>
      <?php endif; ?>

      <!-- SEARCH FORM -->
      <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">PT. Hijau Surya Biotechindo</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../images/hsb.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $_SESSION['user']['username'] ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <?php $baseHref = ($current == "dashboard") ? "index.php" : "../index.php"; ?>
              <a href="<?= $baseHref ?>" class="nav-link <?= $current == "dashboard" ? "active" : "" ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-columns-gap" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M6 1H1v3h5V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12h-5v3h5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8H1v7h5V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6h-5v7h5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z" />
                </svg>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <?php if ($_SESSION["user"]["level"] == "admin") : ?>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "bahan_baku/index.php" : "../bahan_baku/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pisang" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-archive" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 5v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V5h1v7.5c0 1.345-1.021 2.5-2.357 2.5H3.357C2.021 15 1 13.845 1 12.5V5h1z" />
                    <path fill-rule="evenodd" d="M5.5 7.5A.5.5 0 0 1 6 7h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5zM15 2H1v2h14V2zM1 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H1z" />
                  </svg>
                  Data Pisang
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "supplier/index.php" : "../supplier/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data supplier" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                  </svg>
                  Supplier
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "pemesanan/index.php" : "../pemesanan/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pemesanan" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                  </svg>
                  Pemesanan
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "tracking/index.php" : "../tracking/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data tracking" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                  </svg>
                  Tracking Order
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "pembelian/index.php" : "../pembelian/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pembelian" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                    <path fill-rule="evenodd" d="M10.854 7.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 10.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Pembelian
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "produk/index.php" : "../produk/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data produk" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-journal-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 1h5v1H4a1 1 0 0 0-1 1H2a2 2 0 0 1 2-2zm10 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V8h1zM2 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2z" />
                    <path fill-rule="evenodd" d="M15.854 2.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 4.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Barang Masuk
                </a>
              </li>

              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "produksi/index.php" : "../produksi/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data produksi" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-journal-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 1h5v1H4a1 1 0 0 0-1 1H2a2 2 0 0 1 2-2zm10 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V8h1zM2 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2z" />
                    <path fill-rule="evenodd" d="M15.854 2.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 4.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Barang Keluar
                </a>
              </li>

              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "penjualan/index.php" : "../penjualan/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data penjualan" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-journal-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 1h5v1H4a1 1 0 0 0-1 1H2a2 2 0 0 1 2-2zm10 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V8h1zM2 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2z" />
                    <path fill-rule="evenodd" d="M15.854 2.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 4.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Penjualan
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "konsumen/index.php" : "../konsumen/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data konsumen" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                  </svg>
                  Konsumen
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "transaksi/index.php" : "../transaksi/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data transaksi" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                  </svg>
                  Data Transaksi
                </a>
              </li>
            <?php elseif ($_SESSION["user"]["level"] == "pimpinan") : ?>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "bahan_baku/index.php" : "../bahan_baku/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pisang" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-archive nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 5v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V5h1v7.5c0 1.345-1.021 2.5-2.357 2.5H3.357C2.021 15 1 13.845 1 12.5V5h1z" />
                    <path fill-rule="evenodd" d="M5.5 7.5A.5.5 0 0 1 6 7h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5zM15 2H1v2h14V2zM1 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H1z" />
                  </svg>
                  Data Pisang
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "supplier/index.php" : "../supplier/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data supplier" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                  </svg>
                  Supplier
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "pemesanan/index.php" : "../pemesanan/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pemesanan" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                  </svg>
                  Pemesanan
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "tracking/index.php" : "../tracking/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data tracking" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                  </svg>
                  Tracking Order
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "pembelian/index.php" : "../pembelian/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pembelian" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                    <path fill-rule="evenodd" d="M10.854 7.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 10.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Pembelian
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "produk/index.php" : "../produk/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data produk" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-journal-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 1h5v1H4a1 1 0 0 0-1 1H2a2 2 0 0 1 2-2zm10 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V8h1zM2 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2z" />
                    <path fill-rule="evenodd" d="M15.854 2.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 4.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Barang Masuk
                </a>
              </li>

              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "produksi/index.php" : "../produksi/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data produksi" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-journal-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 1h5v1H4a1 1 0 0 0-1 1H2a2 2 0 0 1 2-2zm10 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V8h1zM2 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2z" />
                    <path fill-rule="evenodd" d="M15.854 2.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 4.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Barang Keluar
                </a>
              </li>

              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "penjualan/index.php" : "../penjualan/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data penjualan" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-journal-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 1h5v1H4a1 1 0 0 0-1 1H2a2 2 0 0 1 2-2zm10 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V8h1zM2 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2z" />
                    <path fill-rule="evenodd" d="M15.854 2.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 4.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Penjualan
                </a>
              </li>

            <?php elseif ($_SESSION["user"]["level"] == "supplier") : ?>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "bahan_baku/index.php" : "../bahan_baku/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pisang" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-archive nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 5v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V5h1v7.5c0 1.345-1.021 2.5-2.357 2.5H3.357C2.021 15 1 13.845 1 12.5V5h1z" />
                    <path fill-rule="evenodd" d="M5.5 7.5A.5.5 0 0 1 6 7h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5zM15 2H1v2h14V2zM1 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H1z" />
                  </svg>
                  Data Pisang
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "pembelian/index.php" : "../pembelian/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pembelian" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                    <path fill-rule="evenodd" d="M10.854 7.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 10.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Pembelian
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "tracking/track_supplier.php" : "../tracking/track_supplier.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data tracking" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                  </svg>
                  Tracking Pembelian
                </a>
              </li>

              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "pembelian/faktur.php" : "../pembelian/faktur.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "faktur pembelian" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-journal-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 1h5v1H4a1 1 0 0 0-1 1H2a2 2 0 0 1 2-2zm10 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V8h1zM2 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H2z" />
                    <path fill-rule="evenodd" d="M15.854 2.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 4.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                  </svg>
                  Faktur Pembelian
                </a>
              </li>

            <?php elseif ($_SESSION["user"]["level"] == "konsumen") : ?>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "bahan_baku/index.php" : "../bahan_baku/index.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pupuk" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-archive nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 5v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V5h1v7.5c0 1.345-1.021 2.5-2.357 2.5H3.357C2.021 15 1 13.845 1 12.5V5h1z" />
                    <path fill-rule="evenodd" d="M5.5 7.5A.5.5 0 0 1 6 7h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5zM15 2H1v2h14V2zM1 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H1z" />
                  </svg>
                  Data Pisang
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "bahan_baku/customer_pesanan.php" : "../bahan_baku/customer_pesanan.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data pembelian" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-archive nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 5v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V5h1v7.5c0 1.345-1.021 2.5-2.357 2.5H3.357C2.021 15 1 13.845 1 12.5V5h1z" />
                    <path fill-rule="evenodd" d="M5.5 7.5A.5.5 0 0 1 6 7h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5zM15 2H1v2h14V2zM1 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H1z" />
                  </svg>
                  Data Pembelian
                </a>
              </li>
              <li class="nav-item">
                <?php $baseHref = ($current == "dashboard") ? "bahan_baku/tracking.php" : "../bahan_baku/tracking.php"; ?>
                <a href="<?= $baseHref ?>" class="nav-link <?= $current == "data tracking" ? "active" : "" ?>">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi nav-icon bi-bag" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                  </svg>
                  Tracking Pembelian
                </a>
              </li>

            <?php endif ?>
            <li class="nav-item">
              <?php $baseHref = ($current == "dashboard") ? "logout.php" : "../logout.php"; ?>
              <a href="<?= $baseHref ?>" class="nav-link">
                <svg class="bi nav-icon bi-arrow-bar-left" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L3.207 8l2.647-2.646a.5.5 0 0 0 0-.708z" />
                  <path fill-rule="evenodd" d="M10 8a.5.5 0 0 0-.5-.5H3a.5.5 0 0 0 0 1h6.5A.5.5 0 0 0 10 8zm2.5 6a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 1 0v11a.5.5 0 0 1-.5.5z" />
                </svg>
                Logout
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">