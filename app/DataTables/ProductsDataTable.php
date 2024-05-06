<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Session;

class ProductsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if(request()->length != session('products-table-length')){
            Session::put('products-table-length', request()->length);
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
    public function query(Product $model): QueryBuilder
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
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0,'asc')
            ->selectStyleMulti()
            ->parameters([
                'pagingType' => 'full',
            ])
            ->pageLength(session('products-table-length',50));
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            'product' => [
                'name' => 'product',
                'title' => 'Product',
                'data' => 'product',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'product',
                ],
            ],
            'category' => [
                'name' => 'category',
                'title' => 'Category',
                'data' => 'category',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'category',
                ],
            ],
            'price' => [
                'name' => 'price',
                'title' => 'Price',
                'data' => 'price',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'price',
                ],
            ],
            'SKU' => [
                'name' => 'SKU',
                'title' => 'SKU',
                'data' => 'SKU',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'SKU',
                ],
            ],
            'quantity' => [
                'name' => 'quantity',
                'title' => 'Quantity',
                'data' => 'quantity',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'quantity',
                ],
            ],
            'status' => [
                'name' => 'status',
                'title' => 'Status',
                'data' => 'status',
                'searchable' => true,
                'orderable' => true,
                'visible' => true,
                'attributes' => [
                    'data-sort' => 'status',
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
        return 'Products_' . date('YmdHis');
    }

    protected function getActionColumn($data): string
    {
        return "<i class='fas fa-eye'></i> <i class='fas fa-edit'></i> <i class='fas fa-trash'></i>";
    }
}
