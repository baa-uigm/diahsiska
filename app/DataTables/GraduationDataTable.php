<?php

namespace App\DataTables;

use App\Models\Graduation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GraduationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'graduation.action')
            ->setRowId('id')
            ->editColumn('ipk', function (Graduation $graduate) {
                return number_format($graduate->ipk, 2);
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Graduation $model): QueryBuilder
    {
        $fakultas = $this->request()->get('fakultas');
        $prodi = $this->request()->get('prodi');
        $tahun = $this->request()->get('tahun');
        $query = $model->newQuery()->select('*')->where('lama', '<=', '4')->where('npm', 'NOT LIKE', '%P%')->where('proyeksi_predikat', 'LIKE', '%CUM LAUDE%');

        if (!empty($fakultas)) {
            $query = $query->where('fakultas', $fakultas);
        }

        if (!empty($prodi)) {
            $query = $query->where('prodi', $prodi);
        }

        if (!empty($tahun)) {
            $query = $query->where('tahun', $tahun);
        }
        return $query;
    }
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('graduation-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->parameters([
                'processing' => true,
                'serverSide' => true,
                'lengthMenu' => [10, 20, 30, 50, 100],
                'pagingType' => 'simple_numbers',
                'searchDelay' => 400,
                'responsive' => [
                    'breakpoints' => [
                        ['name' => 'desktop', 'width' => 'Infinity'],
                        ['name' => 'tablet', 'width' => '1024'],
                        ['name' => 'fablet', 'width' => '768'],
                        ['name' => 'phone', 'width' => '480']
                    ]
                ],
                'columnDefs' => [[
                    "targets" => 0,
                    "data" => null,
                    "defaultContent" => "",
                    "render" => "function (data, type, row, meta) {
                        return meta.row + 1;
                    }",
                ]],
                'layout' => [
                    'top2End' => [
                        'buttons' => [
                            ['extend' => 'pdf', 'text' => 'Save as PDF', 'className' => 'me-1 export-button'],
                            ['extend' => 'excel', 'text' => 'Save as Excel', 'className' => 'me-1 export-button'],
                            ['extend' => 'print', 'className' => 'export-button'],
                        ]
                    ]
                ],
                'language' => [
                    'searchPlaceholder' => 'Cari Mahasiswa...',
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('No'),
            Column::make('npm')->title('NPM'),
            Column::make('nama'),
            Column::make('fakultas'),
            Column::make('prodi')->title('Program Studi'),
            Column::make('ipk')->title('IPK'),
            Column::make('tahun'),
            Column::make('proyeksi_predikat'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Graduation_' . date('YmdHis');
    }
}
