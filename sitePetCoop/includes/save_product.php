<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $nome = $_POST['nome'];
        $marca = $_POST['marca'];
        $categoria = $_POST['categoria'];
        $tipo = $_POST['tipo'];
        $estoque = $_POST['estoque'];
        $preco = $_POST['preco'];
        $descricao = $_POST['descricao'];
        $promocao = isset($_POST['promocao']) ? 1 : 0;

        // Processar upload da imagem apenas se uma nova imagem for enviada
        $imagem_path = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            // Criar diretório de uploads se não existir
            $upload_dir = "../uploads/" . $categoria . "/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Se estiver editando, buscar imagem antiga
            if ($id) {
                $stmt = $conn->prepare("SELECT imagem FROM produtos WHERE id = ?");
                $stmt->execute([$id]);
                $produto = $stmt->fetch();
                if ($produto && $produto['imagem']) {
                    $caminho_imagem_antiga = "../" . $produto['imagem'];
                    if (file_exists($caminho_imagem_antiga)) {
                        unlink($caminho_imagem_antiga);
                    }
                }
            }

            // Gerar nome único para o arquivo
            $extensao = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));
            $novo_nome = uniqid() . '.' . $extensao;
            $target_file = $upload_dir . $novo_nome;

            // Verificar tipo de arquivo
            $permitidos = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array($extensao, $permitidos)) {
                throw new Exception('Tipo de arquivo não permitido. Apenas JPG, JPEG, PNG e GIF são aceitos.');
            }

            if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
                throw new Exception('Erro ao fazer upload da imagem');
            }

            $imagem_path = "uploads/" . $categoria . "/" . $novo_nome;
        }

        if ($id) {
            // Update
            $sql = "UPDATE produtos SET nome = ?, marca = ?, categoria = ?, tipo = ?, 
                    estoque = ?, preco = ?, descricao = ?, promocao = ?";
            $params = [$nome, $marca, $categoria, $tipo, $estoque, $preco, $descricao, $promocao];

            if ($imagem_path) {
                $sql .= ", imagem = ?";
                $params[] = $imagem_path;
            }

            $sql .= " WHERE id = ?";
            $params[] = $id;

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        } else {
            // Insert
            $stmt = $conn->prepare("INSERT INTO produtos (nome, marca, categoria, tipo, estoque, 
                                  preco, descricao, imagem, promocao) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $nome,
                $marca,
                $categoria,
                $tipo,
                $estoque,
                $preco,
                $descricao,
                $imagem_path ?? '',
                $promocao
            ]);
        }

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>