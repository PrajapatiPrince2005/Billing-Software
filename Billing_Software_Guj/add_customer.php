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
    <title>ગ્રાહક મેનેજ કરો</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #8b8985ff; font-family: 'Noto Sans Gujarati', sans-serif; }
        .container {
            background:#c9e4ffff;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 { text-align: center; margin-bottom: 25px; font-weight: bold; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h3>👤 ગ્રાહક મેનેજમેન્ટ</h3>
<hr style="border: 2px solid black;">
    <!-- Customer Form -->
    <form method="post" class="row g-3">
        <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $editData['id'] : '' ?>">

        <div class="col-md-4">
            <label>ગ્રાહકનું નામ:</label>
            <input type="text" name="name" class="form-control" required
                value="<?= isset($_GET['edit']) ? $editData['name'] : '' ?>"
                placeholder="નામ દાખલ કરો">
        </div>
        <div class="col-md-4">
            <label>મોબાઇલ નંબર:</label>
            <input type="text" name="phone" class="form-control"
                value="<?= isset($_GET['edit']) ? $editData['phone'] : '' ?>"
                placeholder="મોબાઇલ નંબર દાખલ કરો">
        </div>
        <div class="col-md-4">
            <label>સરનામું:</label>
            <input type="text" name="address" class="form-control"
                value="<?= isset($_GET['edit']) ? $editData['address'] : '' ?>"
                placeholder="સરનામું દાખલ કરો">
        </div>
        <div class="col-md-12">
            <button type="submit" name="<?= isset($_GET['edit']) ? 'update' : 'save' ?>" class="btn btn-primary w-100">
                <?= isset($_GET['edit']) ? 'અપડેટ કરો' : 'ગ્રાહક ઉમેરો' ?>
            </button>
        </div>
    </form>

    <hr>

    <!-- Customer List -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>નામ</th>
                <th>મોબાઇલ</th>
                <th>સરનામું</th>
                <th>ક્રિયા</th>
            </tr>
        </thead>
        <tbody>
            <?php
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

            // Display table
            $result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>
                        <a href='add_customer.php?edit={$row['id']}' class='btn btn-sm btn-warning'>ફેરફાર કરો</a>
                        <a href='add_customer.php?delete={$row['id']}' onclick=\"return confirm('શું તમે ખરેખર ડિલીટ કરવા માંગો છો?')\" class='btn btn-sm btn-danger'>કાઢો</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
