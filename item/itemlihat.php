<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Item - Honda AHASS 904</title>
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
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .edit, .hapus {
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 3px;
            color: white;
        }

        .edit {
            background: #007bff;
        }

        .hapus {
            background: #dc3545;
        }

        .edit:hover {
            background: #0056b3;
        }

        .hapus:hover {
            background: #b02a37;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 12px;
            background-color: #d50000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 5px;
        }

        .pagination a.current {
            background-color: #a10000;
        }
    </style>
</head>

<body>

    <div class="container">
        <h3>HONDA AHASS 904</h3>

        <div class="button-group">
            <a href="itemtambah.php">Tambah Item</a>
            <a href="../dashboard.php">Kembali ke Dashboard</a>
        </div>

        <h4>TABEL ITEM</h4>

        <table>
            <tr>
                <th>Kode Item</th>
                <th>Nama Item</th>
                <th>Jenis</th>
                <th>Harga/Ongkos</th>
                <th>Aksi</th>
            </tr>

            <?php
            include '../koneksi.php';

            $limit = 10; 
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            $query = mysqli_query($conn, "SELECT * FROM item LIMIT $start, $limit");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $data['kode_item']; ?></td>
                    <td><?php echo $data['namaitem']; ?></td>
                    <td><?php echo $data['jenis']; ?></td>
                    <td><?php echo $data['harga_ongkos']; ?></td>
                    <td>
                        <a class="edit" href="itemubah.php?kode_item=<?php echo $data['kode_item']; ?>">Edit</a>
                        |
                        <a class="hapus" href="itemhapus.php?kode_item=<?php echo $data['kode_item']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <div class="pagination">
            <?php
            $query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM item");
            $data_total = mysqli_fetch_assoc($query_total);
            $total_pages = ceil($data_total['total'] / $limit);

            if ($page > 1) {
                echo '<a href="?page=' . ($page - 1) . '">Back</a>';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<a href="?page=' . $i . '" class="current">' . $i . '</a>';
                } else {
                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
                }
            }

            if ($page < $total_pages) {
                echo '<a href="?page=' . ($page + 1) . '">Next</a>';
            }
            ?>
        </div>
    </div>

</body>

</html>
