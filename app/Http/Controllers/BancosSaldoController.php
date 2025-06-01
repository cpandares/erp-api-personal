<?php

namespace App\Http\Controllers;

use App\Models\BancosSaldo;
use App\Http\Requests\StoreBancosSaldoRequest;
use App\Http\Requests\UpdateBancosSaldoRequest;
use Illuminate\Http\Request;

class BancosSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nombreBanco = $_GET['nombre_banco'] ?? null;

        $bancosSaldos = BancosSaldo::where(function ($query) use ($nombreBanco) {
            if ($nombreBanco) {
                $query->where('nombre_banco', 'like', '%' . $nombreBanco . '%');
            }
        })->get();
        return response()->json([
            'data' => $bancosSaldos,
            'message' => 'Bancos Saldos retrieved successfully',
        ]);
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
    public function store(StoreBancosSaldoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BancosSaldo $bancosSaldo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BancosSaldo $bancosSaldo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $data = $request->all();

        if (is_array($data)) {
            $updated = [];
            foreach ($data as $item) {
                $bancosSaldo = BancosSaldo::where('numero_cuenta', $item['numero_cuenta'])->first();
                if (!$bancosSaldo) {
                    return response()->json(['message' => 'Banco not found: ' . $item['numero_cuenta']], 404);
                }
                $bancosSaldo->saldo = $item['saldo'];
                $bancosSaldo->save();
                $updated[] = $bancosSaldo;
            }
            return response()->json([
                'message' => 'Saldos updated successfully',
                'data' => $updated,
            ]);
        }

        return response()->json(['message' => 'Invalid data format'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BancosSaldo $bancosSaldo)
    {
        //
    }
}
