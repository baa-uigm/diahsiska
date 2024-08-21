<?php

namespace App\DataTables;

use App\Models\Study;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StudyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query));
    }

    /**
     * Get the query source of dataTable.
     */

    public function query(Study $model): QueryBuilder
    {
        $prodi = $this->request()->get('prodi');
        $tahun = $this->request()->get('tahun');

        $query = $model->newQuery()->select('nama_mk', DB::raw('SUM(CASE WHEN huruf = "A" THEN 1 ELSE 0 END) AS A_count'), DB::raw('SUM(CASE WHEN huruf = "B" THEN 1 ELSE 0 END) AS B_count'), DB::raw('SUM(CASE WHEN huruf = "C" THEN 1 ELSE 0 END) AS C_count'), DB::raw('SUM(CASE WHEN huruf = "D" THEN 1 ELSE 0 END) AS D_count'), DB::raw('SUM(CASE WHEN huruf = "E" THEN 1 ELSE 0 END) AS E_count'))->groupBy('nama_mk');

        $queryKRS = $model->newQuery()->select('npm', 'nama', DB::raw('SUM(sks) AS total_sks'), 'tahun')->groupBy('npm', 'nama', 'tahun')->orderBy('tahun');

        if (!empty($prodi)) {
            $query = $query->where('prodi', $prodi);
        }
        if (!empty($tahun)) {
            $query = $query->where('tahun', $tahun);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('study-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->parameters([
                'processing' => true,
                'serverSide' => true,
                'lengthMenu' => [10, 20, 30, 50, 100],
                'pagingType' => 'simple_numbers',
                'searchDelay' => 400,
                'columnDefs' => [[
                    "targets" => 0,
                    "data" => null,
                    "defaultContent" => "",
                    "render" => "function (data, type, row, meta) {
                        return meta.row + 1;
                    }",
                ]],
                'responsive' => [
                    'breakpoints' => [
                        ['name' => 'desktop', 'width' => 'Infinity'],
                        ['name' => 'tablet', 'width' => '1024'],
                        ['name' => 'fablet', 'width' => '768'],
                        ['name' => 'phone', 'width' => '480']
                    ]
                ],
                'layout' => [
                    'top2End' => [
                        'buttons' => [
                            ['extend' => 'pdf', 'text' => 'Save as PDF', 'className' => 'me-1 export-button'],
                            ['extend' => 'excel', 'text' => 'Save as Excel', 'className' => 'me-1 export-button'],
                            ['extend' => 'print', 'className' => 'export-button'],
                        ]
                    ]
                ],
                'colReorder' => true,
                'language' => [
                    'searchPlaceholder' => 'Cari Mata Kuliah...',
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('nama_mk')->title('No'),
            Column::make('nama_mk')->title('Mata Kuliah'),
            Column::make('A_count')->title('A')->searchable(false)->addClass('text-center'),
            Column::make('B_count')->title('B')->searchable(false)->addClass('text-center'),
            Column::make('C_count')->title('C')->searchable(false)->addClass('text-center'),
            Column::make('D_count')->title('D')->searchable(false)->addClass('text-center'),
            Column::make('E_count')->title('E')->searchable(false)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Study_' . date('YmdHis');
    }
}
