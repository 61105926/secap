@extends('layouts.print')
@section('content')
    <div class="header">
        <div class="logo">
            <div class="logo-image" style="margin-left: -80px"><img src="img/logo.png" alt=""width="190"
                    height="120"></div>
        </div>
        <div class="texto texto-centro" style="margin-right: 180px">Reporte de Caja</div>
        <div class="texto-derecha"style="font-size:14px">FECHA:{{ date('d/m/Y') }}</div>
        <div class="texto-derecha-abajo"style="font-size:14px">Nº Caja:-{{ $caja->id }}</div>
        <br>
        <div class="texto-derecha-abajo"style="font-size:14px">USUARIO: {{ $caja->user->name }} </div>
    </div>

    <h4 style="text-align: center; font-weight: normal;margin-right:50px; ">MOVIMIENTO DE CAJA

    </h4>

    <h4 style="text-align: center; font-weight: normal;margin-right:50px; ">ENTRADAS EN EFECTIVO
    </h4>
    <table style="width: 100%; ">
        <thead>
            <tr>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    ID</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Tipo</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Pago</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Descripcion</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Fecha </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cajaEntrada as $cajaEntradas)
                <tr>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">{{ $cajaEntradas->id }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaEntradas->type }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaEntradas->monto }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaEntradas->description }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ \Carbon\Carbon::parse($cajaEntradas->created_at)->format('d/m/Y') }}

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>


    <h4 style="text-align: center; font-weight: normal;margin-right:50px; ">SALIDAS EN EFECTIVO
    </h4>
    <table style="width: 100%; ">
        <thead>
            <tr>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    ID</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Tipo</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Pago</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Descripcion</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Fecha </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($cajaSalida as $cajaSalidas)
                <tr>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">{{ $cajaSalidas->id }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaSalidas->type }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaSalidas->monto }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaSalidas->description }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ \Carbon\Carbon::parse($cajaSalidas->created_at)->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <h4 style="text-align: center; font-weight: normal;margin-right:50px; ">ENTRADAS POR OPERACION
    </h4>
    <table style="width: 100%; margin-top:-10px">
        <thead>
            <tr>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    ID</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Tipo</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Pago</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Descripcion</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Fecha </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($cajaOperacion as $cajaOperacions)
                <tr>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->id }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->type }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->monto }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->description }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ \Carbon\Carbon::parse($cajaOperacions->created_at)->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    </td>

    <h4 style="text-align: center; font-weight: normal;margin-right:50px; ">SALIDAS POR OPERACION
    </h4>
    <table style="width: 100%; margin-top:-10px">
        <thead>
            <tr>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    ID</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Tipo</th>
                <th
                    style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                    Pago</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Descripcion</th>
                <th
                    style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                    Fecha </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($cajaOperacionSalida as $cajaOperacions)
                <tr>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->id }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->type }}
                    </td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->monto }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ $cajaOperacions->description }}</td>
                    <td style="font-size:14px;text-align: left;font-weight: normal;">
                        {{ \Carbon\Carbon::parse($cajaOperacions->created_at)->format('d/m/Y') }}
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="text-align: center; font-weight: normal;margin-right:50px; ">RESUMEN GENERAL </h4>

    <table style="width: 100%; ">
        <thead>
            <th
                style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                Descripcion</th>
            <th
                style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                Efectivo
            </th>
            <th
                style="font-size:14px;background-color: rgb(177, 211, 250); text-align: center; font-weight: normal;padding: 6px;">
                Operacion</th>
            <th
                style="font-size:14px;background-color: rgb(176, 184, 192); text-align: center; font-weight: normal;padding: 6px;">
                Total</th>


        </thead>
        <tbody>

            <tr>
                <td style="font-size:14px;text-align: center;font-weight: normal;"><b>Entradas</b></td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $caTotal }}</td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $coTotal }}</td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $caTotal + $coTotal }}</td </tr>
            <tr>
                <td style="font-size:14px;text-align: center;font-weight: normal;"><b>Salidas</b></td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $csTotal }}</td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $cosTotal }}</td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $csTotal + $cosTotal }}</b></td>

            </tr>
            <tr>
                <td style="font-size:14px;text-align: center;font-weight: normal;"><b>Total</b></td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $caTotal - $csTotal }}</td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">{{ $coTotal - $cosTotal }}</td>
                <td style="font-size:14px;text-align: center;font-weight: normal;">
                    {{ $caTotal + $coTotal - ($csTotal + $cosTotal) }}</td>

            </tr>

        </tbody>
    </table>
@endsection
