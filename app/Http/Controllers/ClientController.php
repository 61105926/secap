<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Imports\ClientsImport;
use App\Models\Departament;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $clients = Client::with('departament')->select('id', 'id_departament', 'name', 'phone', 'ci', 'created_at')->get();

            $formattedClients = $clients->map(function ($client) {
                $formattedDate = Carbon::parse($client->created_at)->format('Y-m-d');
                $client->created_at = $formattedDate;
                return $client;
            });

            return datatables()->of($formattedClients)->toJson();
        }


        $departament = Departament::all();
        return view('clients.index', ['departament' => $departament]);
    }


    public function create()
    {
        //
    }


    public function store(StoreClientRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'ci' => [
                'required',
                Rule::unique('clients')->where(function ($query) {
                    return $query->where('id_user', Auth::user()->id);
                })
            ],


        ]);
        $client = new Client();
        $client->name = $request->input('name');
        $client->id_user = Auth::user()->id;
        $client->id_departament = $request->input('id_departament');
        $client->ci = $request->input('ci');
        $client->phone = $request->input('phone');
        $client->save();
        return redirect('clientes');
    }


    public function show(Client $client)
    {
        //
    }


    public function edit(Client $client, string $id)
    {

        $clients = Client::find($id);
        $departament = Departament::all();
        return view('clients.edit', ['clients' => $clients, 'departament' => $departament]);
    }


    public function update(UpdateClientRequest $request, Client $client, string $id)
    {
        try {



            $client = Client::find($id);
            $ci = $request->input('ci');
            if ($ci === $client->ci) {
                $validatedData = $request->validate([
                    'ci' => 'required',
                ]);
            } else {
                $validatedData = $request->validate([
                    'ci' => 'required|unique:clients',
                ]);
            }
            $client->name = $request->input('name');
            // $client->id_user = Auth::user()->id;
            $client->id_departament = $request->input('id_departament');
            $client->ci = $request->input('ci');
            $client->phone = $request->input('phone');

            $client->save();

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function destroy(Client $client, string $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            Session::flash('success', 'El cliente se eliminó correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                Session::flash('error', 'No se puede eliminar el cliente porque tiene ventas relacionadas.');
            } else {
                Session::flash('error', 'Se produjo un error al eliminar el cliente.');
            }
        }

        return redirect('/clientes');
    }
    public function import(Request $request)
    {
        $file = $request->file('import_file');

        Excel::import(new ClientsImport, $file);

        return redirect('clientes');
    }
}
