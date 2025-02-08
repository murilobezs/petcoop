<?php
require_once 'includes/functions.php';
require_once 'includes/product-card.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
  <meta charset="utf-8" />
  <link rel="icon" href="images/website/logo/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <link rel="stylesheet" href="./css/header.css" />
  <link rel="stylesheet" href="./css/index.css" />
  <link rel="stylesheet" href="./css/main.css" />
  <link rel="stylesheet" href="./css/banner.css" />
  <link rel="stylesheet" href="./css/container.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous" />
  <title>PetCoop</title>
</head>

<body>
  <header class="header">
    <div class="logoContainer">
      <a href="/">
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

  <section class="hero">
    <div class="carousel">
      <div class="carousel-track">
        <img src="./images/website/banner/banner-1.png" alt="Imagem 1" class="carousel-image" />
        <img src="./images/website/banner/banner-2.png" alt="Imagem 2" class="carousel-image" />
        <img src="./images/website/banner/banner-3.png" alt="Imagem 3" class="carousel-image" />
        <img src="./images/website/banner/banner-4.png" alt="Imagem 4" class="carousel-image" />
      </div>
      <button class="carousel-button prev">‹</button>
      <button class="carousel-button next">›</button>
    </div>
  </section>

  <main>
    <div class="container-index">
      <section id="products">
        <!-- Seção de Promoções -->
        <div class="promotions">
          <h2>Promoções</h2>
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <?php
              $promocoes = getProdutosEmPromocao();
              foreach ($promocoes as $produto) {
                renderProductCard($produto);
              }
              ?>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>

        <!-- Seção de Cães -->
        <div class="dogs">
          <h2>Cães</h2>
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <?php
              $produtosCaes = getProdutosPorCategoria('cães');
              foreach ($produtosCaes as $produto) {
                renderProductCard($produto);
              }
              ?>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>

        <!-- Repita o mesmo padrão para outras categorias -->
        <?php
        $categorias = ['gatos', 'pássaros', 'peixes', 'furões', 'roedores'];
        foreach ($categorias as $categoria) {
          $produtos = getProdutosPorCategoria($categoria);
          if (!empty($produtos)) {
            ?>
            <div class="<?php echo $categoria; ?>">
              <h2><?php echo ucfirst($categoria); ?></h2>
              <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                  <?php
                  foreach ($produtos as $produto) {
                    renderProductCard($produto);
                  }
                  ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </section>
    </div>
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
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="js/script.js"></script>
  <script src="js/search.js"></script>
  <script>
    const swipers = document.querySelectorAll(".mySwiper");
    swipers.forEach((element) => {
      new Swiper(element, {
        spaceBetween: 25, // Espaço entre slides em pixels
        slidesPerView: "auto",
        loop: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    });
  </script>
</body>

</html>