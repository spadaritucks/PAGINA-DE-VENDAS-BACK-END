<?php

namespace App\Http\Controllers;

use App\Models\Vendas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $vendas = Vendas::all();

            return response()->json([
                "status" => true,
                "vendas" => $vendas,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Erro ao consultar as vendas " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $valor_integral = str_replace(',', '.', $request->valor_integral);

            DB::beginTransaction();
            $venda = Vendas::create([
                'cliente_id' => $request->cliente_id,
                'vendedor_id' => $request->vendedor_id,
                'valor_integral' => $valor_integral,
                'forma_pagamento' => $request->forma_pagamento,
                'parcelas' => $request->parcelas,

            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Venda cadastrada com Sucesso',
                'venda' => $venda
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => true,
                'message' => 'Erro ao cadastrar a venda ' . $e
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $valor_integral = str_replace(',', '.', $request->valor_integral);

            DB::beginTransaction();

            $venda = Vendas::findOrFail($id);

            $venda->updateOrCreate([
                'cliente_id' => $request->cliente_id,
                'vendedor_id' => $request->vendedor_id,
                'forma_pagamento' => $request->forma_pagamento,
                'valor_integral' => $valor_integral,
                'parcelas' => $request->parcelas,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Venda atualizada com sucesso',
                'venda' => $venda
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => true,
                'message' => 'Erro ao atualizar a venda ' . $e
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
            $venda = Vendas::findOrFail($id);

            $venda->delete();

            return response()->json([
                'status' => true,
                'message' => "Venda excluida com sucesso",
            ], 200);



            DB::commit();
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => "Falha ao excluir o venda " . $e,
            ], 400);
        }
    }
}
