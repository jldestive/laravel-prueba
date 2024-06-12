<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Response;


class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Usuario::paginate(10), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsuarioRequest $request)
    {
        $user = Usuario::create($request->validated());

        return response()->json(['usuario' => $user, 'message' => 'Usuario creado con éxito'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        return response()->json($usuario, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        $usuario->update($request->validated());

        return response()->json(['usuario' => $usuario, 'message' => 'Usuario actualizado con éxito'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito'], Response::HTTP_OK);
    }
}
