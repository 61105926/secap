@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $sale }}</h3>
                            <p>Ventas Realizadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cart-arrow-down"></i>
                        </div>
                        <a href="/detalle-venta" class="small-box-footer">Mas Informacion <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $pays }}</h3>
                            <p>Pagos Recibidos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <a href="/cobros" class="small-box-footer">Mas Informacion <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $client }}</h3>
                            <p>Clientes Registrados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <a href="/clientes" class="small-box-footer">Mas Informacion <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{ $user }}</h3>
                            <p>Usuarios Registrados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-id-card-alt"></i>
                        </div>
                        <a href="/usuarios" class="small-box-footer">Mas Informacion <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>




        </div>
        <div class="row">

            <section class="col-lg-8 connectedSortable ui-sortable">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Graficos de Rentabilidad
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">

                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; ">
                                <canvas id="myChart"></canvas>

                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; ">
                                <canvas id="mychart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-4 connectedSortable ui-sortable">

                <div class="col-md-12">

                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Monto en Efectivo</font>
                                </font>
                            </span>
                            <span class="info-box-number">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{ $totalEfectivo }}</font>
                                </font>
                            </span>
                        </div>

                    </div>

                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="far fa-credit-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Monto en Transferencia</font>
                                </font>
                            </span>
                            <span class="info-box-number">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{ $totalTransferencia }}</font>
                                </font>
                            </span>
                        </div>

                    </div>

                    <div class="info-box mb-3 bg-dark">
                        <span class="info-box-icon"><i class="fas fa-donate"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Monto en Deposito</font>
                                </font>
                            </span>
                            <span class="info-box-number">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{ $totalDeposito }}</font>
                                </font>
                            </span>
                        </div>
                    </div>
                    <div class="info-box mb-3 bg-danger">
                        <span class="info-box-icon"><i class="	fas fa-balance-scale-left"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Total de Gastos</font>
                                </font>
                            </span>
                            <span class="info-box-number">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{ $totalSalida }}</font>
                                </font>
                            </span>
                        </div>

                    </div>


            </section>
        </div>
    @stop

    @section('css')
    @stop
    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script>
            var data = {!! $data !!};
            var datasub = {!! $datasub !!};
            var data1 = {!! $data1 !!};
            var datasub1 = {!! $datasub1 !!};
        
            var months = [];
            var totalsGastos = [];
            var totalsGanancias = [];
            var totalsGastos1 = [];
            var totalsGanancias1 = [];
        
            data.forEach(function (item) {
                months.push(item.month);
                totalsGanancias.push(item.total);
            });
        
            datasub.forEach(function (item) {
                totalsGastos.push(item.total1);
            });
        
            data1.forEach(function (item) {
                totalsGanancias1.push(item.total2);
            });
        
            datasub1.forEach(function (item) {
                totalsGastos1.push(item.total3);
            });
        
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                        "Octubre", "Noviembre", "Diciembre"
                    ],
                    datasets: [
                        {
                            label: 'Ingresos 2022',
                            data: totalsGanancias1,
                            backgroundColor: '#2F70A0',
                            borderColor: '#9BD0F5',
                        },
                        {
                            label: 'Gastos 2022',
                            data: totalsGastos1,
                            backgroundColor: '#009933',
                            borderColor: '#66CC99',
                        },
                        {
                            label: 'Ingresos 2023',
                            data: totalsGanancias,
                            backgroundColor: '#FE7D25',
                            borderColor: 'rgba(54, 162, 235, 1)',
                        },
                        {
                            label: 'Gastos 2023',
                            data: totalsGastos,
                            backgroundColor: '#FFCC00',
                            borderColor: '#FFD966',
                        },
                      
                       
                    ],
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                },
                            },
                        ],
                    },
                },
            });
        </script>
        
        <script>
            const totalErned = document.getElementById('totalErned').value;
            const totalBills = document.getElementById('totalBills').value;
            const totalDiscount = document.getElementById('totalDiscount').value;
            const ctx2 = document.getElementById('mychart2').getContext('2d');
            const myChart2 = new Chart(ctx2, {
                type: 'polarArea',
                data: {
                    labels: ['Ganancias', 'Descuentos', 'Gastos en productos'],
                    datasets: [{
                        label: 's',
                        data: [totalErned, totalDiscount, totalBills],
                        backgroundColor: [
                            'rgb(108, 117, 125)',
                            'rgb(255, 193, 7)',
                            'rgb(23, 162, 184)',
                            'rgb(40, 167, 69)',
                        ],
                        borderColor: [
                            'rgb(108, 117, 125)',
                            'rgba(255, 193, 7)',
                            'rgba(23, 162, 184)',
                            'rgba(40, 167, 69)',

                        ],
                        borderWidth: 1
                    }],
                    hoverOffset: 1
                },

            });
        </script>
    @stop
