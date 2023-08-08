<?php 
    $current = "Keranjang";
    
    require_once '../qb.php';

    require_once '../layouts/header.php';

?>
<style>

.text-print{
    display: none;
}

@media print{
    body  {
        visibility: hidden;
    }

    .hide-print, .dataTables_paginate.paging_simple_numbers {
        display: none;
    }

    .text-print{
        display: block;
    }

    #print {
        visibility: visible;
        position: fixed;
        top:0;
        left:0;
        width: 100%;
    }
}

</style>
<form method="post" action="keranjang_update.php">
<div class="container">
	<!-- HERO SECTION-->
	<section class="py-5 bg-light">
		<div class="container">
		<div class="row px-4 px-lg-5 py-lg-4 align-items-center">
			<div class="col-lg-6">
			<h1 class="h2 text-uppercase mb-0">Keranjang</h1>
			</div>
			<div class="col-lg-6 text-lg-right">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb justify-content-lg-end mb-0 px-0">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Keranjang</li>
				</ol>
			</nav>
			</div>
		</div>
		</div>
	</section>

	<section class="py-5">
		<div class="row">
		<div class="col-lg-8 mb-4 mb-lg-0">
			<?php 
            if(isset($_SESSION['keranjang'])){

                $jumlah_isi_keranjang = count($_SESSION['keranjang']);

                if($jumlah_isi_keranjang != 0){
                ?>
			<!-- CART TABLE-->
			<div class="table-responsive mb-4">
			<table class="table">
				<thead class="bg-light">
				<tr>
					<th class="border-0" scope="col"> <strong class="text-small text-uppercase">Produk</strong></th>
					<th class="border-0" scope="col"> <strong class="text-small text-uppercase">Harga</strong></th>
					<th class="border-0" scope="col"> <strong class="text-small text-uppercase">Kuantitas</strong></th>
					<th class="border-0" scope="col"> <strong class="text-small text-uppercase">Total</strong></th>
					<th class="border-0" scope="col"> </th>
					<th class="border-0" scope="col"> </th>
				</tr>
				</thead>
				<tbody>
				<?php
				// cek apakah produk sudah ada dalam keranjang
				$jumlah_total = 0;
				$total = 0;
				for($a = 0; $a < $jumlah_isi_keranjang; $a++){
					$id_produk = $_SESSION['keranjang'][$a]['produk'];
					$jml = $_SESSION['keranjang'][$a]['jumlah'];

					$isi = mysqli_query($conn,"select * from tb_bahan_baku where id='$id_produk'");
					$i = mysqli_fetch_assoc($isi);
					// harga dipotong diskon
					$harga = $i['harga'];
						if($jml > $i['stok']){
							echo "<script type='text/javascript'>";
									echo "alert('Stok tidak mencukupi');";	
							echo "</script>";
							$jml = $i['stok'];
							$total = $harga * $jml;
						}else{
							$total = $harga * $jml;
						}
					$jumlah_total += $total;
					?>
				<tr>
					<th class="pl-0 border-light" scope="row">
					<div class="media align-items-center"><a class="reset-anchor d-block animsition-link" href="detail.php?id=<?= $id_produk; ?>"><img src="upload/<?= $i['gambar'] ?>" alt="..." width="50"/></a>
						<div class="media-body ml-3"><strong class="h6"><a class="reset-anchor animsition-link" href="detail.php?id=<?= $id_produk; ?>"><?= $i['nama_bahan_baku'] ?></a></strong></div>
					</div>
					</th>
					<td class="align-middle border-light">
					<p class="mb-0 small">Rp. <?= number_format($harga) ?></p>
					</td>
					<td class="align-middle border-light">
					<div class="border d-flex align-items-center justify-content-between px-3"><span class="small text-uppercase text-gray headings-font-family">QTY</span>
						<div class="quantity">
							<input class="form-control form-control-sm border-0 shadow-0 p-0" width="50" type="number" value="<?= $jml ?>" name="jumlah[]" id="jumlah_<?php echo $i['id'] ?>" nomor="<?php echo $i['id'] ?>" min="1"/>
							<input class="harga" id="harga_<?php echo $i['id'] ?>" type="hidden" value="<?php echo $harga; ?>">
							<input name="produk[]" value="<?php echo $i['id'] ?>" type="hidden">
						</div>
					</div>
					</td>
					<td class="align-middle border-light">
					<p class="mb-0 small"><?php echo "Rp. ".number_format($total); ?></p>
					</td>
					<td class="align-middle border-light"><a class="reset-anchor" href="keranjang_hapus.php?id=<?php echo $i['id']; ?>&redirect=keranjang"><i class="fas fa-trash-alt small text-muted"></i></a></td>
				</tr>
				<?php
					$total = 0;
				}
				?>
				</tbody>
			</table>
			</div>
			<!-- CART NAV-->
			<div class="bg-light px-4 py-3">
			<div class="row align-items-center text-center">
				<div class="col-md-6 mb-3 mb-md-0 text-md-left"><a class="btn btn-link p-0 text-dark btn-sm" href="index.php"><i class="fas fa-long-arrow-alt-left mr-2"> </i>Lanjut Belanja</a></div>
				<div class="col-md-6 text-md-right">
					<a class="btn btn-outline-dark btn-sm" href="checkout.php">Proses ke checkout<i class="fas fa-long-arrow-alt-right ml-2"></i></a>
				</div>
			</div>
			<br>
			<p style="color:red;font-weight:bold;">*Tekan "Update Keranjang" ketika mengganti jumlah pembelian</p>
			</div>
		</div>
		<!-- ORDER TOTAL-->
		<div class="col-lg-4">
			<div class="card border-0 rounded-0 p-lg-4 bg-light">
			<div class="card-body">
				<h5 class="text-uppercase mb-4">Total Belanja</h5>
				<?php
				// aaa
				?>
				<ul class="list-unstyled mb-0">
					<li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span><?php echo "Rp. ".number_format($jumlah_total) . " ,-"; ?></span></li>
				<li>
					<form action="#">
					<div class="form-group mb-0">
						<button class="btn btn-dark btn-sm btn-block" type="submit"> <i class="fas fa-check mr-2"></i>Update Keranjang</button>
					</div>
					</form>
				</li>
				</ul>
			</div>
			</div>
		</div>
		</div>
	</section>
</div>
</form>
<?php
	}else{

		echo "<br><br><br><h3 class='text-right'>Silahkan membeli produk</h3><br><br><br>";
	}


}else{
	echo "<br><br><br><h3 class='text-right'>Silahkan membeli produk</h3><br><br><br>";
}
    require_once '../layouts/footer.php';
?>


