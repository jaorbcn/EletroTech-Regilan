<?php
include '../db.php';

if (!isset($_GET['cnpj'])) {
    header("Location: index.php");
    exit;
}
$cnpj = $_GET['cnpj'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_fantasia'];
    $categoria = $_POST['categoria'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $sql = "UPDATE Fornecedor SET nome_fantasia=?, categoria=?, endereco=?, telefone=?, email=? WHERE cnpj=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $categoria, $endereco, $telefone, $email, $cnpj);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM Fornecedor WHERE cnpj=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cnpj);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows != 1) {
        echo "Fornecedor não encontrado.";
        exit;
    }
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Editar Fornecedor</title></head>
<body>
    <h1>Editar Fornecedor</h1>
    <form method="post">
        CNPJ: <b><?= htmlspecialchars($row['cnpj']) ?></b><br><br>
        Nome Fantasia:<br>
        <input type="text" name="nome_fantasia" value="<?= htmlspecialchars($row['nome_fantasia']) ?>" required><br><br>
        Categoria:<br>
        <input type="text" name="categoria" value="<?= htmlspecialchars($row['categoria']) ?>"><br><br>
        Endereço:<br>
        <input type="text" name="endereco" value="<?= htmlspecialchars($row['endereco']) ?>"><br><br>
        Telefone:<br>
        <input type="text" name="telefone" value="<?= htmlspecialchars($row['telefone']) ?>"><br><br>
        Email:<br>
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>"><br><br>
        <button type="submit">Atualizar</button>
    </form>
    <br>
    <a href="index.php">Voltar</a>
</body>
</html>