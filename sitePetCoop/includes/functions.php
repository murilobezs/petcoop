<?php
require_once 'db_connection.php';

function getProdutosPorCategoria($categoria)
{
    global $conn;
    try {
        if ($categoria === 'todos') {
            $stmt = $conn->prepare("SELECT * FROM produtos ORDER BY id DESC");
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("SELECT * FROM produtos WHERE LOWER(categoria) = LOWER(?) ORDER BY id DESC");
            $stmt->execute([strtolower(trim($categoria))]);
        }
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    } catch (PDOException $e) {
        error_log("Erro ao buscar produtos: " . $e->getMessage());
        return [];
    }
}

function getProdutosEmPromocao()
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE promocao = 1 ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar promoções: " . $e->getMessage());
        return [];
    }
}

function getTodasCategorias()
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT DISTINCT categoria FROM produtos ORDER BY categoria ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar categorias: " . $e->getMessage());
        return [];
    }
}

function formatarPreco($preco)
{
    return number_format($preco, 2, ',', '.');
}

function getProdutoPorId($id)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erro ao buscar produto: " . $e->getMessage());
        return null;
    }
}

function validarImagem($imagem)
{
    $tipos_permitidos = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');

    $tipo = $imagem['type'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));

    if (!in_array($tipo, $tipos_permitidos) || !in_array($extensao, $extensoes_permitidas)) {
        return false;
    }
    return true;
}

function salvarProduto($dados, $imagem)
{
    global $conn;

    if ($imagem && $imagem['error'] === 0) {
        if (!validarImagem($imagem)) {
            throw new Exception("Formato de imagem não permitido. Use JPG, PNG, GIF ou WebP.");
        }

        // Define base directory and category folder
        $base_dir = "uploads/";
        $categoria_dir = strtolower($dados['categoria']) . "/";
        $diretorio_destino = $base_dir . $categoria_dir;

        // Create category directory if it doesn't exist
        if (!file_exists($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        $nome_arquivo = uniqid() . '_' . basename($imagem['name']);
        $caminho_completo = $diretorio_destino . $nome_arquivo;

        if (!move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
            throw new Exception("Erro ao fazer upload da imagem.");
        }

        $dados['imagem'] = $caminho_completo; // Save full path relative to root
    }

    // ... resto do código de salvamento no banco de dados ...
}

?>