@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Detalle de venta
                    </h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                        <span class="badge badge-success">Nuevo</span>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">

                        @if (count($cartCollection) > 0)
                            <div class="col-lg-12">
                                <div x-data="{ submitted: false }">

                                    <form action="{{ route('cart.save') }}" method="post" class="back"
                                        enctype="multipart/form-data" x-on:submit="submitted = true"
                                        @submit="return validateForm()">
                                        @csrf
                                        <label for="client_id" name="client_id">

                                            Seleccione cliente:</label><br>
                                        <select required id="control" name="id_client"
                                            class="form-control form-control-sm-2 js-example-responsive"
                                            style="width: 100%">
                                            @foreach ($client as $clients)
                                                <option value=""></option>
                                                <option value="{{ $clients->id }}">{{ $clients->name }}|{{ $clients->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" value="{{ Auth::user()->id }}" name="id_user">
                                        <label for="opciones">Selecciona una opción de pago:</label>
                                        <select id="payment_type" required name="payment_type"
                                            class="form-control form-control-sm-2form-control form-control-sm-2">
                                            <option value="" disable selected hidden>Seleccione una Categoria
                                            </option>
                                            <option value="transfer">Transferencia</option>
                                            <option value="deposit">Depósito</option>
                                            <option value="cash">Efectivo</option>
                                        </select>
                                        {{-- input invisible --}}
                                        <div id="input-container"></div>
                                        {{-- end --}}
                                        <label for="input-resta">Fecha de venta:</label>
                                        <input type="date" class="form-control" name="created_at" required>



                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="input-resta">Descuento:</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">BS</span>
                                                    <input type="number" id="discount" name="discount"
                                                        class="form-control" placeholder="Ingresa el valor" required>
                                                    <span id="discount-error" style="color: red; display: none;">Error: el
                                                        descuento no puede ser mayor al precio total.</span>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <label for="input-valor">Pago :</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">BS</span>
                                                    <input type="number" id="pay" name="pay" value=""
                                                        required class="form-control" placeholder="Ingresa el valor">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="input-valor">Total :</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">BS</span>
                                                    <input type="number" id="total_price" name="total_price"
                                                        class="form-control" value="{{ \Cart::getTotal() }}" readonly>
                                                </div>
                                            </div>
                                            <input type="hidden" name="subtotal" value="{{ \Cart::getTotal() }}">
                                            <div class="col-lg-6">
                                                <label for="input-valor">Saldo :</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">BS</span>
                                                    <input type="number" id="balance" name="balance" value=""
                                                        class="form-control" placeholder="saldo" readonly>
                                                </div>
                                            </div>
                                            <label for="input-valor">Descripcion :</label>

                                            <textarea class="form-control" name="description" rows="3"></textarea>
                                            <label for="client_id" name="client_id">
                                                Seleccione su Caja:</label><br>

                                            <select required id="control" name="caja_id" class="form-control "
                                                style="width: 100%">
                                                <option value="" disable selected hidden>Seleccione una Caja
                                                </option>
                                                @foreach ($atm as $atms)
                                                    <option value="{{ $atms->id }}"> Caja {{ $atms->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <br>
                                        <input type="text" hidden name="id_product" value="   {{ $cartCollection }}">
                                        <div class="text-center">
                                            <div id="error"></div>
                                            <div id="error2"></div>
                                            <button type="submit" class="btn btn-danger" x-bind:disabled="submitted"
                                                id="guardar">Guardar</button>

                                        </div>
                                        <br>
                                        {{-- @if (session()->has('success_msg'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                                            style="border-radius: 35px">
                                            {{ session()->get('success_msg') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    @endif
                                    @if (session()->has('alert_msg'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            {{ session()->get('alert_msg') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    @endif --}}
                                        @if (count($errors) > 0)
                                            @foreach ($errors0 > all() as $error)
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert">
                                                    {{ $error }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Fecha : {{ now()->format('Y-m-d') }}
                </div>
                <!-- /.card-footer -->
            </div>

        </div>
        <div class="col-lg-6">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <button type="submit" class="btn btn-primary">
                            <a href="/ventas" style="color: white;"> <i class="fas fa-shopping-cart">|Agregar
                                    Productos</i></a>
                        </button>
                    </h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                        <span class="badge badge-secondary">Productos</span>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($cartCollection as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div style="width: 100px; height: 100px;">
                                            <img src="{{ asset('storage/products/' . $item->attributes->imagen) }}"
                                                style="object-fit: cover; width: 100%; height: 100%;"
                                                alt="{{ $item->name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        @foreach ($product as $products)
                                            @if ($item->id == $products->id)
                                                <h5 class="card-title mb-auto unique-title">
                                                    {{ $products->categories->name }}:{{ $products->name }}</h5>
                                            @endif
                                        @endforeach
                                        <br>
                                        <p class="mb-1">
                                            Precio por unidad: {{ $item->price }} Bs.<br>
                                            Cantidad: {{ $item->quantity }}<br>
                                            Sub Total: {{ \Cart::get($item->id)->getPriceSum() }} Bs.
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="id" name="id"
                                                value="{{ $item->id }}">
                                            <button class="btn btn-danger btn-sm">
                                                <i class='bx bx-trash bx-rotate-270 bx-tada'
                                                    style='color:#ffffff; font-size:15px; '></i>Borrar Producto
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                    Fecha : {{ now()->format('Y-m-d') }}
                </div>
                <!-- /.card-footer -->
            </div>
        </div>

    </div>

@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .unique-title {
            font-family: 'Montserrat', sans-serif;
            /* Cambia la fuente del título */
            font-size: 0.8rem;
            /* Aumenta el tamaño de la fuente */
            font-weight: bold;
            /* Hace que el título sea más grueso */
            text-transform: uppercase;
            /* Convierte el texto en mayúsculas */
            letter-spacing: 0.1em;
            /* Añade un poco de espacio entre las letras */
            margin-bottom: 0.5rem;
            /* Agrega un pequeño margen inferior */
            color: #0080ff;
            /* Cambia el color del texto a blanco */
            text-shadow: 1px 1px 2px #0072dd;
            /* Agrega una sombra al texto */
        }
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#control').select2({
                theme: "classic",
                language: {
                    noResults: function(params) {
                        return "No se encontraron resultados.";
                    }
                },
                placeholder: "Ingrese carnet"
            });
        });
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
        const descuentoInput = document.getElementById("discount");
        const totalInput = document.getElementById("total_price");
        const pagoInput = document.getElementById("pay");
        const saldoInput = document.getElementById("balance");
        const botonGuardar = document.getElementById("guardar");
        const error = document.getElementById("error");
        const error2 = document.getElementById("error2");

        let totalOriginal = parseFloat(totalInput.value);

        totalInput.addEventListener("input", () => {
            totalOriginal = parseFloat(totalInput.value);
            actualizarTotalConDescuento();
            actualizarSaldo();
        });

        descuentoInput.addEventListener("input", () => {
            actualizarTotalConDescuento();
            actualizarSaldo();
        });

        pagoInput.addEventListener("input", () => {
            actualizarSaldo();
        });

        function actualizarTotalConDescuento() {
            const descuento = parseFloat(descuentoInput.value);
            const totalConDescuento = totalOriginal - descuento;
            totalInput.value = totalConDescuento;
        }

        function actualizarSaldo() {
            const pago = parseFloat(pagoInput.value);
            const totalConDescuento = parseFloat(totalInput.value);
            const saldo = totalConDescuento - pago;
            saldoInput.value = saldo;

            if (descuentoInput.value > totalOriginal) {
                error.textContent = "El descuento no puede ser mayor que el total";
                descuentoInput.style.borderColor = "red";
                botonGuardar.disabled = true;
                totalInput.value = "";
            } else {
                error.textContent = "";
                descuentoInput.style.borderColor = "";
                botonGuardar.disabled = false;
            }

            if (pagoInput.value > totalConDescuento) {
                error2.textContent = "El pago no puede ser mayor al total";
                pagoInput.style.borderColor = "red";
                botonGuardar.disabled = true;
                saldoInput.value = "";
            } else {
                error2.textContent = "";
                pagoInput.style.borderColor = "";
                botonGuardar.disabled = false;
            }
        }
    </script>

@stop
