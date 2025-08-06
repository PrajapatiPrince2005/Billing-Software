<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Inventory | MESHNA AUTO GERAJ</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 750px;
        }

        h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }
    </style>
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h3>➕ Add New Inventory Part</h3>

        <!-- Inventory Add Form -->
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label>Part Number (Code):</label>
                <input type="text" name="part_number" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Part Name:</label>
                <input type="text" name="part_name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Quantity:</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Purchase Price (₹):</label>
                <input type="number" step="0.01" name="purchase_price" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Sell Price (₹):</label>
                <input type="number" step="0.01" name="sell_price" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Supplier:</label>
                <input type="text" name="supplier" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Purchase Date:</label>
                <input type="date" name="purchase_date" class="form-control" required>
            </div>
            <div class="col-md-12">
                <button type="submit" name="save" class="btn btn-primary w-100">💾 Save Part</button>
            </div>
        </form>
    </div>

</body>

</html>

<?php
// Insert part into DB
if (isset($_POST['save'])) {
    $part_number = $_POST['part_number'];
    $part_name = $_POST['part_name'];
    $quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];
    $sell_price = $_POST['sell_price'];
    $supplier = $_POST['supplier'];
    $purchase_date = $_POST['purchase_date'];

    $sql = "INSERT INTO stock_parts (part_number, part_name, quantity, purchase_price, sell_price, supplier, purchase_date)
            VALUES ('$part_number', '$part_name', '$quantity', '$purchase_price', '$sell_price', '$supplier', '$purchase_date')";

    if ($conn->query($sql)) {
        echo "<script>alert('✅ Part added successfully'); window.location='add_part.php';</script>";
    } else {
        echo "<div class='alert alert-danger m-3'>❌ Error: " . $conn->error . "</div>";
    }
}
?>