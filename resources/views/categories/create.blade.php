<div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoriaModalLabel">Crear Categoria</h1>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>
            </div>
            <div x-data="{ submitted: false }">
                <form method="POST" action="{{ route('categorias.store') }}" x-on:submit="submitted = true"
                    @submit="return validateForm()">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nombre Completo:</label>
                            <input type="text" class="form-control" id="" name="name" required
                                x-model="name">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" x-bind:disabled="submitted">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
