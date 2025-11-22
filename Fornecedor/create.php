<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cnpj = $_POST['cnpj'];
    $nome = $_POST['nome_fantasia'];
    $categoria = $_POST['categoria'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO Fornecedor (cnpj, nome_fantasia, categoria, endereco, telefone, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $cnpj, $nome, $categoria, $endereco, $telefone, $email);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Cadastrar Fornecedor</title></head>
<body>
    <h1>Cadastrar Fornecedor</h1>
    <form method="post">
        CNPJ: <input type="text" name="cnpj" required><br><br>
        Nome Fantasia: <input type="text" name="nome_fantasia" required><br><br>
        Categoria: <input type="text" name="categoria"><br><br>
        Endereço: <input type="text" name="endereco"><br><br>
        Telefone: <input type="text" name="telefone"><br><br>
        Email: <input type="email" name="email"><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <br>
    <a href="index.php">Voltar</a>
</body>
</html>