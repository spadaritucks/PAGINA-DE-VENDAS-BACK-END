<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $produtos = Produtos::all();

            return response()->json([
                "status" => true,
                "produtos" => $produtos,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Erro ao consultar os produtos " . $e->getMessage()
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
            $produto = Produtos::create([
                'nome' => $request->nome,
                'valor' => $request->valor,


            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Produto Cadastrado com Sucesso',
                'produto' => $produto
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar o produtos ' . $e
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

            $produto = Produtos::findOrFail($id);

            $produto->updateOrCreate([
                'nome' => $request->nome,
                'valor' => $request->valor,

            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Produto Atualizado com Sucesso',
                'produto' => $produto
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar o produtos ' . $e
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
            $produto = Produtos::findOrFail($id);

            $produto->delete();

            return response()->json([
                'status' => true,
                'message' => "Produto Excluido com sucesso",
            ], 200);



            DB::commit();
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => "Falha ao excluir o produto " . $e,
            ], 400);
        }
    }
}
