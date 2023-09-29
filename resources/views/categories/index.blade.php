@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
<h1>Categoria</h1>

<a class="btn btn-app bg-primary" data-toggle="modal" data-target="#categoriaModal">
  <span
      class="badge bg-success"><i class="fas fa-plus"></i> </span>
    <i class="fas fa-categorys"></i> Nuevo Categoria
</a>
@include('categories.create')
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Categorias</h3>
                </div>
                <div class="card-body">
                    <table id="tableCategories" class="cell-border stripe hover compact display responsive nowrap order-column  " style="width:100%">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Creado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ $category->pluck('name') }} --}}
                            @foreach ($category as $categories)
                            <tr>
                                <th>{{ $categories->id }}</th>
                                <th>{{ $categories->name }}</th>
                                <th>{{ $categories->created_at->toDateString() }}</th>
                                <th>
                                    <button
                                      type="button"
                                      class="btn btn-warning"
                                      data-toggle="modal"
                                      data-target="#categoriaModal{{ $categories->id }}">
                                        <i class="	fas fa-edit"></i>
                                        {{-- <i class="fas fa-shopping-cart"></i> --}}
                                    </button>
                                    @include('categories.edit')
                                    @include('categories.delete')
                                </th>
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
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2"></script>

{{-- dataTable --}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {

        $('#tableCategories').DataTable({

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
            "responsive": 'true',
            responsive: true
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
    $('.form-eliminar-categories').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro?',
            text: "De eleiminar la categoria definitivamente.",
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
        'La categoria ha sido eliminado.',
        'success'
    )
</script>
@endif
{{-- en sweetalert2 --}}
@stop