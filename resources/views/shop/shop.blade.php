@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 style="margin: 0;">Venta</h1>
        <a href="{{ route('cart.index') }}" class="btn btn-primary">
            <i class="bx bx-cart-alt"></i>
            Carrito
            <span class="badge badge-light">{{ \Cart::getContent()->count() }}</span>
        </a>
    </div>
@stop

@section('content')
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control col-md-3" placeholder="Buscar productos" aria-label="Small"
            aria-describedby="inputGroup-sizing-sm" id="searchInput">
    </div>
    <div id="searchResults"></div>

@stop

@section('css')
    <style>
        .card-img-overlay {
            background-color: rgba(31, 31, 31, 0.6);
            padding: 1rem;
        }

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
            color: #fff;
            /* Cambia el color del texto a blanco */
            text-shadow: 1px 1px 2px #000;
            /* Agrega una sombra al texto */
        }
    </style>
@stop

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            var searchInput = $('#searchInput');
            var searchResults = $('#searchResults');

            // Realizar búsqueda al cargar la página
            performSearch('');

            searchInput.on('keyup', function() {
                var query = searchInput.val();
                performSearch(query);
            });

            function performSearch(query) {
                $.ajax({
                    url: '{{ route('products.search') }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        var html = '<div class="row">';

                        if (response.length > 0) {
                            response.forEach(function(product) {
                                html += '<div class="col-6 col-sm-6 col-md-2 col-lg-2 mb-4">' +
                                    '<div class="card bg-dark text-white">' +
                                    '<img class="card-img w-100" src="storage/products/' +
                                    product.image + '" alt="' + product.name +
                                    '" style="object-fit: cover; height: 250px;">' +
                                    '<div class="card-img-overlay d-flex flex-column" style="background-color: rgba(0, 0, 0, 0.6); padding: 1rem;">' +
                                    '<h5 class="card-title mb-auto unique-title">' + product
                                    .name + '</h5>' +

                                    '<p class="card-text">Precio: ' + product.price + '</p>' +
                                    '<p class="card-text">Descuento: ' + product.discount +
                                    '</p>' +
                                    '<p class="card-text">Stock: ' + product.stock + '</p>' +
                                    '<form action="{{ route('cart.store') }}" method="POST">' +
                                    '{{ csrf_field() }}' +
                                    '<input type="hidden" value="' + product.id +
                                    '" id="id" name="id">' +
                                    '<input type="hidden" value="' + product.name +
                                    '" id="name" name="name">' +
                                    '<input type="hidden" value="' + product.price +
                                    '" id="total_price" name="price">' +
                                    '<input type="hidden" value="' + product.total_price +
                                    '" id="total_price" name="total_price">' +
                                    '<input type="hidden" value="' + product.image +
                                    '" id="img" name="img">' +
                                    '<input type="hidden" value="' + product.slug +
                                    '" id="slug" name="slug">' +
                                    '<div class="input-group mb-3">' +
                                    '<input type="number" class="form-control" style="font-size: 13px" placeholder="Cantidad" id="quantity" name="quantity" aria-label="Nombre de usuario" aria-describedby="basic-addon1" required>' +
                                    '<button type="submit" class="btn btn-primary">' +
                                    '<i class="fas fa-shopping-cart"></i>' +
                                    '</button>' +
                                    '</div>' +
                                    '</form>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                            });
                        } else {
                            html += '<p>No se encontraron productos.</p>';
                        }

                        html += '</div>';

                        searchResults.html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    </script>


@stop
