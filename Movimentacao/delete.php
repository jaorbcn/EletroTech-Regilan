<?php
include '../db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = $_GET['id'];

// Antes de deletar a movimentação, atualizar o estoque invertendo o efeito.

$sql = "SELECT * FROM Movimentacao_Estoque WHERE id_movimentacao=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: index.php");
    exit;
}

$mov = $result->fetch_assoc();

$sku = $mov['sku_produto'];
$tipo = $mov['tipo_movimentacao'];
$quantidade = $mov['quantidade'];

// Inverter movimentação para atualizar estoque
if ($tipo == 'Entrada') {
    $sql2 = "UPDATE Produto SET estoque_atual = GREATEST(estoque_atual - ?, 0) WHERE sku=?";
} else {
    $sql2 = "UPDATE Produto SET estoque_atual = estoque_atual + ? WHERE sku=?";
}

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("is", $quantidade, $sku);
$stmt2->execute();

// Agora deleta movimentação
$sql3 = "DELETE FROM Movimentacao_Estoque WHERE id_movimentacao=?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("i", $id);
$stmt3->execute();

header("Location: index.php");
exit;
?>