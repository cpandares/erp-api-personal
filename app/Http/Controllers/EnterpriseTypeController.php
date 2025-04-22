<?php

namespace App\Http\Controllers;

use App\Models\EnterpriseType;

use App\Services\EnterpriseTypeService;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use Validator;


class EnterpriseTypeController extends Controller
{
    private $enterpriseTypeService;
    public function __construct()
    {
        //$this->middleware('auth:sanctum')->except(['index']);
        $this->enterpriseTypeService =  new EnterpriseTypeService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => EnterpriseType::all()
        ]);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:enterprise_types',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
       
        try {
            $response =  $this->enterpriseTypeService->create($request->all());
            return response()->json([
                'data' => $response
            ], Response::HTTP_CREATED);
        return response()->json([
            'data' => $enterpriseType
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error creating enterprise type: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($param)
    {
        if(is_numeric($param)){
            $enterpriseType = EnterpriseType::find($param);
        }else{
            $enterpriseType = EnterpriseType::where('name', $param)->first();
        }
        if (!$enterpriseType) {
            return response()->json([
                'error' => 'Enterprise type not found'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'data' => $enterpriseType
        ]);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:enterprise_types,name,' . $id,
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
       
        try {
            $enterpriseType = EnterpriseType::find($id);
            if(!$enterpriseType){
                return response()->json([
                    'error' => 'Enterprise type not found'
                ], Response::HTTP_NOT_FOUND);
            }
            $response =  $this->enterpriseTypeService->update($enterpriseType, $request->all());
            return response()->json([
                'data' => $response
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error updating enterprise type: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $enterpriseType = EnterpriseType::find($id);
        if (!$enterpriseType) {
            return response()->json([
                'error' => 'Enterprise type not found'
            ], Response::HTTP_NOT_FOUND);
        }
        try {
            $this->enterpriseTypeService->delete($enterpriseType);
            return response()->json([
                'message' => 'Enterprise type deleted successfully'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error deleting enterprise type: ' . $th->getMessage()
            ], 500);
        }
    }
}
