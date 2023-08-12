<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{  
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register','logout']]);
    // }

    public function login(Request $valores)
    {

        $credentials = $valores->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token"=>$token], Response::HTTP_OK)->withCookie($cookie);
        }else{
            return response(["message" => "Credencials invaled"], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(Request $request)
    {
        return response()->json([
            "message" => "userProfile OK",
            "userData" => auth()->user()
        ], Response::HTTP_OK);    }

    public function logout(Request $request)
    {        
        $cookie = Cookie::forget('cookie_token');
        return response(["message"=>"Cierre de sesión OK"], Response::HTTP_OK)->withCookie($cookie);

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json($user, Response::HTTP_CREATED);
    }
}
