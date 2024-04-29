<?php
require_once '../includes/conexao.php';

try {
    $sql = "SELECT * FROM orders";
    $stmt = $pdo->query($sql);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pedidos</title>
    <link rel="stylesheet" href="../assets/Style.css">  
</head>
<body>
    <div class="table_box">
        <h2>Relatório de Pedidos</h2>
        <table border='1' class="tabela-pedidos">
            <tr>
                <th>ID do Pedido</th>
                <th>ID do Usuário</th>
                <th>Total do Pedido</th>
                <th>Data do Pedido</th>
            </tr>
            <?php
            foreach ($pedidos as $pedido) {
                echo "<tr>
                        <td>{$pedido['order_id']}</td>
                        <td>{$pedido['order_user_id']}</td>
                        <td>{$pedido['order_total']}</td>
                        <td>{$pedido['order_date']}</td>
                      </tr>";
            }
            ?>
        </table>
        <button class="btn-imprimir" onclick="window.print()">Imprimir Relatório</button>
    </div>
</body>
</html>
