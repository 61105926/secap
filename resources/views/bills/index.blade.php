@extends('adminlte::page')

@section('title', 'Gastos')

@section('content_header')
<h1>Gastos Operativos</h1>
<a class="btn btn-app bg-success" data-toggle="modal" data-target="#billsModal">
    <span class="badge bg-success"><i class="fas fa-plus"></i> </span>
    <i class="	fas fa-cart-arrow-down"></i> Nuevo Gasto
</a>
@include('bills.create')

@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Gastos Operativos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="billTable" class="cell-border stripe hover compact display  nowrap order-column"
                            width="100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>
                                        Usuario</th>
                                    <th>
                                        Categoria
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Fecha</th>
                                    <th>
                                        Fecha D/T</th>
                                    <th>
                                        Metodo de Pago</th>
                                    <th>
                                        Nº D/T</th>
                                    <th>
                                        Monto total</th>
                                    <th>
                                        descripcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $bill)
                                <tr>
                                    <td>{{ explode(' ', $bill->user->name)[0] }}</td>
                                    <td class="small-font">{{ $bill->category }}</td>
                                    <td class="small-font">{{ $bill->name }}</td>
                                    <td>{{ $bill->quantity }}</td>
                                    <td style="text-center: center;font-weight: normal;">

                                        {{ $bill->created_at->toDateString() }}
                                    </td>
                                    <td style="text-center: center;font-weight: normal;">
                                        {{ $bill->updated_at ? $bill->updated_at->toDateString() : '' }}
                                    </td>
                                    @if ($bill->type_transfer == 'deposit')
                                    <td style="text-align: left;font-weight: normal;">
                                        Deposito
                                    </td>
                                    @elseif ($bill->type_transfer == 'transfer')
                                    <td style="text-align: left;font-weight: normal;">
                                        Transferencia
                                    </td>
                                    @elseif ($bill->type_transfer == 'cash')
                                    <td style="text-align: left;font-weight: normal;">
                                        Efectivo
                                    </td>
                                    @endif
                                    @if ($bill->type_transfer == 'cash')
                                    <td>
                                        En Caja
                                    </td>
                                    @else
                                    <td>{{ $bill->transfer }}</td>
                                    @endif
                                    <td>{{ $bill->total_amount }} Bs</td>

                                    <td style="text-align: left;font-weight: normal;">

                                        <button type="button" class="btn btn-link" data-toggle="modal"
                                            data-target="#desModal{{ $bill->id }}"> Descripcion </button>
                                        <div class="modal fade" id="desModal{{ $bill->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="desModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imageModalLabel">
                                                            Detalle</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <label for="message-text" class="col-form-label">
                                                        Descripcion:</label>

                                                    <div class="modal-body text-center">
                                                        <textarea class="form-control" readonly name="description"
                                                            rows="3">{{ $bill->description }}</textarea>
                                                    </div>
                                                    @if ($bill->type_transfer == 'cash')
                                                    <label for="message-text"
                                                        class="col-form-label">Comprobante:</label>
                                                    <label for="message-text" class="col-form-label">En
                                                        Caja</label>
                                                    @else
                                                    <label for="message-text"
                                                        class="col-form-label">Comprobante:</label>
                                                    <img id="largeImage"
                                                        src="{{ asset('storage/comprobante/' . $bill->desposit) }}"
                                                        style="max-width: 100%;
                                                    max-height: 80vh;" alt="Imagen en grande">
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
</div>
@stop

@section('css')
<style>
    thead input {
        width: 100%;
    }
</style>
<style>
    .small-font {
        font-size: 12px;
        /* Puedes ajustar el tamaño de fuente según tus necesidades */
    }
</style>
<style>
    td {
        font-size: 14px;
        /* Puedes ajustar el tamaño de fuente según tus necesidades */
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@stop

@section('js')
<!-- Incluye la biblioteca jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Incluye la biblioteca Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const quantityInput = document.getElementById("quantity");
    const priceInput = document.getElementById("price");
    const totalInput = document.getElementById("total_price");

    // Agregar eventos de cambio a los inputs de cantidad y precio
    quantityInput.addEventListener("input", calcularTotal);
    priceInput.addEventListener("input", calcularTotal);

    function calcularTotal() {
        const cantidad = parseFloat(quantityInput.value);
        const precioUnitario = parseFloat(priceInput.value);

        // Verificar si los valores son numéricos
        if (!isNaN(cantidad) && !isNaN(precioUnitario)) {
            const total = cantidad * precioUnitario;
            totalInput.value = total.toFixed(2); // Mostrar el total con 2 decimales
        } else {
            totalInput.value = ""; // Limpiar el campo de total si los valores no son numéricos
        }
    }

</script>
<script>
    // Obtener el elemento select y el contenedor del input
    const select = document.getElementById("payment_type");
    const inputContainer = document.getElementById("input-container");

    // Agregar un event listener al select para mostrar el input correspondiente
    select.addEventListener("change", function() {
        if (select.value === "transfer") {
            inputContainer.innerHTML =
                `<label for="input-transferencia">Ingresa el número de transferencia:</label><br>
             <input required type="text" id="comprobante" class="form-control" name="comprobante" placeholder="ID Transferencia"><br>
             <label for="input-fecha-transferencia">Ingresa la fecha de Transferencia:</label><br>
             <input required type="date" id="fecha" class="form-control" name="fecha"><br>
             <label for="input-comprobante-transferencia">Sube el comprobante de transferencia:</label><br>
             <input required type="file" id="deposit"  class="form-control" name="deposit">`;
        } else if (select.value === "deposit") {
            inputContainer.innerHTML =
                `<label for="input-transferencia">Ingresa el número de Deposito:</label><br>
             <input required type="text" id="comprobante" class="form-control" name="comprobante" placeholder="ID Deposito"><br>
             <label for="input-fecha-transferencia">Ingresa la fecha de Deposito:</label><br>
             <input required type="date" id="fecha" class="form-control" name="fecha"><br>
             <label for="input-comprobante-transferencia">Sube el comprobante de Deposito:</label><br>
             <input required type="file" id="deposit"  class="form-control" name="deposit">`;
        } else {
            inputContainer.innerHTML = "";
        }
    });

</script>



<script>
    $(document).ready(function() {
        var table1 = $('#billTable thead tr').clone(true).addClass('filters').appendTo(
            '#billTable thead');
        var table = $('#billTable').DataTable({

            orderCellsTop: true
            , fixedHeader: true
            , autoWidth: true
            , bAutoWidth: true,

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
                                .search((this.value != "") ? regexr.replace('{search}'
                                        , '(((' + this.value + ')))') : "", this.value !=
                                    "", this.value == "")
                                .draw();
                            $(this).focus()[0].setSelectionRange(cursorPosition
                                , cursorPosition);
                        });
                });
            }
            , dom: 'Blfrtip'
            , "lengthMenu": [
                [50, 100, 200, -1]
                , [50, 100, 200, "Todo"]
            ]
            , buttons: [{
                extend: 'excelHtml5'
                , text: '<i class="fas fa-file-excel">Excel</i>'
                , titleAttr: 'Exportar a excel'
                , className: 'btn btn-success'
                , exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },

            }, {
                extend: 'print'
                , className: 'btn btn-danger'
                , exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    , stripHtml: false
                , }
            }, ],

        });

        // Función que calcula la suma de la columna 6
        function updateTotal() {
            var tot = table.column(8, {
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