<?php
require_once 'conexao.php';

try {
    $sql_paises = "SELECT DISTINCT user_country FROM user";
    $stmt_paises = $pdo->query($sql_paises);
    $paises = $stmt_paises->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die("Erro ao obter a lista de países: " . $e->getMessage());
}

try {
    $sql = "SELECT u.user_country, SUM(o.order_total) AS total_vendas
            FROM orders o
            INNER JOIN user u ON o.order_user_id = u.user_id
            GROUP BY u.user_country";
    $stmt = $pdo->query($sql);
    $vendas_por_pais = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}

if (isset($_GET['pais'])) {
    $pais_selecionado = $_GET['pais'];
} else {
    $pais_selecionado = null;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total de Vendas por País</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: linear-gradient(#a3ce6b, #29bbc5);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 60%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 12px 12px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 10px;
            border: 1px solid #dddddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        select, button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .table_box {
            margin: 0 auto;
            width: 60%;
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 12px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-imprimir {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Total de Vendas por País</h2>

    <form action="" method="GET">
        <label for="pais">Selecione um país:</label>
        <select name="pais" id="pais">
            <option value="">Todos os Países</option>
            <?php foreach ($paises as $pais) : ?>
                <option value="<?php echo $pais; ?>" <?php echo ($pais_selecionado == $pais) ? 'selected' : ''; ?>><?php echo $pais; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <tr>
            <th>País</th>
            <th>Total de Vendas</th>
        </tr>
        <?php
        foreach ($vendas_por_pais as $venda) {
            if ($pais_selecionado && $venda['user_country'] != $pais_selecionado) {
                continue;
            }
            echo "<tr>
                    <td>{$venda['user_country']}</td>
                    <td>{$venda['total_vendas']}</td>
                  </tr>";
        }
        ?>
    </table>

    <div class="table_box">
        <h2>Relatório de Pedidos</h2>
        <table border='1'>
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
