<?php
require_once 'includes/functions.php';
require_once 'includes/product-card.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$produto = $id ? getProdutoPorId($id) : null;

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <meta charset="utf-8" />
    <link rel="icon" href="images/website/logo/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/product-details.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous" />
    <title>Detalhes do Produto - PetCoop</title>
</head>

<body>
    <header class="header">
        <div class="logoContainer">
            <a href="index.php">
                <img src="./images/website/logo/Pet Coop.png" alt="logo" />
            </a>
            <button class="hamburger" onclick="toggleMenu()">
                <i class="bi bi-list" id="menuIcon"></i>
            </button>
            <div class="searchContainer">
                <i class="bi bi-search searchIcon"></i>
                <input type="text" class="searchBar" placeholder="Do que seu pet precisa?" />
            </div>
        </div>
        <nav class="navLinks">
            <a href="/">Cães</a>
            <a href="/">Gatos</a>
            <a href="/">Pássaros</a>
            <a href="/">Peixes</a>
            <a href="/">Furões</a>
            <a href="/">Roedores</a>
            <a href="/">Promoções</a>
            <a href="https://wa.me/yourwhatsapplink" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-whatsapp"></i>
                <p>(00) 12345-6789</p>
            </a>
            <a href="https://instagram.com/yourinstagramlink" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-instagram"></i>
                <p>petcoopbr</p>
            </a>
        </nav>
        <div class="overlay" onclick="toggleMenu()"></div>
    </header>

    <main>
        <div class="product-details-container">
            <div class="product-image">
                <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
            </div>
            <div class="product-info">
                <h1><?php echo $produto['nome']; ?></h1>
                <p class="brand">Marca: <?php echo $produto['marca']; ?></p>
                <p class="type">Tipo: <?php echo $produto['tipo']; ?></p>
                <p class="category">Categoria: <?php echo $produto['categoria']; ?></p>
                <p class="price">R$ <?php echo formatarPreco($produto['preco']); ?></p>
                <p class="stock">Estoque: <?php echo $produto['estoque']; ?> unidades</p>
                <p class="description"><?php echo $produto['descricao']; ?></p>
                <button class="order-button">Fazer Pedido</button>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footerContent">
            <div class="companyInfo">
                <h2>PetCoop</h2>
                <p>Pensado para seu pet</p>
            </div>
            <div class="credits">
                <p>Developed by Murilo Bezerra &reg; 2025</p>
                <p>
                    GitHub:
                    <a href="https://github.com/murilobezs" target="_blank" rel="noopener noreferrer">murilobezs</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>