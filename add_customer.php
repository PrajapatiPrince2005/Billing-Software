<?php include 'db.php'; ?>
<?php
$editData = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM customers WHERE id=$id");
    $editData = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 { text-align: center; margin-bottom: 25px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>👤 Customer Management</h3>

    <!-- Customer Form -->
    <form method="post" class="row g-3">
        <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $editData['id'] : '' ?>">

        <div class="col-md-4">
            <label>Name:</label>
            <input type="text" name="name" class="form-control"
                value="<?= isset($_GET['edit']) ? $editData['name'] : '' ?>" required>
        </div>
        <div class="col-md-4">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control"
                value="<?= isset($_GET['edit']) ? $editData['phone'] : '' ?>">
        </div>
        <div class="col-md-4">
            <label>Address:</label>
            <input type="text" name="address" class="form-control"
                value="<?= isset($_GET['edit']) ? $editData['address'] : '' ?>">
        </div>
        <div class="col-md-12">
            <button type="submit" name="<?= isset($_GET['edit']) ? 'update' : 'save' ?>" class="btn btn-primary">
                <?= isset($_GET['edit']) ? 'Update' : 'Add Customer' ?>
            </button>
        </div>
    </form>

    <hr>

    <!-- Customer List -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Handle DB connection
            include 'db.php';

            // Save
            if (isset($_POST['save'])) {
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $conn->query("INSERT INTO customers (name, phone, address) VALUES ('$name', '$phone', '$address')");
                echo "<script>window.location='add_customer.php';</script>";
            }

            // Update
            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $conn->query("UPDATE customers SET name='$name', phone='$phone', address='$address' WHERE id=$id");
                echo "<script>window.location='add_customer.php';</script>";
            }

            // Delete
            if (isset($_GET['delete'])) {
                $id = $_GET['delete'];
                $conn->query("DELETE FROM customers WHERE id=$id");
                echo "<script>window.location='add_customer.php';</script>";
            }

            // Edit
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $res = $conn->query("SELECT * FROM customers WHERE id=$id");
                $editData = $res->fetch_assoc();
            }

            // Display table
            $result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>
                        <a href='add_customer.php?edit={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='add_customer.php?delete={$row['id']}' onclick=\"return confirm('Delete this customer?')\" class='btn btn-sm btn-danger'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
