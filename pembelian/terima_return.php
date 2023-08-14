<?php
include '../db.php';
session_start();
$id_transaksi  = $_GET['id_transaksi'];
$status  = $_GET['status'];
if (isset($_SESSION['jumlahbeli'])) {
    $jumlahbeli = $_SESSION['jumlahbeli'];
    // set status
    if ($status == 7) {
        $setStatus = mysqli_query($conn, "update tb_pembelian set keterangan='return ditolak' where id='$id_transaksi'");
    } elseif ($status == 8) {
        $setStatus = mysqli_query($conn, "update tb_pembelian set keterangan='return diterima' where id='$id_transaksi'");

        $updatestock = mysqli_query($conn, "
        UPDATE tb_pembelian
        join tb_bahan_baku on tb_pembelian.nama_bahan_baku = tb_bahan_baku.nama_bahan_baku
        JOIN tb_return_adsup ON tb_pembelian.id = tb_return_adsup.id_pembelian
        SET tb_bahan_baku.stok = tb_bahan_baku.stok - tb_return_adsup.jumlah_return
        WHERE tb_pembelian.id = '$id_transaksi'");
    }
}


header("location:index.php");
