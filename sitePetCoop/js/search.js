const searchBar = document.querySelector('.searchBar');
const searchResults = document.createElement('div');
const searchOverlay = document.createElement('div');

searchResults.className = 'search-results';
searchOverlay.className = 'search-overlay-bg';

document.querySelector('.searchContainer').appendChild(searchResults);
document.body.appendChild(searchOverlay);

let searchTimeout;

searchBar.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const query = e.target.value;

    if (query.length < 2) {
        searchResults.classList.remove('active');
        searchOverlay.classList.remove('active');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch(`includes/search_products.php?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.results.length > 0) {
                    searchResults.innerHTML = data.results.map(product => `
                        <a href="product-details.php?id=${product.id}" class="search-item">
                            <img src="${product.imagem}" alt="${product.nome}" style="width: 50px; height: 50px; object-fit: contain;">
                            <div class="search-item-info">
                                <div class="search-item-name">${product.nome}</div>
                                <div class="search-item-price">R$ ${formatPrice(product.preco)}</div>
                                <div class="search-item-category">
                                    <i class="bi bi-tag"></i>
                                    ${product.categoria}
                                </div>
                            </div>
                        </a>
                    `).join('');
                    searchResults.classList.add('active');
                    searchOverlay.classList.add('active');
                } else {
                    searchResults.innerHTML = '<div class="no-results">Nenhum produto encontrado</div>';
                    searchResults.classList.add('active');
                    searchOverlay.classList.add('active');
                }
            })
            .catch(error => console.error('Erro:', error));
    }, 300);
});

// Fechar ao clicar fora
searchOverlay.addEventListener('click', () => {
    searchResults.classList.remove('active');
    searchOverlay.classList.remove('active');
    searchBar.blur();
});

// Fechar com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        searchResults.classList.remove('active');
        searchOverlay.classList.remove('active');
        searchBar.blur();
    }
});

function formatPrice(price) {
    return Number(price).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
