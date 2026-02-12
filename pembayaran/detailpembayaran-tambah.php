<?php
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $no_pembayaran = $_POST['no_pembayaran'];
    $kode_item = $_POST['kode_item'];
    $banyaknya = $_POST['banyaknya'];
    $harga_total = $_POST['harga_total'];

    // Validasi input
    if (empty($no_pembayaran) || empty($kode_item) || empty($banyaknya) || empty($harga_total)) {
        die("<script>alert('Data tidak lengkap!');window.history.back();</script>");
    }

    // Insert detail pembayaran menggunakan prepared statement
    $query_insert = $conn->prepare("INSERT INTO detailpembayaran VALUES(?, ?, ?, ?)");
    $query_insert->bind_param("ssid", $no_pembayaran, $kode_item, $banyaknya, $harga_total);
    $result_insert = $query_insert->execute();

    if ($result_insert) {
        // Update total in pembayaran table
        $query_update = $conn->prepare("UPDATE pembayaran SET jumlah = jumlah + ? WHERE no_pembayaran = ?");
        $query_update->bind_param("ds", $harga_total, $no_pembayaran);
        $result_update = $query_update->execute();
        
        if ($result_update) {
            // Redirect ke halaman detail pembayaran
            header("Location: detailpembayaran-lihat.php?no_pembayaran=$no_pembayaran");
            exit;
        } else {
            die("<script>alert('Gagal update total pembayaran!');window.history.back();</script>");
        }
    } else {
        die("<script>alert('Gagal menyimpan detail pembayaran!');window.history.back();</script>");
    }
}

// Ambil data untuk tampilan form
if (isset($_GET['no_pembayaran'])) {
    $no_pembayaran = $_GET['no_pembayaran'];
    $query = mysqli_query($conn, "SELECT p.*, pg.nama_pegawai, m.no_polisi 
                                FROM pembayaran p
                                JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                JOIN motor m ON p.no_polisi = m.no_polisi
                                WHERE p.no_pembayaran = '$no_pembayaran'");
    $data = mysqli_fetch_array($query);
    
    if (!$data) {
        die("<script>alert('Data pembayaran tidak ditemukan!');window.location='pembayaran-lihat.php';</script>");
    }
    
    // Format tanggal
    $tanggal = date('d/m/Y', strtotime($data['tanggal']));
} else {
    die("<script>alert('Nomor pembayaran tidak disediakan!');window.location='pembayaran-lihat.php';</script>");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Detail Pembayaran - Honda AHASS 904</title>
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

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>HONDA AHASS 904</h3>

        <div class="button-group">
            <a href="detailpembayaran-lihat.php?no_pembayaran=<?php echo htmlspecialchars($no_pembayaran); ?>">Kembali ke Detail Pembayaran</a>
            <a href="../dashboard.php">Kembali ke Dashboard</a>
        </div>

        <h4>FORM DETAIL PEMBAYARAN: <?php echo htmlspecialchars($data['no_pembayaran']); ?></h4>
        <hr>

        <form method="POST" action="">
            <div class="form">
                <div class="form-element">
                    <label class="form-label">NO PEMBAYARAN</label>
                    <input class="form-control" name="no_pembayaran" value="<?php echo htmlspecialchars($data['no_pembayaran']); ?>" readonly>
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

                <hr>
                <h4>TAMBAH DETAIL PEMBAYARAN</h4>
                <hr>

                <div class="form-element">
                    <label class="form-label">ITEM</label>
                    <select class="form-control" name="kode_item" id="kode_item" required>
                        <option value="">-- Pilih Item --</option>
                        <?php
                        $query_item = mysqli_query($conn, "SELECT * FROM item");
                        while ($item = mysqli_fetch_array($query_item)) {
                            echo '<option value="'.htmlspecialchars($item['kode_item']).'" data-harga="'.htmlspecialchars($item['harga_ongkos']).'">';
                            echo htmlspecialchars($item['kode_item'].' - '.$item['namaitem'].' (Rp '.number_format($item['harga_ongkos'], 0, ',', '.').')');
                            echo '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-element">
                    <label class="form-label">BANYAKNYA</label>
                    <input type="number" class="form-control" name="banyaknya" id="banyaknya" min="1" required>
                </div>

                <div class="form-element">
                    <label class="form-label">HARGA TOTAL</label>
                    <input type="number" class="form-control" name="harga_total" id="harga_total" readonly>
                </div>

                <div class="form-element" style="text-align: right;">
                    <button type="submit" name="proses" class="btn btn-success">Simpan Detail</button>
                    <a href="detailpembayaran-lihat.php?no_pembayaran=<?php echo htmlspecialchars($no_pembayaran); ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </form>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
        // Hitung harga total otomatis
        document.getElementById('kode_item').addEventListener('change', hitungTotal);
        document.getElementById('banyaknya').addEventListener('input', hitungTotal);

        function hitungTotal() {
            const kodeItem = document.getElementById('kode_item');
            const banyaknya = document.getElementById('banyaknya');
            const hargaTotal = document.getElementById('harga_total');
            
            if (kodeItem.value && banyaknya.value && banyaknya.value > 0) {
                const hargaSatuan = kodeItem.options[kodeItem.selectedIndex].getAttribute('data-harga');
                hargaTotal.value = hargaSatuan * banyaknya.value;
            } else {
                hargaTotal.value = '';
            }
        }
    </script>
</body>
</html>