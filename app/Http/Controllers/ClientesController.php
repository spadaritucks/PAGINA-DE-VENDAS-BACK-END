<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clientes = Clientes::all();

            return response()->json([
                "status" => true,
                "clientes" => $clientes,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Erro ao consultar os clientes " . $e->getMessage()
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
            $cliente = Clientes::create([
                'nome' => $request->nome,
                'cpf' => $request->cpf,


            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cliente Cadastrado com Sucesso',
                'cliente' => $cliente
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar o clientes ' . $e
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

            $cliente = Clientes::findOrFail($id);

            $cliente->updateOrCreate([
                'nome' => $request->nome,
                'cpf' => $request->cpf,

            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cliente Atualizado com Sucesso',
                'cliente' => $cliente
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar o clientes ' . $e
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
            $cliente = Clientes::findOrFail($id);

            $cliente->delete();

            return response()->json([
                'status' => true,
                'message' => "Cliente Excluido com sucesso",
            ], 200);



            DB::commit();
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => "Falha ao excluir o cliente " . $e,
            ], 400);
        }
    }
}
