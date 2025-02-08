<?php
require_once 'includes/functions.php';
$categorias = getTodasCategorias();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PetCoop - Administrador</title>
    <link rel="icon" href="images/website/logo/favicon.ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="./css/index.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <div class="search-sidebar">
                        <div class="search-container">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="search-input" placeholder="Pesquisar produtos..."
                                id="searchProducts" autocomplete="off">
                        </div>
                    </div>
                    <a href="dashboard.php" class="list-group-item list-group-item-action">
                        Painel de Controle
                    </a>
                    <div class="products-dropdown">
                        <a href="#" class="list-group-item list-group-item-action dropdown-toggle"
                            data-toggle="collapse" data-target="#productsCollapse">
                            Produtos
                        </a>
                        <div class="collapse" id="productsCollapse">
                            <a href="?page=products&categoria=todos"
                                class="list-group-item list-group-item-action sub-item">
                                Todos os Produtos
                            </a>
                            <?php foreach ($categorias as $categoria): ?>
                                <a href="?page=products&categoria=<?php echo urlencode($categoria['categoria']); ?>"
                                    class="list-group-item list-group-item-action sub-item">
                                    <?php echo ucfirst($categoria['categoria']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <a href="?page=promotions" class="list-group-item list-group-item-action">
                        Promoções
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';

                switch ($page) {
                    case 'products':
                        include 'includes/product-list.php';
                        break;
                    case 'promotions':
                        include 'includes/promotions.php';
                        break;
                    default:
                        echo '<h1>Bem-vindo ao Painel de Administração</h1>';
                        echo '<p>Aqui você pode gerenciar sua loja virtual.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="js/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>