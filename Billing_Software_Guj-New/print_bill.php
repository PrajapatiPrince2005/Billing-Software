<?php
include 'db.php';

if (!isset($_GET['bill_id']) || empty($_GET['bill_id'])) {
    die("Bill ID missing.");
}

$bill_id = intval($_GET['bill_id']);

// Bill & Customer Info
$sql = "
    SELECT b.id, b.bill_date, b.total_amount, 
           b.labour_charge,    -- 👈 સાચું નામ
           c.name, c.phone, b.vehicle_number, c.address 
    FROM bills b 
    JOIN customers c ON b.customer_id = c.id 
    WHERE b.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();

if (!$bill) {
    die("Bill not found.");
}

// Bill Items
$items_sql = "
    SELECT bi.*, sp.part_name 
    FROM bill_items bi 
    JOIN stock_parts sp ON bi.part_id = sp.id 
    WHERE bi.bill_id = ?
";
$stmt_items = $conn->prepare($items_sql);
$stmt_items->bind_param("i", $bill_id);
$stmt_items->execute();
$items = $stmt_items->get_result();
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <title>Bill #<?php echo $bill_id; ?></title>
    <style>
        body { font-family: "Noto Sans Gujarati", sans-serif; margin: 0; padding: 0; }
        .a5-page { width: 148mm; height: 210mm; padding: 15px; border: 3px solid #000; margin: auto; }
        h2, h3 { margin: 5px 0; text-align: center; }
        .company { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 5px; text-align: center; font-size: 14px; }
        .terms { font-size: 12px; margin-top: 10px; border-top: 1px solid #000; padding-top: 5px; }
        .footer { text-align: center; margin-top: 10px; font-size: 13px; }
        .no-border td { border: none; text-align: left; }
    </style>
    <script>
        window.onload = function(){ window.print(); }
    </script>
</head>
<body>
<div class="a5-page">
    <div class="company">
        <h2>🚗 મહેસાણા ઓટો પાર્ટ્સ એન્ડ ગેરેજ 🚗</h2>
        <p>સ્થાપના વર્ષ: 2007</p>
        <p>જય શ્રી મેલડી કૃપા</p>
        <p>📞 7895648860 / 8977586955</p>
    </div>

    <h3>ગ્રાહક બિલ</h3>

    <table class="no-border">
        <tr>
            <td><b>બિલ નં:</b> <?php echo $bill['id']; ?></td>
            <td><b>તારીખ:</b> <?php echo date("d-m-Y", strtotime($bill['bill_date'])); ?></td>
        </tr>
        <tr>
            <td><b>ગ્રાહક નામ:</b> <?php echo $bill['name']; ?></td>
            <td><b>મોબાઇલ:</b> <?php echo $bill['phone']; ?></td>
        </tr>
        <tr>
            <td><b>વાહન નં:</b> <?php echo $bill['vehicle_number']; ?></td>
            <td><b>સરનામું:</b> <?php echo $bill['address']; ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <th>ક્રમ</th>
            <th>પાર્ટનું નામ</th>
            <th>જથ્થો</th>
            <th>ભાવ</th>
            <th>કુલ</th>
        </tr>
        <?php 
        $i = 1; 
        while($row = $items->fetch_assoc()): 
            $total = $row['quantity'] * $row['price'];
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['part_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['price'], 2); ?></td>
            <td><?php echo number_format($total, 2); ?></td>
        </tr>
        <?php endwhile; ?>

        <tr>
            <td colspan="4"><b>લેબર ચાર્જ</b></td>
            <td><?php echo number_format($bill['labour_charge'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>કુલ રકમ</b></td>
            <td><b><?php echo number_format($bill['total_amount'], 2); ?></b></td>
        </tr>
    </table>

    <div class="terms">
        <b>Terms & Conditions:</b>
        <p>1) માલ પરત લેવો નહિ. <br>
           2) ચુકવણી તરત જ કરવી. <br>
           3) ગેરેજ કોઈ પણ પ્રકારની નુકશાની માટે જવાબદાર નહિ હોય.</p>
    </div>

    <div class="footer">
        <p>🙏 આપનો આભાર, ફરી આવજો 🙏</p>
    </div>
</div>
</body>
</html>
