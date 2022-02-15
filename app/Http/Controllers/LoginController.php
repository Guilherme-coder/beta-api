<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\User;

class LoginController extends Controller
{
    public function register(Request $request) {
        $request->merge(['password' => bcrypt($request->password)]);
        $data = $request->only(['name', 'email', 'password']);
        $user = User::create($data);

        $result['name'] = $user->name;
        $result['email'] = $user->email;
        $result['token'] = $user->createToken('token')->accessToken;

        return response()->json($result);
    }

    public function login(Request $request){
        $credenciais = $request->only(['email', 'password']);
        if(!Auth::attempt($credenciais)){
            $erro = 'Nao autorizado';
            $result = [
                'error' => $erro
            ];
            return response()->json($result, 401);
        }
        $user = $request->user();
        $result['name'] = $user->name;
        $result['email'] = $user->email;
        $result['token'] = $user->createToken('token')->accessToken;

        return response()->json($result, 200);
//        return response()->json($credenciais);
    }

    public function logout(Request $request) {
        $isAuth = $request->user()->token()->revoke();
        if(!$isAuth){
            $message['erro'] = 'nao foi possivel fazer o logout';
            return response()->json($message, 200);
        }
        $message['message'] = 'logout feito';
        return response()->json($message, 200);
    }
}
