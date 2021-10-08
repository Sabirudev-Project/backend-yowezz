<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DISC\AuthAPI;
use App\Http\Controllers\DISC\JsonReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function login(Request $request)
    {
        $table = 'users';
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $getUser = DB::table($table)->where('email', '=', $data['email'])->first();
            if (Hash::check($data['password'], $getUser['password'])) {
                return JsonReturn::successReturn("Get data " . $table, $getUser, $table, $request);
            } else {
                return JsonReturn::failedReturn('Email or Password Incorrect', $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function update(Request $request, $index)
    {
        $table = 'users';
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $update = DB::table($table)->where('id', '=', $index)->update($data);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function view(Request $request, $table)
    {
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $insert = DB::table($table)->insert($data);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }
}
