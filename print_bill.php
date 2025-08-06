<?php include 'db.php'; ?>
<?php
if (!isset($_GET['bill_id'])) {
    die("Bill ID missing.");
}
$bill_id = $_GET['bill_id'];

// Fetch bill
$bill = $conn->query("SELECT b.*, c.name AS customer_name, c.phone, c.address, v.vehicle_number, v.model 
    FROM bills b
    JOIN customers c ON b.customer_id = c.id
    JOIN vehicles v ON b.vehicle_id = v.id
    WHERE b.id = $bill_id")->fetch_assoc();

// Fetch items
$items = $conn->query("SELECT bi.*, sp.part_name 
    FROM bill_items bi
    JOIN stock_parts sp ON bi.part_id = sp.id
    WHERE bi.bill_id = $bill_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Print Bill #<?= $bill_id ?></title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; margin: 30px; }
        .header { text-align: center; }
        .header h2 { margin-bottom: 5px; }
        .header small { color: gray; }
        .bill-details, .items, .footer { margin-top: 25px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .footer { text-align: right; font-weight: bold; }
        .print-btn { margin-bottom: 15px; }
    </style>
</head>
<body>

<button class="print-btn" onclick="window.print()">🖨 Print</button>

<div class="header">
    <h2>મહેસાણા ઓટો પાર્ટ્સ એન્ડ ગેરેજ</h2>
    <small>સંસ્થાપના: ૨૦૦૭ | જય શ્રી મેલડી કૃપા</small>
    <hr>
</div>

<div class="bill-details">
    <strong>Bill ID:</strong> <?= $bill['id'] ?><br>
    <strong>Date:</strong> <?= $bill['bill_date'] ?><br>
    <strong>Customer:</strong> <?= $bill['customer_name'] ?> (<?= $bill['phone'] ?>)<br>
    <strong>Address:</strong> <?= $bill['address'] ?><br>
    <strong>Vehicle:</strong> <?= $bill['vehicle_number'] ?> - <?= $bill['model'] ?>
</div>

<div class="items">
    <h4>Parts:</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Part</th>
                <th>Qty</th>
                <th>Price (₹)</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1; $grandTotal = 0;
            while ($row = $items->fetch_assoc()) {
                $total = $row['quantity'] * $row['price'];
                $grandTotal += $total;
                echo "<tr>
                    <td>$i</td>
                    <td>{$row['part_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>₹{$row['price']}</td>
                    <td>₹" . number_format($total, 2) . "</td>
                </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>

<div class="footer">
    <?php if ($bill['labour_charge'] > 0): ?>
        <div>Labour/Work Charges: ₹<?= number_format($bill['labour_charge'], 2) ?></div>
    <?php endif; ?>
    <div>Parts Total: ₹<?= number_format($grandTotal, 2) ?></div>
    <div><strong>Grand Total: ₹<?= number_format($grandTotal + $bill['labour_charge'], 2) ?></strong></div>
</div>


</body>
<div class="thank-you">
    <p>🙏 Thank you for your trust in <strong>MESHNA AUTO PARTS & GERAJ</strong></p>
    <p>We appreciate your business and look forward to serving you again!</p>
</div>

<style>
    .thank-you {
        margin-top: 60px;
        border-top: 2px dashed #999;
        padding-top: 20px;
        text-align: center;
        font-size: 18px;
        font-weight: 500;
        color: #2c3e50;
        font-family: 'Segoe UI', sans-serif;
    }
    .thank-you p:first-child {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>
<div class="terms">
    <strong>Terms & Conditions:</strong>
    <p>
        Once we have repaired and properly delivered the vehicle, we are not responsible for any issues that may occur afterward during usage.
    </p>
</div>

<style>
    .terms {
        margin-top: 30px;
        font-size: 14px;
        color: #555;
        font-family: 'Segoe UI', sans-serif;
        border-top: 1px dotted #ccc;
        padding-top: 15px;
    }
    .terms strong {
        color: #000;
    }
</style>

</html>
<div class="signature-section">
    <div class="signature-box">
        Customer Signature
    </div>
    <div class="signature-box">
        Authorized Signature
    </div>
</div>

<div class="date-line">
    Date: <?= date("d-m-Y") ?>
</div>

<style>
    .signature-section {
        margin-top: 60px;
        display: flex;
        justify-content: space-between;
    }
    .signature-box {
        width: 45%;
        border-top: 1px solid #000;
        text-align: center;
        padding-top: 10px;
        font-weight: 500;
    }
    .date-line {
        text-align: right;
        margin-top: 20px;
        font-style: italic;
        color: #444;
        font-size: 15px;
    }
</style>
