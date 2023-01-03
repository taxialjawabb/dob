
@extends('index')
@section('title','رحـلات الراكب')
@section('content')

            <div class="container">
                <h4 class="text-center mt-4 mb-3">
                طلبات
                @switch($state)
                    @case('request')
                        قيد الإنتظار
                        @break
                    @case('inprogress')
                        قيد العمل
                        @break
                    @case('canceled')
                        تم إلغاءها من قبل العمـلاء
                        @break
                    @case('rejected')
                        تم رفضها من قبل السائـقين
                        @break
                    @case('expired')
                        تم تنفيذها
                        @break
                    @case('reserve')
                        تم حجزها
                        @break

                    @default
                        طلب غير معروف
                @endswitch
                </h4>
            </div>
            <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم الرحلة</th>
                                    <th> اسم الراكب</th>
                                    <th> اسم السائق</th>
                                    <th> رقم لوحة المركبة</th>
                                    <th>نوع الرحلة</th>
                                    <th>وقت طلب الرحلة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trips as $trip)
                                <tr>
                                    <td>{{ $trip->id }}</td>
                                    <td>{{ $trip->rider_name }}</td>
                                    <td>{{ $trip->driver_name }}</td>
                                    <td>{{ $trip->plate_number }}</td>
                                    <td>{{ $trip->trip_type }}</td>
                                    <td>{{ $trip->reqest_time }}</td>
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
                    "sLengthMenu": "عـرض _MENU_ الرحلات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الرحلات من _START_ إلى _END_ من إجمالي _TOTAL_ من رحلة",
                    "sInfoEmpty": "عرض الرحلات من 0 إلى 0 من إجمالي 0 رحلة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الرحلات)",
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