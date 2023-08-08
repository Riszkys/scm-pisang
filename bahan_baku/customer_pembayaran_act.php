<?php 
include '../db.php';

$id = $_POST['id'];

$rand = rand();
$allowed =  array('png','jpg','jpeg');

$filename = $_FILES['bukti']['name'];

$ext = pathinfo($filename, PATHINFO_EXTENSION);

if(in_array($ext,$allowed) ) {

	$file_gambar = $rand.'.'.$ext;

	move_uploaded_file($_FILES['bukti']['tmp_name'], 'bukti/'.$file_gambar);

	// hapus gambar lama
	$lama = mysqli_query($conn, "select * from tb_transaksi where id='$id'");
	$l = mysqli_fetch_assoc($lama);

	$foto = $l['bukti'];
    if($foto != ""){
        unlink("bukti/.$foto");
    }else{
        mysqli_query($conn,"update tb_transaksi set bukti='$file_gambar', status='1' where id='$id'")or die(mysqli_error($con));
	    header("location:customer_pesanan.php?alert=upload");
    }
}else{
	header("location:customer_pesanan.php?alert=gagal");
}