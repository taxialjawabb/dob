
@extends('index')
@section('title','العهد')
@section('content')

                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم </th>
                                    <th>رقم التسلسلى </th>
                                    <th>حالة العهدة</th>
                                    <th>اضيفة بواسطة</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>السائق المستلم</th>
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
                                    <td>{{ $covenant->admin_name}}</td>
                                    <td>{{ $covenant->add_date}}</td>
                                    <td>{{ $covenant->driver_name }}</td>
                                    <td>{{ $covenant->delivery_date }}</td>
                                    <td>
                                        <a href="{{ url('covenant/show/note/'.$covenant->id) }}"
                                        class="btn btn-primary m-1">الملاحظات</a>
                                        <a href="{{ url('covenant/show/record/'.$covenant->id) }}"
                                        class="btn btn-primary  m-1">سجل العهدة</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

@endsection

@section('scripts')
<script>
        $(document).ready( function () {
            $('#datatable').DataTable({
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
