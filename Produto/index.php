<?php
include '../db.php';

$sql = "SELECT p.*, c.nome_categoria, f.nome_fantasia FROM Produto p
        LEFT JOIN Categoria c ON p.id_categoria = c.id_categoria
        LEFT JOIN Fornecedor f ON p.cnpj_fornecedor = f.cnpj
        ORDER BY p.nome_produto ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Produtos - EletroTech</title>
</head>
<body>
    <h1>Produtos</h1>
    <a href="create.php">Cadastrar Produto</a> | <a href="../index.php">Inicio</a>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top:10px;">
        <tr>
            <th>SKU</th>
            <th>Nome Produto</th>
            <th>Descrição</th>
            <th>Preço Custo</th>
            <th>Preço Venda</th>
            <th>Estoque Atual</th>
            <th>Categoria</th>
            <th>Fornecedor</th>
            <th>Ações</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['sku']) ?></td>
                    <td><?= htmlspecialchars($row['nome_produto']) ?></td>
                    <td><?= htmlspecialchars($row['descricao']) ?></td>
                    <td>R$ <?= number_format($row['preco_custo'],2,',','.') ?></td>
                    <td>R$ <?= number_format($row['preco_venda'],2,',','.') ?></td>
                    <td><?= $row['estoque_atual'] ?></td>
                    <td><?= htmlspecialchars($row['nome_categoria']) ?></td>
                    <td><?= htmlspecialchars($row['nome_fantasia']) ?></td>
                    <td>
                        <a href="update.php?sku=<?= urlencode($row['sku']) ?>">Editar</a> |
                        <a href="delete.php?sku=<?= urlencode($row['sku']) ?>" onclick="return confirm('Excluir produto?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9">Nenhum produto cadastrado.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>