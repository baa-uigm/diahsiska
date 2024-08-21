<?php

namespace App\DataTables;

use App\Models\Study;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\Services\DataTable;

class AdminStudy extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Study $study) {
                return view('partials.buttonsStudy', [
                    'study' => $study,
                ]);
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */

    public function query(Study $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
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
            Column::make('id')->title('No')->addClass('text-center'),
            Column::make('npm')->title('NPM'),
            Column::make('nama'),
            Column::make('nama_mk')->title('Mata Kuliah'),
            Column::make('huruf'),
            Column::make('tahun'),
            Column::computed('action')->addClass('align-middle')->responsivePriority(1),
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
