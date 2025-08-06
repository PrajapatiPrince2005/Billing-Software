<!-- navbar.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .navbar-custom {
        background: linear-gradient(90deg, #1f1c2c, #928dab);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .navbar-brand {
        font-size: 22px;
        font-weight: 700;
        color: #ffc107 !important;
        letter-spacing: 1px;
        font-family: 'Poppins', sans-serif;
        animation: glow 1.5s ease-in-out infinite alternate;
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
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">🚗 MESHNA AUTO GERAJ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">🏠 Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="add_customer.php">👤 Add Customer</a></li>
        <li class="nav-item"><a class="nav-link" href="add_vehicle.php">🚘 Add Vehicle</a></li>
        <li class="nav-item"><a class="nav-link" href="add_part.php">🛒 Add Inventory</a></li>
        <li class="nav-item"><a class="nav-link" href="view_stock.php">📦 View Stock</a></li>
        <li class="nav-item"><a class="nav-link" href="create_bill.php">🧾 Create Bill</a></li>
        <li class="nav-item"><a class="nav-link" href="view_bills.php">📑 View Bills</a></li>
        <li class="nav-item"><a class="nav-link" href="view_customers.php">👥 View Customers</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">🔒 Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
