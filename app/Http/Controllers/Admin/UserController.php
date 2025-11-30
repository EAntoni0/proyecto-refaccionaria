<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación personalizada para usuarios
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,almacenista,vendedor',
        ]);

        // Crear usuario (encriptando contraseña)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Alerta SweetAlert
        session()->flash("swal", [
            "icon" => "success",
            "title" => "Usuario creado correctamente",
            "text" => "El usuario ha sido registrado exitosamente",
            "confirmButtonColor" => "#3085d6"
        ]);

        return redirect()->route("admin.users.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Generalmente no usamos show en usuarios, pero lo dejo por si acaso
        return view("admin.users.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Restringir editar al Super Admin (ID 1) para seguridad
        if($user->id == 1){
            session()->flash('swal', [
                'icon'=>'error',
                'title'=>'ERROR',
                'text'=>'No se puede editar al Super Administrador principal'
            ]);

            return redirect()->route('admin.users.index');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validación (ignorando el email del usuario actual)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,almacenista,vendedor',
        ]);

        // Preparar datos
        $data = $request->only(['name', 'email', 'role']);

        // Si escribió contraseña nueva, la encriptamos y agregamos
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Lógica para detectar si no hubo cambios (Opcional, pero siguiendo tu ejemplo)
        // Nota: Comparar password es difícil porque está encriptada, así que comparamos lo básico
        if(
            $user->name == $request->name && 
            $user->email == $request->email && 
            $user->role == $request->role && 
            !$request->filled('password')
        ){
            session()->flash('swal', [
                'icon'=>'info',
                'title'=>'Sin cambios',
                'text'=>'No se detectaron modificaciones en el usuario'
            ]); 
            return redirect()->route('admin.users.edit', $user);
        }

        // Actualizar
        $user->update($data);

        session()->flash('swal', [
            'icon'=>'success',
            'title'=>'Usuario actualizado correctamente',
            'text'=>'Los datos han sido guardados con éxito'
        ]); 

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Protección: No eliminar al ID 1
        if($user->id == 1){
            session()->flash('swal', [
                'icon'=>'error',
                'title'=>'ERROR',
                'text'=>'No puedes eliminar al Super Administrador'
            ]);
            return redirect()->route('admin.users.index');
        }

        // Borrar usuario
        $user->delete();

        session()->flash('swal', [
            'icon'=>'success',
            'title'=>'Usuario eliminado correctamente',
            'text'=>'El registro ha sido borrado del sistema'
        ]); 

        return redirect()->route('admin.users.index');
    }
}