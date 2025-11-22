<?php
include '../db.php';
if (!isset($_GET['cnpj'])) {
    header("Location: index.php");
    exit;
}
$cnpj = $_GET['cnpj'];
$sql = "DELETE FROM Fornecedor WHERE cnpj=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cnpj);
$stmt->execute();
header("Location: index.php");
exit;
?>