<?php
include '../db.php';

$sql = "SELECT m.*, p.nome_produto FROM Movimentacao_Estoque m 
        LEFT JOIN Produto p ON m.sku_produto = p.sku
        ORDER BY m.data_movimentacao DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movimentações - EletroTech</title>
</head>
<body>
    <h1>Movimentações de Estoque</h1>
    <a href="create.php">Registrar Movimentação</a> | <a href="../index.php">Inicio</a>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top:10px;">
        <tr>
            <th>ID</th>
            <th>Produto (SKU)</th>
            <th>Tipo</th>
            <th>Quantidade</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_movimentacao'] ?></td>
                    <td><?= htmlspecialchars($row['nome_produto']) ?> (<?= htmlspecialchars($row['sku_produto']) ?>)</td>
                    <td><?= $row['tipo_movimentacao'] ?></td>
                    <td><?= $row['quantidade'] ?></td>
                    <td><?= $row['data_movimentacao'] ?></td>
                    <td>
                        <a href="delete.php?id=<?= $row['id_movimentacao'] ?>" onclick="return confirm('Excluir movimentação?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Nenhuma movimentação registrada.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>