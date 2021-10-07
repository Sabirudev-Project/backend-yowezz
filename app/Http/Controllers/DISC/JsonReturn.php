<?php

namespace App\Http\Controllers\DISC;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;


class JsonReturn extends Controller
{
    public static function successReturn($message, $data, $table, Request $request)
    {
        $jsonMessage = response()->json(['status' => 'success', 'message' => $message, 'data' => $data], 200);
        $acitivity = $request->method() . ' ' . $table;
        JsonReturn::insert_log($request, $acitivity);
        return $jsonMessage;
    }
    public static function failedReturn($message, $table, Request $request)
    {
        $jsonMessage = response()->json(['status' => 'failed', 'message' => $message], 200);
        $acitivity = $request->method() . ' ' . $table;
        JsonReturn::insert_log($request, $acitivity);
        return $jsonMessage;
    }

    private static function insert_log(Request $request, $message)
    {
        $agent = new \Jenssegers\Agent\Agent;
        $data['ip_address'] = $request->ip();
        $data['platform'] = $agent->platform();
        $data['browser'] = $agent->browser();
        $data['browser_version'] = $agent->version($data['browser']);
        $data['agent_string'] = $request->server('HTTP_USER_AGENT');
        $referer = URL::current();
        $data['referer'] = $referer;
        $data['activity'] = $message;
        $data['is_mobile'] = $agent->isMobile();
        $data['is_robot'] = $agent->isRobot();
        $data['is_desktop'] = $agent->isDesktop();
        DB::table('api_log')->insert($data);
    }
}
