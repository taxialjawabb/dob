
@extends('index')
@section('title','العهد')
@section('content')
<h4 class=" mt-3 pt-3 p-3 text-danger">يجب تسليم هذه العهد ومراجعة العهد المستلمه قبل الاستبعاد

@if(count($stored) === 0)
<a href="{{ url('user/block/confirm/'.$user->id) }}" class="btn btn-danger rounded-0 m-0" >تأكيد الاستبعاد</a>
@endif
</h4>
@if(count($stored)> 0)
<div class="panel panel-default mt-3 pt-3 p-3 border border-dark">
    <h5>عهد بحوزة المستخدم: {{ $user->name }}</h5>
    <div class="table-responsive">
        <table class="table " id="covenant">
            <thead>
                <tr>
                    <th>اسم العهدة </th>
                    <th>عدد العهد</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stored as $store)
                <tr>
                    <td>{{ $store->covenant_name }}</td>
                    <td>{{ $store->numbers }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if( count($covenants) > 0)
    
                <div class="panel panel-default mt-4 p-3 border border-dark">
                    <h5>عهد مسلمة من قبل المستخدم: {{ $user->name }}</h5>
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم </th>
                                    <th>رقم التسلسلى </th>
                                    <th>حالة العهدة</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>السائق المستلم</th>
                                    <th>هاتف السائق</th>
                                    <th>تاريخ التسلم</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($covenants as $covenant)
                                <tr>
                                    <td>{{ $covenant->id }}</td>
                                    <td>{{ $covenant->serial_number }}</td>
                                    <td>
                                    @switch($covenant->state)
                                        @case('active')
                                            مستلمة
                                            @break
                                        @case('waiting')
                                            المخزن  
                                            @break
                                        @case('broken')
                                            معطلة
                                            @break
                                        @default
                                            غير مستلمة
                                    @endswitch
                                    </td>
                                    <td>{{ $covenant->add_date}}</td>
                                    <td>{{ $covenant->driver_name }}</td>
                                    <td>{{ $covenant->phone }}</td>
                                    <td>{{ $covenant->delivery_date }}</td>
                                    <td>
                                        <a href="{{ url('covenant/show/note/'.$covenant->id) }}"
                                        class="btn btn-primary">الملاحظات</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

@endsection

@section('scripts')
<script>
        $(document).ready( function () {
            $('#datatable, #covenant').DataTable({
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ العهد",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض العهد من _START_ إلى _END_ من إجمالي _TOTAL_ من عهده",
                    "sInfoEmpty": "عرض العهد من 0 إلى 0 من إجمالي 0 عهده",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من العهد)",
                    "sInfoPostFix": "",
                    "sSearch": "بـحــث:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "التحميل...",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sLast": "الأخير",
                        "sNext": "التالى",
                        "sPrevious": "السابق"
                    },
                    "oAria": {
                        "sSortAscending": ": التفعيل لفرز العمود بترتيب تصاعدي",
                        "sSortDescending": ": التفعيل لفرز العمود بترتيب تنازلي"
                    }
                }
            });

           $('#datatable_length').addClass('mb-3');
        });


    </script>
@endsection