<?php

namespace App\DataTables;

use App\Models\Rider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RiderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'rider.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Rider $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Rider $model)
    {
        return $model->newQuery()->select('id','name','phone', 'email', 'state');
    }

    
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('rider-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(0,'asc')
                    ->buttons(
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('print')
                    )
                    ->parameters([
                        'dom' => 'Blfrtip',
                        'lengthMenu' => [[10,25,50,100, -1],[10,25,50,100, 'All Rider']],
                        'buttons' => [
                            [ 'extend' => 'csv'  , 'className' => 'btn btn-success text-light' , 'text' => 'CSV' ],
                            [ 'extend' => 'excel', 'className' => 'btn btn-success text-light' , 'text' => 'Excel' ],
                            // [ 'extend' => 'pdf'  , 'className' => 'btn btn-success text-light' , 'text' => 'PDF' ],
                            [ 'extend' => 'print', 'className' => 'btn btn-success text-light' , 'text' => 'Print' ],
                        ],
                        'language' => [
                            'url' => url('json/rider.json')
                        ],
                       
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'name'=>'id',
                'data'=>'id',
                'title'=>'م',
            ],
            [
                'name'=>'name',
                'data'=>'name',
                'title'=>'الاســـــم',
            ],
            [
                'name'=>'phone',
                'data'=>'phone',
                'title'=>'رقـم الهاتـف',
            ],
            [
                'name'=>'email',
                'data'=>'email',
                'title'=>'الإيميـل',
            ],
            [
                'name'=>'state',
                'data'=>'state',
                'title'=>'الحالــة',
            ],
            [
                'name'=>'action',
                'data'=>'action',
                'title'=>'تحديث',
                'exportable'=> false,
                'printable'=> false,
                'orderable'=> false,
                'searchable'=> false,
            ]
            // [
            //     'name' => 'riderTrips.id',
            //     'data' => 'riderTrips.id',
            //     'title' => 'Trips ',
            //     'defaultContent' => '',
            // ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Rider_' . date('YmdHis');
    }
}
