<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>👥 View Customers</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; }
        .container {
            background: #fff;
            margin-top: 40px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .table thead th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3 class="text-center">👥 All Customers</h3>

    <!-- Search -->
    <form method="get" class="row mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search by Name or Reach..." value="<?= $_GET['search'] ?? '' ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 Search</button>
        </div>
        <div class="col-md-2">
            <a href="view_customers.php" class="btn btn-secondary w-100">⟳ Reset</a>
        </div>
    </form>

    <!-- Table -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Reach</th>
                <th>Action</th>
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
                        <a href='add_customer.php?edit={$row['id']}' class='btn btn-sm btn-warning'>✏️ Edit</a>
                        <a href='add_customer.php?delete={$row['id']}' onclick=\"return confirm('Delete this customer?')\" class='btn btn-sm btn-danger'>🗑 Delete</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center text-muted'>No customers found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
