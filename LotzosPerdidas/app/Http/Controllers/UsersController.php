<?php

namespace App\Http\Controllers;

use App\Services\UsersServices;
use App\Http\Requests\UsersRequest;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UsersServices $userService)
    {
        $this->userService = $userService;
    }

    // LISTAR USUARIOS — solo admin
    public function index()
    {
        $data = $this->userService->getAllUsers();

        return response()->json([
            'success' => true,
            'message' => 'Usuarios Listados Correctamente',
            'data'    => $data
        ], 200);
    }

    // VER USUARIO — admin ve cualquiera, otros solo a sí mismos
    public function show($id)
    {
        $usuario = $this->userService->getUserById($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Usuario Encontrado Correctamente',
            'usuario' => $usuario
        ], 200);
    }

    // CREAR USUARIO — público para roles normales, solo admin puede crear admins
    public function store(UsersRequest $request)
    {

        $data = $this->userService->createUser($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Usuario Creado Correctamente',
            'data'    => $data
        ], 201);
    }

    // ACTUALIZAR USUARIO — admin actualiza a todos, otros solo a sí mismos
    // nadie que no sea admin puede modificar a un admin
    public function update(UsersRequest $request, $id)
    {
        $usuario = $this->userService->getUserById($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }
        $updated = $this->userService->updateUser($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Usuario Actualizado Correctamente',
            'data'    => $updated
        ], 200);
    }

    // ELIMINAR USUARIO — solo admin
    public function destroy($id)
    {

        $usuario = $this->userService->getUserById($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        $result = $this->userService->deleteUser($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario Eliminado Correctamente'
        ], 200);
    }
}