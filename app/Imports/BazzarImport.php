<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class BazzarImport implements ToCollection
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
            $data['bazzar_name'] = $row[0];
            $data['bazzar_image'] = $row[1];
            $data['bazzar_url'] = $row[2];
            $check = DB::table('bazzar')->where('sponsor_name', '=', $data['sponsor_name'])->get();
            if ($check->count() == 0) {
                $insert = DB::table('bazzar')->insert($data);
                array_push($result, $data);
            } else {
                array_push($result['exist'], $data);
            }
        }
        return $result;
    }
}
