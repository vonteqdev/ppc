<?php

namespace App\DataTables;

use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PermissionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if(request()->length != session('permissions-table-length')){
            Session::put('permissions-table-length', request()->length);
        }

        return (new EloquentDataTable($query))
            ->addColumn('action', 'permissions.action');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Permission $model): QueryBuilder
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
                    ->setTableId('permissions-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2)
                    ->selectStyleMulti()
                    ->parameters([
                        'pagingType' => 'full',
                    ])
                    ->pageLength(session('permissions-table-length',50))
                    ->language([
                        'searchPlaceholder' => 'Search permission',
                        'search' => '',
                        'lengthMenu' => '<span title="length">_MENU_</span>',
                        'paginate' => [
                            'first' => '<span id="noOfResults"></span>',
                            'last' => '',
                            'previous' => '<span style="color:#1565C0"><i title="previous" class="fas fa-angle-left" style="margin-right: 5px"></i> Prev</span>',
                            'next' => '<span style="color:#1565C0">Next <i title="next" class="fas fa-angle-right" style="margin-left: 5px;"></i></span>',
                        ],
                        'processing' => '<span class="data-table-spinner-position"><i class="fas fa-spinner fa-spin data-table-spinner"></i><span>',
                    ])
            ;
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
            'group' => [
                'name' => 'group',
                'title' => 'Group',
                'data' => 'group',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'group',
                ],
            ],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Permissions_' . date('YmdHis');
    }
}
