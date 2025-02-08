<?php
require_once 'db_connection.php';

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : 'todos';
$produtos = getProdutosPorCategoria($categoria);
?>

<div class="product-management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciamento de Produtos - <?php echo ucfirst($categoria); ?></h2>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
            Adicionar Produto
        </button>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td>
                            <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>"
                                style="width: 50px; cursor: pointer;"
                                onclick="showImageModal('<?php echo $produto['imagem']; ?>', '<?php echo $produto['nome']; ?>')"
                                class="image-preview">
                        </td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['categoria']; ?></td>
                        <td>R$ <?php echo formatarPreco($produto['preco']); ?></td>
                        <td><?php echo $produto['estoque']; ?></td>
                        <td>
                            <div class="btn-action-container">
                                <button class="btn btn-sm btn-warning" onclick="editProduct(<?php echo $produto['id']; ?>)">
                                    Editar
                                </button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="deleteProduct(<?php echo $produto['id']; ?>)">
                                    Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para adicionar/editar produto -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Produto</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="productForm" method="post" action="includes/save_product.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="productId">
                    <div class="form-group">
                        <label>Nome do Produto</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" class="form-control" name="marca" required>
                    </div>
                    <div class="form-group">
                        <label>Categoria</label>
                        <select class="form-control" name="categoria" required>
                            <option value="">Selecione uma categoria</option>
                            <option value="cães">Cães</option>
                            <option value="gatos">Gatos</option>
                            <option value="peixes">Peixes</option>
                            <option value="pássaros">Pássaros</option>
                            <option value="furões">Furões</option>
                            <option value="roedores">Roedores</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control" name="tipo" required>
                            <option value="">Selecione um tipo</option>
                            <option value="ração">Ração</option>
                            <option value="remédio">Remédio</option>
                            <option value="acessório">Acessório</option>
                            <option value="casa">Casa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estoque</label>
                        <input type="number" class="form-control" name="estoque" required min="0">
                    </div>
                    <div class="form-group">
                        <label>Preço</label>
                        <input type="number" class="form-control" name="preco" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Imagem</label>
                        <input type="file" class="form-control-file" name="imagem" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea class="form-control" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="promocao" id="promocao">
                        <label class="form-check-label" for="promocao">Em promoção</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveProduct()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="close-modal">&times;</span>
    <img id="modalImage" class="modal-image" src="" alt="">
</div>

<script>
    function editProduct(id) {
        fetch(`includes/get_product.php?id=${id}`)
            .then(response => response.json())
            .then(product => {
                // Preencher todos os campos do formulário
                document.getElementById('productId').value = product.id;
                document.querySelector('input[name="nome"]').value = product.nome;
                document.querySelector('input[name="marca"]').value = product.marca;
                document.querySelector('select[name="categoria"]').value = product.categoria;
                document.querySelector('select[name="tipo"]').value = product.tipo;
                document.querySelector('input[name="estoque"]').value = product.estoque;
                document.querySelector('input[name="preco"]').value = product.preco;
                document.querySelector('textarea[name="descricao"]').value = product.descricao;
                document.querySelector('input[name="promocao"]').checked = product.promocao == 1;

                // Atualizar título do modal
                document.querySelector('.modal-title').textContent = 'Editar Produto';

                // Tornar campo de imagem opcional na edição
                document.querySelector('input[name="imagem"]').removeAttribute('required');

                // Abrir modal
                $('#addProductModal').modal('show');
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar dados do produto');
            });
    }

    // Resetar formulário quando o modal for fechado
    $('#addProductModal').on('hidden.bs.modal', function () {
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.querySelector('.modal-title').textContent = 'Adicionar Produto';
        document.querySelector('input[name="imagem"]').setAttribute('required', '');
    });

    function deleteProduct(id) {
        if (confirm('Tem certeza que deseja excluir este produto?')) {
            const formData = new FormData();
            formData.append('id', id);

            fetch('includes/delete_product.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao excluir produto: ' + (data.error || 'Erro desconhecido'));
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir produto');
                });
        }
    }

    function saveProduct() {
        const form = document.getElementById('productForm');
        const formData = new FormData(form);

        fetch('includes/save_product.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#addProductModal').modal('hide');
                    location.reload();
                } else {
                    alert('Erro ao salvar produto');
                }
            })
            .catch(error => console.error('Erro:', error));
    }

    function showImageModal(src, alt) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.classList.add('show');
        modalImg.src = src;
        modalImg.alt = alt;
        document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('show');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });

    // Prevent modal from closing when clicking on the image
    document.getElementById('modalImage').addEventListener('click', function (event) {
        event.stopPropagation();
    });
</script>