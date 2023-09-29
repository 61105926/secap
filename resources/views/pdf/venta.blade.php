@extends('layouts.print')
@section('content')
    <div class="header">
        <div class="logo">
            <div class="logo-image"><img src="img/logo.png" alt="" width="200" height="150"></div>
        </div>
        <div class="texto-centro">COMPROBANTE</div>
        <div class="texto-derecha-abajo"style="font-size:12px">Nº:TPLANA-{{ $venta->id }}</div>
        <br>
        <div class="texto-derecha-abajo"style="font-size:12px">USUARIO:{{ $venta->id_user }}</div>
        <br>
        <div class="texto-derecha-abajo"style="font-size:12px">FECHA: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
        </div>

    </div>

    <br>
    <table style="width: 70%; margin-left: 30%;margin-top:-50px">
        <thead>
            <td style="font-size:12px">
                Nombres y Apellidos:
            </td>
            <td style="font-size:12px">
                NºCI:
            </td>
            <td style="font-size:12px">
                Celular:
            </td>
            <td style="font-size:12px">
                Departamento:
            </td>
        </thead>
        <tbody>

            <tr>
                <th style="font-size:12px;font-weight: normal;">{{ $client->name }}</th>
                <th style="font-size:12px;font-weight: normal;">{{ $client->ci }}</th>
                <th style="font-size:12px;font-weight: normal;">{{ $client->phone }}</th>
                <th style="font-size:12px;font-weight: normal;">{{ $client->departament->abv }}</th>

            </tr>
        </tbody>
    </table>
    <table style="width: 90%; margin-left: 10%;">
        <thead>
            <th
                style="font-size:12px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                Cod</th>
            <th
                style="font-size:12px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                Cantidad
            </th>
            <th
                style="font-size:12px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                Descripcion</th>
            <th
                style="font-size:12px;background-color: rgb(198, 204, 209); text-align: center; font-weight: normal;padding: 6px;">
                Precio
                Unitario</th>
            <th
                style="font-size:12px;background-color: rgb(198, 204, 209); text-align: center; font-weight: normal;padding: 6px;">
                Descuento</th>
            <th
                style="font-size:12px;background-color: rgb(198, 204, 209); text-align: center; font-weight: normal;padding: 6px;">
                Subtotal
            </th>

        </thead>
        <tbody>

            @foreach ($product_id as $key => $value)
                <tr>
                    <th style="font-size:12px;text-align: center;font-weight: normal;">{{ $value['id'] }} </th>
                    <th style="font-size:12px;text-align: center;font-weight: normal;">{{ $value['quantity'] }} </th>
                    <th style="font-size:12px;text-align: left;font-weight: normal;">{{ $value['name'] }} </th>
                    @foreach ($product as $products)
                        @if ($value['id'] == $products->id)
                            <th style="font-size:12px;text-align: right;font-weight: normal;">
                                {{ $products->price }}
                        @endif
                        </th>
                    @endforeach
                    @foreach ($product as $products)
                        @if ($value['id'] == $products->id)
                            <th style="font-size:12px;text-align: right;font-weight: normal;">
                                {{ $products->discount * $value['quantity'] }}
                        @endif
                        </th>
                    @endforeach
                    <th style="font-size:12px;text-align: right;font-weight: normal;">
                        {{ $value['price'] * $value['quantity'] }} </th>

                </tr>
            @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right; font-weight: normal; font-size:11px">SUBTOTAL:</th>
                <th style="text-align: right;font-weight: normal; font-size:12px">Bs: {{ $subtotal }}</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right; font-weight: normal; font-size:11px">DESCUENTO GENERAL:</th>
                <th style="text-align: right;font-weight: normal;font-size:12px ">Bs: {{ $discount }}</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right; font-weight: normal; font-size:11px ">RECARGO:</th>

                @if ($venta->extra == null)
                    <th style="text-align: right;font-weight: normal;font-size:12px ">0 Bs</th>
                @else
                    <th style="text-align: right;font-weight: normal;font-size:12px "> {{ $venta->extra }} Bs </th>
                @endif

            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="background-color: rgb(198, 204, 209); text-align: right; font-weight: normal; font-size:11px">
                    TOTAL A PAGAR:</th>
                <th style="background-color: rgb(198, 204, 209); text-align: right;font-weight: normal;font-size:12px ">
                    Bs: {{ $total_price }}</th>
            </tr>
            {{-- <td>{{ $totalEnc }}</td>
                    <td>{{ number_format((float) $general, 1, '.', '') }}</td>
                    <td>{{ $totalAse }}</td> --}}
            </tr>
        </tbody>
    </table>
    <h4 style="text-align: center; font-weight: normal;margin-right:50px; margin-top:-8px">PAGOS REALIZADOS </h4>

    <table style="width: 90%; margin-left: 10%;margin-top:-10px">
        <tr>
            <td colspan="2">
                <table style="width: 100%; margin-top:-10px">
                    <thead>
                        <tr>
                            <th
                                style="font-size:12px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                                Usuario</th>
                            <th
                                style="font-size:12px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                                Fecha</th>
                            <th
                                style="font-size:12px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                                Metodo de Pago</th>
                            <th
                                style="font-size:12px;background-color: rgb(198, 204, 209); text-align: center; font-weight: normal;padding: 6px;">
                                Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pays as $pay)
                            <tr>
                                <td style="font-size:12px;text-align: right;font-weight: normal;">{{ $pay->id_user }}</td>
                                <td style="font-size:12px;text-align: center;font-weight: normal;">
                                    {{ \Carbon\Carbon::parse($pay->updated_at)->format('d/m/Y') }}
                                </td>
                                @if ($pay->type_transfer == 'deposit')
                                    <td style="font-size:12px;text-align: left;font-weight: normal;">
                                        Deposito
                                    </td>
                                @elseif ($pay->type_transfer == 'transfer')
                                    <td style="font-size:12px;text-align: left;font-weight: normal;">
                                        Transferencia
                                    </td>
                                @elseif ($pay->type_transfer == 'cash')
                                    <td style="font-size:12px;text-align: left;font-weight: normal;">
                                        Efectivo
                                    </td>
                                @endif
                                <td style="font-size:12px;text-align: right;font-weight: normal;">{{ $pay->amount }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: right; font-weight: normal; font-size:11px">TOTAL PAGADO</td>
                            <td style="text-align: right; font-weight: normal; font-size:12px">Bs: {{ $sumPay }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td
                                style="font-size:12px;background-color: rgb(198, 204, 209); text-align: right; font-weight: ">
                                SALDO</td>
                            <td
                                style="font-size:12px;background-color: rgb(198, 204, 209); text-align: right; font-weight: ">
                                Bs: {{ $total_price - $sumPay }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td colspan="2">
                <table style="margin-left: 30%;>
                    <tr>
                        <td style="text-align:
                    right;"> <img src="data:image/png;base64,{{ base64_encode($qr) }}" alt="Código QR">
            </td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
    {{-- <p style="padding-top: -50px; padding-left:80px;">Gracias por inscribirse..!. cualquier consulta estaremos atentos a
        sus preguntas ;-)</p> --}}
@endsection
