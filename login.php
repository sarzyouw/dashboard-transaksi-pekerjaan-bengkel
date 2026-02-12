<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Honda AHASS 904</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap'>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, red, white);
      overflow: hidden;
      position: relative;
    }
    .background {
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
    }
    .background span {
      position: absolute;
      width: 20px;
      height: 20px;
      background: rgba(255,255,255,0.5);
      border-radius: 50%;
      animation: move 10s infinite linear;
    }
    @keyframes move {
      0% { transform: translateY(0px); opacity: 1; }
      100% { transform: translateY(-100vh); opacity: 0; }
    }
    .screen {
      text-align: center;
      width: 100%;
      max-width: 400px;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      position: relative;
      z-index: 1;
    }
    .logo {
      margin-bottom: 10px;
    }
    .input-group {
      margin-bottom: 15px;
    }
    .btn {
      background: red;
      color: white;
      padding: 10px;
      border: none;
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
    }
    .btn:hover {
      background: darkred;
    }
    .footer span {
      cursor: pointer;
      color: red;
    }
  </style>
</head>
<body>
  <div class="background">
    <!-- Animasi latar belakang -->
    <span style="top: 10%; left: 15%;"></span>
    <span style="top: 50%; left: 30%;"></span>
    <span style="top: 80%; left: 70%;"></span>
    <span style="top: 20%; left: 80%;"></span>
    <span style="top: 60%; left: 50%;"></span>
  </div>

  <div class="screen">
    <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
      <circle cx="50" cy="50" r="40" fill="red"></circle>
    </svg>
    <h3>Login</h3>
    <form action="connect.php" method="post">
      <div class="input-group">
        <input type="text" name="email" placeholder="Email" required>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn">Login</button>
  </div>
</body>
</html>
