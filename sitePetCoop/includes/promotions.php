<?php
require_once 'db_connection.php';

// Buscar apenas produtos em promoção
try {
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE promocao = 1 ORDER BY id DESC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar produtos em promoção: " . $e->getMessage();
    $products = [];
}
?>

<div class="product-management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produtos em Promoção</h2>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-info" role="alert">
            Nenhum produto em promoção no momento.
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td>
                            <img src="<?php echo $product['imagem']; ?>" alt="<?php echo $product['nome']; ?>"
                                style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td><?php echo $product['nome']; ?></td>
                        <td><?php echo $product['marca']; ?></td>
                        <td><?php echo ucfirst($product['categoria']); ?></td>
                        <td><?php echo ucfirst($product['tipo']); ?></td>
                        <td><?php echo $product['estoque']; ?></td>
                        <td>R$ <?php echo number_format($product['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <div class="btn-group" role="group" style="gap: 5px;">
                                <button class="btn btn-sm btn-warning" style="width: 80px;"
                                    onclick="editProduct(<?php echo $product['id']; ?>)">
                                    Editar
                                </button>
                                <button class="btn btn-sm btn-danger" style="width: 80px;"
                                    onclick="removeFromPromotion(<?php echo $product['id']; ?>)">
                                    Remover
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
    function removeFromPromotion(id) {
        if (confirm('Deseja remover este produto das promoções?')) {
            fetch('includes/update_promotion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&promocao=0`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao remover produto da promoção');
                    }
                })
                .catch(error => console.error('Erro:', error));
        }
    }

    // Reutiliza a função editProduct do product-list.php
</script>