<?php
include '../db.php';
$id_transaksi  = $_GET['id_transaksi'];
$status  = $_GET['status'];

// echo "\"update tb_order set status='$status' where id='$id_transaksi'\"";

$setStatus = mysqli_query($conn, "update tb_order set status='$status' where id='$id_transaksi'");

if ($setStatus) {
    header("location:index.php");
}