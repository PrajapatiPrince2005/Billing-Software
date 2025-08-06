<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - Meshna Auto Parts & Geraj</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('./BackGround2.jpg') no-repeat center center fixed;
      background-size: cover;
      animation: bgfade 10s ease-in-out infinite alternate;
    }

    @keyframes bgfade {
      0% { filter: brightness(0.8); }
      100% { filter: brightness(1.1); }
    }

    .login-box {
      background: rgba(255, 255, 255, 0.95);
      max-width: 450px;
      margin: 100px auto;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      animation: fadeIn 1.5s;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      font-family: 'Orbitron', sans-serif;
      margin-bottom: 30px;
      color: #2c3e50;
    }

    .login-box input {
      height: 45px;
      font-size: 16px;
    }

    .btn-login {
      background: #2e86de;
      color: white;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .btn-login:hover {
      background: #1b4f72;
    }

    .footer-note {
      text-align: center;
      margin-top: 15px;
      font-size: 13px;
      color: orangered;
    }

    .brand-name {
      text-align: center;
      font-size: 18px;
      margin-top: 10px;
      color: #000;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Admin Login</h2>
  <form method="POST" action="login_process.php">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-login w-100">Login</button>
    <div class="mt-3 text-center">
      <a href="#">Forgot Password?</a>
    </div>
  </form>

  <div class="brand-name">
    <strong>MESHNA AUTO PARTS & GERAJ</strong><br>
    Since 2007 | Jay Shree Meldi Krupa
  </div>
</div>

<div class="footer-note">
  &copy; <?= date('Y') ?> Meshna Auto Parts. All rights reserved.
</div>

</body>
</html>
