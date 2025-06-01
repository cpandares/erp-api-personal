<?php

namespace App\Http\Controllers;

use App\Models\Taxes;

use Illuminate\Http\Request;

use Validator;

class TaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request('page', 1);
        $perPage = request('perPage', 10);
        $taxes = Taxes::paginate($perPage, ['*'], 'page', $page);
        return response()->json($taxes, 200);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:taxes,name',
            'description' => 'string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'created_at' => 'date',
            'updated_at' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Check if the name already exists
        $existingTax = Taxes::where('name', $request->name)->first();
        if ($existingTax) {
            return response()->json(['error' => 'The name has already been taken.'], 422);
        }


        try {
            $taxes = Taxes::create($request->all());
            return response()->json($taxes, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to create tax: ' . $th->getMessage()], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $taxes = Taxes::find($id);
        if (!$taxes) {
            return response()->json(['error' => 'Tax not found'], 404);
        }
        return response()->json([
            'data' => $taxes,
        ]);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $taxes = Taxes::find($id);
        if (!$taxes) {
            return response()->json(['error' => 'Tax not found'], 404);
        }

        try {
            $taxes->update($request->all());
            return response()->json([
                'message' => 'Tax updated successfully',
                'tax' => $taxes,
            ], 201);
            
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to update tax: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $taxes = Taxes::find($id);
        if (!$taxes) {
            return response()->json(['error' => 'Tax not found'], 404);
        }

        try {
            $taxes->delete();
            return response()->json([
                'ok' => true,
                'message' => 'Tax deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to delete tax: ' . $th->getMessage()], 500);
        }
    }
   
}
