<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if(request()->length != session('users-table-length')){
            Session::put('users-table-length', request()->length);
        }

        return (new EloquentDataTable($query))
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->setRowId('id')->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
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
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0,'asc')
            ->selectStyleMulti()
            ->parameters([
                'pagingType' => 'full',
            ])
            ->pageLength(session('users-table-length',50));
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
            'first_name' => [
                'name' => 'first_name',
                'title' => 'First Name',
                'data' => 'first_name',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'first_name',
                ],
            ],
            'last_name' => [
                'name' => 'last_name',
                'title' => 'Last Name',
                'data' => 'last_name',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'last_name',
                ],
            ],
            'email' => [
                'name' => 'email',
                'title' => 'Email',
                'data' => 'email',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'email',
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
        return 'Users_' . date('YmdHis');
    }

    protected function getActionColumn($data): string
    {
        $editUrl = route('users.show', $data->id);
        $impersonateRoute = route('users.impersonate', $data->id);
        return "<a class='waves-effect btn btn-warning btn-sm' title='Impersonate user' href='$impersonateRoute'><i class='fas fa-eye'></i></a><a class='waves-effect btn btn-primary btn-sm' href='$editUrl'><i class='fas fa-edit'></i> Edit</a> <button type='button' onclick='deleteUser(".$data->id.")' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</button>";
    }
}
