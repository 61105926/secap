@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuario</h1>

    <a class="btn btn-app bg-primary"data-toggle="modal" data-target="#usuarioModal">
        <span class="badge bg-success"><i class="fas fa-plus"></i> </span>
        <i class="fas fa-users"></i> Nuevo Usuario
    </a>
    @include('users.create')
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Usuarios</h3>

                    </div>
                    <div class="card-body">
                        <table id="userTable"
                            class="cell-border stripe hover compact display responsive nowrap order-column  "
                            style="width:100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Id</th>
                                    <th>Rol</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Creado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>


                                {{-- {{ $user->pluck('name') }} --}}
                                @foreach ($user as $users)
                                    <tr>
                                        <td>{{ $users->id }}</td>
                                        <td>{{ $users->roles[0]['name'] }}</td>
                                        <td>{{ $users->name }}</td>
                                        <td>{{ $users->email }}</td>
                                        <td>{{ $users->created_at->toDateString() }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#editUser{{ $users->id }}">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                            @include('users.edit')
                                            @include('users.delete')
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- dataTable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
    {{-- end datable --}}
    <!-- Agrega el archivo CSS del complemento Select -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
@stop


@section('js')
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#editUser{{ $users->id }}').modal('show');
            });
        </script>
    @endif
    <script>
        function validateForm() {
            // Realiza tus validaciones personalizadas aquí
            // Si hay algún error, devuelve false para cancelar el envío del formulario
            // Si no hay errores, puedes devolver true o simplemente omitir la declaración "return"
            // Ejemplo de validación de campo:
            var name = document.getElementById('name').value;
            if (name.trim() === '') {
                alert('Por favor, ingrese un nombre válido');
                return false;
            }

            // Otras validaciones...

            return true;
        }

        $(document).ready(function() {
            $('#usuariosCreateAjax').on('submit', function(event) {
                event.preventDefault();

                // Deshabilitar botón de guardar
                $('#guardarBtn').prop('disabled', true);

                var formData = $(this).serialize();
                var url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            location
                        .reload(); // Recargamos la página para mostrar el nuevo usuario creado
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorsHtml = '';

                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });

                        $('#usuarioModal .modal-body').prepend(
                            '<div class="alert alert-danger"><ul>El email ya ha sido registrado</ul></div>'
                        );
                    },
                    complete: function() {
                        // Habilitar botón de guardar después de un retardo de 1 segundo
                        setTimeout(function() {
                            $('#guardarBtn').prop('disabled', false);
                        }, 1000);
                    }
                });
            });
        });
    </script>

    <!-- Agrega el archivo JavaScript del complemento Select -->
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    {{-- dataTable --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#userTable').DataTable({

                "order": [
                    [0, 'desc']
                ],
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "Todo"]
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "Ningun registro encontrado",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    'search': 'Buscar:',
                    'paginate': {
                        'next': 'Siguiente',
                        'previous': 'Anterior'
                    }

                },
            });

        });
    </script>
    {{-- end datatable --}}
    {{-- close modal --}}
    <script>
        window.addEventListener('close-modal', event => {
            $('#usuarioModal').modal('hide');
        })
    </script>
    {{-- end modal --}}
    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.form-eliminar').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Está seguro?',
                text: "El Usuario se eliminara definitivamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
            })
        });
    </script>
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
                'Eliminado',
                'El Usuario ha sido eliminado.',
                'success'
            )
        </script>
    @endif
    {{-- en sweetalert2 --}}
@stop
