<?php
// Koneksi ke database
$host = "localhost"; // Ganti dengan host Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "pekerjaansparepart"; // Ganti dengan nama database Anda

$koneksi = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil data pembayaran terakhir dengan JOIN
$query = "
SELECT c.nama, p.tanggal, p.jumlah
FROM pembayaran p
JOIN motor m ON p.no_polisi = m.no_polisi
JOIN customer c ON m.id_customer = c.id_customer
ORDER BY p.no_pembayaran DESC;
";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
    $tanggal = $row['tanggal'];
    $jumlah = $row['jumlah'];
} else {
    $nama = "Tidak ada data";
    $tanggal = "Tidak ada data";
    $jumlah = "Tidak ada data";
}

$koneksi->close();
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="Honda AHASS 904, Sparepart Honda, Servis Motor Honda" />
  <meta name="description" content="Honda AHASS 904 - Penyedia Sparepart dan Jasa Servis Resmi Honda" />
  <meta name="author" content="Honda AHASS 904" />
  <link rel="shortcut icon" href="images/favicon.PNG" type="image/x-icon">

  <title>
    Honda AHASS 904
  </title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <!-- Custom CSS untuk Gradasi Background dan Warna Teks -->
  <style>
    body {
      background: linear-gradient(to bottom, #FF0000, rgba(219, 199, 198, 0.9)); /* Gradasi merah ke merah pastel */
      color: #000000; /* Warna teks default hitam */
      font-family: Arial, sans-serif;
    }

    .header_section {
      background: rgba(255, 255, 255, 0.8); /* Background header semi-transparan */
      padding: 10px 0;
    }

    .navbar-brand span {
      color: #000000; /* Warna hitam untuk logo */
      font-weight: bold;
      font-size: 24px;
    }

    .navbar-nav .nav-link {
      color: #000000 !important; /* Warna teks menu hitam */
      font-weight: bold;
    }

    .navbar-nav .nav-link:hover {
      color:rgb(223, 187, 187) !important; /* Warna merah saat hover */
    }

    .slider_section {
      background: rgba(255, 255, 255, 0.9); /* Background slider semi-transparan */
      padding: 50px 0;
      border-radius: 10px;
      margin: 20px;
    }

    .slider_section h1 {
      color: #000000; /* Warna hitam untuk judul */
    }

    .slider_section p {
      color: #000000; /* Warna teks hitam */
    }

    .slider_section ul {
      color: #000000; /* Warna teks hitam untuk poin-poin */
    }

    .pembayaran_terakhir_section {
      background: rgba(255, 255, 255, 0.9); /* Background semi-transparan */
      padding: 20px;
      border-radius: 10px;
      margin: 20px;
    }

    .pembayaran_terakhir_section h2 {
      color: #000000; /* Warna hitam untuk judul */
    }

    .pembayaran_terakhir_section h5 {
      color: #000000; /* Warna teks hitam */
    }

    .footer_section {
      background: rgba(210, 153, 152, 0.9); /* Background footer merah pastel */
      color: #FFFFFF; /* Warna teks putih */
      padding: 20px 0;
      text-align: center;
    }

    .footer_section a {
      color: #FFFFFF; /* Warna teks putih untuk link */
      text-decoration: none;
    }

    .footer_section a:hover {
      color: #000000; /* Warna teks hitam saat hover */
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="dashboard.php">
          <span>
            Honda AHASS 904
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item active">
              <a class="nav-link" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="customer/customerlihat.php">
                Pelanggan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="motor/motorlihat.php">
                Motor
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="item/itemlihat.php">
                Item
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pegawai/pegawailihat.php">
                Pegawai
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pembayaran/pembayaranlihat.php">
                Pembayaran
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section">
      <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Selamat Datang di <br>
                        Honda AHASS 904
                      </h1>
                      <p>
                        Honda AHASS 904 adalah bengkel resmi Honda yang menyediakan layanan terbaik untuk kendaraan roda dua Anda. Kami menyediakan sparepart asli Honda, jasa servis berkualitas tinggi, dan pengecekan rutin oleh teknisi berpengalaman. Dengan komitmen kami untuk memberikan pelayanan terbaik, Anda dapat mempercayakan kendaraan Anda kepada kami untuk performa yang optimal dan tahan lama.
                      </p>
                      <p>
                        Layanan kami meliputi:
                      </p>
                      <ul>
                        <li>Penjualan sparepart asli Honda</li>
                        <li>Servis berkala dan perawatan rutin</li>
                        <li>Perbaikan mesin dan kelistrikan</li>
                        <li>Pengecekan dan penggantian oli</li>
                        <li>Pemeriksaan keselamatan kendaraan</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img src="images/ahass.jpg" alt="Honda AHASS 904" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>
  <!-- end hero area -->

  <!-- Pembayaran Terakhir Section -->
  <section class="pembayaran_terakhir_section">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Pembayaran Terakhir
        </h2>
      </div>
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="box">
            <div class="detail-box">
              <h5>Nama Customer: <?php echo $nama; ?></h5>
              <h5>Tanggal Pembayaran: <?php echo $tanggal; ?></h5>
              <h5>Jumlah Pembayaran: Rp <?php echo number_format($jumlah, 0, ',', '.'); ?></h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Pembayaran Terakhir Section -->

  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> Honda AHASS 904. All Rights Reserved.
      </p>
    </div>
  </footer>
  <!-- footer section -->

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>