<?php
include 'db.php';

if (!isset($_GET['bill_id'])) {
    die("Bill ID missing.");
}
$bill_id = $_GET['bill_id'];

// Fetch bill to get labour charge
$bill = $conn->query("SELECT * FROM bills WHERE id = $bill_id")->fetch_assoc();
$labour_charge = $bill['labour_charge'] ?? 0;

// Fetch items
$items = $conn->query("
    SELECT bi.*, sp.part_name 
    FROM bill_items bi
    JOIN stock_parts sp ON bi.part_id = sp.id
    WHERE bi.bill_id = $bill_id
");
echo "<table class='table table-bordered'>
        <thead class='table-light'>
            <tr>
                <th>#</th>
                <th>Part</th>
                <th>Qty</th>
                <th>Price (₹)</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>";

$i = 1;
$part_total = 0;
while ($row = $items->fetch_assoc()) {
    $total = $row['quantity'] * $row['price'];
    $part_total += $total;
    echo "<tr>
            <td>{$i}</td>
            <td>{$row['part_name']}</td>
            <td>{$row['quantity']}</td>
            <td>₹{$row['price']}</td>
            <td>₹" . number_format($total, 2) . "</td>
        </tr>";
    $i++;
}

// Labour charge row
echo "<tr>
        <td colspan='4' class='text-end fw-bold'>Labour Charges:</td>
        <td><strong>₹" . number_format($labour_charge, 2) . "</strong></td>
    </tr>";

// Grand Total
$grand_total = $part_total + $labour_charge;
echo "<tr class='table-success'>
        <td colspan='4' class='text-end fw-bold'>Grand Total:</td>
        <td><strong>₹" . number_format($grand_total, 2) . "</strong></td>
    </tr>";

echo "</tbody></table>";
?>
