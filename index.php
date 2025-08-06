<!-- index.php -->
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | MESHNA AUTO PARTS & GERAJ</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eaf0f7;
            font-family: 'Segoe UI', sans-serif;
        }
        .main-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 1px;
        }
        .text-muted {
            text-align: center;
            font-size: 16px;
            margin-top: -10px;
        }
        .btn-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 35px;
        }
        .btn-lg {
            height: 65px;
            font-size: 18px;
            transition: 0.3s ease;
            border-radius: 12px;
        }
        .btn-lg:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-card {
                padding: 25px;
            }
            .btn-lg {
                height: 55px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="main-card">
        <h2>MESHNA AUTO PARTS & GERAJ</h2>
        <p class="text-muted">SINCE 2007 | Jay Shree Meldi Krupa</p>

        <div class="btn-grid">
            <a href="add_customer.php" class="btn btn-primary btn-lg">👤 Add Customer</a>
            <a href="add_vehicle.php" class="btn btn-secondary btn-lg">🚘 Add Vehicle</a>
            <a href="create_bill.php" class="btn btn-success btn-lg">🧾 Create Bill</a>
            <a href="add_part.php" class="btn btn-warning btn-lg">➕ Add Inventory</a>
            <a href="view_stock.php" class="btn btn-info btn-lg">📦 View Stock</a>
            <a href="view_customers.php" class="btn btn-dark btn-lg">👥 View Customers</a>
            <a href="view_bills.php" class="btn btn-outline-success btn-lg">📑 View Bills</a>
            <a href="customer_dues.php" class="btn btn-outline-success btn-lg">📑 Customer Dues</a>
            <a href="logout.php" class="btn btn-outline-danger btn-lg">🔒 Logout</a>
        </div>
    </div>
</div>

</body>
</html>
