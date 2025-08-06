<?php include 'db.php'; ?>

<?php
// Fetch Part Data
if (!isset($_GET['id'])) {
    die("Invalid Part ID");
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM stock_parts WHERE id = $id");
$part = $result->fetch_assoc();

if (!$part) {
    die("Part not found.");
}

// Update Logic
if (isset($_POST['update'])) {
    $part_number = $_POST['part_number'];
    $part_name = $_POST['part_name'];
    $quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];
    $sell_price = $_POST['sell_price'];
    $supplier = $_POST['supplier'];
    $purchase_date = $_POST['purchase_date'];

    $conn->query("UPDATE stock_parts SET 
        part_number = '$part_number',
        part_name = '$part_name',
        quantity = '$quantity',
        purchase_price = '$purchase_price',
        sell_price = '$sell_price',
        supplier = '$supplier',
        purchase_date = '$purchase_date'
        WHERE id = $id
    ");

    echo "<script>alert('✅ Part updated successfully.'); window.location='view_stock.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Part</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef2f7; }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-top: 50px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3 class="text-center">✏️ Edit Part</h3>
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                <label>Part Number</label>
                <input type="text" name="part_number" class="form-control" value="<?= $part['part_number'] ?>" required>
            </div>
            <div class="col-md-4">
                <label>Part Name</label>
                <input type="text" name="part_name" class="form-control" value="<?= $part['part_name'] ?>" required>
            </div>
            <div class="col-md-4">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" value="<?= $part['quantity'] ?>" required>
            </div>
            <div class="col-md-4">
                <label>Purchase Price (₹)</label>
                <input type="number" name="purchase_price" class="form-control" value="<?= $part['purchase_price'] ?>" required>
            </div>
            <div class="col-md-4">
                <label>Sell Price (₹)</label>
                <input type="number" name="sell_price" class="form-control" value="<?= $part['sell_price'] ?>" required>
            </div>
            <div class="col-md-4">
                <label>Supplier</label>
                <input type="text" name="supplier" class="form-control" value="<?= $part['supplier'] ?>" required>
            </div>
            <div class="col-md-4">
                <label>Purchase Date</label>
                <input type="date" name="purchase_date" class="form-control" value="<?= $part['purchase_date'] ?>" required>
            </div>
        </div>
        <br>
        <button type="submit" name="update" class="btn btn-success w-100">💾 Update Part</button>
    </form>
</div>

</body>
</html>
