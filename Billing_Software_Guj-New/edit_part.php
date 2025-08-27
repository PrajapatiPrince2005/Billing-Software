<?php include 'db.php'; ?>

<?php
if (!isset($_GET['id'])) {
    die("અયોગ્ય પાર્ટ ID");
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM stock_parts WHERE id = $id");
$part = $result->fetch_assoc();

if (!$part) {
    die("પાર્ટ મળ્યો નથી.");
}

// Update
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

    echo "<script>alert('✅ પાર્ટ સફળતાપૂર્વક અપડેટ થયો.'); window.location='view_stock.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <title>✏️ પાર્ટ સુધારવા</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Noto Sans Gujarati', sans-serif;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-top: 50px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>✏️ પાર્ટ માહિતી સુધારો</h3>
    <form method="post">
        <div class="row g-3">
            <div class="col-md-4">
                <label>પાર્ટ નંબર</label>
                <input type="text" name="part_number" class="form-control" value="<?= $part['part_number'] ?>" required placeholder="ઉદા: 1234XYZ">
            </div>
            <div class="col-md-4">
                <label>પાર્ટ નામ</label>
                <input type="text" name="part_name" class="form-control" value="<?= $part['part_name'] ?>" required placeholder="ઉદા: બ્રેક શૂ">
            </div>
            <div class="col-md-4">
                <label>જથ્થો</label>
                <input type="number" name="quantity" class="form-control" value="<?= $part['quantity'] ?>" required placeholder="જેમ કે: 10">
            </div>
            <div class="col-md-4">
                <label>ખરીદ કિંમત ₹</label>
                <input type="number" name="purchase_price" class="form-control" value="<?= $part['purchase_price'] ?>" required placeholder="જેમ કે: 120.00">
            </div>
            <div class="col-md-4">
                <label>વેચાણ કિંમત ₹</label>
                <input type="number" name="sell_price" class="form-control" value="<?= $part['sell_price'] ?>" required placeholder="જેમ કે: 180.00">
            </div>
            <div class="col-md-4">
                <label>સપ્લાયર</label>
                <input type="text" name="supplier" class="form-control" value="<?= $part['supplier'] ?>" placeholder="ઉદા: રામ એન્જિન્સ">
            </div>
            <div class="col-md-4">
                <label>ખરીદીની તારીખ</label>
                <input type="date" name="purchase_date" class="form-control" value="<?= $part['purchase_date'] ?>" required>
            </div>
        </div>

        <br>
        <button type="submit" name="update" class="btn btn-success w-100">💾 અપડેટ કરો</button>
    </form>
</div>

</body>
</html>
