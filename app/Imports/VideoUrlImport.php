<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class VideoUrlImport implements ToCollection
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
            $data['video_name'] = $row[0];
            $data['video_url'] = $row[1];
            $check = DB::table('video_url')->where('video_name', '=', $data['sponsor_name'])->get();
            if ($check->count() == 0) {
                $insert = DB::table('video_url')->insert($data);
                array_push($result, $data);
            } else {
                array_push($result['exist'], $data);
            }
        }
        return $result;
    }
}
