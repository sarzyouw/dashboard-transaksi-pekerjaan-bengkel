<?php
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $no_pembayaran = $_GET['no_pembayaran'];
    $kode_item = $_GET['kode_item'];
    $banyaknya = $_POST['banyaknya'];
    $harga_total = $_POST['harga_total'];

    $query_total = "SELECT jumlah FROM pembayaran WHERE no_pembayaran = '$no_pembayaran'";
    $result_total = mysqli_query($conn, $query_total);

    if ($result_total) {
        $row_total = mysqli_fetch_assoc($result_total);
        $total_sebelumnya = $row_total['jumlah'];

        // Dapatkan harga total sebelumnya untuk item ini
        $query_old = "SELECT harga_total FROM detailpembayaran WHERE no_pembayaran='$no_pembayaran' AND kode_item='$kode_item'";
        $result_old = mysqli_query($conn, $query_old);
        $old_data = mysqli_fetch_assoc($result_old);
        $harga_sebelumnya = $old_data['harga_total'];

        $queryUpdate = "UPDATE detailpembayaran SET banyaknya='$banyaknya', harga_total='$harga_total' 
                       WHERE no_pembayaran='$no_pembayaran' AND kode_item='$kode_item' LIMIT 1";
        $result_update = mysqli_query($conn, $queryUpdate);

        if ($result_update) {
            // Mengupdate nilai total di tabel pembayaran
            $total_baru = $total_sebelumnya - $harga_sebelumnya + $harga_total;
            $query_update_total = "UPDATE pembayaran SET jumlah='$total_baru' WHERE no_pembayaran = '$no_pembayaran'";
            $result_update_total = mysqli_query($conn, $query_update_total);

            if ($result_update_total) {
                // Redirect ke halaman lain setelah sukses
                header("Location: detailpembayaranlihat.php?no_pembayaran=$no_pembayaran");
                exit;
            } else {
                echo "Error Update Total: " . mysqli_error($conn);
            }
        } else {
            echo "Error Update: " . mysqli_error($conn);
        }
    } else {
        echo "Error Total: " . mysqli_error($conn);
    }
}

// Ambil data untuk tampilan form
if (isset($_GET['no_pembayaran']) && isset($_GET['kode_item'])) {
    $no_pembayaran = $_GET['no_pembayaran'];
    $kode_item = $_GET['kode_item'];

    $query_pembayaran = mysqli_query($conn, "SELECT p.*, pg.nama_pegawai, m.no_polisi 
                                          FROM pembayaran p
                                          JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                          JOIN motor m ON p.no_polisi = m.no_polisi
                                          WHERE p.no_pembayaran = '$no_pembayaran'");
    if ($query_pembayaran) {
        $data_pembayaran = mysqli_fetch_array($query_pembayaran);
    } else {
        die("Error: " . mysqli_error($conn));
    }

    $query_detail = mysqli_query($conn, "SELECT dp.*, i.kode_item, i.namaitem, i.harga_ongkos 
                                      FROM detailpembayaran dp 
                                      JOIN item i ON dp.kode_item = i.kode_item 
                                      WHERE dp.no_pembayaran = '$no_pembayaran' AND dp.kode_item = '$kode_item'");
    if ($query_detail) {
        $data = mysqli_fetch_array($query_detail);
    } else {
        die("Error: " . mysqli_error($conn));
    }
} else {
    die("Nomor pembayaran atau kode item tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Ubah Detail Pembayaran</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
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

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <div class="container">
        <h3 style="text-align: center; color: #d50000;">HONDA AHASS 904</h3>
        
        <div class="button-group" style="margin-bottom: 20px;">
            <a href="pembayaran-lihat.php" class="btn btn-danger">Kembali ke Pembayaran</a>
            <a href="../dashboard.php" class="btn btn-danger">Kembali ke Dashboard</a>
        </div>

        <h4 style="text-align: center;">FORM DETAIL PEMBAYARAN: <?php echo htmlspecialchars($data_pembayaran['no_pembayaran']); ?></h4>
        <hr>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">NO PEMBAYARAN</label>
            <input name="no_pembayaran" class="form-control" value="<?php echo htmlspecialchars($data_pembayaran['no_pembayaran']); ?>" style="display: inline-block; width: calc(100% - 160px);" readonly>
        </div>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">TANGGAL</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($data_pembayaran['tanggal']); ?>" style="display: inline-block; width: calc(100% - 160px);" readonly>
        </div>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">NO POLISI</label>
            <input type="text" name="no_polisi" class="form-control" value="<?php echo htmlspecialchars($data_pembayaran['no_polisi']); ?>" style="display: inline-block; width: calc(100% - 160px);" readonly>
        </div>

        <h4 style="text-align: center; margin-top: 30px;">UBAH DETAIL ITEM PEMBAYARAN</h4>
        <hr>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">KODE ITEM</label>
            <input type="text" name="kode_item" class="form-control" value="<?php echo htmlspecialchars($data['kode_item']); ?>" style="display: inline-block; width: calc(100% - 160px);" readonly>
        </div>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">NAMA ITEM</label>
            <input type="text" name="namaitem" class="form-control" value="<?php echo htmlspecialchars($data['namaitem']); ?>" style="display: inline-block; width: calc(100% - 160px);" readonly>
        </div>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">HARGA ONGKOS</label>
            <input type="number" name="harga_ongkos" class="form-control" value="<?php echo htmlspecialchars($data['harga_ongkos']); ?>" style="display: inline-block; width: calc(100% - 160px);" readonly>
        </div>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">BANYAKNYA</label>
            <input type="number" name="banyaknya" class="form-control" value="<?php echo htmlspecialchars($data['banyaknya']); ?>" style="display: inline-block; width: calc(100% - 160px);" oninput="hitungTotal()">
        </div>

        <div class="form-element" style="margin-bottom: 15px;">
            <label style="display: inline-block; width: 150px;">HARGA TOTAL</label>
            <input type="number" name="harga_total" class="form-control" value="<?php echo htmlspecialchars($data['harga_total']); ?>" style="display: inline-block; width: calc(100% - 160px);" readonly>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" name="proses" class="btn btn-success">Simpan Perubahan</button>
            <a href="detailpembayaran-lihat.php?no_pembayaran=<?php echo htmlspecialchars($data_pembayaran['no_pembayaran']); ?>" class="btn btn-danger">Batal</a>
        </div>
    </div>
</form>

<script src="../js/jquery.min.js"></script> 
<script src="../js/popper.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<script>
    function hitungTotal() {
        var banyaknya = document.querySelector("input[name='banyaknya']").value;
        var harga_ongkos = <?php echo $data['harga_ongkos']; ?>;
        var total = banyaknya * harga_ongkos;
        document.querySelector("input[name='harga_total']").value = total;
    }
</script>
</body>
</html>