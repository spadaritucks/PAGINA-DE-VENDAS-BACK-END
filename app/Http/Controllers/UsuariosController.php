<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $usuarios = Usuarios::all();

            return response()->json([
                "status" => true,
                "usuarios" => $usuarios,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Erro ao consultar os usuarios " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $usuario = Usuarios::create([
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'password' => Hash::make($request->password)

            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Usuario Cadastrado com Sucesso',
                'usuario' => $usuario
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => true,
                'message' => 'Erro ao cadastrar o usuarios ' . $e
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            DB::beginTransaction();

            $usuario = Usuarios::findOrFail($id);

            $usuario->updateOrCreate([
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'password' => Hash::make($request->password)
            ]);
          
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Usuario Atualizado com Sucesso',
                'usuario' => $usuario
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => true,
                'message' => 'Erro ao atualizar o usuarios ' . $e
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $usuario = Usuarios::findOrFail($id);

            $usuario->delete();

            return response()->json([
                'status' => true,
                'message' => "Usuario Excluido com sucesso",
            ],200);



            DB::commit();
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => "Falha ao excluir o usuario " .$e,
            ],400);
        }
    }
}
