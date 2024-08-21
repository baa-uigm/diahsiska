<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (User $user) {
                return view('partials.buttonsUser', [
                    'user' => $user,
                ]);
            })
            ->rawColumns(['action'])
            ->editColumn('updated_at', function (User $user) {
                return $user->updated_at->locale('in_ID')->diffForHumans();
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->select('nidn', 'name', 'username', 'email', 'fps as role', 'updated_at')->where('role', '!=', 'admin');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->parameters([
                'processing' => true,
                'serverSide' => true,
                'lengthMenu' => [5, 10, 15, 20, 50, 100],
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
                            ['extend' => 'print', 'className' => 'export-button']
                        ]
                    ]
                ],
                'colReorder' => true,
                'language' => [
                    'searchPlaceholder' => 'Cari apa?',
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('nidn')->addClass('align-middle')->title('NIDN')->responsivePriority(1),
            Column::make('name')->addClass('align-middle')->responsivePriority(1),
            Column::make('username')->addClass('align-middle')->responsivePriority(2),
            Column::make('email')->addClass('align-middle')->responsivePriority(3),
            Column::make('role')->addClass('align-middle')->responsivePriority(2),
            Column::computed('updated_at')->width(100)->addClass('align-middle')->title('Update')->responsivePriority(2),
            Column::computed('action')->addClass('align-middle')->responsivePriority(1),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
