<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(Request $request) {
        if(!$user = User::find(Auth::user()->id)){
            return response()->json([ 'message' => 'este usuario nao existe' ], 404);
        }
        $user->update($request->all());
        return response()->json($user, 201);
    }

    public function destroy(Request $request) {
        if(!$user = User::find(Auth::user()->id)){
            return response()->json([ 'message' => 'este usuario nao existe' ], 404);
        }
        $request->user()->token()->revoke();
        $user->delete();
        return response()->json(['message' => 'usuario removido com sucesso'], 200);
    }

    public function loadSession() {
        $ssesion = Auth::user();
        return response()->json($ssesion, 200);
    }
}
