@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
    {{-- <form method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="import_file">
        <button class="btn btn-primary" type="submit">Importar</button>
    </form> --}}


@stop
@section('content')

    <livewire:student.student-controller />

@stop

@section('css')
@livewireStyles

    {{-- dataTable --}}
    <style>
        thead input {
            width: 100%;
        }
    </style>
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
@stop

@section('js')
<script src="../src/plugins/src/flatpickr/flatpickr.js"></script>

<script src="../src/plugins/src/flatpickr/custom-flatpickr.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@livewireScriptConfig 

    {{-- <script type="text/javascript">
        @if (count($errors) > 0)
            $('#clienteModal').modal('show');
        @endif
    </script> --}}
    {{-- datafilters columns --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.1.2/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
    {{-- end datafilter --}}

    {{-- buttoms pdf dataTable --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    {{-- dataTable --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.0/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.js">
    </script>
    {{-- validacion --}}
  
    <script>
        $(document).ready(function() {
            $('.submit-form').on('click', function(event) {
                event.preventDefault();
                var form = $(this).closest('form');
                var url = form.attr('action');
                var method = form.attr('method');
                var data = form.serialize();
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(field, messages) {
                                var input = form.find('[name="' + field + '"]');
                                var parent = input.parent();
                                parent.addClass('has-error');
                                parent.append(
                                    '<div class="alert alert-danger">Este carnet ya esta registrado.</div>'
                                );
                            });
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $('#clientesCreate').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    // Si la petición AJAX es exitosa, ocultamos el modal y recargamos la página
                    location.reload();
                },
                error: function(xhr) {
                    // Si hay errores, mostramos los mensajes de error correspondientes
                    var errors = xhr.responseJSON.errors;
                    var errorString = '';
                    $.each(errors, function(key, value) {
                        errorString += value + '<br>';
                    });
                    $('#clienteModal .modal-body').prepend('<div class="alert alert-danger">' +
                        errorString + '</div>');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#clients thead tr').clone(true).addClass('filters').appendTo('#clients thead');
            var table = $('#clients').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('clientes.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'ci',
                        name: 'ci'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'departament.name',
                        name: 'departament.name',

                    },

                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            var formattedDate = data.substring(0, 10);
                            return formattedDate;
                        }
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            var editUrl = "{{ route('clientes.edit', ':id') }}".replace(':id', row
                                .id);
                            var deleteUrl = "{{ route('clientes.destroy', ':id') }}".replace(':id',
                                row.id);

                            return `
                    <a class="btn btn-warning"  href="${editUrl}" >
                        <i class="fas fa-edit"></i>
                    </a>
                        <form action="${deleteUrl}" method="POST" style="display: inline-block;"onsubmit="return confirm('¿Estás seguro de que deseas eliminar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    `;
                        }
                    }
                ],
                initComplete: function() {
                    var api = this.api();
                    // For each column
                    api.columns().eq(0).each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');
                        // On every keypress in this input
                        $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                            .off('keyup change')
                            .on('keyup change', function(e) {
                                e.stopPropagation();
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();
                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search((this.value != "") ? regexr.replace('{search}',
                                            '(((' + this.value + ')))') : "", this.value !=
                                        "", this.value == "")
                                    .draw();
                                $(this).focus()[0].setSelectionRange(cursorPosition,
                                    cursorPosition);
                            });
                    });
                },
                dom: 'Blfrtip',
                deferRender: true,
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel">Excel</i>',
                        titleAttr: 'Exportar a excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },

                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf">PDF</i>',
                        titleAttr: 'Exportar a pdf',
                        className: 'btn btn-danger',
                        filename: function() {
                            return "Listado de clientes"
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        customize: function(doc) {
                            //Remove the title created by datatTables
                            doc.content.splice(0, 1);
                            //Create a date string that we use in the footer. Format is dd-mm-yyyy
                            var now = new Date();
                            var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now
                                .getFullYear();
                            // Logo converted to base64
                            // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
                            // The above call should work, but not when called from codepen.io
                            // So we use a online converter and paste the string in.
                            // Done on http://codebeautify.org/image-to-base64-converter
                            // It's a LONG string scroll down to see the rest of the code !!!
                            var logo =
                                'data:image/png;base64,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';

                            // A documentation reference can be found at
                            // https://github.com/bpampuch/pdfmake#getting-started
                            // Set page margins [left,top,right,bottom] or [horizontal,vertical]
                            // or one number for equal spread
                            // It's important to create enough space at the top for a header !!!
                            doc.pageMargins = [20, 60, 20, 30];
                            // Set the font size fot the entire document
                            doc.defaultStyle.fontSize = 12;
                            // Set the fontsize for the table header
                            doc.styles.tableHeader.fontSize = 12;
                            // Create a header object with 3 columns
                            // Left side: Logo
                            // Middle: brandname
                            // Right side: A document title
                            doc['header'] = (function() {
                                return {
                                    columns: [{
                                            image: logo,
                                            width: 100
                                        },
                                        {
                                            alignment: 'center',
                                            text: 'Tabla Clientes',
                                            fontSize: 16,
                                            margin: [10, 0]
                                        },
                                        {
                                            alignment: 'right',
                                            fontSize: 10,
                                            text: 'Telefono:63841038'
                                        }
                                    ],
                                    margin: 20
                                }
                            });
                            // Create a footer object with 2 columns
                            // Left side: report creation date
                            // Right side: current page and total pages
                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [{
                                            alignment: 'left',
                                            fontSize: 7,

                                            text: ['Creado: ', {
                                                text: jsDate.toString()
                                            }]
                                        },
                                        {
                                            alignment: 'right',
                                            fontSize: 7,
                                            text: ['Pagina ', {
                                                text: page.toString()
                                            }, ' de ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: 20
                                }
                            });
                            // Change dataTable layout (Table styling)
                            // To use predefined layouts uncomment the line below and comment the custom lines below
                            // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['paddingLeft'] = function(i) {
                                return 4;
                            };
                            objLayout['paddingRight'] = function(i) {
                                return 4;
                            };
                            doc.content[0].layout = objLayout;
                        }
                    }


                ],
                "order": [
                    [0, 'desc']
                ],
                "lengthMenu": [
                    [50, 100, 500, -1],
                    [50, 100, 500, "Todo"]
                ],
                "pageLength": 10,

                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "Ningun registro encontrado",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    'search': 'Buscar:',
                    'paginate': {
                        'next': 'Siguiente',
                        'previous': 'Anterior'
                    }

                },
                "responsive": 'true',
            });



        });
    </script>
    {{-- end datatable --}}
    {{-- close modal --}}
    <script>
        window.addEventListener('close-modal', event => {
            $('#clienteModal').modal('hide');
        })
    </script>
    {{-- end modal --}}
    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    <script>
        $('.form-eliminar-clients').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Está seguro?',
                text: "El Cliente se eliminara definitivamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
            })
        });
    </script>
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
                'Eliminado',
                'El Cliente se ha sido eliminado.',
                'success'
            )
        </script>
        
    @endif
    {{-- en sweetalert2 --}}
@stop
