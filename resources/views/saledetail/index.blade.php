@extends('adminlte::page')

@section('title', 'Detalle-Ventas')

@section('content_header')
    <h1>Ventas Realizadas</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Historial de Venta</h3>
                    </div>
                    <div class="card-body">
                        <table style="with" id="saledetailTable"
                            class="cell-border stripe hover compact display responsive nowrap order-column" width="100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th style="width: 10px; ">Id</th>
                                    <th>Usuario</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                    <th>Desc</th>
                                    <th>Precio <br> Total</th>
                                    <th>Saldo</th>
                                    <th>Creado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ explode(' ', $sale->user->name)[0] }}</td>
                                        <td>{{ $sale->client->name }}</td>

                                        <td>
                                            <ul style=" list-style-type: none; padding: 0;">
                                                @foreach ($productsBySale[$sale->id] as $product)
                                                    <li>{{ $product }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $sale->subtotal }} Bs</td>
                                        <td>{{ $sale->discount }} Bs</td>
                                        <td>{{ $sale->total_price }} Bs</td>
                                        <td>
                                            {{ $sale->balance }} Bs
                                        </td>

                                        <td>{{ $sale->created_at->toDateString() }}</td>
                                        <td>
                                            <a href="{{ route('detalle-venta.show', $sale) }}" class="btn btn-warning">
                                                <i class="fas fa-book"></i>
                                            </a>
                                            <a href="{{ route('reportPdf', $sale) }}" class="btn btn-danger"
                                                target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
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
    <style>
        thead input {
            width: 100%;
        }

        table tbody td {
            font-size: 14px;
            /* Tamaño de letra de 12px */
        }

        .saldo-cero {
            background-color: #6fcc81 !important;
            /* color de fondo de la fila */
            font-weight: bold;
            /* estilo de fuente de la fila */
        }

        .saldo-mayor {
            background-color: #ebc1c1 !important;
            /* color de fondo de la fila */
            font-weight: bold;
            /* estilo de fuente de la fila */
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
        // Obtener el elemento select y el contenedor del input
        const select = document.getElementById("payment_type");
        const inputContainer = document.getElementById("input-container1");

        // Agregar un event listener al select para mostrar el input correspondiente
        select.addEventListener("change", function() {
            if (select.value === "transfer") {
                inputContainer.innerHTML =
                    `<label for="input-transferencia">Ingresa el número de transferencia:</label><br><input type="text" id="transfer" class="form-control" name="transfer" placeholder="ID transferencia">`;
            } else if (select.value === "deposit") {
                inputContainer.innerHTML =
                    `<label for="input-deposito">Sube el comprobante de depósito:</label><br><input type="file" id="deposit"  class="form-control" name="deposit">`;
            } else {
                inputContainer.innerHTML = "";
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var table1 = $('#saledetailTable thead tr').clone(true).addClass('filters').appendTo(
                '#saledetailTable thead');
            $('#saledetailTable').DataTable({
                createdRow: function(row, data, dataIndex) {
                    // Obtener el valor de la columna de saldo (asumiendo que es la tercera columna)
                    var saldo = parseFloat(data[7]);
                    // Verificar si el valor es 0
                    if (saldo === 0) {
                        // Aplicar el estilo CSS personalizado a la fila
                        $(row).addClass('saldo-cero');
                    } else {
                        $(row).addClass('saldo-mayor');
                    }
                },
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
                "lengthMenu": [
                    [50, 100, 200, -1],
                    [50, 100, 200, "Todo"]
                ],
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel">Excel</i>',
                    titleAttr: 'Exportar a excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },

                }, {
                    extend: 'print',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        stripHtml: false,
                    }
                }, ],

            });


        });
    </script>
@stop
