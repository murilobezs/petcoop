function toggleMenu() {
    const menu = document.querySelector(".navLinks");
    const overlay = document.querySelector(".overlay");
    const menuIcon = document.getElementById("menuIcon");
    menu.classList.toggle("navOpen");
    if (menu.classList.contains("navOpen")) {
      menuIcon.classList.replace("bi-list", "bi-x");
      if (window.innerWidth <= 768) {
        overlay.classList.add("show");
      }
    } else {
      menuIcon.classList.replace("bi-x", "bi-list");
      overlay.classList.remove("show");
    }
  }


  const track = document.querySelector('.carousel-track');
  const images = Array.from(track.children);
  const prevButton = document.querySelector('.carousel-button.prev');
  const nextButton = document.querySelector('.carousel-button.next');
  
  let currentIndex = 0;
  let startX = 0; // Ponto inicial do toque
  let moveX = 0;  // Movimento durante o toque
  let isDragging = false; // Flag para detectar arrasto
  
  // Atualiza o carrossel
  function updateCarousel() {
    const width = images[0].getBoundingClientRect().width;
    track.style.transform = `translateX(-${currentIndex * width}px)`;
  }
  
  // Avança para a próxima imagem
  function moveToNext() {
    currentIndex = (currentIndex + 1) % images.length;
    updateCarousel();
  }
  
  // Retrocede para a imagem anterior
  function moveToPrev() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateCarousel();
  }
  
  // Controle dos botões
  nextButton.addEventListener('click', () => {
    clearInterval(autoPlayInterval); // Pausa o autoplay
    moveToNext();
    startAutoPlay(); // Reinicia o autoplay
  });
  
  prevButton.addEventListener('click', () => {
    clearInterval(autoPlayInterval); // Pausa o autoplay
    moveToPrev();
    startAutoPlay(); // Reinicia o autoplay
  });
  
  // Inicia o autoplay
  let autoPlayInterval;
  function startAutoPlay() {
    autoPlayInterval = setInterval(moveToNext, 2000);
  }
  startAutoPlay();
  
  // Controle de toque
  track.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX; // Registra o ponto inicial do toque
    isDragging = true;
    clearInterval(autoPlayInterval); // Pausa o autoplay durante o toque
  });
  
  track.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    moveX = e.touches[0].clientX - startX; // Calcula o deslocamento do toque
  });
  
  track.addEventListener('touchend', () => {
    isDragging = false;
    if (Math.abs(moveX) > 50) { // Mínimo de 50px para considerar como arrasto
      if (moveX < 0) {
        moveToNext(); // Passa para a próxima imagem se arrastar para a esquerda
      } else {
        moveToPrev(); // Passa para a anterior se arrastar para a direita
      }
    }
    moveX = 0; // Reseta o deslocamento
    startAutoPlay(); // Reinicia o autoplay após o toque
  });
  
  // Atualiza a largura corretamente ao redimensionar
  window.addEventListener('resize', updateCarousel);

  const swipers = document.querySelectorAll(".mySwiper");
  swipers.forEach((element) => {
      new Swiper(element, {
          slidesPerView: "auto",
          spaceBetween: 25,
          loop: true,
          navigation: {
              nextEl: ".swiper-button-next",
              prevEl: ".swiper-button-prev",
          }
      });
  });
