<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="gu">
<head>
    <title>👥 ગ્રાહકો જોઈ શકાય</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #c9e4ffff;
            font-family: 'Noto Sans Gujarati', sans-serif;
        }
        .container {
            background: #fcffc9ff;
            margin-top: 40px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 {
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>👥 તમામ ગ્રાહકો</h3>
<hr style="border: 2px solid black;">
    <!-- 🔍 શોધ -->
    <form method="get" class="row mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="નામ અથવા રીચથી શોધો..." value="<?= $_GET['search'] ?? '' ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 શોધો</button>
        </div>
        <div class="col-md-2">
            <a href="view_customers.php" class="btn btn-secondary w-100">⟳ રીસેટ</a>
        </div>
    </form>

    <!-- ટેબલ -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>આઈડી</th>
                <th>નામ</th>
                <th>મોબાઇલ</th>
                <th>સરનામું</th>
                <th>રીચ</th>
                <th>ક્રિયા</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $search = $_GET['search'] ?? '';
        $sql = "SELECT * FROM customers WHERE name LIKE '%$search%' OR reach LIKE '%$search%' ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['reach']}</td>
                    <td>
                        <a href='add_customer.php?edit={$row['id']}' class='btn btn-sm btn-warning'>✏️ સુધારો</a>
                        <a href='add_customer.php?delete={$row['id']}' onclick=\"return confirm('શું ખરેખર કાઢી નાંખવું છે?')\" class='btn btn-sm btn-danger'>🗑 કાઢો</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center text-muted'>❌ કોઈ ગ્રાહકો મળ્યા નથી.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
