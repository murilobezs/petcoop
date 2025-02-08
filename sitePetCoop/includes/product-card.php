<?php
function renderProductCard($product)
{
    ?>
    <div class="swiper-slide">
        <div class="card">
            <img src="<?php echo $product['imagem']; ?>" alt="<?php echo $product['nome']; ?>" />
            <h3><?php echo $product['nome']; ?></h3>
            <div class="price">R$ <?php echo formatarPreco($product['preco']); ?></div>
            <p><?php echo $product['descricao']; ?></p>
            <a href="product-details.php?id=<?php echo $product['id']; ?>" class="details-button">Ver detalhes</a>
        </div>
    </div>
    <?php
}
?>