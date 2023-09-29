<div class="modal fade" id="ampliacion" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Agregar Recargo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div x-data="{ submitted: false }">
                <form method="POST" action="{{ route('venta-completa.update', $venta->id) }}"
                    onsubmit="document.getElementById('guardarBtn').disabled = true;">
                    @csrf @method('PUT')
                    <div class="modal-body">

                        {{-- input invisible --}}
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Precio</label>
                            <input type="number" class="form-control precio-input" name="price"
                                value="{{ $total_price }}" readonly>

                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Monto de Recargo</label>
                            <input type="number" class="form-control ampliacion-input" value="" id="ampliacion"
                                name="extra" required>

                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Total Precio</label>
                            <input type="number" class="form-control total-input" name="total_final" value=""
                                readonly>
                        </div>


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
