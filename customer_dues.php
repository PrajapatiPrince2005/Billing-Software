<?php include 'db.php'; ?> 
<!DOCTYPE html>
<html>
<head>
    <title>ગ્રાહક બાકી ચૂકવણી</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container {
            margin-top: 40px;
            background: #ffc9c9ff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .search-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3 class="text-center">💰 ગ્રાહક બાકી ચુકવણી</h3>
<hr style="border: 2px solid black;">
    <form method="get" class="search-box row">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="ગ્રાહકનું નામ અથવા વિસ્તારો શોધો..." value="<?= $_GET['search'] ?? '' ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 શોધો</button>
        </div>
        <div class="col-md-2">
            <a href="customer_dues.php" class="btn btn-secondary w-100">⟳ ફરીથી લાવો</a>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ગ્રાહક</th>
                <th>વિસ્તાર</th>
                <th>કુલ બિલ (₹)</th>
                <th>ચૂકવેલ રકમ (₹)</th>
                <th>બાકી રકમ (₹)</th>
                <th>ક્રિયા</th>
            </tr>
        </thead>
        <tbody>
<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "
    SELECT c.id AS customer_id, c.name, c.reach,
        COALESCE(SUM(b.total_amount),0) AS total_bill,
        COALESCE((SELECT SUM(p.paid_amount) FROM customer_payments p WHERE p.customer_id = c.id),0) AS total_paid
    FROM customers c
    LEFT JOIN bills b ON b.customer_id = c.id
    WHERE c.name LIKE '%$search%' OR c.reach LIKE '%$search%'
    GROUP BY c.id
    HAVING total_bill > total_paid
    ORDER BY c.name ASC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $due = $row['total_bill'] - $row['total_paid'];
        echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['reach']}</td>
            <td>₹{$row['total_bill']}</td>
            <td>₹{$row['total_paid']}</td>
            <td class='text-danger fw-bold'>₹" . number_format($due,2) . "</td>
            <td><button class='btn btn-sm btn-success' onclick=\"collectDue({$row['customer_id']}, '{$row['name']}', $due)\">ચુકવણી લો</button></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center text-muted'>કોઈ બાકી ચુકવણી મળતી નથી</td></tr>";
}
?>
        </tbody>
    </table>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="collectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">💵 ચુકવણી મેળવો</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="customer_id" id="modal_customer_id">
        <div class="mb-3">
            <label>ગ્રાહક નામ:</label>
            <input type="text" class="form-control" id="modal_customer_name" disabled>
        </div>
        <div class="mb-3">
            <label>બાકી રકમ (₹):</label>
            <input type="number" class="form-control" id="modal_due" disabled>
        </div>
        <div class="mb-3">
            <label>હમણાં મળી ચુકવણી (₹):</label>
            <input type="number" name="paid_amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>નોંધ (ફેકલ્ટેટિવ):</label>
            <input type="text" name="note" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="collect_now" class="btn btn-success">💾 સેવ કરો</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">રદ કરો</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function collectDue(id, name, due) {
    document.getElementById("modal_customer_id").value = id;
    document.getElementById("modal_customer_name").value = name;
    document.getElementById("modal_due").value = due;
    var modal = new bootstrap.Modal(document.getElementById('collectModal'));
    modal.show();
}
</script>

<?php
// Save due payment
if (isset($_POST['collect_now'])) {
    $cid = $_POST['customer_id'];
    $amount = $_POST['paid_amount'];
    $note = $_POST['note'];
    $conn->query("INSERT INTO customer_payments (customer_id, bill_id, paid_amount, note) VALUES ('$cid', NULL, '$amount', '$note')");
    echo "<script>alert('✅ ₹$amount ચુકવણી સેવ થઈ ગઈ છે.'); window.location='customer_dues.php';</script>";
}
?>

</body>
</html>
