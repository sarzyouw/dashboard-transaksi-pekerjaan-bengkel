<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Informasi Honda AHASS 904</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(-45deg, #d50000, #ffffff, #d50000);
      background-size: 400% 400%;
      animation: gradientBG 5s ease infinite;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .container {
      text-align: center;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      margin-bottom: 20px;
      color: #d50000;
    }
    p {
      margin-bottom: 20px;
      font-size: 16px;
      color: #555;
    }
    .btn {
      display: inline-block;
      margin: 10px;
      padding: 10px 20px;
      font-size: 16px;
      font-weight: 600;
      color: #fff;
      background: #d50000;
      text-decoration: none;
      border-radius: 5px;
      transition: 0.3s;
    }
    .btn:hover {
      background: #b20000;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Sistem Informasi Honda AHASS 904</h1>
    <a href="login.php" class="btn">Login</a>
  </div>
</body>
</html>
