<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="gu">
<head>
    <title>📑 બિલ વિગત</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Noto Sans Gujarati', sans-serif;
        }
        .container {
            background: #cdffc9ff;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }
        .highlight {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>📑 તમામ બિલ</h3>
<hr style="border: 2px solid black;">
    <!-- 🔍 શોધ ફોર્મ -->
    <form method="get" class="row mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="બિલ નં, ગ્રાહક, વાહન અથવા તારીખથી શોધો" value="<?= $_GET['search'] ?? '' ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 શોધો</button>
        </div>
        <div class="col-md-2">
            <a href="view_bills.php" class="btn btn-secondary w-100">⟳ રીસેટ કરો</a>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>બિલ નં</th>
                <th>ગ્રાહક</th>
                <th>વાહન નં</th>
                <th>પાર્ટ્સ ₹</th>
                <th>મજૂરી ₹</th>
                <th>કુલ રકમ ₹</th>
                <th>તારીખ</th>
                <th>ક્રિયા</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        $sql = "
            SELECT b.id, b.total_amount, b.labour_charge, b.bill_date,
                   c.name AS customer_name,
                   v.vehicle_number
            FROM bills b
            JOIN customers c ON b.customer_id = c.id
            JOIN vehicles v ON b.vehicle_id = v.id
            WHERE 
                b.id LIKE '%$search%' OR
                c.name LIKE '%$search%' OR
                v.vehicle_number LIKE '%$search%' OR
                b.bill_date LIKE '%$search%'
            ORDER BY b.id DESC";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $grandTotal = $row['total_amount'] + $row['labour_charge'];
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['vehicle_number']}</td>
                    <td>₹{$row['total_amount']}</td>
                    <td>₹{$row['labour_charge']}</td>
                    <td class='highlight'>₹" . number_format($grandTotal, 2) . "</td>
                    <td>{$row['bill_date']}</td>
                    <td>
                        <button class='btn btn-sm btn-info' onclick='viewItems({$row['id']})'>જુઓ</button>
                        <a href='print_bill.php?bill_id={$row['id']}' target='_blank' class='btn btn-sm btn-secondary'>🖨 છાપો</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center text-muted'>❌ બિલ મળ્યા નથી.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal - Bill View -->
<div class="modal fade" id="itemsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">🧾 બિલ વિગત</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="billItemsContent">
        <div id="printArea">Loading...</div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="printBillContent()">🖨 છાપો</button>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function viewItems(billId) {
    fetch('view_bill_items.php?bill_id=' + billId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('printArea').innerHTML = data;
            var modal = new bootstrap.Modal(document.getElementById('itemsModal'));
            modal.show();
        });
}

function printBillContent() {
    const content = document.getElementById("printArea").innerHTML;
    const printWindow = window.open("", "", "width=800,height=700");
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Bill</title>
            <style>
                body { font-family: Arial; padding: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
                th { background-color: #eee; }
                h3 { text-align: center; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <h3>🧾 Bill Details</h3>
            ${content}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>

</body>
</html>
