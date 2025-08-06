<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>📑 View Bills</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; }
        .container {
            background: #fff;
            margin-top: 40px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .modal-title { font-weight: bold; }
        .highlight { font-weight: bold; color: #2c3e50; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3 class="text-center">📑 All Bills</h3>

    <!-- 🔍 Search Form -->
    <form method="get" class="row mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search by Bill ID, Customer, Vehicle or Date" value="<?= $_GET['search'] ?? '' ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 Search</button>
        </div>
        <div class="col-md-2">
            <a href="view_bills.php" class="btn btn-secondary w-100">⟳ Reset</a>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Bill ID</th>
                <th>Customer</th>
                <th>Vehicle</th>
                <th>Parts (₹)</th>
                <th>Labour (₹)</th>
                <th>Grand Total (₹)</th>
                <th>Date</th>
                <th>Action</th>
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
                        <button class='btn btn-sm btn-info' onclick='viewItems({$row['id']})'>View</button>
                        <a href='print_bill.php?bill_id={$row['id']}' target='_blank' class='btn btn-sm btn-secondary'>🖨 Print</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center text-muted'>No bills found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- View Items Modal -->
<div class="modal fade" id="itemsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">🧾 Bill Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="billItemsContent">
    <div id="printArea">Loading...</div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" onclick="printBillContent()">🖨 Print</button>
</div>

    </div>
  </div>
</div>

<!-- Bootstrap JS + AJAX -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function viewItems(billId) {
    fetch('view_bill_items.php?bill_id=' + billId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('billItemsContent').innerHTML = data;
            var modal = new bootstrap.Modal(document.getElementById('itemsModal'));
            modal.show();
        });
}

</script>
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
