<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div>
        <div class="layout-px-spacing">
            <div class="middle-content container-xxl p-0">
                <!-- BREADCRUMB -->
                <div class="page-meta">
                    <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Estudiantes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lista</li>
                        </ol>
                    </nav>
                </div>
                <!-- /BREADCRUMB -->
                <div class="widget-content widget-content-area br-8">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary _effect--ripple waves-effect waves-light"
                                data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-user"></i> Añadir Estudiante
                            </button>
                            <br>
                            <br>
                        </div>
                        <div class="col"><div class="my-4">
                            <input wire:model.live="searchTerm" type="text" class="form-control" placeholder="Buscar estudiantes...">
                        </div></div>
                    </div>

                    @include('livewire.student.form')
                </div>
            </div>
            <div class="widget-content widget-content-area br-8">
                <div id="invoice-list_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    {{-- <div class="inv-list-top-section">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center">
                                <div class="dataTables_length" id="invoice-list_length"><label>Results : <select
                                            name="invoice-list_length" aria-controls="invoice-list" class="form-control">
                                            <option value="7">7</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select></label></div>
    
                            </div>
    
                        </div>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="invoice-list" class="table table-hover table-striped table-bordered"
                            style="width: 100%;" role="grid" aria-describedby="invoice-list_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" style="width: 63px;">Codigo</th>
                                    <th class="sorting" tabindex="0" aria-controls="invoice-list" rowspan="1"
                                        colspan="1" aria-label="Name: activate to sort column ascending"
                                        style="width: 63px;">Usuario</th>
                                    <th class="sorting" tabindex="0" aria-controls="invoice-list" rowspan="1"
                                        colspan="1" aria-label="Email: activate to sort column ascending"
                                        style="width: 63px;">Nombre</th>
                                    <th class="sorting" tabindex="0" aria-controls="invoice-list" rowspan="1"
                                        colspan="1" aria-label="Status: activate to sort column ascending"
                                        style="width: 63px;">Apellido</th>
                                    <th class="sorting" tabindex="0" aria-controls="invoice-list" rowspan="1"
                                        colspan="1" aria-label="Amount: activate to sort column ascending"
                                        style="width: 62px;">Email</th>
                                    <th class="sorting" tabindex="0" aria-controls="invoice-list" rowspan="1"
                                        colspan="1" aria-label="Date: activate to sort column ascending"
                                        style="width: 65px;">Cursos</th>

                                    <th class="sorting" tabindex="0" aria-controls="invoice-list" rowspan="1"
                                        colspan="1" aria-label="Actions: activate to sort column ascending"
                                        style="width: 84px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estudiantes as $estudents)
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-success">{{ ++$contador }}</span>


                                        </td>

                                        <td>
                                            {{ $estudents['username'] }}
                                        </td>
                                        <td>{{ $estudents['firstname'] }}</td>
                                        <td>{{ $estudents['lastname'] }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-light-success">{{ $estudents['email'] }}</span>
                                        </td>
                                        <td>
                                            @if (isset($estudents['cursos']) && count($estudents['cursos']) > 0)
                                                <ul>
                                                    @foreach ($estudents['cursos'] as $curso)
                                                        <li>{{ $curso }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                No inscrito en cursos
                                                <!-- Mensaje para estudiantes no inscritos en ningún curso -->
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 40px;">
                                            <div class="action-btns">
                                                <!-- Botón de editar -->
                                                <a class="btn btn-info bs-tooltip" data-toggle="tooltip"
                                                    wire:click='edit({{ $estudents['id'] }})' data-placement="top"
                                                    title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>


                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td class="text-center">
                                        <span class="badge badge-light-danger">NO SE ENCONTRARON REGISTROS</span>
                                    </td>
                                @endforelse



                            </tbody>

                        </table>

                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
