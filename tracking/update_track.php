<?php
$current = "Tracking";

require_once '../db.php';
$lokasi = $_POST['lokasi_barang'];
$id_order = $_POST['id_order'];

$update = $conn->query("UPDATE tb_order SET lokasi_barang='$lokasi' WHERE id='$id_order' ");
if ($update) {
    echo "<script>
    window.location=history.go(-1);
    </script>";
}
