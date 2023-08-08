<?php
session_start();
include "../db.php";
$id_transaksi = $_GET['id'];
$id_user = $_SESSION['user']['id'];
// ambil data transaksi
$transaksi = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE id='$id_transaksi'");
$trx = mysqli_fetch_assoc($transaksi);

// update status ke Selesai
$update = "Update tb_transaksi set status='5' where id='$id_transaksi'";
$hasil = mysqli_query($conn,$update);

if ($hasil){
header("Location: customer_pesanan.php?alert=selesai");
}

?>