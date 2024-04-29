<?php

require_once 'conexao.php';

try {
    $sql = "SELECT strftime('%Y-%m-%d', order_date) as dia, SUM(order_total) as total_pedidos 
            FROM orders 
            GROUP BY dia";

    $stmt = $pdo->query($sql);
    $pedidos_por_dia = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $soma_pedidos = 0;
    foreach ($pedidos_por_dia as $pedido) {
        $soma_pedidos += $pedido['total_pedidos'];
    }
    $media = count($pedidos_por_dia) > 0 ? $soma_pedidos / count($pedidos_por_dia) : 0;

    function determinarCor($total_pedidos) {
        global $media;
        if ($media < 3000) {
            return "vermelha";
        } elseif ($media > 3000) {
            return "verde";
        } else {
            return "cinza";
        }
    }
    
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Pedidos</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="table_box">
        <table border='1'>
            <tr>
                <th>Dia</th>
                <th>Pedidos</th>
            </tr>
            <?php
            foreach ($pedidos_por_dia as $pedido) {
                $cor = determinarCor($pedido['total_pedidos']);
                echo "<tr>
                        <td>{$pedido['dia']}</td>
                        <td>{$pedido['total_pedidos']}</td>
                      </tr>";
            }
            ?>
            <tr class='<?php echo determinarCor($media); ?>'>
                <td><b>Média</b></td>
                <td><b><?php echo number_format($media, 2); ?></b></td>
            </tr>
        </table>
    </div>
</body>
</html>
