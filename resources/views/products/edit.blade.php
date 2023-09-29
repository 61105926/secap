<div class="modal fade" id="productModal{{ $products->id }}" tabindex="-1" aria-labelledby="productModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="productModalLabel">Editar Producto</h1>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>
            </div>
            <form method="POST" action="{{ route('productos.update', $products->id) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="message-text" class="col-form-label">Imagen:</label>
                            <input type="file" value="" name="image" class="form-control"
                                onchange="document.getElementById('blah1{{ $products->id }}').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-md-4">
                            <img class="img-thumbnail mx-auto d-block" id="blah1{{ $products->id }}"
                                src="{{ asset('storage/products/' . $products->image) }}" width="150"
                                height="150" />
                        </div>
                        <div class="col-md-4">
                            <label for="message-text" class="col-form-label">Categoria:</label>
                            <select name="id_category" class="form-control form-control-sm-2"
                                aria-label="Default select example" required>
                                <option value="" disable selected hidden>Seleccione una Categoria
                                </option>
                                @foreach ($category as $categories)
                                    <option @if ($categories->id == $products->id_category) selected @endif
                                        value="{{ $categories->id }}">
                                        {{ $categories->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre Producto:</label>
                            <input type="text" class="form-control" id="" name="name"
                                value="{{ $products->name }}" required>
                        </div>


                        <div class="col-md-3">
                            <label for="message-text" class="col-form-label">Precio:</label>
                            <input type="number" class="form-control" name="price" step="0.01"
                                value="{{ $products->price }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="message-text" class="col-form-label">Descuento:</label>
                            <input type="number" class="form-control" name="discount" step="0.01"
                                value="{{ $products->discount }}" required>
                        </div>

                        <div class="col-md-2">
                            <label for="message-text" class="col-form-label">Stock:</label>
                            <input type="number" class="form-control" name="stock" value="{{ $products->stock }}"
                                required>

                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
