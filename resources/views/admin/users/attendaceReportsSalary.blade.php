@extends('index')
@section('title', 'تقرير الرواتب المستحقة')
@section('content')
<div class="container mt-4">
    <div class="clearfix">
        <div class="float-start d-flex">
            <div>
                <h5 class="h5 text-dark mt-2">تقرير الرواتب المستحقة  </h5>
                <p>
                    تقرير رواتب المستحقة للموظفين
                </p>
            </div>

        </div>
    </div>
</div>
<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الشهر</th>
                    <th>عدد الموظفين</th>
                    <th>أجمالى المبلغ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index=>$month)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $month->salary_date }}</td>
                    <td>{{ $month->bills }}</td>
                    <td>{{ round($month->total_salary , 2) }}</td>
                    <td>
                        @if ($type === 'users')
                            <a href="{{url('user/attendance/show/reports/users?date='. $month->salary_date )}}" class="btn btn-primary rounded-0 m-0">عرض التقرير</a>
                        @elseif ($type ==='drivers')
                            <a href="{{url('user/attendance/show/reports/drivers?date='. $month->salary_date )}}" class="btn btn-primary rounded-0 m-0">عرض التقرير</a>
                        @else
                            <a href="{{url('user/attendance/show/reports/all?date='. $month->salary_date )}}" class="btn btn-primary rounded-0 m-0">عرض التقرير</a>
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
    $(document).ready(function() {
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
                    "sLengthMenu": "عـرض _MENU_ المستخدمين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المستخدمين من _START_ إلى _END_ من إجمالي _TOTAL_ من مستخدم",
                    "sInfoEmpty": "عرض المستخدمين من 0 إلى 0 من إجمالي 0 مستخدم",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المستخدمين)",
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
