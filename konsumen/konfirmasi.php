<?php
include '../db.php';
session_start();
if (isset($_GET['konfirmasi'])) {
    $idKonsumen = $_GET['konfirmasi'];
    $query = "UPDATE tb_konsumen SET status_reg = 'Dikonfirmasi' WHERE id = $idKonsumen";
    mysqli_query($conn, $query);
    // Redirect back to the page after confirmation
    header("Location: index.php");
    exit();
}
