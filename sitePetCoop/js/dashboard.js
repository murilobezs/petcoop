let searchTimeout;

document.getElementById('searchProducts').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    
    const query = e.target.value;
    
    searchTimeout = setTimeout(() => {
        if (query.length >= 2) {
            fetch(`includes/search_products.php?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(products => {
                    const tbody = document.querySelector('.table tbody');
                    tbody.innerHTML = '';
                    
                    products.forEach(product => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${product.id}</td>
                                <td>
                                    <img src="${product.imagem}" 
                                         alt="${product.nome}" 
                                         style="width: 50px; cursor: pointer;"
                                         onclick="showImageModal('${product.imagem}', '${product.nome}')"
                                         class="image-preview">
                                </td>
                                <td>${product.nome}</td>
                                <td>${product.categoria}</td>
                                <td>R$ ${formatPrice(product.preco)}</td>
                                <td>${product.estoque}</td>
                                <td>
                                    <div class="btn-action-container">
                                        <button class="btn btn-sm btn-warning" onclick="editProduct(${product.id})">
                                            Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">
                                            Excluir
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Erro:', error));
        }
    }, 300);
});

function formatPrice(price) {
    return Number(price).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
