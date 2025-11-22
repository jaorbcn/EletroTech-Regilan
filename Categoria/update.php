<?php
include '../db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_categoria'];
    $sql = "UPDATE Categoria SET nome_categoria=? WHERE id_categoria=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nome, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM Categoria WHERE id_categoria=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows != 1) {
        echo "Categoria não encontrada.";
        exit;
    }
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Editar Categoria</title></head>
<body>
    <h1>Editar Categoria</h1>
    <form method="post">
        Nome Categoria: <input type="text" name="nome_categoria" value="<?= htmlspecialchars($row['nome_categoria']) ?>" required><br><br>
        <button type="submit">Atualizar</button>
    </form>
    <br><a href="index.php">Voltar</a>
</body>
</html>