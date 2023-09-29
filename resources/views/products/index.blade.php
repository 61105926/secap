@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Productos</h1>

    <a class="btn btn-app bg-primary"data-toggle="modal" data-target="#productModal">
        <span class="badge bg-success"><i class="fas fa-plus"></i> </span>
        <i class="fas fa-book-open"></i> Nuevo Producto
    </a>
    @include('products.create')
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Productos</h3>
                    </div>
                    <div class="card-body">
                        <table id="productTable"
                            class="cell-border stripe hover compact display responsive nowrap order-column" width="100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th style="width: 10px; ">Id</th>
                                    <th>Categoria</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                    <th>Total Precio</th>
                                    <th>Stock</th>
                                    <th>Portada</th>
                                    <th>Creado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $products)
                                    <tr>
                                        <th>{{ $products->id }}</th>
                                        <th>{{ $products->categories->name }}</th>
                                        <th class="miColumna">
                                            {{ $products->name }}</th>



                                        <th>{{ $products->price }} Bs</th>
                                        @if ($products->discount == null)
                                            <th>sin/dto.</th>
                                        @else
                                            <th>{{ $products->discount }} Bs</th>
                                        @endif
                                        <th>{{ $products->total_price }}/bs</th>
                                        <th>{{ $products->stock }}</th>
                                        <th>
                                            <img src="{{ asset('storage/products/' . $products->image) }}" width="60"
                                                height="60" alt="tag">
                                        </th>
                                        <th>{{ $products->created_at->toDateString() }}</th>
                                        <th>
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#productModal{{ $products->id }}">
                                                <i class="fas fa-book"></i>
                                            </button>
                                            @include('products.edit')
                                            @include('products.delete')
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
    <style>
        thead input {
            width: 100%;
        }

        .miColumna {
            width: 20%;
        }
    </style>
    {{-- dataTable --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
    {{-- buttoms pdf dataTable --}}
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.0/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    {{-- end datable --}}
    {{-- datafilterscolumn --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
    {{-- end datafilter --}}
@stop

@section('js')
    {{-- datafilters columns --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2"></script>

    <script>
        function validateForm() {
          
            // Deshabilitar el botón después de enviar el formulario
            Alpine.data('submitted', true);

            // Mostrar un mensaje de "Enviando..." o realizar otras acciones necesarias

            return true;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.1.2/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
    {{-- end datafilter --}}
    {{-- buttoms pdf dataTable --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    {{-- dataTable --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.0/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.js">
    </script>
    <script>
        $(document).ready(function() {
            var table1 = $('#productTable thead tr').clone(true).addClass('filters').appendTo(
                '#productTable thead');
            $('#productTable').DataTable({

                orderCellsTop: true,
                fixedHeader: true,
                autoWidth: true,
                bAutoWidth: true,

                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api.columns().eq(0).each(function(colIdx) {

                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');
                        // On every keypress in this input
                        $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                            .off('keyup change')
                            .on('keyup change', function(e) {
                                e.stopPropagation();
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();
                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search((this.value != "") ? regexr.replace('{search}',
                                            '(((' + this.value + ')))') : "", this.value !=
                                        "", this.value == "")
                                    .draw();
                                $(this).focus()[0].setSelectionRange(cursorPosition,
                                    cursorPosition);
                            });
                    });
                },
                dom: 'Blfrtip',
                responsive: true,

                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel">Excel</i>',
                    titleAttr: 'Exportar a excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    },

                }, {
                    extend: 'print',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        stripHtml: false,
                    }
                }, ],

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
        $('.form-eliminar-productos').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Está seguro?',
                text: "El Producto se eliminara definitivamente.",
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
                'El Producto se ha sido eliminado.',
                'success'
            )
        </script>
    @endif
    {{-- en sweetalert2 --}}
@stop
