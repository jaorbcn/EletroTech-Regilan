<?php
include '../db.php';

if (!isset($_GET['sku'])) {
    header("Location: index.php");
    exit;
}
$sku = $_GET['sku'];

$sql = "DELETE FROM Produto WHERE sku=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sku);
$stmt->execute();

header("Location: index.php");
exit;
?>