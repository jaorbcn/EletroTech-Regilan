<?php
include '../db.php';
$sql = "SELECT * FROM Fornecedor ORDER BY nome_fantasia ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fornecedores - EletroTech</title>
</head>
<body>
    <h1>Lista de Fornecedores</h1>
    <a href="create.php">Cadastrar Novo Fornecedor</a> | <a href="../index.php">Inicio</a>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top:10px;">
        <tr>
            <th>CNPJ</th>
            <th>Nome Fantasia</th>
            <th>Categoria</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['cnpj'] ?></td>
                    <td><?= htmlspecialchars($row['nome_fantasia']) ?></td>
                    <td><?= htmlspecialchars($row['categoria']) ?></td>
                    <td><?= htmlspecialchars($row['endereco']) ?></td>
                    <td><?= htmlspecialchars($row['telefone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <a href="update.php?cnpj=<?= urlencode($row['cnpj']) ?>">Editar</a> | 
                        <a href="delete.php?cnpj=<?= urlencode($row['cnpj']) ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">Nenhum fornecedor cadastrado.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>