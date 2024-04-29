    <?php
    try {
        $pdo = new PDO('sqlite:../bigbang.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro ao conectar: " . $e->getMessage());
    }
    ?>