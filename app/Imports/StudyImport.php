<?php

namespace App\Imports;

use App\Models\Study;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudyImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $index = 1;

        foreach ($collection as $item) {
            if ($index > 1) {
                $data['npm'] = !empty($item[0]) ? $item[0] : '';
                $data['nama'] = !empty($item[1]) ? $item[1] : '';
                $data['prodi'] = !empty($item[2]) ? $item[2] : '';
                $data['kode_mk'] = !empty($item[3]) ? $item[3] : '';
                $data['nama_mk'] = !empty($item[4]) ? $item[4] : '';
                $data['sks'] = !empty($item[5]) ? $item[5] : '';
                $data['huruf'] = !empty($item[6]) ? $item[6] : '';
                $data['tahun'] = !empty($item[7]) ? $item[7] : '';
                $data['fakultas'] = !empty($item[8]) ? $item[8] : '';

                Study::create($data);
            }
            $index++;
        }
    }
}
