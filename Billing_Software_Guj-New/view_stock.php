<?php include 'db.php'; ?> 
<!DOCTYPE html>
<html lang="gu">
<head>
    <title>📦 સ્ટોક યાદી | MESHNA AUTO GERAJ</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

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
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }
        .low-stock {
            background-color: #ffe2e2 !important;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>📦 સ્ટોકની યાદી</h3>
<hr style="border: 2px solid black;">

    <table id="stockTable" class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ક્રમ</th>
                <th>પાર્ટ નં.</th>
                <th>પાર્ટ નામ</th>
                <th>જથ્થો</th>
                <th>ખરીદ કિંમત ₹</th>
                <th>વેચાણ કિંમત ₹</th>
                <th>સપ્લાયર</th>
                <th>તારીખ</th>
                <th>કાર્ય</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Delete part
            if (isset($_GET['delete'])) {
                $id = $_GET['delete'];
                $conn->query("DELETE FROM stock_parts WHERE id = $id");
                echo "<script>window.location='view_stock.php';</script>";
            }

            // Display stock
            $result = $conn->query("SELECT * FROM stock_parts ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                $lowStockClass = ($row['quantity'] <= 5) ? "low-stock" : "";
                echo "<tr class='$lowStockClass'>
                        <td>{$row['id']}</td>
                        <td>{$row['part_number']}</td>
                        <td>{$row['part_name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>₹{$row['purchase_price']}</td>
                        <td>₹{$row['sell_price']}</td>
                        <td>{$row['supplier']}</td>
                        <td>{$row['purchase_date']}</td>
                        <td>
                            <a href='edit_part.php?id={$row['id']}' class='btn btn-sm btn-warning'>✏️</a>
                            <a href='view_stock.php?delete={$row['id']}' onclick=\"return confirm('શું તમે આ પાર્ટને કાઢી નાખવા માંગો છો?')\" class='btn btn-sm btn-danger'>🗑</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
$(document).ready(function () {
    $('#stockTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        language: {
            search: "શોધો:",
            lengthMenu: "દરેક પેજે _MENU_ રેકોર્ડ",
            info: "_TOTAL_માંથી _START_ થી _END_ દર્શાવી રહ્યું છે",
            paginate: { next: "આગળ", previous: "પાછળ" }
        }
    });
});
</script>

</body>
</html>
