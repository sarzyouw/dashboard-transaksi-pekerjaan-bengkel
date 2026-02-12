<?php
include '../koneksi.php';
$query = mysqli_query($conn, "Select*from pembayaran where no_pembayaran = '$_GET[no_pembayaran]'");
$data = mysqli_fetch_array($query);
    
if (isset($_POST['proses'])){
    $no_pembayaran = $_POST['no_pembayaran'];
    $no_polisi = $_POST['no_polisi'];
    $id_pegawai = $_POST['id_pegawai'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];
    $terbilang = $_POST['terbilang'];

    mysqli_query($conn, "UPDATE pembayaran SET no_polisi='$no_polisi', id_pegawai='$id_pegawai', tanggal='$tanggal', jumlah='$jumlah', terbilang='$terbilang' WHERE no_pembayaran='$no_pembayaran'");
    header("location:pembayaranlihat.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Pembayaran - Honda AHASS 904</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

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
            max-width: 800px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #d50000;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #d50000;
            outline: none;
            box-shadow: 0 0 0 3px rgba(213, 0, 0, 0.1);
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 10px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            flex: 1;
            text-align: center;
        }

        .btn-ubah {
            background-color: #d50000;
            color: white;
        }

        .btn-ubah:hover {
            background-color: #a10000;
        }

        .btn-kembali {
            background-color: #343a40;
            color: white;
        }

        .btn-kembali:hover {
            background-color: #23272b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>UBAH PEMBAYARAN</h1>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="no_pembayaran">No Pembayaran</label>
                <input type="text" id="no_pembayaran" name="no_pembayaran" value="<?php echo $data['no_pembayaran']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="no_polisi">No Polisi</label>
                <select id="no_polisi" name="no_polisi" required>
                    <option value="">-- Pilih No Polisi --</option>
                    <?php
                    $ambilmotor = mysqli_query($conn, "SELECT * FROM motor");
                    while ($motor = mysqli_fetch_array($ambilmotor)) {
                        $selected = ($data['no_polisi'] == $motor['no_polisi']) ? 'selected' : '';
                        echo '<option value="'.$motor['no_polisi'].'" '.$selected.'>'.$motor['no_polisi'].'</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="id_pegawai">Pegawai</label>
                <select id="id_pegawai" name="id_pegawai" required>
                    <option value="">-- Pilih Pegawai --</option>
                    <?php
                    $ambilpegawai = mysqli_query($conn, "SELECT * FROM pegawai");
                    while ($pegawai = mysqli_fetch_array($ambilpegawai)) {
                        $selected = ($data['id_pegawai'] == $pegawai['id_pegawai']) ? 'selected' : '';
                        echo '<option value="'.$pegawai['id_pegawai'].'" '.$selected.'>'.$pegawai['nama_pegawai'].'</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo $data['tanggal']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" value="<?php echo $data['jumlah']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="terbilang">Terbilang</label>
                <input type="text" id="terbilang" name="terbilang" value="<?php echo $data['terbilang']; ?>" required>
            </div>
            
            <div class="button-group">
                <button type="submit" name="proses" class="btn btn-ubah">Ubah Pembayaran</button>
                <a href="pembayaranlihat.php" class="btn btn-kembali">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>