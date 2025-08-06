<?php include 'db.php'; ?>
<?php
$editData = null;

// Handle Edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM vehicles WHERE id = $id");
    $editData = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Vehicles</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; }
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
    <h3>🚘 Vehicle Management</h3>

    <!-- Form -->
    <form method="post" class="row g-3">
        <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $editData['id'] : '' ?>">

        <div class="col-md-4">
            <label>Customer:</label>
            <select name="customer_id" class="form-select" required>
                <option value="">-- Select Customer --</option>
                <?php
                $customers = $conn->query("SELECT * FROM customers");
                while ($c = $customers->fetch_assoc()) {
                    $selected = isset($_GET['edit']) && $c['id'] == $editData['customer_id'] ? "selected" : "";
                    echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Vehicle Number:</label>
            <input type="text" name="vehicle_number" class="form-control"
                   value="<?= isset($_GET['edit']) ? $editData['vehicle_number'] : '' ?>" required>
        </div>

        <div class="col-md-4">
            <label>Model:</label>
            <input type="text" name="model" class="form-control"
                   value="<?= isset($_GET['edit']) ? $editData['model'] : '' ?>">
        </div>

        <div class="col-md-4">
            <label>Brand:</label>
            <input type="text" name="brand" class="form-control"
                   value="<?= isset($_GET['edit']) ? $editData['brand'] : '' ?>">
        </div>

        <div class="col-md-4">
            <label>Fuel Type:</label>
            <select name="fuel_type" class="form-select">
                <option value="">-- Select --</option>
                <?php
                $fuels = ['Diesel', 'Petrol', 'CNG'];
                foreach ($fuels as $fuel) {
                    $selected = (isset($_GET['edit']) && $editData['fuel_type'] == $fuel) ? "selected" : "";
                    echo "<option value='$fuel' $selected>$fuel</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-12">
            <button type="submit" name="<?= isset($_GET['edit']) ? 'update' : 'save' ?>" class="btn btn-primary">
                <?= isset($_GET['edit']) ? 'Update Vehicle' : 'Add Vehicle' ?>
            </button>
        </div>
    </form>

    <hr>

    <!-- List of Vehicles -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Vehicle No</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Fuel</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Save
            if (isset($_POST['save'])) {
                $customer_id = $_POST['customer_id'];
                $vehicle_number = $_POST['vehicle_number'];
                $model = $_POST['model'];
                $brand = $_POST['brand'];
                $fuel_type = $_POST['fuel_type'];
                $conn->query("INSERT INTO vehicles (customer_id, vehicle_number, model, brand, fuel_type)
                              VALUES ('$customer_id', '$vehicle_number', '$model', '$brand', '$fuel_type')");
                echo "<script>window.location='add_vehicle.php';</script>";
            }

            // Update
            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $customer_id = $_POST['customer_id'];
                $vehicle_number = $_POST['vehicle_number'];
                $model = $_POST['model'];
                $brand = $_POST['brand'];
                $fuel_type = $_POST['fuel_type'];
                $conn->query("UPDATE vehicles SET customer_id='$customer_id', vehicle_number='$vehicle_number',
                    model='$model', brand='$brand', fuel_type='$fuel_type' WHERE id=$id");
                echo "<script>window.location='add_vehicle.php';</script>";
            }

            // Delete
            if (isset($_GET['delete'])) {
                $id = $_GET['delete'];
                $conn->query("DELETE FROM vehicles WHERE id=$id");
                echo "<script>window.location='add_vehicle.php';</script>";
            }

            // View Table
            $result = $conn->query("SELECT vehicles.*, customers.name AS customer_name FROM vehicles 
                                    JOIN customers ON vehicles.customer_id = customers.id ORDER BY vehicles.id DESC");

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['vehicle_number']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['brand']}</td>
                        <td>{$row['fuel_type']}</td>
                        <td>
                            <a href='add_vehicle.php?edit={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='add_vehicle.php?delete={$row['id']}' onclick=\"return confirm('Delete this vehicle?')\" class='btn btn-sm btn-danger'>Delete</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
