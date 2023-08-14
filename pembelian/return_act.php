<?php
include '../db.php';

$id_pembelian = $_POST['id_pembelian'];
$id_supplier = $_POST['id_supplier'];
$alasan = $_POST['alasan'];
$jumlah_return = $_POST['jumlah_return'];

$rand = rand();
$allowed =  array('png', 'jpg', 'jpeg');

$filename = $_FILES['bukti']['name'];

$ext = pathinfo($filename, PATHINFO_EXTENSION);

$query = "INSERT INTO tb_return_adsup (id_supplier, id_pembelian, tanggal_return, alasan_return, jumlah_return) 
          VALUES ('$id_supplier', '$id_pembelian', NOW(), '$alasan', '$jumlah_return')";
mysqli_query($conn, $query);

$queryupdate = "update  `tb_order` set status = '3' where id = $id_pembelian";
mysqli_query($conn, $queryupdate);

$queryupdate = "update  `tb_pembelian` set keterangan = 'return' where id = $id_pembelian";
mysqli_query($conn, $queryupdate);

if (in_array($ext, $allowed)) {

	$file_gambar = $rand . '.' . $ext;

	move_uploaded_file($_FILES['bukti']['tmp_name'], '../bahan_baku/bukti_return/' . $file_gambar);

	// hapus gambar lama
	$lama = mysqli_query($conn, "select * from tb_return_adsup where id_pembelian ='$id_pembelian'");
	$l = mysqli_fetch_assoc($lama);

	$foto = $l['gambar'];
	if ($foto != "") {
		unlink("../bahan_baku/bukti_return/.$foto");
	} else {
		mysqli_query($conn, "update tb_return_adsup set gambar ='$file_gambar' where id_pembelian ='$id_pembelian'") or die(mysqli_error($conn));
		header("location:index.php");
	}
} else {
	header("location:index.php");
}
