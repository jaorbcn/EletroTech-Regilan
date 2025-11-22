<?php
include '../db.php';

if (!isset($_GET['sku'])) {
    header("Location: index.php");
    exit;
}
$sku = $_GET['sku'];

$categorias = $conn->query("SELECT * FROM Categoria ORDER BY nome_categoria ASC");
$fornecedores = $conn->query("SELECT * FROM Fornecedor ORDER BY nome_fantasia ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco_custo = $_POST['preco_custo'];
    $preco_venda = $_POST['preco_venda'];
    $id_categoria = $_POST['id_categoria'] ?: NULL;
    $cnpj_fornecedor = $_POST['cnpj_fornecedor'] ?: NULL;

    $sql = "UPDATE Produto SET nome_produto=?, descricao=?, preco_custo=?, preco_venda=?, id_categoria=?, cnpj_fornecedor=? WHERE sku=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddsss", $nome, $descricao, $preco_custo, $preco_venda, $id_categoria, $cnpj_fornecedor, $sku);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM Produto WHERE sku=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sku);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows != 1) {
        echo "Produto não encontrado.";
        exit;
    }
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head><title>Editar Produto</title></head>
<body>
    <h1>Editar Produto</h1>
    <form method="post">
        SKU: <b><?= htmlspecialchars($row['sku']) ?></b><br><br>
        Nome Produto: <input type="text" name="nome_produto" value="<?= htmlspecialchars($row['nome_produto']) ?>" required><br><br>
        Descrição:<br>
        <textarea name="descricao" rows="4" cols="50"><?= htmlspecialchars($row['descricao']) ?></textarea><br><br>
        Preço Custo: <input type="number" step="0.01" min="0" name="preco_custo" value="<?= $row['preco_custo'] ?>" required><br><br>
        Preço Venda: <input type="number" step="0.01" min="0" name="preco_venda" value="<?= $row['preco_venda'] ?>" required><br><br>

        Categoria:<br>
        <select name="id_categoria">
            <option value="">-- Selecionar --</option>
            <?php while ($cat = $categorias->fetch_assoc()): ?>
                <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $row['id_categoria'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['nome_categoria']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        Fornecedor:<br>
        <select name="cnpj_fornecedor">
            <option value="">-- Selecionar --</option>
            <?php while ($forn = $fornecedores->fetch_assoc()): ?>
                <option value="<?= $forn['cnpj'] ?>" <?= $forn['cnpj'] == $row['cnpj_fornecedor'] ? 'selected' : '' ?>><?= htmlspecialchars($forn['nome_fantasia']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Atualizar</button>
    </form>
    <br><a href="index.php">Voltar</a>
</body>
</html>