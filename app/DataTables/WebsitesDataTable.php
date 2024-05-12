<?php

namespace App\DataTables;

use App\Models\Website;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Session;

class WebsitesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if(request()->length != session('websites-table-length')){
            Session::put('websites-table-length', request()->length);
        }

        return (new EloquentDataTable($query))
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->editColumn('last_update',function ($data){
                return 0;
            })
            ->editColumn('feeds_imported',function ($data){
                return 0;
            })
            ->editColumn('no_of_products',function ($data){
                return 0;
            })
            ->setRowId('id')->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Website $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableHeadClass('thead-light')
            ->setTableId('websites-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0,'asc')
            ->selectStyleMulti()
            ->parameters([
                'pagingType' => 'full',
            ])
            ->pageLength(session('websites-table-length',50));
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'title' => 'Name',
                'data' => 'name',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'name',
                ],
            ],
            'feeds_imported' => [
                'name' => 'feeds_imported',
                'title' => 'Feeds Imported',
                'data' => 'feeds_imported',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'feeds_imported',
                ],
            ],
            'no_of_products' => [
                'name' => 'no_of_products',
                'title' => 'No of Products',
                'data' => 'no_of_products',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'no_of_products',
                ],
            ],
            'last_update' => [
                'name' => 'last_update',
                'title' => 'Last Update',
                'data' => 'last_update',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'last_update',
                ],
            ],
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Websites_' . date('YmdHis');
    }

    protected function getActionColumn($data): string
    {
        return "<i class='fas fa-eye'></i> <i class='fas fa-edit'></i> <i class='fas fa-trash'></i>";
    }
}
