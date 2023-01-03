
@extends('index')
@section('title','الركاب')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">عرض جميع الركاب</h5>
    
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الراكب</th>
                                    <th>الجوال</th>
                                    <th>الإيميل</th>
                                    <th>الحالة</th>
                                    <th>عرض</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riders as $rider)
                                <tr>
                                    <td>{{ $rider->id }}</td>
                                    <td>{{ $rider->name }}</td>
                                    <td>{{ $rider->phone }}</td>
                                    <td>{{ $rider->email }}</td>
                                    <td>{{ $rider->state }}</td>
                                    
                                    <td>
                                        
                                        @if(Auth::user()->isAbleTo('rider_details'))
                                        <a href="{{ url('rider/detials/'.$rider->id) }}" class="btn btn-primary">عرض</a>
                                        @endif
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