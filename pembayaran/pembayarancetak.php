<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pembayaran - HONDA AHASS 904</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #d50000;
            margin: 5px 0;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header .ahass-title {
            background-color: #d50000;
            color: white;
            padding: 8px 0;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .customer-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .invoice-info {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature img {
            max-width: 150px;
        }
        .stamp {
            position: absolute;
            opacity: 0.4;
            transform: rotate(-15deg);
        }
        hr {
            border: 0;
            height: 1px;
            background-color: #d50000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <?php
        include '../koneksi.php';
        $no_pembayaran = $_GET['no_pembayaran'];

        $query_pembayaran = mysqli_query($conn, "SELECT p.*, pg.nama_pegawai, m.no_polisi, c.nama 
                                               FROM pembayaran p
                                               JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                               JOIN motor m ON p.no_polisi = m.no_polisi
                                               JOIN customer c ON m.id_customer = c.id_customer
                                               WHERE p.no_pembayaran = '$no_pembayaran'");
        $data_pembayaran = mysqli_fetch_array($query_pembayaran);
        
        
        $tanggal = date('d/m/Y', strtotime($data_pembayaran['tanggal']));
        ?>

        <div class="header">
            <div class="ahass-title">
                <h1>HONDA AHASS 904</h1>
            </div>
            <p>Bengkel Resmi HONDA</p>
            <p>Jl. Daan Mogot No. 121, Jakarta Barat</p>
            <p>Telp: (021) 5602945</p>
            <hr>
            <h2>INVOICE PEMBAYARAN</h2>
        </div>

        <div class="customer-info">
            <div>
                <p><strong>Kepada Yth:</strong></p>
                <p><?php echo htmlspecialchars($data_pembayaran['nama']); ?></p>
                <p>No. Polisi: <?php echo htmlspecialchars($data_pembayaran['no_polisi']); ?></p>
            </div>
            <div class="invoice-info">
                <p><strong>No. Pembayaran:</strong> <?php echo htmlspecialchars($data_pembayaran['no_pembayaran']); ?></p>
                <p><strong>Tanggal:</strong> <?php echo $tanggal; ?></p>
                <p><strong>Pegawai:</strong> <?php echo htmlspecialchars($data_pembayaran['nama_pegawai']); ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Item</th>
                    <th>Nama Item</th>
                    <th>Banyaknya</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query detail pembayaran
                $query_detail = mysqli_query($conn, "SELECT dp.*, i.namaitem, i.harga_ongkos 
                                                    FROM detailpembayaran dp
                                                    JOIN item i ON dp.kode_item = i.kode_item
                                                    WHERE dp.no_pembayaran = '$no_pembayaran'");
                
                $no = 1;
                $total = 0;
                $rowCount = 0;
                
                while ($data_detail = mysqli_fetch_array($query_detail)) {
                    $subtotal = $data_detail['banyaknya'] * $data_detail['harga_ongkos'];
                    $total += $subtotal;
                    $rowCount++;
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($data_detail['kode_item']); ?></td>
                    <td><?php echo htmlspecialchars($data_detail['namaitem']); ?></td>
                    <td><?php echo htmlspecialchars($data_detail['banyaknya']); ?></td>
                    <td class="text-right"><?php echo number_format($data_detail['harga_ongkos'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php 
                }
                
                // Tambahkan baris kosong jika kurang dari 10 baris
                for ($i = $rowCount; $i < 10; $i++) {
                    echo '<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><strong>TOTAL</strong></td>
                    <td class="text-right"><strong><?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="total-section">
            <p>Terbilang: <strong><?php echo terbilang($total); ?> Rupiah</strong></p>
        </div>

        <div class="signature">
            <p>Jakarta, <?php echo $tanggal; ?></p>
            <p>Hormat Kami,</p>
            <br><br><br>
            <p><strong><?php echo htmlspecialchars($data_pembayaran['nama_pegawai']); ?></strong></p>
            <div class="stamp">
                <img src="../images/stempel.png" alt="Stempel">
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>

<?php
// Fungsi untuk mengubah angka menjadi terbilang
function terbilang($angka) {
    $angka = abs($angka);
    $baca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $terbilang = "";
    
    if ($angka < 12) {
        $terbilang = " " . $baca[$angka];
    } elseif ($angka < 20) {
        $terbilang = terbilang($angka - 10) . " belas";
    } elseif ($angka < 100) {
        $terbilang = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $terbilang = " seratus" . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $terbilang = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        $terbilang = " seribu" . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $terbilang = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $terbilang = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
    }
    
    return $terbilang;
}