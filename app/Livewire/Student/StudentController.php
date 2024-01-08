<?php

namespace App\Livewire\Student;

use App\Models\Client as ModelsClient;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class StudentController extends Component
{
    public $hola;
    public $searchTerm = '';

    public $contador;
    public $pageTitle;
    public $componentName;

    public $selected_id;
    public  $username, $password, $firtsname, $lastname, $email, $course = [], $matricular;

    private $pagination = 10;
    public function mount()
    {
        $this->pageTitle = 'listado';
        $this->componentName = 'Estudiante';
    }

    public function rules()
    {
        return  [
            'username' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&*()_+|{}:;<>,.?~]).*$/',
            ],
            'firtsname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',

            ],
            'course' => 'required|array|min:1',
        ];
    }
    

    public function store()
    {
        $this->validate(); // Realiza la validación (se asume que esto está definido en otra parte del código)
    
        $client = new Client();
    
        // Información del nuevo estudiante
        $nuevoEstudiante = [
            'wstoken' => '54ba9d71de467adab5ed172d145d64e3',
            'wsfunction' => 'core_user_create_users',
            'moodlewsrestformat' => 'json',
            'users' => [
                [
                    'username' => $this->username,
                    'password' => $this->password,

                    'firstname' => $this->firtsname,
                    'lastname' => $this->lastname,
                    'email' => $this->email,
                    'auth' => 'manual',
                ],
            ],
        ];
    
        $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
            'form_params' => $nuevoEstudiante,
        ]);
    
        $data = json_decode($response->getBody(), true);
    
        if (isset($data['exception']) && isset($data['message'])) {
            $exception = $data['exception'];
            $message = $data['message'];
    
            if (isset($data['debuginfo'])) {
                $debuginfo = $data['debuginfo'];
    
                $this->dispatch('validarCamposResponse', $debuginfo);
    
                // Mostrar un SweetAlert2 con el mensaje de error
            } else {
                dd($message);
                $this->dispatch('validarCamposResponse', $message);
            }
        }
    
        if (isset($data[0]['id'])) {
            $nuevoEstudianteId = $data[0]['id'];
            ModelsClient::create([
                'id_user' => Auth::user()->id,
                'name' => $this->firtsname,
                'lastname' => $this->lastname,
                'user_name' => $this->username,
                'email' => $this->email,
            ]);
            // Matricular al estudiante en los cursos proporcionados en el arreglo 'cursos'
            foreach ($this->course as $cursoId) {
                $matriculacion = [
                    'wstoken' => '54ba9d71de467adab5ed172d145d64e3',
                    'wsfunction' => 'enrol_manual_enrol_users',
                    'moodlewsrestformat' => 'json',
                    'enrolments' => [
                        [
                            'roleid' => 5,
                            'userid' => $nuevoEstudianteId,
                            'courseid' => $cursoId,
                        ],
                    ],
                ];
    
                $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
                    'form_params' => $matriculacion,
                ]);
    
                $matriculacionExitosa = json_decode($response->getBody(), true);
    
                // Verificar si la matriculación fue exitosa
              
            }
        }
    
        return redirect('/clientes');
    }
    
    
    
    public function update()
    {
        // Valida los datos del formulario
        // Crea una instancia de GuzzleHttp\Client
        $client = new Client();

        // Información del estudiante
        $estudiante = [
            'wstoken' => '54ba9d71de467adab5ed172d145d64e3', // Tu token
            'wsfunction' => 'core_user_update_users',
            'moodlewsrestformat' => 'json',
            'users' => [
                [
                    'id' => $this->selected_id, // ID del estudiante a actualizar
                    'username' => $this->username,
                    'firstname' => $this->firtsname,
                    'lastname' => $this->lastname,
                    'email' => $this->email,
                    'auth' => 'manual',
                ],
            ],
        ];

        // Realiza la solicitud para actualizar al estudiante
        $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
            'form_params' => $estudiante,
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['exception']) && isset($data['message'])) {
            $exception = $data['exception'];
            $message = $data['message'];

            if (isset($data['debuginfo'])) {
                $debuginfo = $data['debuginfo'];
                $this->dispatch('validarCamposResponse', $debuginfo);

            } else {
                $this->dispatch('validarCamposResponse', $message);

            }

            return; // Termina la ejecución si hubo un error en la actualización del estudiante
        }

        // Obtiene la lista de cursos actuales del estudiante
        $estudiante = $this->getStudentDataFromMoodle($this->selected_id);
        $cursosActuales = $estudiante['courses'];

        // Obtiene la lista de cursos seleccionados
        $cursosSeleccionados = $this->course;

        // Compara los cursos actuales con los cursos seleccionados para determinar las matriculaciones y desmatriculaciones
        $cursosAMatricular = array_diff($cursosSeleccionados, array_column($cursosActuales, 'id'));
        $cursosADesmatricular = array_diff(array_column($cursosActuales, 'id'), $cursosSeleccionados);

        // Matricula o desmatricula al estudiante según el valor de $this->matricular
        if ($this->matricular) {
            // Desmatricular al estudiante de los cursos que deben desmatricularse
            foreach ($cursosADesmatricular as $cursoId) {
                $desmatriculacion = [
                    'wstoken' => '54ba9d71de467adab5ed172d145d64e3',
                    'wsfunction' => 'enrol_manual_unenrol_users',
                    'moodlewsrestformat' => 'json',
                    'enrolments' => [
                        [
                            'roleid' => 5,
                            'userid' => $this->selected_id,
                            'courseid' => $cursoId,
                        ],
                    ],
                ];

                $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
                    'form_params' => $desmatriculacion,
                ]);

                $desmatriculacionExitosa = json_decode($response->getBody(), true);

                if (!isset($desmatriculacionExitosa[0]['id'])) {
                    // Manejar errores en la desmatriculación
                }
            }
        } else {
            // Matricular al estudiante en los cursos que deben matricularse
            foreach ($cursosAMatricular as $cursoId) {
                $matriculacion = [
                    'wstoken' => '54ba9d71de467adab5ed172d145d64e3',
                    'wsfunction' => 'enrol_manual_enrol_users',
                    'moodlewsrestformat' => 'json',
                    'enrolments' => [
                        [
                            'roleid' => 5,
                            'userid' => $this->selected_id,
                            'courseid' => $cursoId,
                        ],
                    ],
                ];

                $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
                    'form_params' => $matriculacion,
                ]);

                $matriculacionExitosa = json_decode($response->getBody(), true);

                if (!isset($matriculacionExitosa[0]['id'])) {
                    // Manejar errores en la matriculación
                }
            }
        }
        return redirect('/clientes');

        // Redirigir o devolver una respuesta según sea necesario
    }

    public function render()
    {
        // Crear un cliente HTTP de Guzzle
        $client = new Client();

        // Obtener la lista de todos los cursos
        $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
            'form_params' => [
                'wstoken' => '54ba9d71de467adab5ed172d145d64e3', // Tu token
                'wsfunction' => 'core_course_get_courses',
                'moodlewsrestformat' => 'json',
            ],
        ]);

        // Decodificar la respuesta JSON
        $cursos = json_decode($response->getBody(), true);

        // Inicializar un array asociativo para los estudiantes
        $estudiantes = [];

        // Iterar a través de la lista de cursos
        foreach ($cursos as $curso) {
            // Obtener la lista de usuarios para cada curso
            $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
                'form_params' => [
                    'wstoken' => '54ba9d71de467adab5ed172d145d64e3', // Tu token
                    'wsfunction' => 'core_enrol_get_enrolled_users',
                    'moodlewsrestformat' => 'json',
                    'courseid' => $curso['id'], // ID del curso actual
                ],
            ]);

            // Decodificar la respuesta JSON
            $usuariosEnCurso = json_decode($response->getBody(), true);

            // Filtrar la lista de usuarios para seleccionar solo a los estudiantes
            $estudiantesEnCurso = array_filter($usuariosEnCurso, function ($usuario) {
                foreach ($usuario['roles'] as $rol) {
                    if ($rol['shortname'] === 'student') {
                        return true;
                    }
                }
                return false;
            });

            // Iterar a través de los estudiantes en este curso
            foreach ($estudiantesEnCurso as $estudiante) {
                $estudianteId = $estudiante['id'];

                // Verificar si el estudiante ya está en la lista
                if (!isset($estudiantes[$estudianteId])) {
                    // Agregar el estudiante a la lista con su ID como clave
                    $estudiantes[$estudianteId] = $estudiante;

                    // Agregar el nombre del curso a la lista de cursos del estudiante
                    $estudiantes[$estudianteId]['cursos'][] = $curso['fullname'];
                } else {
                    // Si el estudiante ya existe, simplemente agrega el nombre del curso
                    $estudiantes[$estudianteId]['cursos'][] = $curso['fullname'];
                }
            }
        }

        // Puedes obtener la lista final de estudiantes usando array_values para eliminar las claves
        $listaEstudiantes = array_values($estudiantes);

        // Puedes ordenar la lista de estudiantes según tus necesidades
        $listaEstudiantes = collect($listaEstudiantes)->sortBy('nombre_completo')->toArray();

        // Pasar la lista de estudiantes a la vista
        $filteredEstudiantes = array_filter($listaEstudiantes, function ($estudiante) {
            // Comparar el término de búsqueda con el nombre completo del estudiante
            return stristr($estudiante['username'], $this->searchTerm) !== false;
        });

        return view('livewire.student.student', [
            'estudiantes' => $filteredEstudiantes,
            'cursos' => $cursos,
        ]);
    }
    public function getStudentDataFromMoodle($studentId)
    {
        // Crear una instancia de GuzzleHttp\Client
        $client = new Client();

        // Parámetros de la solicitud para obtener los datos del estudiante
        $params = [
            'wstoken' => '54ba9d71de467adab5ed172d145d64e3', // Reemplaza 'TU_TOKEN' por tu token de autenticación de Moodle
            'wsfunction' => 'core_user_get_users',
            'moodlewsrestformat' => 'json',
            'criteria[0][key]' => 'id',
            'criteria[0][value]' => $studentId,
        ];

        // Realizar la solicitud a la API de Moodle para obtener los datos del estudiante
        $response = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
            'form_params' => $params,
        ]);

        // Verificar si la solicitud fue exitosa (código de respuesta 200)
        if ($response->getStatusCode() === 200) {
            // Decodificar la respuesta JSON
            $data = json_decode($response->getBody(), true);

            // Comprobar si se encontró al estudiante
            if (!empty($data)) {
                $user = $data['users'][0];

                // Ahora, vamos a obtener los cursos del estudiante usando core_enrol_get_users_courses
                $params = [
                    'wstoken' => '54ba9d71de467adab5ed172d145d64e3', // Tu token
                    'wsfunction' => 'core_enrol_get_users_courses',
                    'moodlewsrestformat' => 'json',
                    'userid' => $user['id'],
                ];

                // Realizar la solicitud a la API de Moodle para obtener los cursos
                $coursesResponse = $client->post('https://secap.edu.bo/webservice/rest/server.php', [
                    'form_params' => $params,
                ]);

                if ($coursesResponse->getStatusCode() === 200) {
                    $coursesData = json_decode($coursesResponse->getBody(), true);

                    // Ahora puedes acceder a los datos del estudiante y los cursos
                    return [
                        'student' => $user,
                        'courses' => $coursesData,
                    ];
                }
            }
        }

        // Estudiante no encontrado o solicitud fallida
        return null;
    }
    public function edit($estudent)
    {
        $this->selected_id = $estudent;
        $studentData = $this->getStudentDataFromMoodle($estudent);

        // Asigna los datos del estudiante a las propiedades de Livewire
        $this->username = $studentData['student']['username'];
        $this->firtsname = $studentData['student']['firstname'];
        $this->lastname = $studentData['student']['lastname'];
        $this->email = $studentData['student']['email'];
        $this->course = collect($studentData['courses'])->pluck('id')->toArray();
        $this->dispatch('show-modal', 'show');
    }


    public function resetUI()
    {
        $this->reset();
        $this->componentName = 'Estudiante';
    }
}
