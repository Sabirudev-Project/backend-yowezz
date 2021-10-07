<?php

namespace App\Http\Controllers\API;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DISC\AuthAPI;
use App\Http\Controllers\DISC\JsonReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    //
    public function fetch_message(Request $request)
    {
        $table = 'messages';
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $getMessage = DB::table($table)->orderByDesc('created_at')->take(50)->get();
            return JsonReturn::successReturn("Get data " . $table, $getMessage, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function send_message(Request $request)
    {
        $table = 'messages';
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $insert = DB::table($table)->insert($data);
            if ($insert) {
                broadcast(new ChatEvent($data))->toOthers();
                return JsonReturn::successReturn("Get data " . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('failed sending message', $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }
}
