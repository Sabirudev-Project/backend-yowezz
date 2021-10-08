<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
        $result = [];
        $result['exist'] = [];
        foreach ($collection as $row) {
            $data['email'] = $row[0];
            $data['password'] = $row[1];
            $check = DB::table('users')->where('email', '=', $data['email'])->get();
            if ($check->count() == 0) {
                $insert = DB::table('users')->insert($data);
                array_push($result, $data);
            } else {
                array_push($result['exist'], $data);
            }
        }
        return $result;
    }
}
