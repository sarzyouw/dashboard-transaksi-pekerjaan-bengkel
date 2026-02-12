<?php
include '../koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM motor WHERE no_polisi = '$_GET[no_polisi]'");
$motor = mysqli_fetch_array($query);

$customers = mysqli_query($conn, "SELECT * FROM customer");

if (isset($_POST['proses'])) {
    $no_polisi = $_POST['no_polisi'];
    $id_customer = $_POST['id_customer'];
    $no_rangka = $_POST['no_rangka'];
    $no_mesin = $_POST['no_mesin'];
    $tipe = $_POST['tipe'];
    $tahun = $_POST['tahun'];
    
    mysqli_query($conn, "UPDATE motor SET id_customer='$id_customer', no_rangka='$no_rangka', no_mesin='$no_mesin', tipe='$tipe', tahun='$tahun' WHERE no_polisi='$no_polisi'");
    header("location:motorlihat.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Motor - Honda AHASS 904</title>
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
            max-width: 600px;
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

        .form-group input[readonly] {
            background-color: #f5f5f5;
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
        <h1>UBAH DATA MOTOR</h1>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="no_polisi">No Polisi</label>
                <input type="text" id="no_polisi" name="no_polisi" value="<?php echo htmlspecialchars($motor['no_polisi']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="id_customer">Customer</label>
                <select id="id_customer" name="id_customer" required>
                    <option value="">-- Pilih Customer --</option>
                    <?php 
                    mysqli_data_seek($customers, 0);
                    while ($customer = mysqli_fetch_array($customers)): ?>
                        <option value="<?php echo htmlspecialchars($customer['id_customer']); ?>"
                            <?php echo ($customer['id_customer'] == $motor['id_customer']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($customer['id_customer'] . ' - ' . $customer['nama']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="no_rangka">No Rangka</label>
                <input type="text" id="no_rangka" name="no_rangka" value="<?php echo htmlspecialchars($motor['no_rangka']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="no_mesin">No Mesin</label>
                <input type="number" id="no_mesin" name="no_mesin" value="<?php echo htmlspecialchars($motor['no_mesin']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tipe">Tipe</label>
                <input type="text" id="tipe" name="tipe" value="<?php echo htmlspecialchars($motor['tipe']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($motor['tahun']); ?>" required>
            </div>
            
            <div class="button-group">
                <button type="submit" name="proses" class="btn btn-ubah">Simpan Perubahan</button>
                <a href="motorlihat.php" class="btn btn-kembali">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>