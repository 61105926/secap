<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="productModalLabel">Crear Producto</h1>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>
            </div>
            <div x-data="{ submitted: false }">
                <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data"
                    x-on:submit="submitted = true" @submit="return validateForm()">


                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="message-text" class="col-form-label">Portada:</label>
                                <input type="file" name="image" class="form-control"
                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            </div>

                            <div class="col-md-4">
                                <img class="img-thumbnail mx-auto d-block" id="blah" src="{{ asset('/logo.jpg') }}"
                                    width="150" height="150" />
                            </div>
                            <div class="col-md-4">
                                <label for="message-text" class="col-form-label">Categoria:</label>
                                <select name="id_category" class="form-control form-control-sm-2"
                                    aria-label="Default select example" required>
                                    <option value="" disable selected hidden>Seleccione una Categoria
                                    </option>
                                    @foreach ($category as $categories)
                                        <option value="{{ $categories->id }}">{{ $categories->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="recipient-name" class="col-form-label">Nombre Producto:</label>
                                <input type="text" class="form-control" id="" name="name" required>
                            </div>
                            <div class="col-md-3">
                                <label for="message-text" class="col-form-label">Precio:</label>
                                <input type="number" class="form-control"step="0.01" name="price" required>
                            </div>
                            <div class="col-md-3">
                                <label for="message-text" class="col-form-label">Descuento:</label>
                                <input type="number" class="form-control"step="0.01" name="discount" required>
                            </div>
                            <div class="col-md-2">
                                <label for="message-text" class="col-form-label">Stock:</label>
                                <input type="number" class="form-control" name="stock" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" x-bind:disabled="submitted">Guardar</button>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
