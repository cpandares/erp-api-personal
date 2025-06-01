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
            'surname' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'username' => 'string|max:255|unique:users',
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
        $user = $this->getUserByEmail($request->input('email'));
        /* ret */
        return response()->json(['token' => $token, 'user' => $user], Response::HTTP_CREATED);
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

            $user = $this->getUserByEmail($request->input('email'));
            return response()->json(
                [
                    'token' => $token, 
                    'user' => $user
                ], Response::HTTP_OK);
            
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
                'error' => 'Invalid or expired tokensssssssssss',
            ], Response::HTTP_UNAUTHORIZED);
        }
        // Return the authenticated user
        $auth = auth('sanctum')->user();

        return response()->json([
            'user' =>  $auth,
            'token' => $token,
        ]);
    }

    public function getUserByEmail($email){
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $user->makeHidden(['password', 'remember_token']);
        return $user;
    }

    public function renewToken(Request $request)
    {
        $token = $request->bearerToken();
       
        
        if (!$token) {
            return response()->json([
                'error' => 'Token not provided',
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        // Return the authenticated user
        $auth = auth('sanctum')->user();
        // Generate a new token for the user
        $token = $auth->createToken('auth_token')->plainTextToken;


        return response()->json([
            'token' => $token,
            'user' => $auth,
        ], Response::HTTP_OK);
    }

    


}
