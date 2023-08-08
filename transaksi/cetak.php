<?php
$current = "data transaksi";

require_once '../qb.php';

if (isset($_GET['delete'])) {
    $res = delete('tb_transaksi', $_GET['delete']);
    if ($res) {
        $success = true;
        unset($_GET);
        header("location:index.php");
    } else {
        $failed = true;
    }
}

require_once '../layouts/header.php';

$sqlKonsumen = mysqli_query($conn, "SELECT tt.id, tt.tanggal, tk.nama_konsumen, tt.alamat, tt.hp, tt.total, tt.status, tt.bukti FROM tb_transaksi tt join tb_konsumen tk on tt.id_konsumen = tk.id");
?>

<title>Data Transaksi</title>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    .hide-print {
        display: none;
    }
</style>

<h2 style="text-align: center;">Data Transaksi</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomor Handphone</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($data = mysqli_fetch_array($sqlKonsumen)) { ?>
            <tr>
                <td><?= $data["id"] ?></td>
                <td><?= $data["tanggal"] ?></td>
                <td><?= $data["nama_konsumen"] ?></td>
                <td><?= $data["alamat"] ?></td>
                <td><?= $data["hp"] ?></td>
                <td>Rp. <?= number_format($data["total"]) ?></td>
                <td>
                    <?php
                    if ($data['status'] == 0) {
                        echo "<span class='badge badge-secondary'>dipesan</span>";
                    } elseif ($data['status'] == 1) {
                        echo "<span class='badge badge-warning'>Bukti telah dikirim</span>";
                    } elseif ($data['status'] == 2) {
                        echo "<span class='badge badge-info'>Dikonfirmasi</span>";
                    } elseif ($data['status'] == 3) {
                        echo "<span class='badge badge-danger'>Ditolak</span>";
                    } elseif ($data['status'] == 4) {
                        echo "<span class='badge badge-primary'>Dikirim</span>";
                    } elseif ($data['status'] == 5) {
                        echo "<span class='badge badge-success'>Selesai</span>";
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-sm btn-success ml-3" style="margin-top: 1rem;" onclick="printTable()"> Print Bukti</button>


<!-- Script JavaScript -->
<script>
    function printTable() {
        // Menyembunyikan tombol print agar tidak ikut tercetak
        var printButton = document.querySelector('.btn-success');
        printButton.style.display = 'none';

        // Memicu proses pencetakan
        window.print();

        // Setelah pencetakan selesai, tampilkan kembali tombol print
        printButton.style.display = 'block';
    }
</script>