<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        $promocao = $_POST['promocao'];

        $stmt = $conn->prepare("UPDATE produtos SET promocao = ? WHERE id = ?");
        $stmt->execute([$promocao, $id]);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método inválido']);
}
?>