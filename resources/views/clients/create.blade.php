<div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="clienteModalLabel">Crear Cliente</h1>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>

            </div>

            <div x-data="{ submitted: false }">
                <form id="clientesCreate" method="POST"
                    action="{{ route('clientes.store') }}"onsubmit="document.getElementById('guardarBtn').disabled = true;">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label ">Nombre Completo:</label>
                            <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();"
                                id="" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">CI:</label>
                            <input type="text" class="form-control" name="ci" required>
                            @if ($errors->has('ci'))
                                <span class="badge badge-danger">{{ $errors->first('ci') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Celular:</label>
                            <input type="number" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <select name="id_departament" class="form-control form-control-sm-2"
                                aria-label="Default select example" required>
                                <option value="" disable selected hidden>Departamento
                                </option>
                                @foreach ($departament as $departaments)
                                    <option value="{{ $departaments->id }}">{{ $departaments->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button id="guardarBtn" type="submit" class="btn btn-primary">Guardar</button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
