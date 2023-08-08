<?php
include '../db.php';

$id_pembelian = $_POST['id_pembelian'];
$id_konsumen = $_POST['id_konsumen'];
$alasan = $_POST['alasan'];

$rand = rand();
$allowed =  array('png', 'jpg', 'jpeg');

$filename = $_FILES['bukti']['name'];

$ext = pathinfo($filename, PATHINFO_EXTENSION);

$query = "INSERT INTO tb_return (id_konsumen, id_pembelian, tanggal_return, alasan_return) 
          VALUES ('$id_konsumen', '$id_pembelian', NOW(), '$alasan')";
mysqli_query($conn, $query);

$queryupdate = "update  `tb_transaksi` set status = '6' where id = $id_pembelian";
mysqli_query($conn, $queryupdate);

if (in_array($ext, $allowed)) {

	$file_gambar = $rand . '.' . $ext;

	move_uploaded_file($_FILES['bukti']['tmp_name'], 'bukti_return/' . $file_gambar);

	// hapus gambar lama
	$lama = mysqli_query($conn, "select * from tb_return where id_pembelian ='$id_pembelian'");
	$l = mysqli_fetch_assoc($lama);

	$foto = $l['gambar'];
	if ($foto != "") {
		unlink("bukti_return/.$foto");
	} else {
		mysqli_query($conn, "update tb_return set gambar ='$file_gambar' where id_pembelian ='$id_pembelian'") or die(mysqli_error($conn));
		header("location:customer_pesanan.php?alert=return");
	}
} else {
	header("location:customer_pesanan.php?alert=gagal");
}
