<?php
require_once 'db_connection.php';

if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $produto = $stmt->fetch();

        if ($produto) {
            echo json_encode($produto);
        } else {
            echo json_encode(['error' => 'Produto não encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID não fornecido']);
}
?>