<?php include 'db.php'; ?> 
<?php
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM vehicles WHERE id = $id");
    $editData = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <title> વાહન મેનેજમેન્ટ | MESHNA AUTO</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Noto Sans Gujarati', sans-serif;
        }
        .container {
            background: #d1cec3ff;
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
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>🚘 વાહન મેનેજમેન્ટ</h3>
<hr style="border: 2px solid black;">
    <!-- Form -->
    <form method="post" class="row g-3">
        <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $editData['id'] : '' ?>">

        <div class="col-md-4">
            <label>ગ્રાહક પસંદ કરો:</label>
            <select name="customer_id" class="form-select" required>
                <option value="">-- ગ્રાહક પસંદ કરો --</option>
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
            <label>વાહન નંબર:</label>
            <input type="text" name="vehicle_number" class="form-control" required
                placeholder="જેમ કે: GJ05BR1234"
                value="<?= isset($_GET['edit']) ? $editData['vehicle_number'] : '' ?>">
        </div>

        <div class="col-md-4">
            <label>મોડેલ:</label>
            <input type="text" name="model" class="form-control"
                placeholder="મોડેલ લખો (જેમ કે Activa, Splendor...)"
                value="<?= isset($_GET['edit']) ? $editData['model'] : '' ?>">
        </div>

        <div class="col-md-4">
            <label>બ્રાન્ડ:</label>
            <input type="text" name="brand" class="form-control"
                placeholder="જેમ કે Hero, Honda..."
                value="<?= isset($_GET['edit']) ? $editData['brand'] : '' ?>">
        </div>

        <div class="col-md-4">
            <label>ઇંધણનો પ્રકાર:</label>
            <select name="fuel_type" class="form-select">
                <option value="">-- પસંદ કરો --</option>
                <?php
                $fuels = ['Diesel' => 'ડીઝલ', 'Petrol' => 'પેટ્રોલ', 'CNG' => 'સી.એન.જી.'];
                foreach ($fuels as $value => $label) {
                    $selected = (isset($_GET['edit']) && $editData['fuel_type'] == $value) ? "selected" : "";
                    echo "<option value='$value' $selected>$label</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-12">
            <button type="submit" name="<?= isset($_GET['edit']) ? 'update' : 'save' ?>" class="btn btn-primary w-100">
                <?= isset($_GET['edit']) ? 'અપડેટ કરો' : 'વાહન ઉમેરો' ?>
            </button>
        </div>
    </form>

    <hr>

    <!-- Vehicle List -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ગ્રાહક</th>
                <th>વાહન નં</th>
                <th>મોડેલ</th>
                <th>બ્રાન્ડ</th>
                <th>ઇંધણ</th>
                <th>ક્રિયા</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Insert New
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

            // Table
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
                            <a href='add_vehicle.php?edit={$row['id']}' class='btn btn-sm btn-warning'>ફેરફાર</a>
                            <a href='add_vehicle.php?delete={$row['id']}' onclick=\"return confirm('શું વાસ્તવમાં કાઢી નાખવું છે?')\" class='btn btn-sm btn-danger'>કાઢો</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
