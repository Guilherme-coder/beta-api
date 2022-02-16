<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyLogController extends Controller
{
    public function store(Request $request) {
        $request->merge(['user_id' => Auth::user()->id]);
        $dailyLog = DailyLog::create($request->all());
        return response()->json($dailyLog, 201);
    }

    public function index() {
        $dailyLog = DailyLog::all();
        return response()->json($dailyLog, 200);
    }

    public function getDailyLogsByUserId() {
        $dailyLog = DailyLog::where('user_id', Auth::user()->id)->get();
        return response()->json($dailyLog, 200);
    }

    public function destroy($id) {
        if(!$dailyLog = DailyLog::find($id)){
            return response()->json([ 'message' => 'este log nao existe' ], 404);
        }
        $dailyLog->delete();
        return response()->json(['message' => 'daily log removido com sucesso'], 200);
    }

    public function update(Request $request, $id) {
        if(!$dailyLog = DailyLog::find($id)){
            return response()->json([ 'message' => 'este log nao existe' ], 404);
        }
        $dailyLog->update($request->all());
        return response()->json($dailyLog, 201);
    }

    public function changeDeadline(Request $request, $id) {
        if(!$dailyLog = DailyLog::find($id)){
            return response()->json([ 'message' => 'est log nao existe' ], 404);
        }
        $dailyLog->update($request->only('deadline'));
        return response()->json($dailyLog, 201);
    }
}
