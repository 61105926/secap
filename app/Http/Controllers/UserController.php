<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Contracts\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('superadmin')) {
            $rol =  \Spatie\Permission\Models\Role::get();
            $user = User::get();
            return view('users.index', ['user' => $user, 'rol' => $rol]);
        } else {
            $rol =  \Spatie\Permission\Models\Role::where('name', '!=', 'superadmin')->get();
            // dd($rol);
            $role = \Spatie\Permission\Models\Role::where('name', 'superadmin')->first();
            $user = User::whereDoesntHave('roles', function ($query) use ($role) {
                $query->where('id', $role->id);
            })->get();
            // dd($user);

            return view('users.index', ['user' => $user, 'rol' => $rol]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->assignRole($request->input('rol'));
        $user->save();
        return response()->json(['success' => true]);
    }

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {

        // dd($request->all());
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'required',
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->syncRoles($request->input('rol'));
        $user->save();
        return redirect('usuarios');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/usuarios')->with('eliminar', 'ok');
    }
}
