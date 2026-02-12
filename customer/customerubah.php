<?php
include '../koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM customer WHERE id_customer = '$_GET[id_customer]'");
$data = mysqli_fetch_array($query);

if (isset($_POST['proses'])) {
    $id_customer = $_POST['id_customer'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "UPDATE customer SET nama='$nama', alamat='$alamat' WHERE id_customer='$id_customer'");
    header("location:customerlihat.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Pelanggan - Honda AHASS 904</title>
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

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-group input:focus {
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
        <h1>UBAH PELANGGAN</h1>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="id_customer">ID Customer</label>
                <input type="text" id="id_customer" name="id_customer" value="<?php echo htmlspecialchars($data['id_customer']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="nama">Nama Pelanggan</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
            </div>
            
            <div class="button-group">
                <button type="submit" name="proses" class="btn btn-ubah">Ubah Pelanggan</button>
                <a href="customerlihat.php" class="btn btn-kembali">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>