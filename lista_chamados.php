<!DOCTYPE html>
<html>
<head>
    <title>Lista de Chamados</title>
    <style>
        /* Estilo da tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ccc;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Lista de Chamados</h1>

    <?php
    require 'vendor/autoload.php'; // Carregar a biblioteca PhpSpreadsheet

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chamados"; // Defina o nome do banco de dados aqui

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Função para gerar uma cor aleatória em formato hexadecimal
    function gerarCorAleatoria() {
        $chars = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $chars[rand(0, 15)];
        }
        return $color;
    }

    // Função para exibir botões de edição e exclusão para cada chamado
    function exibirBotoes($id) {
        echo "<td><a href='editar_chamado.php?id=".$id."'>Editar</a></td>";
        echo "<td><a href='excluir_chamado.php?id=".$id."'>Excluir</a></td>";
    }

    // Consulta para listar os chamados e seus erros
    $sql = "SELECT c.id, c.numero, c.data, c.tipo_sistema, c.tela, c.descricao, e.nome AS erro_tela
            FROM chamados c
            INNER JOIN chamados_erros ce ON c.id = ce.chamado_id
            INNER JOIN erros e ON ce.erro_id = e.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Lista de Chamados:</h2>";
        echo "<table>";
        echo "<tr><th>Número do Chamado</th><th>Data do Chamado</th><th>Tipo de Sistema</th><th>Tela</th><th>Descrição do Chamado</th><th>Erro da Tela</th><th>Editar</th><th>Excluir</th></tr>";

        $telaCores = array(); // Array para armazenar as cores associadas às telas
        $telaContagem = array(); // Array para armazenar a contagem de cada tela

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['numero']."</td>";
            echo "<td>".$row['data']."</td>";
            echo "<td>".$row['tipo_sistema']."</td>";
            $tela = $row['tela'];
            // Verifica se a cor já foi associada à tela, senão gera uma nova cor
            if (!isset($telaCores[$tela])) {
                $telaCores[$tela] = gerarCorAleatoria();
                $telaContagem[$tela] = 1; // Inicia a contagem para a tela
            } else {
                $telaContagem[$tela]++; // Incrementa a contagem para a tela
            }
            echo "<td style='background-color: ".$telaCores[$tela]."'>".$tela."</td>";
            echo "<td>".$row['descricao']."</td>";
            echo "<td>".$row['erro_tela']."</td>";
            exibirBotoes($row['id']); // Exibe os botões de edição e exclusão passando o ID do chamado
            echo "</tr>";
        }

        echo "</table>";

        // Exibir a contagem de telas
        echo "<h2>Quantidade de Telas:</h2>";
        echo "<table>";
        echo "<tr><th>Tela</th><th>Quantidade</th></tr>";

        foreach ($telaContagem as $tela => $quantidade) {
            echo "<tr>";
            echo "<td>".$tela."</td>";
            echo "<td>".$quantidade."</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Exportar para Excel
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalho da tabela
        $sheet->setCellValue('A1', 'Número do Chamado');
        $sheet->setCellValue('B1', 'Data do Chamado');
        $sheet->setCellValue('C1', 'Tipo de Sistema');
        $sheet->setCellValue('D1', 'Tela');
        $sheet->setCellValue('E1', 'Descrição do Chamado');
        $sheet->setCellValue('F1', 'Erro da Tela');

        // Dados dos chamados
        $row = 2;
        mysqli_data_seek($result, 0); // Voltar o ponteiro do resultado para o início
        while ($chamado = $result->fetch_assoc()) {
            $sheet->setCellValue('A'.$row, $chamado['numero']);
            $sheet->setCellValue('B'.$row, $chamado['data']);
            $sheet->setCellValue('C'.$row, $chamado['tipo_sistema']);
            $sheet->setCellValue('D'.$row, $chamado['tela']);
            $sheet->setCellValue('E'.$row, $chamado['descricao']);
            $sheet->setCellValue('F'.$row, $chamado['erro_tela']);
            $row++;
        }

        // Contagem por tela
        $row += 2;
        $sheet->setCellValue('D'.$row, 'Tela');
        $sheet->setCellValue('E'.$row, 'Total de Chamados');
        $row++;
        foreach ($telaContagem as $tela => $quantidade) {
            $sheet->setCellValue('D'.$row, $tela);
            $sheet->setCellValue('E'.$row, $quantidade);
            $row++;
        }

        // Gerar o arquivo Excel
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'chamados.xlsx'; // Nome do arquivo
        $writer->save($filename);

        // Botão para baixar o arquivo Excel
        echo "<br>";
        echo "<a href='".$filename."' download>Baixar Excel</a>";
    } else {
        echo "<p>Nenhum chamado encontrado.</p>";
    }

    $conn->close();
    ?>

    <a href="index.php">Ir para a página inicial (index)</a>
</body>
</html>
