<div class="modal fade" id="categoriaModal{{ $categories->id }}" tabindex="-1" aria-labelledby="editUserLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserLabel">Editar Categoria</h1>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>
            </div>
            <form method="POST" action="{{ route('categorias.update', $categories->id) }}">
                @csrf @method('PUT')
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nombre Completo:</label>
                        <input type="text" class="form-control" id="" name="name"
                            value="{{ $categories->name }}">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
