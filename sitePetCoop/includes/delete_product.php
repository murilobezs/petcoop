<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];

        // Primeiro, buscar informações da imagem
        $stmt = $conn->prepare("SELECT imagem FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch();

        // Deletar o produto do banco
        $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);

        // Se existir uma imagem, deletá-la
        if ($produto && $produto['imagem']) {
            $caminho_imagem = "../" . $produto['imagem'];
            if (file_exists($caminho_imagem)) {
                unlink($caminho_imagem);
            }
        }

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método inválido']);
}
?>