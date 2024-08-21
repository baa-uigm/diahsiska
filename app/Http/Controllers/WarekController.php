<?php

namespace App\Http\Controllers;

use App\DataTables\GraduationDataTable;
use App\Models\Graduation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Study;

class WarekController extends Controller
{
    public function nilai($warek)
    {
        $listWarek = ['warek1', 'warek2', 'warek3'];
        $title = 'NILAI';
        $listTahun = Study::distinct()->pluck('Tahun');
        $listFakultas = Study::distinct()->pluck('Fakultas');

        $localStorageKeyNilai = 'fakultasNilai';
        $fakultasDataGraph = [];

        echo "<script> if (!window.localStorage.getItem('$localStorageKeyNilai')) {";
        foreach ($listFakultas as $fakultas) {
            $dataFakultas = Study::select('Tahun', DB::raw('SUM(CASE WHEN Huruf = "A" THEN 1 ELSE 0 END) AS A_count'), DB::raw('SUM(CASE WHEN Huruf = "B" THEN 1 ELSE 0 END) AS B_count'), DB::raw('SUM(CASE WHEN Huruf = "C" THEN 1 ELSE 0 END) AS C_count'), DB::raw('SUM(CASE WHEN Huruf = "D" THEN 1 ELSE 0 END) AS D_count'), DB::raw('SUM(CASE WHEN Huruf = "E" THEN 1 ELSE 0 END) AS E_count'))->where('Fakultas', $fakultas)->groupBy('Tahun')->get();

            $fakultasDataGraph[$fakultas] = $dataFakultas;
        }

        $localStorageData = json_encode($fakultasDataGraph);
        echo "window.localStorage.setItem('$localStorageKeyNilai', '$localStorageData');}</script>";

        if (in_array($warek, $listWarek)) {
            return view('nilaiwarek', compact('title', 'listFakultas', 'localStorageKeyNilai', 'localStorageData'));
        } else {
            return view('404');
        }
    }

    public function krs($warek)
    {
        $listWarek = ['warek1', 'warek2', 'warek3'];
        $title = 'KRS';
        $listTahun = Study::distinct()->pluck('Tahun');
        $listFakultas = Study::distinct()->pluck('Fakultas');
        $dataFakultasKRS = [];
        $dataMBFakultas = [];
        $localStorageKeyKRS = 'fakultasKRS';
        $localStorageKeyMB = 'fakultasMB';

        echo "<script> if (!window.localStorage.getItem('$localStorageKeyKRS')) {";
        foreach ($listTahun as $tahun) {
            $dataKRS = Study::select('Tahun', DB::raw('COUNT(DISTINCT NPM) AS JmlAll'), DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="Ekonomi" THEN NPM END) AS Ekonomi'), DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="FKIP" THEN NPM END) AS FKIP'), DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="FIPB" THEN NPM END) AS FIPB'), DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="Teknik" THEN NPM END) AS Teknik'), DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="ILKOM SAINS" THEN NPM END) AS ILKOM_SAINS'))->where('Tahun', $tahun)->groupBy('Tahun')->get();

            $dataFakultasKRS[$tahun] = $dataKRS;
        }
        $localStorageDataKRS = json_encode($dataFakultasKRS);
        echo "window.localStorage.setItem('$localStorageKeyKRS', '$localStorageDataKRS');}</script>";

        echo "<script> if (!window.localStorage.getItem('$localStorageKeyMB')) {";
        foreach ($listFakultas as $fakultas) {
            $queryFakultas = Study::select('Fakultas', DB::raw('COUNT(DISTINCT CASE WHEN LEFT(NPM,4)="2019" AND Tahun="20191" THEN NPM END) AS Data2019'), DB::raw('COUNT(DISTINCT CASE WHEN LEFT(NPM,4)="2020" AND Tahun="20201" THEN NPM END) AS Data2020'), DB::raw('COUNT(DISTINCT CASE WHEN LEFT(NPM,4)="2021" AND Tahun="20211" THEN NPM END) AS Data2021'), DB::raw('COUNT(DISTINCT CASE WHEN LEFT(NPM,4)="2022" AND Tahun="20221" THEN NPM END) AS Data2022'), DB::raw('COUNT(DISTINCT CASE WHEN LEFT(NPM,4)="2023" AND Tahun="20231" THEN NPM END) AS Data2023'))->where('Fakultas', $fakultas)->groupBy('Fakultas')->get();

            $dataFakultasMB[$fakultas] = $queryFakultas;
        }
        $localStorageDataMB = json_encode($dataFakultasMB);
        echo "window.localStorage.setItem('$localStorageKeyMB', '$localStorageDataMB');}</script>";

        if (in_array($warek, $listWarek)) {
            return view('krswarek', compact('title', 'listTahun', 'listFakultas', 'localStorageKeyKRS', 'localStorageKeyMB'));
        } else {
            return view('404');
        }
    }

    public function ipk()
    {
        $listProdi = Study::distinct()->pluck('prodi');
        $listStatusMahasiswa = ['Aktif', 'Non-Aktif'];

        // Ambil data tanpa filter
        $dataStatus = $this->getDataByProdi();

        $dataProdi = [];

        foreach ($listProdi as $prodi) {
            $query = DB::table('tbl_master_mhs')->select(DB::raw('COUNT(*) AS Jumlah'))->where('Tahun_Masuk', '<', 2023)->where('Tahun_Masuk', '=', 2021)->where('Program_Studi', $prodi)->where('IPK', '<=', 2)->whereIn('Status_Mahasiswa', $listStatusMahasiswa)->groupBy('Program_Studi');

            $data = $query->first();
            $dataProdi[$prodi] = $data ? $data->Jumlah : 0;
        }

        return view('ipk', compact('dataStatus', 'listProdi', 'listStatusMahasiswa', 'dataProdi'));
    }

    public function filterIpk(Request $request)
    {
        $selectedProdi = $request->input('prodi');

        // Jika prodi tidak dipilih, kembalikan semua data tanpa filter
        if ($selectedProdi === '') {
            $dataStatus = $this->getDataByProdi();
        } else {
            // Jika ada filter, ambil data sesuai dengan prodi yang dipilih
            $dataStatus = $this->getDataByProdi($selectedProdi);
        }

        return view('partials.ipk_table', compact('dataStatus'))->render();
    }

    private function getDataByProdi($prodi = null)
    {
        $listStatusMahasiswa = ['Aktif', 'Non-Aktif'];
        $dataStatus = [];

        foreach ($listStatusMahasiswa as $statusMahasiswa) {
            $query = DB::table('tbl_master_mhs')->where('Tahun_Masuk', '<', 2023)->where('Tahun_Masuk', '=', 2021)->where('Status_Mahasiswa', $statusMahasiswa)->where('IPK', '<=', 2);

            if ($prodi) {
                $query->where('Program_Studi', $prodi);
            }

            $dataStatus[$statusMahasiswa] = $query->orderBy('PA')->get();
        }

        return $dataStatus;
    }

    public function getFakultasTable($fakultas)
    {
        $fakultasDataTable = [];
        $data = Study::select('Tahun', DB::raw('SUM(CASE WHEN Huruf = "A" THEN 1 ELSE 0 END) AS A_count'), DB::raw('SUM(CASE WHEN Huruf = "B" THEN 1 ELSE 0 END) AS B_count'), DB::raw('SUM(CASE WHEN Huruf = "C" THEN 1 ELSE 0 END) AS C_count'), DB::raw('SUM(CASE WHEN Huruf = "D" THEN 1 ELSE 0 END) AS D_count'), DB::raw('SUM(CASE WHEN Huruf = "E" THEN 1 ELSE 0 END) AS E_count'), DB::raw('COUNT(*) AS total_count'))->where('Fakultas', $fakultas)->groupBy('Tahun')->get();

        foreach ($data as $item) {
            $total = $item->A_count + $item->B_count + $item->C_count + $item->D_count + $item->E_count;
            $item->A_percentage = $total != 0 ? ($item->A_count / $total) * 100 : 0;
            $item->B_percentage = $total != 0 ? ($item->B_count / $total) * 100 : 0;
            $item->C_percentage = $total != 0 ? ($item->C_count / $total) * 100 : 0;
            $item->D_percentage = $total != 0 ? ($item->D_count / $total) * 100 : 0;
            $item->E_percentage = $total != 0 ? ($item->E_count / $total) * 100 : 0;
        }
        $fakultasDataTable[$fakultas] = $data;

        return view('partials.table_nilai', compact('data'));
    }

    public function caseGraduate($userFPS, GraduationDataTable $dataTable)
    {
        $listWarek = ['warek1', 'warek2', 'warek3'];

        if (in_array($userFPS, $listWarek)) {
            return $this->graduate($dataTable);
        } else {
            return view('404');
        }
    }

    public function graduate(GraduationDataTable $dataTable)
    {
        $listTahun = Graduation::distinct()->pluck('tahun');
        $listFakultas = Graduation::distinct()->pluck('fakultas');
        $title = 'GRADUATE';

        $dataFakultas = Graduation::select('fakultas', DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'))->where('lama', '<=', 4)->where('npm', 'NOT LIKE', '%P%')->groupBy('fakultas')->get();

        $dataTahun = Graduation::select('tahun', DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'))->where('lama', '<=', 4)->where('npm', 'NOT LIKE', '%P%')->groupBy('tahun')->get();

        $dataSeluruh = Graduation::select('tahun', DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'), DB::raw('SUM(CASE WHEN proyeksi_predikat = "Sangat Memuaskan" THEN 1 ELSE 0 END) AS SM'), DB::raw('SUM(CASE WHEN proyeksi_predikat = "Memuaskan" THEN 1 ELSE 0 END) AS M'))->groupBy('tahun')->get();

        $dataFourYears = Graduation::select('tahun', DB::raw('SUM(CASE WHEN lama < 4 THEN 1 ELSE 0 END) AS lessFourYears'), DB::raw('SUM(CASE WHEN lama > 4 THEN 1 ELSE 0 END) AS moreFourYears'))->where(DB::raw('SUBSTRING(npm, 5, 2)'), '!=', '50')->groupBy('tahun')->get();

        return $dataTable->render('graduate', compact('listFakultas', 'listTahun', 'title', 'dataTahun', 'dataFakultas', 'dataFourYears', 'dataSeluruh'));
    }
}
