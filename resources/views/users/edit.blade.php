<div class="modal fade" id="editUser{{ $users->id }}" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="editUserLabel">Editar Usuario</h3>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>
            </div>
            <form id="editUserForm" method="POST" action="{{ route('usuarios.update', $users->id) }}">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nombre Completo:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id=""
                            value="{{ $users->name }}" name="name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Correo:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', $users->email) }}"" required>
                        @error('email')
                            <div class="invalid-feedback">El email ya fue registrado</div>
                        @enderror
                        <label for="message-text" class="col-form-label">Contraseña:</label>
                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <select name="rol" class="form-control form-control-sm-2"
                            aria-label="Default select example" required>
                            @foreach ($rol as $roles)
                                <option value="{{ $roles->id }}" @if ($users->roles[0]['id'] == $roles->id) selected @endif>
                                    {{ $roles->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
