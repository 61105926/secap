<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Agregar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div x-data="{ submitted: false }">

                <form method="POST" action="{{ route('detalle-venta.store') }}" enctype="multipart/form-data"
                    x-on:submit="submitted = true" @submit="return validateForm()">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" value="{{ $venta->id }}" name="id_venta">
                            <label for="opciones">Selecciona una opción de pago:</label>
                            <select required id="payment_type" name="payment_type"
                                class="form-control form-control-sm-2form-control form-control-sm-2">
                                <option value="" disable selected hidden>Seleccione una Categoria
                                </option>
                                <option value="transfer">Transferencia</option>
                                <option value="deposit">Depósito</option>
                                <option value="cash">Efectivo</option>
                            </select>
                        </div>
                        {{-- input invisible --}}
                        <div id="input-container1"></div>
                        {{-- end --}}
                        <label for="input-resta">Fecha de Pago:</label>
                        <input type="date" class="form-control" name="created_at" required>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Total de deuda</label>
                            <input class="form-control" readonly value="{{ $total_price - $sumPay }}" id="totalDeuda">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Monto Pago</label>
                            <input class="form-control" value="" id="pago" name="pay">
                            <p id="error" style="color: red; display: none">
                                El pago no puede ser mayor al total de la deuda.
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Restante</label>
                            <input class="form-control" value="" readonly id="restante" name="balance">
                        </div>
                        <label for="exampleFormControlInput1" class="form-label">Seleccione Caja</label>

                        <select required id="control" name="caja_id" class="form-control " style="width: 100%">
                            <option value="" disable selected hidden>Seleccione una Caja
                            </option>
                            @foreach ($atm as $atms)
                                <option value="{{ $atms->id }}"> Caja {{ $atms->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit"
                            x-bind:disabled="submitted">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
