<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class WOFImport implements ToCollection
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
            $data['wof_name'] = $row[0];
            $data['wof_description'] = $row[1];
            $data['wof_image'] = $row[2];
            $check = DB::table('wof')->where('wof_name', '=', $data['sponsor_name'])->get();
            if ($check->count() == 0) {
                $insert = DB::table('wof')->insert($data);
                array_push($result, $data);
            } else {
                array_push($result['exist'], $data);
            }
        }
        return $result;
    }
}
