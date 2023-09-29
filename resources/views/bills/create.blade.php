<div class="modal fade" id="billsModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="usuarioModalLabel">Registrar Gasto</h3>
                <button type="button" class="btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    &times;</button>
            </div>
            <div x-data="{ submitted: false }">

                <form method="POST" action="{{ route('bills.store') }}" enctype="multipart/form-data"
                    onsubmit="document.getElementById('guardarBtn').disabled = true;">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="opciones">Selecciona una opción de pago:</label>
                                    <select id="payment_type" required name="payment_type"
                                        class="form-control form-control-sm-2form-control form-control-sm-2">
                                        <option value="" disable selected hidden>Seleccione
                                        </option>
                                        <option value="transfer">Transferencia</option>
                                        <option value="deposit">Depósito</option>
                                        <option value="cash">Efectivo</option>
                                    </select>
                                    {{-- input invisible --}}

                                </div>
                            </div>
                            <div class="col">
                                <div id="input-container"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Categoria:</label>

                                    <select name="category" class="form-control form-control-sm-2"
                                        aria-label="Default select example" required>
                                        <option value="" disable selected hidden>Seleccione una Categoria
                                        </option>
                                        <option value="MATERIAL DE ESCRITORIO">MATERIAL DE ESCRITORIO</option>
                                        <option value="MATERIAL DE LIMPIEZA">MATERIAL DE LIMPIEZA</option>
                                        <option value="INSUMOS DE PRODUCCION">INSUMOS DE PRODUCCION</option>
                                        <option value="GASTOS DE FUNDACION">GASTOS DE FUNDACION</option>
                                        <option value="SUELDOS AL PERSONAL">SUELDOS AL PERSONAL</option>
                                        <option value="COMISIONES">COMISIONES</option>
                                        <option value="MANTENIMIENTO Y REPARACIONES">MANTENIMIENTO Y REPARACIONES
                                        </option>
                                        <option value="REPUESTOS Y ACCESORIOS">REPUESTOS Y ACCESORIOS</option>
                                        <option value="ALQUILERES">ALQUILERES</option>
                                        <option value="SERVICIOS BASICOS">SERVICIOS BASICOS</option>
                                        <option value="VIATICOS">VIATICOS</option>
                                        <option value="SERVICIOS EXTERNOS">SERVICIOS EXTERNOS</option>
                                        <option value="IMPUESTOS">IMPUESTOS</option>
                                        <option value="GASTOS DE ORGANIZACION">GASTOS DE ORGANIZACION</option>
                                        <option value="CAJA CHICA">CAJA CHICA</option>
                                        <option value="GASTOS DE FIN DE AÑO">GASTOS DE FIN DE AÑO</option>
                                        <option value="REFRIGERIOS Y ALMUERZOS">REFRIGERIOS Y ALMUERZOS</option>
                                        <option value="GASTOS POR UNIFORMES">GASTOS POR UNIFORMES</option>
                                        <option value="ENVIÓS">ENVIÓS</option>
                                        <option value="UTENSILIOS DE COCINA">UTENSILIOS DE COCINA</option>
                                        <option value="DEVOLUCIONES">DEVOLUCIONES</option>
                                        <option value="MOBILIARIO">MOBILIARIO</option>
                                        <option value="EQUIPOS DE COMPUTACIÓN">EQUIPOS DE COMPUTACIÓN</option>
                                        <option value="MUEBLES Y ENSERES">MUEBLES Y ENSERES</option>
                                        <option value="MAQUINARIA Y EQUIPO">MAQUINARIA Y EQUIPO</option>
                                        <option value="OTROS ACTIVOS FIJOS">OTROS ACTIVOS FIJOS</option>
                                        <option value="OTROS GASTOS DE PRODUCCION">OTROS GASTOS DE PRODUCCION</option>
                                        <option value="OTROS GASTOS">OTROS GASTOS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nombre Producto:</label>
                                    <input type="text" class="form-control" id="" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="price" class="col-form-label">Precio/U:</label>
                                    <input type="text" class="form-control" id="price" name="price" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="quantity" class="col-form-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="total_price" class="col-form-label">Total:</label>
                                    <input type="text" readonly class="form-control" id="total_price"
                                        name="total_price">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
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
                            <div class="col">
                                <label for="message-text" class="col-form-label">Fecha de Pago:</label>
                                <input type="date" class="form-control" name="created_at" required>
                            </div>
                        </div>
                        <label for="message-text" class="col-form-label">Descripcion:</label>
                        <textarea required class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button id="guardarBtn" type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
