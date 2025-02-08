<?php
require_once 'db_connection.php';
require_once 'functions.php';

header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $query = '%' . strtolower(trim($_GET['q'])) . '%';

    try {
        $stmt = $conn->prepare("
            SELECT id, nome, marca, categoria, preco, imagem 
            FROM produtos 
            WHERE LOWER(nome) LIKE :query 
            OR LOWER(marca) LIKE :query 
            OR LOWER(categoria) LIKE :query 
            LIMIT 5
        ");

        $stmt->execute(['query' => $query]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'results' => $results
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erro na busca'
        ]);
    }
}
?>