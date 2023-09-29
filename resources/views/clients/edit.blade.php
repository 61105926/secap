@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Editar cliente</h1>

@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos de Cliente</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-edit-client" method="POST" action="{{ route('clientes.update', $clients->id) }}">

                            @csrf @method('PUT')
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nombre Completo:</label>
                                    <input type="text" class="form-control" id="" name="name"
                                        value="{{ $clients->name }}">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">CI:</label>
                                        <input type="text" class="form-control" name="ci" required
                                            value="{{ $clients->ci }}">

                                    </div>
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Celular:</label>
                                        <input type="number" class="form-control" name="phone"
                                            value="{{ $clients->phone }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <select name="id_departament" class="form-control form-control-sm-2"
                                            aria-label="Default select example" required>
                                            </option>
                                            @foreach ($departament as $departaments)
                                                <option value="{{ $departaments->id }}"
                                                    @if ($clients->departament->id == $departaments->id) selected @endif>
                                                    {{ $departaments->name }}
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary submit-form">Guardar</button>
                                <button type="button" class="btn btn-secondary" id="btnCerrarModal"
                                    data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#btnCerrarModal').on('click', function() {
                window.location.href = '/clientes';
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.submit-form').on('click', function(event) {
                event.preventDefault();
                var form = $(this).closest('form');
                var url = form.attr('action');
                var method = form.attr('method');
                var data = form.serialize();
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(response) {
                        window.location.href = '/clientes';
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(field, messages) {
                                var input = form.find('[name="' + field + '"]');
                                var parent = input.parent();
                                parent.addClass('has-error');
                                parent.append(
                                    '<div class="alert alert-danger">Este carnet ya esta registrado.</div>'
                                );
                            });
                        }
                    }
                });
            });
        });
    </script>
@stop
