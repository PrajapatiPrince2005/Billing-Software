<?php
include "db.php";

$cid = intval($_GET['customer_id']);
$res = $conn->query("SELECT * FROM customers WHERE customer_id=$cid");

if ($res->num_rows > 0) {
    while ($v = $res->fetch_assoc()) {
        echo "<option value='{$v['id']}'>{$v['vehicle_number']}</option>";
    }
} else {
    echo "<option value=''>-- No Vehicle Found --</option>";
}
?>
