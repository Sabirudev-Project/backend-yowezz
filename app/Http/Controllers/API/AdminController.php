<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DISC\AuthAPI;
use App\Http\Controllers\DISC\JsonReturn;
use App\Http\Controllers\DISC\UploadFile;
use App\Imports\BazzarImport;
use App\Imports\SponsorImport;
use App\Imports\UsersImport;
use App\Imports\VideoUrlImport;
use App\Imports\WOFImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    //
    public function login(Request $request)
    {
        $username = "admin_yowez";
        $password = Hash::make("adminmantab");
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            if ($data['username'] == $username && Hash::check($data['password'], $password)) {
                return JsonReturn::successReturn("Get data " . "admin", $data, "admin", $request);
            } else {
                return JsonReturn::failedReturn('Email or Password Incorrect', "admin", $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', "admin", $request);
        }
    }

    public function create_users(Request $request)
    {
        $table = "users";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $insert = DB::table($table)->insert($data);
            if ($insert) {
                return JsonReturn::successReturn("Create data " . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed create ' . $table, $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function get_users(Request $request)
    {
        $table = "users";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data = DB::table($table)->paginate(25);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function update_users(Request $request, $index)
    {
        $table = "users";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $update = DB::table($table)->where('id', '=', $index)->update($data);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function delete_users(Request $request, $index)
    {
        $table = "users";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $delete = DB::table($table)->where('id', '=', $index)->delete();
            if ($delete) {
                return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed ' . $request->method(), $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function import_users(Request $request)
    {
        $table = 'users';
        if (AuthApi::get_auth_api($request)) {
            $file = $request->file('import');
            $namaFile = $file->getClientOriginalName();
            $file->move(public_path('/' . $table . '/'), $namaFile);
            $data = Excel::import(new UsersImport, public_path('/' . $table . '/' . $namaFile));
            return JsonReturn::successReturn("Get data " . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }


    //WOF
    public function create_wof(Request $request)
    {
        $table = "wof";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data['wof_image'] = UploadFile::upload_file($request, $table, 'wof_image', Str::random(40));
            $insert = DB::table($table)->insert($data);
            if ($insert) {
                return JsonReturn::successReturn("Create data " . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed create ' . $table, $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function get_wof(Request $request)
    {
        $table = "wof";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data = DB::table($table)->paginate(25);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function update_wof(Request $request, $index)
    {
        $table = "wof";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $update = DB::table($table)->where('id', '=', $index)->update($data);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function delete_wof(Request $request, $index)
    {
        $table = "wof";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $delete = DB::table($table)->where('id', '=', $index)->delete();
            if ($delete) {
                return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed ' . $request->method(), $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function import_wof(Request $request)
    {
        $table = 'wof';
        if (AuthApi::get_auth_api($request)) {
            $file = $request->file('import');
            $namaFile = $file->getClientOriginalName();
            $file->move(public_path('/' . $table . '/'), $namaFile);
            $data = Excel::import(new WOFImport, public_path('/' . $table . '/' . $namaFile));
            return JsonReturn::successReturn("Get data " . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }


    //video url
    public function create_videourl(Request $request)
    {
        $table = "video_url";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $insert = DB::table($table)->insert($data);
            if ($insert) {
                return JsonReturn::successReturn("Create data " . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed create ' . $table, $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function get_videourl(Request $request)
    {
        $table = "video_url";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data = DB::table($table)->paginate(25);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function update_videourl(Request $request, $index)
    {
        $table = "video_url";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $update = DB::table($table)->where('id', '=', $index)->update($data);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function delete_videourl(Request $request, $index)
    {
        $table = "video_url";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $delete = DB::table($table)->where('id', '=', $index)->delete();
            if ($delete) {
                return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed ' . $request->method(), $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function import_videourl(Request $request)
    {
        $table = 'video_url';
        if (AuthApi::get_auth_api($request)) {
            $file = $request->file('import');
            $namaFile = $file->getClientOriginalName();
            $file->move(public_path('/' . $table . '/'), $namaFile);
            $data = Excel::import(new VideoUrlImport, public_path('/' . $table . '/' . $namaFile));
            return JsonReturn::successReturn("Get data " . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    //Sponsor
    public function create_sponsor(Request $request)
    {
        $table = "sponsor";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data['sponsor_image'] = UploadFile::upload_file($request, $table, 'sponsor_image', Str::random(40));
            $insert = DB::table($table)->insert($data);
            if ($insert) {
                return JsonReturn::successReturn("Create data " . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed create ' . $table, $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function get_sponsor(Request $request)
    {
        $table = "sponsor";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data = DB::table($table)->paginate(25);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function update_sponsor(Request $request, $index)
    {
        $table = "sponsor";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $update = DB::table($table)->where('id', '=', $index)->update($data);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function delete_sponsor(Request $request, $index)
    {
        $table = "sponsor";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $delete = DB::table($table)->where('id', '=', $index)->delete();
            if ($delete) {
                return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed ' . $request->method(), $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function import_sponsor(Request $request)
    {
        $table = 'sponsor';
        if (AuthApi::get_auth_api($request)) {
            $file = $request->file('import');
            $namaFile = $file->getClientOriginalName();
            $file->move(public_path('/' . $table . '/'), $namaFile);
            $data = Excel::import(new SponsorImport, public_path('/' . $table . '/' . $namaFile));
            return JsonReturn::successReturn("Get data " . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    //Bazzar
    public function create_bazzar(Request $request)
    {
        $table = "bazzar";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data['bazzar_image'] = UploadFile::upload_file($request, $table, 'bazzar_image', Str::random(40));
            $insert = DB::table($table)->insert($data);
            if ($insert) {
                return JsonReturn::successReturn("Create data " . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed create ' . $table, $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function get_bazzar(Request $request)
    {
        $table = "bazzar";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $data = DB::table($table)->paginate(25);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function update_bazzar(Request $request, $index)
    {
        $table = "bazzar";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $update = DB::table($table)->where('id', '=', $index)->update($data);
            return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function delete_bazzar(Request $request, $index)
    {
        $table = "bazzar";
        if (AuthAPI::get_auth_api($request)) {
            $data = $request->all();
            $delete = DB::table($table)->where('id', '=', $index)->delete();
            if ($delete) {
                return JsonReturn::successReturn($request->method() . ' ' . $table, $data, $table, $request);
            } else {
                return JsonReturn::failedReturn('Failed ' . $request->method(), $table, $request);
            }
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }

    public function import_bazzar(Request $request)
    {
        $table = 'bazzar';
        if (AuthApi::get_auth_api($request)) {
            $file = $request->file('import');
            $namaFile = $file->getClientOriginalName();
            $file->move(public_path('/' . $table . '/'), $namaFile);
            $data = Excel::import(new BazzarImport, public_path('/' . $table . '/' . $namaFile));
            return JsonReturn::successReturn("Get data " . $table, $data, $table, $request);
        } else {
            return JsonReturn::failedReturn('Unauthorized', $table, $request);
        }
    }
}
