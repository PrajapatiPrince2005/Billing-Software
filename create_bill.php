<?php include 'db.php'; ?> 
<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>નવી બિલ બનાવો</title>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: hsla(0, 67%, 97%, 1.00);
        }

        .container {
            background: hsla(0, 67%, 97%, 1.00);
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        <h3>🧾 નવી બિલ બનાવો</h3>

        <form method="post">
            <!-- Customer -->
            <div class="mb-3">
                <label>ગ્રાહક પસંદ કરો:</label>
                <select name="customer_id" class="form-select" required onchange="this.form.submit()">
                    <option value="">-- ગ્રાહક પસંદ કરો --</option>
                    <?php
                    $customers = $conn->query("SELECT * FROM customers");
                    while ($c = $customers->fetch_assoc()) {
                        $selected = (isset($_POST['customer_id']) && $_POST['customer_id'] == $c['id']) ? "selected" : "";
                        echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Vehicle -->
            <?php if (!empty($_POST['customer_id'])): ?>
                <div class="mb-3">
                    <label>વાહન પસંદ કરો:</label>
                    <select name="vehicle_id" class="form-select" required>
                        <option value="">-- વાહન પસંદ કરો --</option>
                        <?php
                        $vehicles = $conn->query("SELECT * FROM vehicles WHERE customer_id = {$_POST['customer_id']}");
                        while ($v = $vehicles->fetch_assoc()) {
                            echo "<option value='{$v['id']}'>{$v['vehicle_number']} - {$v['model']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Part Selection -->
                <div class="mb-3">
                    <label>સ્પેર પાર્ટ્સ પસંદ કરો:</label>
                    <table class="table table-bordered" id="partsTable">
                        <thead>
                            <tr>
                                <th>પાર્ટ</th>
                                <th>જથ્થો</th>
                                <th>ભાવ (₹)</th>
                                <th>કુલ</th>
                                <th>કામ</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button type="button" class="btn btn-secondary" onclick="addPartRow()">➕ પાર્ટ ઉમેરો</button>
                </div>

                <div class="mb-3">
                    <label><strong>મજૂરી ચાર્જ (₹):</strong></label>
                    <input type="number" name="labour_charge" id="labourCharge" class="form-control" min="0" onchange="calcTotal()" required>

                    <label class="form-label fw-bold mt-3">કુલ રકમ: ₹<span id="grandTotal">0</span></label><br>

                    <label>લેણી લેનાર પાસેથી ભરપાઈ (₹):</label>
                    <input type="number" name="paid_amount" class="form-control d-inline-block w-25" step="0.01" required>
                </div>

                <center><button type="submit" name="save_bill" class="btn btn-primary w-50">💾 બિલ સાચવો</button></center>
            <?php endif; ?>
        </form>
    </div>


    <!-- JS for Part Add Row -->
    <script>
        let partsData = {};
        <?php
        $parts = $conn->query("SELECT * FROM stock_parts");
        echo "partsData = {";
        while ($p = $parts->fetch_assoc()) {
            $name = addslashes($p['part_name']);
            $code = addslashes($p['part_number']); // assuming your field is part_number
            $price = $p['sell_price'];
            $id = $p['id'];
            echo "$id:{name:'$name', code:'$code', price:$price},";
        }
        echo "};";
        ?>



        function addPartRow() {
            let row = document.createElement("tr");
            row.innerHTML = `
    <td style="width: 40%;">
        <select name="part_id[]" class="form-select part-select" onchange="updatePrice(this)">
            <option value="">-- Select --</option>
            ${Object.entries(partsData).map(([id, p]) => `
                <option value="${id}" data-code="${p.code}">${p.name}</option>
            `).join('')}
        </select>
    </td>
    <td style="width: 10%;"><input type="number" name="qty[]" class="form-control" value="1" min="1" onchange="calcTotal()"></td>
    <td style="width: 15%;"><input type="number" name="price[]" class="form-control" readonly></td>
    <td style="width: 20%;"><span class="itemTotal">0</span></td>
    <td style="width: 10%;"><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); calcTotal();">❌</button></td>
    `;
            document.querySelector("#partsTable tbody").appendChild(row);

            // Enable Select2 with custom matcher for name OR part number search
            $(row).find('.part-select').select2({
                width: '100%',
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') return data;
                    if (typeof data.text === 'undefined') return null;

                    let code = $(data.element).data('code')?.toString().toLowerCase() || '';
                    let term = params.term.toLowerCase();
                    if (data.text.toLowerCase().includes(term) || code.includes(term)) {
                        return data;
                    }
                    return null;
                }
            });
        }


        function updatePrice(select) {
            let id = select.value;
            let row = select.closest("tr");
            if (partsData[id]) {
                row.querySelector('[name="price[]"]').value = partsData[id].price;
                calcTotal();
            }
        }

        function calcTotal() {
            let total = 0;
            document.querySelectorAll("#partsTable tbody tr").forEach(row => {
                let qty = parseFloat(row.querySelector('[name="qty[]"]').value || 0);
                let price = parseFloat(row.querySelector('[name="price[]"]').value || 0);
                let lineTotal = qty * price;
                row.querySelector(".itemTotal").innerText = lineTotal.toFixed(2);
                total += lineTotal;
            });

            // Add Labour Charges
            let labour = parseFloat(document.getElementById("labourCharge").value || 0);
            total += labour;

            document.getElementById("grandTotal").innerText = total.toFixed(2);
        }
    </script>

</body>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('select.select-part').select2({
            width: '100%'
        });
    });
</script>

</html>

<?php
if (isset($_POST['save_bill'])) {
    $labour_charge = floatval($_POST['labour_charge']);
    $customer_id = $_POST['customer_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $part_ids = $_POST['part_id'];
    $qtys = $_POST['qty'];
    $prices = $_POST['price'];
    $paid_amount = floatval($_POST['paid_amount']);

    // Calculate total bill
    $total += $labour_charge;

    for ($i = 0; $i < count($part_ids); $i++) {
        $total += $qtys[$i] * $prices[$i];
    }

    // Insert Bill
    $conn->query("INSERT INTO bills (customer_id, vehicle_id, total_amount, labour_charge)
              VALUES ('$customer_id', '$vehicle_id', '$total', '$labour_charge')");

    $bill_id = $conn->insert_id;

    // Insert Bill Items
    for ($i = 0; $i < count($part_ids); $i++) {
        $pid = $part_ids[$i];
        $q = $qtys[$i];
        $p = $prices[$i];
        $conn->query("INSERT INTO bill_items (bill_id, part_id, quantity, price) VALUES ('$bill_id', '$pid', '$q', '$p')");
        $conn->query("UPDATE stock_parts SET quantity = quantity - $q WHERE id = $pid");
    }

    // Insert into customer_payments
    $conn->query("INSERT INTO customer_payments (customer_id, bill_id, paid_amount, note) VALUES ('$customer_id', '$bill_id', '$paid_amount', 'Initial Payment')");

    // Calculate remaining due
    $due = $total - $paid_amount;

   echo "<script>alert('✅ ₹$paid_amount મેળવાયા. ₹$due બાકી છે.'); window.location='create_bill.php';</script>";

}
?>