<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_categoria'];
    $sql = "INSERT INTO Categoria (nome_categoria) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Cadastrar Categoria</title></head>
<body>
    <h1>Cadastrar Categoria</h1>
    <form method="post">
        Nome Categoria: <input type="text" name="nome_categoria" required><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <br><a href="index.php">Voltar</a>
</body>
</html>