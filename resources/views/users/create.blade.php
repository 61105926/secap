<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="usuarioModalLabel">Crear Usuario</h1>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>
            </div>
            <div x-data="{ submitted: false }">
                <form id="usuariosCreateAjax" method="POST" action="{{ route('usuarios.store') }}"
                    x-on:submit="submitted = true" @submit="return validateForm()">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nombre Completo:</label>
                            <input type="text" class="form-control" id="" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Correo:</label>
                            <input type="text" class="form-control" name="email" required>
                            <label for="message-text" class="col-form-label">Contraseña:</label>
                            <input type="text" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <select name="rol" class="form-control form-control-sm-2"
                                aria-label="Default select example" required>
                                <option value="" disable selected hidden>Seleccione un rol</option>

                                @foreach ($rol as $roles)
                                    <option value="{{ $roles->id }}">
                                        {{ $roles->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="guardarBtn" class="btn btn-primary"
                            :disabled="submitted">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
