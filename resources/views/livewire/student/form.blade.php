@include('common.modalhead')

<div class="modal-body">
    <form class="mt-3 mb-4" enctype="multipart/form-data">

        <div class="row ">
            <div class="col-sm-4">
                <label for="exampleFormControlInput1">Nombre De Usuario:</label>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fas fa-address-book"></i>
                        </span>
                        <input wire:model.lazy="username" type="text" class="form-control" placeholder="Usuario">
                    </div>
                    @error('username')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <label for="exampleFormControlInput1">Contraseña:</label>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fas fa-address-book"></i>
                        </span>
                        <input wire:model.lazy="password" type="text" class="form-control" placeholder="Contraseña">
                    </div>
                    @error('password')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <label for="exampleFormControlInput1">Nombres :</label>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fas fa-address-book"></i>
                        </span>
                        <input wire:model="firtsname" type="text" class="form-control" placeholder="Nombres">
                    </div>
                    @error('firtsname')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <div class="col-sm-4">
                <label for="exampleFormControlInput1">Apellidos:</label>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input wire:model="lastname" type="text" class="form-control" placeholder="Apellidos">
                    </div>
                    @error('lastname')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <label for="exampleFormControlInput1">Correo Electronico:</label>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input wire:model="email" type="text" class="form-control" placeholder="Email">
                    </div>
                    @error('email')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>
        <span style="font-size: 20px;">Asignar Cursos</span>

        <div>
            @error('course')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        @if ($selected_id > 1)
            <div class="form-check">
                <input class="form-check-input" wire:model="matricular" type="checkbox" id="matricularCheck">
                <label class="form-check-label" for="matricularCheck">
                    Desmatricular al estudiante
                </label>
            </div>
        @else
        @endif

        @foreach ($cursos as $curso)
            @if (!$loop->first)
                <div class="form-check form-check-primary form-check-inline">
                    <input class="form-check-input" wire:model="course" type="checkbox" value="{{ $curso['id'] }}"
                        id="curso{{ $loop->index }}">
                    <label class="form-check-label" for="curso{{ $loop->index }}">{{ $curso['shortname'] }}</label>
                </div>
            @endif
        @endforeach



    </form>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
{{-- buttoms pdf dataTable --}}
<link
    href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.0/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
{{-- end datable --}}
{{-- datafilterscolumn --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
{{-- end datafilter --}}


<script src="../src/plugins/src/flatpickr/flatpickr.js"></script>

<script src="../src/plugins/src/flatpickr/custom-flatpickr.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('user-added', (event) => {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.hide();
        });
        @this.on('show-modal', (event) => {

            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        });

        @this.on('user-updated', (event) => {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.hide();
        });
        @this.on('validarCamposResponse', (event) => {
            console.log(event);
            if (event !== undefined && event !== null) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: event, // Mensaje de error específico del formato de email incorrecto
                    showConfirmButton: false,
                    timer: 50500
                });
            } else if (!event) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Debes rellenar todos los campos',
                    showConfirmButton: false,
                    timer: 22500
                });
            }
        });
    });
    // Accede a la variable de Livewire y úsala en tu JavaScript
</script>
@include('common.modalfooter')
