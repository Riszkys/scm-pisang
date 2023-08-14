<?php
if (isset($_GET['submit'])) {
    try {
        $conn = new mysqli("localhost", "root", "", "db_pisang2");

        $id_pembelian = $_GET['id_pembelian'];
        $nama_bahan_baku = $_GET['nama_bahan_baku'];
        $keterangan = isset($_GET['keterangan']) ? $_GET['keterangan'] : [];

        $kuantitas = in_array('kuantitas', $keterangan) ? 1 : 0;
        $kualitas = in_array('kualitas', $keterangan) ? 1 : 0;
        $fisik = in_array('fisik', $keterangan) ? 1 : 0;

        // Memasukkan data ke dalam tabel tb_checking
        $insertSql = "INSERT INTO tb_checking (id_pembelian, bahan_baku, kuantitas, kualitas, fisik) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("isiii", $id_pembelian, $nama_bahan_baku, $kuantitas, $kualitas, $fisik);
        $insertStmt->execute();
        $insertStmt->close();

        // Tutup koneksi
        $conn->close();

        header('Location: index.php'); // Mengarahkan kembali ke halaman index
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}