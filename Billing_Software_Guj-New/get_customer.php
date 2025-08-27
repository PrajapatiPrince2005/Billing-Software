<?php
include 'db.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $conn->query("SELECT * FROM customers WHERE id = $id");
    $data = $result->fetch_assoc();
    echo json_encode($data);
}
?>
