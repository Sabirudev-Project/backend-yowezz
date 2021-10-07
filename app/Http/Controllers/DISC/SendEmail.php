<?php

namespace App\Http\Controllers\DISC;

use App\Http\Controllers\Controller;
use App\Mail\OtpEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DISC\Generateid;
use App\Mail\ForgotPassword;
use App\Mail\PasswordEmail;
use App\Mail\SendPrize;
use App\Mail\SendPrizeGojek;
use App\Mail\VerifikasiEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SendEmail extends Controller
{
    //
    public static function send_prize($users)
    {
        Mail::to($users['email'])->send(new SendPrize($users));
        return true;
    }

    public static function send_prize_gojek($users)
    {
        Mail::to($users['email'])->send(new SendPrizeGojek($users));
        return true;
    }



    // public static function send_verifikasi($users)
    // {
    //     Mail::to($users['email'])->send(new VerifikasiEmail($users));
    //     return true;
    // }

    public static function send_otp($users)
    {
        $table = 'users_otp';
        $dataInsert['id'] = Generateid::generate($table);
        $dataInsert['otp'] = mt_rand(100000, 999999);
        $dataInsert['user_id'] = $users->id;
        $dateNow = date("Y-m-d H:i:s");
        $dataInsert['valid_until'] = date("Y-m-d H:i:s", strtotime("$dateNow +30 minutes"));
        $insert = DB::table($table)->insert($dataInsert);
        $data['otp'] = $dataInsert['otp'];
        $data['email'] = $users->email;
        $data['nama'] = $users->name;
        if ($insert) {
            // Mail::to($data['email'])->send(new OtpEmail($data));
            return true;
        } else {
            return false;
        }
    }
    public static function forgot_password($users)
    {
        $table = 'users_forget_password';
        $insertData['id'] = Generateid::generate($table);
        $insertData['user_id'] = $users->id;
        $dateNow = date("Y-m-d H:i:s");
        $insertData['valid_until'] = date("Y-m-d H:i:s", strtotime("$dateNow +1 days"));
        $insertData['token'] = Str::random(60);
        $insert = DB::table($table)->insert($insertData);
        $data['id'] = $users->id;
        $data['email'] = $users->email;
        $data['nama'] = $users->name;
        $data['token'] = $insertData['token'];
        if ($insert) {
            // Mail::to($data['email'])->send(new ForgotPassword($data));
            return $insertData;
        } else {
            return false;
        }
    }
}
