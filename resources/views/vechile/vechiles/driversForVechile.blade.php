
@extends('index')
@section('title','السائقين المستلمين ')
@section('content')

                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>السائق</th>
                                    <th>الجوال</th>
                                    <th>الجنسية</th>
                                    <th>تاريخ الإستلام</th>
                                    <th>تاريخ الإعادة</th>
                                    <th>سبب الإعادة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->name }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>{{ $driver->nationality }}</td>
                                    <td>{{ $driver->start_date_drive }}</td>
                                    <td>{{ $driver->end_date_drive}}</td>
                                    <td>{{ $driver->reason}}</td>
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
                dom: 'Blfrtip',
                buttons: [
                            { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                            { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                            // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                            { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                        ],
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