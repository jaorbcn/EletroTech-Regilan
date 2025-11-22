<?php
include '../db.php';

$produtos = $conn->query("SELECT sku, nome_produto FROM Produto ORDER BY nome_produto ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sku_produto = $_POST['sku_produto'];
    $tipo = $_POST['tipo_movimentacao'];
    $quantidade = intval($_POST['quantidade']);
    $data = $_POST['data_movimentacao'];

    if ($quantidade <= 0) {
        echo "Quantidade deve ser maior que zero.";
    } else {
        // Inserir movimentação
        $sql = "INSERT INTO Movimentacao_Estoque (sku_produto, tipo_movimentacao, quantidade, data_movimentacao) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $sku_produto, $tipo, $quantidade, $data);
        if ($stmt->execute()) {
            // Atualizar estoque
            if ($tipo == 'Entrada') {
                $sql2 = "UPDATE Produto SET estoque_atual = estoque_atual + ? WHERE sku = ?";
            } else {
                $sql2 = "UPDATE Produto SET estoque_atual = GREATEST(estoque_atual - ?, 0) WHERE sku = ?";
            }
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("is", $quantidade, $sku_produto);
            $stmt2->execute();

            header("Location: index.php");
            exit;
        } else {
            echo "Erro ao registrar movimentação: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Registrar Movimentação</title></head>
<body>
    <h1>Registrar Movimentação de Estoque</h1>
    <form method="post">
        Produto:<br>
        <select name="sku_produto" required>
            <option value="">-- Selecionar --</option>
            <?php while ($p = $produtos->fetch_assoc()): ?>
                <option value="<?= $p['sku'] ?>"><?= htmlspecialchars($p['nome_produto']) ?> (<?= htmlspecialchars($p['sku']) ?>)</option>
            <?php endwhile; ?>
        </select><br><br>

        Tipo de Movimentação:<br>
        <select name="tipo_movimentacao" required>
            <option value="Entrada">Entrada</option>
            <option value="Saída">Saída</option>
        </select><br><br>

        Quantidade:<br>
        <input type="number" name="quantidade" min="1" required><br><br>

        Data da Movimentação:<br>
        <input type="date" name="data_movimentacao" value="<?= date('Y-m-d') ?>" required><br><br>

        <button type="submit">Registrar</button>
    </form>
    <br><a href="index.php">Voltar</a>
</body>
</html>