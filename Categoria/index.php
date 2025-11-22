<?php
include '../db.php';
$sql = "SELECT * FROM Categoria ORDER BY nome_categoria ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Categorias - EletroTech</title>
</head>
<body>
    <h1>Categorias</h1>
    <a href="create.php">Cadastrar Categoria</a> | <a href="../index.php">Inicio</a>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top:10px;">
        <tr>
            <th>ID</th>
            <th>Nome Categoria</th>
            <th>Ações</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_categoria'] ?></td>
                    <td><?= htmlspecialchars($row['nome_categoria']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $row['id_categoria'] ?>">Editar</a> |
                        <a href="delete.php?id=<?= $row['id_categoria'] ?>" onclick="return confirm('Excluir categoria?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">Nenhuma categoria cadastrada.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>