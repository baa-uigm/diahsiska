<?php

namespace App\Http\Controllers;

use App\DataTables\GraduationDataTable;
use App\Models\Graduation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Study;
use Illuminate\Support\Facades\Auth;

class DekanController extends Controller
{
    public function caseFakultas($fakultas, GraduationDataTable $dataTable)
    {
        $listFakultas = [
            'ilkom' => 'ILKOM SAINS',
            'teknik' => 'Teknik',
            'ekonomi' => 'Ekonomi',
            'fipb' => 'FIPB',
            'fkip' => 'FKIP',
        ];

        if (array_key_exists($fakultas, $listFakultas) && Auth::user()->fps == $fakultas) {
            return $this->graduateFakultas($fakultas, $listFakultas[$fakultas], $dataTable);
        } else {
            return view('404');
        }
    }

    protected function graduateFakultas($fakultas, $title, GraduationDataTable $dataTable)
    {
        $listTahun = Graduation::distinct()->pluck('tahun');
        $listProdi = Graduation::where('fakultas', $fakultas)->distinct()->pluck('prodi');

        $dataProdi = Graduation::select('prodi', DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'))
            ->where('lama', '<=', 4)
            ->where('npm', 'NOT LIKE', '%P%')
            ->where('fakultas', $title)
            ->groupBy('prodi')
            ->get();

        $dataTahun = Graduation::select('tahun', DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'))
            ->where('lama', '<=', 4)
            ->where('npm', 'NOT LIKE', '%P%')
            ->where('fakultas', $title)
            ->groupBy('tahun')
            ->get();

        $dataSeluruh = Graduation::select(
            'tahun',
            DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'),
            DB::raw('SUM(CASE WHEN proyeksi_predikat = "Sangat Memuaskan" THEN 1 ELSE 0 END) AS SM'),
            DB::raw('SUM(CASE WHEN proyeksi_predikat = "Memuaskan" THEN 1 ELSE 0 END) AS M')
        )
            ->where('fakultas', $title)
            ->groupBy('tahun')
            ->get();

        $dataFourYears = Graduation::select(
            'tahun',
            DB::raw('SUM(CASE WHEN lama < 4 THEN 1 ELSE 0 END) AS lessFourYears'),
            DB::raw('SUM(CASE WHEN lama > 4 THEN 1 ELSE 0 END) AS moreFourYears'),
        )
            ->where('fakultas', $title)
            ->where(DB::raw('SUBSTRING(npm, 5, 2)'), '!=', '50')
            ->groupBy('tahun')
            ->get();

        return $dataTable->render('dekanGraduate', compact('title', 'listProdi', 'listTahun', 'dataProdi', 'dataFourYears', 'dataTahun', 'dataSeluruh'));
    }

    public function nilaiDekan($fakultas)
    {
        $data = $this->getDataByFakultas($fakultas);
        if (!$data) {
            return redirect('404');
        }
        return $data;
    }

    protected function getDataByFakultas($fakultas)
    {
        $prodiDataGraph = [];
        $localStorageKeyNilai = "fakultas{$fakultas}DataNilai";

        switch ($fakultas) {
            case 'ilkom':
                $title = 'ILKOM SAINS';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'ekonomi':
                $title = 'Ekonomi';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'fipb':
                $title = 'FIPB';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'fkip':
                $title = 'FKIP';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'teknik':
                $title = 'Teknik';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            default:
                return false;
        }

        foreach ($listProdi as $prodi) {
            $data = Study::select(
                'Tahun',
                DB::raw('SUM(CASE WHEN Huruf = "A" THEN 1 ELSE 0 END) AS A_count'),
                DB::raw('SUM(CASE WHEN Huruf = "B" THEN 1 ELSE 0 END) AS B_count'),
                DB::raw('SUM(CASE WHEN Huruf = "C" THEN 1 ELSE 0 END) AS C_count'),
                DB::raw('SUM(CASE WHEN Huruf = "D" THEN 1 ELSE 0 END) AS D_count'),
                DB::raw('SUM(CASE WHEN Huruf = "E" THEN 1 ELSE 0 END) AS E_count')
            )
                ->where('prodi', $prodi)
                ->groupBy('Tahun')
                ->get();

            $prodiDataGraph[$prodi] = $data;
        }

        $localStorageData = json_encode($prodiDataGraph);
        echo "<script>window.localStorage.setItem('$localStorageKeyNilai', '$localStorageData');</script>";
        return view('nilaidekan', compact('title', 'listProdi', 'localStorageKeyNilai'));
    }

    public function KRSDekan($fakultas)
    {
        $data = $this->getKRSData($fakultas);
        if (!$data) {
            return redirect('404');
        }
        return $data;
    }

    protected function getKRSData($fakultas)
    {
        $title = '';
        $listProdi = [];
        $localStorageKeyKRS = '';
        $localStorageKeyMB = '';
        $dataKRS = [];
        $dataMBProdi = [];
        $listTahun = Study::distinct()->pluck('Tahun');
        $newListTahun = Student::distinct()->pluck('tahun_masuk');

        switch ($fakultas) {
            case 'ilkom':
                $title = 'ILKOM SAINS';
                $localStorageKeyKRS = 'fakultasIlkomDataKRSIlkom';
                $localStorageKeyMB = 'fakultasIlkomDataMBIlkom';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'ekonomi':
                $title = 'Ekonomi';
                $localStorageKeyKRS = 'fakultasEkonomiDataKRSEkonomi';
                $localStorageKeyMB = 'fakultasEkonomiDataMBEkonomi';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'fipb':
                $title = 'FIPB';
                $localStorageKeyKRS = 'fakultasFIPBDataKRSFIPB';
                $localStorageKeyMB = 'fakultasFIPBDataMBFIPB';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'fkip':
                $title = 'FKIP';
                $localStorageKeyKRS = 'fakultasFKIPDataKRSFKIP';
                $localStorageKeyMB = 'fakultasFKIPDataMBFKIP';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            case 'teknik':
                $title = 'Teknik';
                $localStorageKeyKRS = 'fakultasTeknikDataKRSTeknik';
                $localStorageKeyMB = 'fakultasTeknikDataMBTeknik';
                $listProdi = Study::where('fakultas', $title)->distinct()->pluck('prodi');
                break;
            default:
                return false;
        }

        foreach ($listTahun as $tahun) {
            $data = Study::select('Tahun');
            foreach ($listProdi as $prodi) {
                $data->addSelect(DB::raw("COUNT(DISTINCT CASE WHEN Fakultas='$title' AND prodi='$prodi' THEN NPM END) AS `$prodi`"));
            }
            $data->addSelect(DB::raw("COUNT(DISTINCT CASE WHEN Fakultas='$title' THEN NPM END) AS JmlAll"))
                ->where('Tahun', $tahun)
                ->groupBy('Tahun');

            $dataKRS[$tahun] = $data->get();
        }

        foreach ($newListTahun as $tahun) {
            $data = Student::select('tahun_masuk');
            foreach ($listProdi as $prodi) {
                $data->addSelect(DB::raw("COUNT(DISTINCT CASE WHEN prodi='$prodi' THEN NPM END) AS `$prodi`"));
            }
            $data->where('tahun_masuk', $tahun)
                ->groupBy('tahun_masuk');

            $dataMBProdi[$tahun] = $data->first();
        }

        $localStorageDataKRS = json_encode($dataKRS);
        echo "<script>window.localStorage.setItem('$localStorageKeyKRS', '$localStorageDataKRS');</script>";

        return view('krsdekan', compact('title', 'newListTahun', 'listTahun', 'listProdi', 'localStorageKeyKRS', 'localStorageKeyMB', 'dataMBProdi'));
    }

    public function getProdiTable($fakultas, $prodi)
    {
        $prodiDataTable = [];
        $data = Study::select('Tahun', DB::raw('SUM(CASE WHEN Huruf = "A" THEN 1 ELSE 0 END) AS A_count'), DB::raw('SUM(CASE WHEN Huruf = "B" THEN 1 ELSE 0 END) AS B_count'), DB::raw('SUM(CASE WHEN Huruf = "C" THEN 1 ELSE 0 END) AS C_count'), DB::raw('SUM(CASE WHEN Huruf = "D" THEN 1 ELSE 0 END) AS D_count'), DB::raw('SUM(CASE WHEN Huruf = "E" THEN 1 ELSE 0 END) AS E_count'))->where('prodi', $prodi)->groupBy('Tahun')->get();

        foreach ($data as $item) {
            $total = $item->A_count + $item->B_count + $item->C_count + $item->D_count + $item->E_count;
            $item->A_percentage = $total != 0 ? ($item->A_count / $total) * 100 : 0;
            $item->B_percentage = $total != 0 ? ($item->B_count / $total) * 100 : 0;
            $item->C_percentage = $total != 0 ? ($item->C_count / $total) * 100 : 0;
            $item->D_percentage = $total != 0 ? ($item->D_count / $total) * 100 : 0;
            $item->E_percentage = $total != 0 ? ($item->E_count / $total) * 100 : 0;
        }
        $prodiDataTable[$prodi] = $data;

        return view('partials.table_nilai', compact('data'));
    }
}
