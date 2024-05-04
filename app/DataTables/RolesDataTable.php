<?php

namespace App\DataTables;

use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RolesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if(request()->length != session('roles-table-length')){
            Session::put('roles-table-length', request()->length);
        }

        return (new EloquentDataTable($query))
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->addColumn('users_count',function ($data){
                return $data->users_count;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery()->withCount('users');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableHeadClass('thead-light')
            ->setTableId('roles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0,'asc')
            ->selectStyleMulti()
            ->parameters([
                'pagingType' => 'full',
            ])
            ->pageLength(session('roles-table-length',50))
            ->language([
                'searchPlaceholder' => 'Search role',
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
            'id' => [
                'name' => 'id',
                'title' => 'ID',
                'data' => 'id',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'id',
                ],
            ],
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
            'users_count' => [
                'name' => 'users_count',
                'title' => 'Users',
                'data' => 'users_count',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'users_count',
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
        return 'Roles_' . date('YmdHis');
    }

    protected function getActionColumn($data): string
    {
        $editUrl = route('roles.show', $data->id);
       return "<a class='waves-effect btn btn-primary btn-sm' href='$editUrl'><i class='fas fa-edit'></i> Edit</a><button type='button' onclick='deleteRole(".$data->id.")' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</button>";
    }
}
