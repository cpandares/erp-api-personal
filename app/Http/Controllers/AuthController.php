<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function __construct()
    {
        // Middleware assignment removed. Apply it in the routes file instead.
    }
   

    public function register(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'username' => 'required|string|max:255|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

     try {
           // Create a new user
        $user = new \App\Models\User();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->username = $request->input('username');
        $user->save();

        // Generate a new token for the user
        $token = $user->createToken('auth_token')->plainTextToken;
        // Return the token in the response
        return response()->json(['token' => $token], Response::HTTP_CREATED);
     } catch (\Throwable $th) {
        // Handle any errors that may occur
        return response()->json(['error' => 'User registration failed ' . $th->getMessage()], 500);
     }
    }


    public function login (Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::whereEmail($request->email)->first();
        // Validate the credentials
       
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        try {
            // Generate a new token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return the token in the response
            return response()->json(['token' => $token], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized ' . $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $th) {
            // Handle any errors that may occur
            return response()->json(['error' => 'Unauthorized ' . $th->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }


    public function getUser(Request $request)
    {
        $token = $request->bearerToken();

       

        if (!$token) {
            return response()->json([
                'error' => 'Token not provided',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Invalid or expired token',
            ], Response::HTTP_UNAUTHORIZED);
        }
        // Return the authenticated user
        $auth = auth('sanctum')->user();

        return response()->json([
            'user' =>  $auth,
        ]);
    }

    


}
