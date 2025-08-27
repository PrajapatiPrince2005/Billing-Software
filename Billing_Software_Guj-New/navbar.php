<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">

<style>
    .navbar-gujarati {
        background: linear-gradient(90deg, #1f1c2c, #928dab);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        font-family: 'Noto Sans Gujarati', sans-serif;
    }

    .navbar-brand {
    font-size: 24px;
    font-weight: 600;
    color: #ffc107 !important;
    letter-spacing: 0.5px;
    font-family: 'Noto Sans Gujarati', sans-serif;
    transition: color 0.3s ease, transform 0.3s ease;
}

.navbar-brand:hover {
    color: #fff !important;
    transform: scale(1.05);
}


    @keyframes glow {
        from {
            text-shadow: 0 0 5px #ffc107, 0 0 10px #ffc107;
        }
        to {
            text-shadow: 0 0 15px #ffd54f, 0 0 25px #ffd54f;
        }
    }

    .nav-link {
        color: #fff !important;
        margin-left: 15px;
        font-weight: 500;
        position: relative;
        transition: all 0.3s ease-in-out;
    }

    .nav-link::after {
        content: '';
        display: block;
        width: 0%;
        height: 2px;
        background-color: #ffc107;
        transition: width 0.3s ease;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-link:hover {
        color: #ffc107 !important;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255,255,255, 1%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
    .trail {
      position: fixed;
      width: 15px;
      height: 15px;
      background: #ffcc00;
      border-radius: 50%;
      pointer-events: none;
      box-shadow: 0 0 10px #ffcc00, 0 0 20px #ffcc00;
      transform: translate(-50%, -50%);
      z-index: 9999;
      transition: 0.08s ease;}
</style>
<link rel="stylesheet" href="cursor.css">
<script src="cursor.js" defer></script>
<nav class="navbar navbar-expand-lg navbar-dark navbar-gujarati mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">🚗 મહેસાણા ઓટો ગેરેજ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">🏠 હોમપેજ</a></li>
        <li class="nav-item"><a class="nav-link" href="add_customer.php">👤 ગ્રાહક ઉમેરો</a></li>
        <li class="nav-item"><a class="nav-link" href="create_bill.php">🧾 બિલ બનાવો</a></li>
        <li class="nav-item"><a class="nav-link" href="view_bills.php">📑 બિલ્સ જુઓ</a></li>
        <li class="nav-item"><a class="nav-link" href="add_part.php">🛒 સ્ટોક ઉમેરો</a></li>
        <li class="nav-item"><a class="nav-link" href="view_stock.php">📦 સ્ટોક જુઓ</a></li>
        <li class="nav-item"><a class="nav-link" href="view_customers.php">👥 ગ્રાહકો જુઓ</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">🔒 લૉગઆઉટ</a></li>
      </ul>
    </div>
  </div>
</nav>
 <script>
    const trail = document.querySelector('.trail');

    document.addEventListener('mousemove', (e) => {
      trail.style.left = e.clientX + 'px';
      trail.style.top = e.clientY + 'px';
    });
  </script>
