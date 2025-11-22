<?php
include '../db.php';

// Consultar Categorias e Fornecedores para select
$categorias = $conn->query("SELECT * FROM Categoria ORDER BY nome_categoria ASC");
$fornecedores = $conn->query("SELECT * FROM Fornecedor ORDER BY nome_fantasia ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sku = $_POST['sku'];
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco_custo = $_POST['preco_custo'];
    $preco_venda = $_POST['preco_venda'];
    $id_categoria = $_POST['id_categoria'] ?: NULL;
    $cnpj_fornecedor = $_POST['cnpj_fornecedor'] ?: NULL;

    $sql = "INSERT INTO Produto (sku, nome_produto, descricao, preco_custo, preco_venda, estoque_atual, id_categoria, cnpj_fornecedor)
            VALUES (?, ?, ?, ?, ?, 0, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssddss", $sku, $nome, $descricao, $preco_custo, $preco_venda, $id_categoria, $cnpj_fornecedor);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao cadastrar produto: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Cadastrar Produto</title></head>
<body>
    <h1>Cadastrar Produto</h1>
    <form method="post">
        SKU: <input type="text" name="sku" required><br><br>
        Nome Produto: <input type="text" name="nome_produto" required><br><br>
        Descrição:<br>
        <textarea name="descricao" rows="4" cols="50"></textarea><br><br>
        Preço Custo: <input type="number" step="0.01" min="0" name="preco_custo" required><br><br>
        Preço Venda: <input type="number" step="0.01" min="0" name="preco_venda" required><br><br>

        Categoria:<br>
        <select name="id_categoria">
            <option value="">-- Selecionar --</option>
            <?php while ($cat = $categorias->fetch_assoc()): ?>
                <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nome_categoria']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        Fornecedor:<br>
        <select name="cnpj_fornecedor">
            <option value="">-- Selecionar --</option>
            <?php while ($forn = $fornecedores->fetch_assoc()): ?>
                <option value="<?= $forn['cnpj'] ?>"><?= htmlspecialchars($forn['nome_fantasia']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>
    <br><a href="index.php">Voltar</a>
</body>
</html>