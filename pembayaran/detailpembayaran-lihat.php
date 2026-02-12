<?php
include '../koneksi.php';

// Periksa apakah 'no_pembayaran' ada di URL
if (isset($_GET['no_pembayaran'])) {
    $no_pembayaran = $_GET['no_pembayaran'];
    $query = mysqli_query($conn, "SELECT p.*, pg.nama_pegawai, m.no_polisi 
                                FROM pembayaran p
                                JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                JOIN motor m ON p.no_polisi = m.no_polisi
                                WHERE p.no_pembayaran = '$no_pembayaran'");
    $data = mysqli_fetch_array($query);
    
    // Mengubah format tanggal ke dd/mm/yyyy
    $tanggal = date('d/m/Y', strtotime($data['tanggal']));

    // Periksa apakah query SQL berhasil mengambil data
    if (!$data) {
        die("Pembayaran tidak ditemukan.");
    }
} else {
    die("Nomor pembayaran tidak disediakan.");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pembayaran - Honda AHASS 904</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #d50000, #ffffff, #d50000);
            background-size: 400% 400%;
            animation: gradientBG 5s ease infinite;
            color: #000;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            width: 90%;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #d50000;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .button-group a {
            background: #d50000;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
        }

        .button-group a:hover {
            background: #a10000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 5px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #d50000;
            color: white;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .edit, .hapus, .detail, .cetak, .tambah {
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 3px;
            color: white;
            margin: 0 2px;
            display: inline-block;
        }

        .edit {
            background: #007bff;
        }

        .hapus {
            background: #dc3545;
        }
        
        .tambah {
            background: #28a745;
        }
        
        .cetak {
            background: #6c757d;
        }

        .edit:hover {
            background: #0056b3;
        }

        .hapus:hover {
            background: #b02a37;
        }
        
        .tambah:hover {
            background: #218838;
        }
        
        .cetak:hover {
            background: #5a6268;
        }

        .form-element {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        hr {
            border: 0;
            height: 1px;
            background: #d50000;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>HONDA AHASS 904</h3>

        <div class="button-group">
            <a href="pembayaranlihat.php">Kembali ke Pembayaran</a>
            <a href="../dashboard.php">Kembali ke Dashboard</a>
        </div>

        <h4>DETAIL PEMBAYARAN: <?php echo htmlspecialchars($data['no_pembayaran']); ?></h4>
        <hr>

        <div class="form">
            <div class="form-element">
                <label class="form-label">NO PEMBAYARAN</label>
                <input class="form-control" value="<?php echo htmlspecialchars($data['no_pembayaran']); ?>" readonly>
            </div>

            <div class="form-element">
                <label class="form-label">TANGGAL</label>
                <input class="form-control" value="<?php echo $tanggal; ?>" readonly>
            </div>

            <div class="form-element">
                <label class="form-label">NO POLISI</label>
                <input class="form-control" value="<?php echo htmlspecialchars($data['no_polisi']); ?>" readonly>
            </div>

            <div class="form-element">
                <label class="form-label">PEGAWAI</label>
                <input class="form-control" value="<?php echo htmlspecialchars($data['nama_pegawai']); ?>" readonly>
            </div>

            <div class="form-element">
                <label class="form-label">JUMLAH</label>
                <input class="form-control" value="<?php echo htmlspecialchars($data['jumlah']); ?>" readonly>
            </div>

            <div class="form-element">
                <label class="form-label">TERBILANG</label>
                <input class="form-control" value="<?php echo htmlspecialchars($data['terbilang']); ?>" readonly>
            </div>
        </div>

        <br>

        <h4>TABEL DETAIL ITEM PEMBAYARAN</h4>
        <hr>
        
        <div class="mb-3">
            <a class="tambah" href="detailpembayaran-tambah.php?no_pembayaran=<?php echo htmlspecialchars($data['no_pembayaran']); ?>">Tambah Item</a>
            <a class="cetak" href="pembayarancetak.php?no_pembayaran=<?php echo htmlspecialchars($data['no_pembayaran']); ?>" style="color:white;">Cetak</a>
        </div>
        
        <table>
            <tr>
                <th>No Pembayaran</th>
                <th>Kode Item</th>
                <th>Banyaknya</th>
                <th>Harga Total</th>
                <th>Aksi</th>
            </tr>

            <?php
            $index = 1;
            $query_detail = mysqli_query($conn, "SELECT dp.*, i.namaitem 
                                             FROM detailpembayaran dp
                                             JOIN item i ON dp.kode_item = i.kode_item
                                             WHERE dp.no_pembayaran = '$no_pembayaran'");

            $total_harga = 0;

            while ($data_detail = mysqli_fetch_array($query_detail)) {
                $total_harga += $data_detail['harga_total'];
            ?>

                <tr>
                    <td><?php echo htmlspecialchars($index++); ?></td>
                    <td><?php echo htmlspecialchars($data_detail['kode_item'] . ' - ' . $data_detail['namaitem']); ?></td>
                    <td><?php echo htmlspecialchars($data_detail['banyaknya']); ?></td>
                    <td><?php echo htmlspecialchars($data_detail['harga_total']); ?></td>
                    <td>
                        <a class="edit" href="detailpembayaran-ubah.php?no_pembayaran=<?php echo htmlspecialchars($data_detail['no_pembayaran']); ?>&kode_item=<?php echo htmlspecialchars($data_detail['kode_item']); ?>">Ubah</a> |
                        <a class="hapus" href="detailpembayaran-hapus.php?no_pembayaran=<?php echo htmlspecialchars($data_detail['no_pembayaran']); ?>&kode_item=<?php echo htmlspecialchars($data_detail['kode_item']); ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>

            <?php } ?>
            <tr>
                <td colspan="3" style="text-align: center;"> <strong> TOTAL HARGA </strong> </td>
                <td><?php echo htmlspecialchars($total_harga); ?></td>
                <td></td>
            </tr>
        </table>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>