@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Cliente
        </div>
        <div class="card-body">
            <div class="container overflow-hidden">
                <div class="row align-items-start">
                    <div class="col">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nombre y Apellido</label>
                            <input class="form-control" value="{{ $client->name }}" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Ci</label>
                            <input class="form-control" value="{{ $client->ci }}" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Celular</label>
                            <input class="form-control" value="{{ $client->phone }}" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Departamento</label>
                            <input class="form-control" value="{{ $client->departament->name }}" readonly>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer text-muted">
            <div class="float-left"> Cliente creado en : {{ $client->created_at }}</div>
            <div class="float-right"> Creado por : {{ $client->user->name }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-header">
                <div class="float-left"> Detalle de Venta</div>
                <div class="float-right">
                    @if ($venta->extra == null)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ampliacion">
                            <i class="fas fa-plus-circle"></i> Agregar Recargo
                        </button>
                        @include('saledetail.amplicacion')
                    @endif

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container overflow-hidden">
                <table class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <th
                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                            Cod</th>
                        <th
                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                            Cantidad
                        </th>
                        <th
                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                            Descripcion</th>
                        <th
                            style="background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 8px;">
                            Precio
                            Unitario</th>
                        <th
                            style="background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 8px;">
                            Descuento</th>
                        <th
                            style="background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 8px;">
                            Subtotal
                        </th>

                    </thead>
                    <tbody>

                        @foreach ($product_id as $key => $value)
                            <tr>
                                <th style="text-align: center;font-weight: normal;">code{{ $value['id'] }}
                                </th>
                                <th style="text-align: center;font-weight: normal;">{{ $value['quantity'] }}
                                </th>
                                <th style="text-align: left;font-weight: normal;">{{ $value['name'] }} </th>
                                @foreach ($product as $products)
                                    @if ($value['id'] == $products->id)
                                        <th style="text-align: right;font-weight: normal;">
                                            {{ $products->price * $value['quantity'] }}
                                    @endif
                                    </th>
                                @endforeach
                                @foreach ($product as $products)
                                    @if ($value['id'] == $products->id)
                                        <th style="text-align: right;font-weight: normal;">
                                            {{ $products->discount * $value['quantity'] }}
                                    @endif
                                    </th>
                                @endforeach
                                <th style="text-align: right;font-weight: normal;">
                                    {{ $value['price'] * $value['quantity'] }} </th>

                            </tr>
                        @endforeach
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right; font-weight: normal; ">SUBTOTAL:</th>
                            <th style="text-align: right;font-weight: normal; ">{{ $subtotal }}Bs</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right; font-weight: normal; ">DESCUENTO GENERAL:</th>
                            <th style="text-align: right;font-weight: normal; ">{{ $discount }}Bs</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right; font-weight: normal; ">RECARGO:</th>

                            @if ($venta->extra == null)
                                <th style="text-align: right;font-weight: normal; ">0 Bs</th>
                            @else
                                <th style="text-align: right;font-weight: normal; "> {{ $venta->extra }} Bs </th>
                            @endif

                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="background-color: rgb(176, 184, 192); text-align: right; font-weight: normal; ">
                                TOTAL A PAGAR:</th>
                            <th style="background-color: rgb(176, 184, 192); text-align: right;font-weight: normal; ">
                                {{ $total_price }}Bs</th>
                        </tr>
                        {{-- <td>{{ $totalEnc }}</td>
                                <td>{{ number_format((float) $general, 1, '.', '') }}</td>
                                <td>{{ $totalAse }}</td> --}}
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="card-header">
            Descripcion de Venta
        </div>
        <form method="POST" action="{{ route('venta-completa.update', $venta->id) }}">
            @csrf @method('PUT')
            <div class="card-body">
                <textarea class="form-control" name="description" rows="3">{{ $venta->description }}</textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
        <div class="card-footer text-muted">
            <div class="float-left"> Cliente creado en : {{ $venta->created_at }}</div>
            <div class="float-right"> Creado por : {{ $venta->user->name }}</div>
        </div>

    </div>
    <div class="card">
        <div class="card-header">
            <div class="float-left"> Historial de Pagos</div>
            <div class="float-right">
                @if ($total_price - $sumPay == 0)
                @else
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPaymentModal">
                        <i class="fas fa-plus-circle"></i> Agregar Pago
                    </button>
                    @include('saledetail.add-payment')
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="container overflow-hidden">
                <table style="width: 100%">
                    <tr>
                        <td colspan="2">
                            <table style="width:100% "class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th
                                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                                            Usuario</th>
                                        <th
                                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                                            Fecha</th>
                                        <th
                                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                                            Fecha D/T</th>
                                        <th
                                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                                            Metodo de Pago</th>
                                        <th
                                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                                            Comprobante</th>
                                        <th
                                            style="background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 8px;">
                                            Nº D/T</th>
                                        <th
                                            style="background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 8px;">
                                            Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pays as $pay)
                                        <tr>
                                            <td style="text-align: right;font-weight: normal;">
                                                {{ $pay->id_user }}</td>
                                            <td style="text-center: center;font-weight: normal;">
                                                {{ \Carbon\Carbon::parse($pay->created_at)->format('d/m/Y') }}
                                            </td>
                                            <td style="text-center: center;font-weight: normal;">
                                                {{ \Carbon\Carbon::parse($pay->updated_at)->format('d/m/Y') }}
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
                                                    <div class="modal fade" id="imageModal{{ $pay->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="imageModalLabel">
                                                                        Comprobante</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
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
                                                {{ $pay->amount }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right; font-weight: normal; ">TOTAL PAGADO</td>
                                        <td style="text-align: right; font-weight: normal; ">
                                            Bs:{{ $sumPay }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background-color: rgb(176, 184, 192); text-align: right; font-weight: ">
                                            SALDO</td>
                                        <td style="background-color: rgb(176, 184, 192); text-align: right; font-weight: ">
                                            Bs:{{ $total_price - $sumPay }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td> {{ $qr }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted">
            <div class="float-left"> Cliente creado en : {{ $client->created_at }}</div>
            <div class="float-right"> Creado por : {{ $client->user->name }}</div>
        </div>
    </div>


@stop

@section('css')
    <style>
        .loading-indicator {
            display: none;
            /* Inicialmente oculto */
            /* Estilos adicionales */
        }
    </style>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>

    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2"></script>
    <script>
        function validateForm() {
            // Deshabilitar el botón después de enviar el formulario
            Alpine.data('submitted', true);
            // Mostrar un mensaje de "Enviando..." o realizar otras acciones necesarias
            return true;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.ampliacion-input').on('input', function() {
                var precio = parseFloat($('.precio-input').val());
                var ampliacion = parseFloat($('.ampliacion-input').val());
                var total = precio + ampliacion;
                $('.total-input').val(total);
            });
        });
    </script>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- calcular deuda en modal --}}
    <script>
        const totalInput = document.getElementById("totalDeuda");
        const pagoInput = document.getElementById("pago");
        const restanteInput = document.getElementById("restante");
        const errorText = document.getElementById("error");
        const submitBtn = document.getElementById("submit");

        pagoInput.addEventListener("input", () => {
            const total = Number(totalInput.value);
            const pago = Number(pagoInput.value);

            if (pago > total) {
                errorText.style.display = "block";
                submitBtn.disabled = true;
                restanteInput.value = "";
            } else {
                errorText.style.display = "none";
                submitBtn.disabled = false;
                restanteInput.value = total - pago;
            }
        });
    </script>
    {{-- end --}}
    {{-- abrir imagen con modal --}}
    <script>
        $(document).ready(function() {
            $('#imageModal').on('show.bs.modal', function(e) {
                var image = $(e.relatedTarget).attr('src');
                $('#largeImage').attr('src', image);
            });
        });
    </script>



    <script>
        // Obtener el elemento select y el contenedor del input
        const select = document.getElementById("payment_type");
        const inputContainer = document.getElementById("input-container1");

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
            var table1 = $('#saledetailTable thead tr').clone(true).addClass('filters').appendTo(
                '#saledetailTable thead');
            $('#saledetailTable').DataTable({
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
                        columns: [0, 1, 2, 3, 4, 5]
                    },

                }, {
                    extend: 'print',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                        stripHtml: false,
                    }
                }, ],

            });


        });
    </script>
@stop
