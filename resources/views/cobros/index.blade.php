@extends('adminlte::page')

@section('title', 'Cobros')

@section('content_header')
    <h1>Cobros</h1>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Cobros</h3>
                    </div>
                    <div class="card-body">
                        <table id="payTable" class="cell-border stripe hover compact display responsive nowrap order-column"
                            width="100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>
                                        Usuario</th>
                                    <th style="width: 10px; ">
                                        Id Venta</th>
                                    <th>
                                        Fecha</th>
                                    <th>
                                        Fecha D/T</th>
                                    <th>
                                        Metodo de Pago</th>
                                    <th>
                                        Comprobante</th>
                                    <th>
                                        Nº D/T</th>
                                    <th>
                                        Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pays as $pay)
                                    <tr>
                                        <td style="text-align: right;font-weight: normal;">
                                            {{ $pay->user->name }}</td>
                                        <td style="text-align: right;font-weight: normal;">
                                            {{ $pay->id_venta }}</td>
                                        <td style="text-center: center;font-weight: normal;">

                                            @if ($pay->created_at)
                                                {{ $pay->created_at->toDateString() }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td style="text-center: center;font-weight: normal;">
                                            @if ($pay->updated_at)
                                                {{ $pay->updated_at->toDateString() }}
                                            @else
                                                N/A
                                            @endif

                                        </td>
                                        @if ($pay->type_transfer == 'deposit')
                                            <td style="text-align: left;font-weight: normal;">
                                                Deposito
                                            </td>
                                        @elseif ($pay->type_transfer == 'transfer')
                                            <td style="text-align: left;font-weight: normal;">
                                                Transferencia
                                            </td>
                                        @elseif ($pay->type_transfer == 'cash')
                                            <td style="text-align: left;font-weight: normal;">
                                                Efectivo
                                            </td>
                                        @endif
                                        @if ($pay->type_transfer == 'cash')
                                            <td>
                                                En Caja
                                            </td>
                                        @else
                                            <td style="text-align: left;font-weight: normal;">
                                                <button type="button" class="btn btn-link" data-toggle="modal"
                                                    data-target="#imageModal{{ $pay->id }}">
                                                    Imagen
                                                </button>
                                                <div class="modal fade" id="imageModal{{ $pay->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="imageModalLabel">
                                                                    Comprobante</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img id="largeImage"
                                                                    src="{{ asset('storage/comprobante/' . $pay->desposit) }}"
                                                                    style="max-width: 100%;
                                                                    max-height: 80vh;"
                                                                    alt="Imagen en grande">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif

                                        <td>{{ $pay->transfer }}</td>
                                        <td style="text-align: right;font-weight: normal;">
                                            {{ $pay->amount }} Bs</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <button type="button" class="btn btn-outline-secondary btn-lg ml-3">Total Bs: <span
                                        id="total" class="badge badget-light"></span>
                                </button>
                                <br>
                            </tfoot>
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
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/api/sum().js"></script>

    <script>
        $(document).ready(function() {
            var table1 = $('#payTable thead tr').clone(true).addClass('filters').appendTo(
                '#payTable thead');
            var table = $('#payTable').DataTable({

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

            // Función que calcula la suma de la columna 6
            function updateTotal() {
                var tot = table.column(7, {
                    page: 'current'
                }).data().sum();
                $('#total').text(tot);
            }

            // Llama a la función de suma en el evento draw.dt de DataTables
            table.on('draw.dt', function() {
                updateTotal();
            });

            // Calcula la suma inicialmente
            updateTotal();

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


    {{-- en sweetalert2 --}}
@stop
