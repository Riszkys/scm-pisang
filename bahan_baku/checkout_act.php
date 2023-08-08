<?php 
include '../db.php';

session_start();

$id_konsumen = $_SESSION['user']['id'];

date_default_timezone_set('Asia/Jakarta');

$tanggal = date('Y-m-d');

$hp = $_POST['hp'];
$alamat = $_POST['alamat'];
$total_bayar = $_POST['total_bayar'];

mysqli_query($conn,"insert into tb_transaksi values(NULL,'$id_konsumen','$alamat','$hp','$total_bayar','0','','$tanggal')")or die(mysqli_error($con));

$last_id = mysqli_insert_id($conn);

// transaksi
$id_transaksi = $last_id;

$jumlah_isi_keranjang = count($_SESSION['keranjang']);

for($a = 0; $a < $jumlah_isi_keranjang; $a++){
	$id_produk = $_SESSION['keranjang'][$a]['produk'];

	$isi = mysqli_query($conn,"select * from tb_bahan_baku where id='$id_produk'");
	$i = mysqli_fetch_assoc($isi);

	$produk = $i['id'];
	$stok= $i['stok'];
	$jumlah = $_SESSION['keranjang'][$a]['jumlah'];
	$sisa = $stok-$jumlah;
    $harga = $i['harga'];
	$insert = mysqli_query($conn,"insert into tb_transaksi_detail values(NULL,'$id_transaksi','$produk','$jumlah','$harga')");
	if($insert){
		//update stok
		mysqli_query($conn, "update tb_bahan_baku set stok='$sisa' where id='$produk'");
		?>
		<?php								
	}
	unset($_SESSION['keranjang'][$a]);
}

header("location:customer_pesanan.php?alert=sukses");