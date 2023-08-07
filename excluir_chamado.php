<!DOCTYPE html>
<html>
<head>
    <title>Excluir Chamado</title>
    <style>
        /* Estilos da tabela aqui (mesmo estilo da página listar) */
        /* ... (estilos fornecidos anteriormente) ... */
    </style>
</head>
<body>
    <h1>Excluir Chamado</h1>

    <a href="index.php">Ir para a página inicial (index)</a>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chamados"; // Defina o nome do banco de dados aqui

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        // Verifica se o chamado existe antes de realizar a exclusão
        $sql_check = "SELECT * FROM chamados WHERE id = $id";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            // Realiza a exclusão do chamado
            $sql_delete = "DELETE FROM chamados WHERE id = $id";
            if ($conn->query($sql_delete) === TRUE) {
                echo "<p>Chamado excluído com sucesso.</p>";
            } else {
                echo "<p>Erro ao excluir o chamado: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Chamado não encontrado.</p>";
        }
    } else {
        echo "<p>Erro: ID do chamado não especificado.</p>";
    }

    $conn->close();
    ?>

    <a href="index.php">Ir para a página inicial (index)</a>
</body>
</html>
