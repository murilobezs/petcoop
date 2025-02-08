<?php
require_once 'includes/functions.php';
require_once 'includes/product-card.php';

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : 'todos';
$produtos = getProdutosPorCategoria($categoria);
$categorias = getTodasCategorias();
$categoriaTitulo = $categoria === 'todos' ? 'Todos os Produtos' : ucfirst($categoria);
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
  <link rel="stylesheet" href="./css/products.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <title>PetCoop</title>
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
    <div class="container-products">
      <aside class="filter-menu">
        <h3>Filtrar por</h3>
        <div class="filter-category">
          <h4>Categoria</h4>
          <ul>
            <li><a href="products.php?categoria=todos">Todos</a></li>
            <?php foreach ($categorias as $cat): ?>
              <li><a
                  href="products.php?categoria=<?php echo $cat['categoria']; ?>"><?php echo ucfirst($cat['categoria']); ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </aside>
      <section id="products">
        <h2><?php echo $categoriaTitulo; ?></h2>
        <div class="products-grid">
          <?php foreach ($produtos as $produto): ?>
            <?php renderProductCard($produto); ?>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>