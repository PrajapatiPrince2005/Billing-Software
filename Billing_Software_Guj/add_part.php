<?php include 'db.php'; ?> 
<!DOCTYPE html>
<html lang="gu">
<head>
    <title>ઈન્વેન્ટરી ઉમેરો | MESHNA AUTO GERAJ</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Noto Sans Gujarati', sans-serif;
        }

        .container {
            background: #ffee9bff;
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
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>🛠️ નવા પાર્ટ્સ ઉમેરો</h3>
<hr style="border: 2px solid black;">
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label>પાર્ટ નંબર:</label>
            <input type="text" name="part_number" class="form-control" placeholder="જેમ કે: 0123-A12" required>
        </div>
        <div class="col-md-6">
            <label>પાર્ટ નામ:</label>
            <input type="text" name="part_name" class="form-control" placeholder="જેમ કે: Oil Filter" required>
        </div>
        <div class="col-md-4">
            <label>જથ્થો:</label>
            <input type="number" name="quantity" class="form-control" placeholder="જેમ કે: 10" required>
        </div>
        <div class="col-md-4">
            <label>ખરીદ કિંમત (₹):</label>
            <input type="number" step="0.01" name="purchase_price" class="form-control" placeholder="જેમ કે: 120.50" required>
        </div>
        <div class="col-md-4">
            <label>વેચાણ કિંમત (₹):</label>
            <input type="number" step="0.01" name="sell_price" class="form-control" placeholder="જેમ કે: 150.00" required>
        </div>
        <div class="col-md-6">
            <label>સપ્લાયરનું નામ:</label>
            <input type="text" name="supplier" class="form-control" placeholder="જેમ કે: Raju Auto Traders">
        </div>
        <div class="col-md-6">
            <label>ખરીદ તારીખ:</label>
            <input type="date" name="purchase_date" class="form-control" required>
        </div>
        <div class="col-md-12">
            <button type="submit" name="save" class="btn btn-success w-100">💾 પાર્ટ ઉમેરો</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
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
        echo "<script>alert('✅ પાર્ટ સફળતાપૂર્વક ઉમેરવામાં આવ્યો'); window.location='add_part.php';</script>";
    } else {
        echo "<div class='alert alert-danger m-3'>❌ ભૂલ: " . $conn->error . "</div>";
    }
}
?>
