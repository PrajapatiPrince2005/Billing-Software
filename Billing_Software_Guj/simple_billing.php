<?php
$show_print = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST["customer_name"];
    $vehicle_number = $_POST["vehicle_number"];
    $items = $_POST["item_name"];
    $prices = $_POST["item_price"];
    $labour_charge = floatval($_POST["labour_charge"]);
    $total = 0;

    $bill_rows = "";

    for ($i = 0; $i < count($items); $i++) {
        $name = htmlspecialchars($items[$i]);
        $price = floatval($prices[$i]);
        $total += $price;
        $bill_rows .= "<tr><td>$name</td><td>₹$price</td></tr>";
    }

    $grand_total = $total + $labour_charge;
    $show_print = true;
}
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <title>બિલ બનાવો</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-header {
            text-align: center;
            border-bottom: 2px dashed #444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .terms {
            font-size: 14px;
            margin-top: 20px;
            border-top: 1px dashed #aaa;
            padding-top: 10px;
        }
    </style>
    <script>
        function addRow() {
            const container = document.getElementById("items-container");
            const row = document.createElement("div");
            row.className = "row mb-2";
            row.innerHTML = `
                <div class="col-md-6">
                    <input type="text" name="item_name[]" class="form-control" placeholder="વસ્તુનું નામ" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="item_price[]" class="form-control item-price" placeholder="કિંમત ₹" step="0.01" oninput="calculateTotal()" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="this.closest('.row').remove(); calculateTotal()">❌</button>
                </div>
            `;
            container.appendChild(row);
        }

        function calculateTotal() {
            let prices = document.querySelectorAll('.item-price');
            let labour = parseFloat(document.getElementById("labourCharge").value || 0);
            let total = 0;
            prices.forEach(input => {
                total += parseFloat(input.value || 0);
            });
            total += labour;
            document.getElementById("totalDisplay").innerText = `₹${total.toFixed(2)}`;
        }

        function printBill() {
            let printContents = document.getElementById("print-section").innerHTML;
            let w = window.open('', '', 'width=800,height=700');
            w.document.write('<html><head><title>બિલ પ્રિન્ટ કરો</title>');
            w.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
            w.document.write('<style>.invoice-header{text-align:center;border-bottom:2px dashed #444;padding-bottom:10px;margin-bottom:20px;}.terms{font-size:14px;margin-top:20px;border-top:1px dashed #aaa;padding-top:10px;}</style>');
            w.document.write('</head><body>');
            w.document.write(printContents);
            w.document.write('</body></html>');
            w.document.close();
            w.print();
        }
    </script>
</head>
<body class="bg-light">
      <?php include 'navbar.php'; ?>
<div class="container mt-5 p-4 bg-white rounded shadow">
    <h2 class="mb-4 text-center">🧾 નવું બિલ બનાવો</h2>

    <form method="POST" oninput="calculateTotal()">
        <div class="mb-3">
            <label class="form-label">ગ્રાહકનું નામ:</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">વાહન નંબર:</label>
            <input type="text" name="vehicle_number" class="form-control" required>
        </div>

        <label class="form-label">વસ્તુઓ અને કિંમત:</label>
        <div id="items-container">
            <div class="row mb-2">
                <div class="col-md-6">
                    <input type="text" name="item_name[]" class="form-control" placeholder="વસ્તુનું નામ" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="item_price[]" class="form-control item-price" placeholder="કિંમત ₹" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="this.closest('.row').remove(); calculateTotal()">❌</button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">➕ વધુ વસ્તુ ઉમેરો</button>

        <div class="mb-3">
            <label class="form-label">મજૂરી ચાર્જ ₹:</label>
            <input type="number" step="0.01" id="labourCharge" name="labour_charge" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">💰 કુલ રકમ: <span id="totalDisplay">₹0.00</span></label>
        </div>

        <button type="submit" class="btn btn-primary w-100">💾 બિલ સબમિટ કરો</button>
    </form>

    <?php if ($show_print): ?>
    <div id="print-section" class="mt-5">
        <div class="invoice-header">
            <h2>મહેસાણા ઓટો પાર્ટ્સ એન્ડ ગેરેજ</h2>
            <p>સંસ્થાપના: ૨૦૦૭ | જય શ્રી મેલડી કૃપા 🙏</p>
        </div>

        <p><strong>ગ્રાહકનું નામ:</strong> <?= $customer_name ?></p>
        <p><strong>વાહન નં:</strong> <?= $vehicle_number ?></p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>વસ્તુ</th>
                    <th>કિંમત ₹</th>
                </tr>
            </thead>
            <tbody>
                <?= $bill_rows ?>
            </tbody>
        </table>

        <p><strong>મજૂરી ચાર્જ:</strong> ₹<?= number_format($labour_charge, 2) ?></p>
        <h5><strong>કુલ રકમ:</strong> ₹<?= number_format($grand_total, 2) ?></h5>

        <div class="mt-3">
            <p>🙏 <strong>Thank you for your visit!</strong></p>
        </div>

        <div class="terms">
            <strong>🔹 Terms & Conditions:</strong>
            <ul>
                <li>સામાન વેચાય પછી પાછું લેવામાં આવતું નથી.</li>
                <li>પેમેન્ટ કેશ/ઉપીઆઈ દ્વારા સ્વીકારવામાં આવે છે.</li>
                <li>બિલના વિવાદ માટે માત્ર મહેસાણા જ્યુરીસ્ડીકશન લાગુ પડશે.</li>
            </ul>
        </div>
    </div>

    <button onclick="printBill()" class="btn btn-success mt-3">📄 PDF / 🖨️ પ્રિન્ટ કરો</button>
    <?php endif; ?>
</div>
</body>
</html>
