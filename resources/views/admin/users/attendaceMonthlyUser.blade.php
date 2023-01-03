@extends('index')
@section('title', 'تقرير الرواتب المستحقة')
@section('content')
<div class="container mt-4">
    <div class="clearfix">
        <div class="float-start d-flex">
            <div>
                <h5 class="h5 text-dark mt-2">تقرير الرواتب المستحقة  </h5>
                <p>
                    أجمالي المبلغ المستحق  رواتب الموظفين
                </p>
                <div class="bg-warning m-2 text-center p-2 ">
                    {{ round($total , 2) }}
                </div>
            </div>
            @if($confirm === 2)
            <div class="ms-auto mt-auto mb-2 ">
                <form method="POST" action="{{ url('user/attendance/confirm/reports') }}" id='form'>
                    @csrf
                    <input type="hidden" value="{{ \Carbon\Carbon::parse($dateFormat)->format('Y-m') }}" name="date" required>
                    <input type="hidden" value="{{$type}}" name="type" required>
                    <button type="submit" class="btn btn-primary ">اعتماد الرواتب للمستخدمين</button>
                </form>
            </div>
            @elseif($confirm === 3)
            <div class="ms-auto mt-auto mb-2 ">
                <form method="POST" action="{{ url('user/attendance/confirm/reports') }}" id='form'>
                    @csrf
                    <input type="hidden" value="{{ \Carbon\Carbon::parse($dateFormat)->format('Y-m') }}" name="date" required>
                    <input type="hidden" value="{{$type}}" name="type" required>
                    <button type="submit" class="btn btn-primary ">اعتماد الرواتب للسائقين</button>
                </form>
            </div>
            @elseif($confirm === 4)
            <div class="ms-auto mt-auto mb-2 ">
                <form method="POST" action="{{ url('user/attendance/confirm/reports') }}" id='form'>
                    @csrf
                    <input type="hidden" value="{{ \Carbon\Carbon::parse($dateFormat)->format('Y-m') }}" name="date" required>
                    <input type="hidden" value="{{$type}}" name="type" required>
                    <button type="submit" class="btn btn-primary ">اعتماد الرواتب للجميع</button>
                </form>
            </div>
            @endif
        </div>


        <div class="float-end mt-3">
            <form method="GET" action="{{ url('user/attendance/show/reports/'.$type) }}" id='form'>
                <div class="clearfix">
                    <div class="float-start">

                        <label for="date" class="form-label">فلترت الحضور بالشهر</label>
                        <input type="month" style="text-direction:rtl"
                            value="{{ \Carbon\Carbon::parse($dateFormat)->format('Y-m') }}" name="date"
                            class="form-control" id="date" min="2022-09"
                            max="{{ \Carbon\Carbon::now()->format('Y-m') }}" required>
                    </div>
                    <div class="float-start mt-2 ms-3">
                        <button type="submit" class="btn btn-primary mt-4 ">بحث</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="float-end m-3">
            <a  class="btn {{ $type !='users' && $type != 'drivers'? 'btn-primary': 'btn-outline-primary' }}" href="{{url('user/attendance/show/reports/all?date='. $dateFormat->format('Y-m') )}}" >عرض تقارير الحضور للجميع</a>
            <a  class="btn {{ $type =='users' ? 'btn-primary': 'btn-outline-primary' }}" href="{{url('user/attendance/show/reports/users?date='. $dateFormat->format('Y-m') )}}">المستخدمين فقط</a>
            <a  class="btn {{ $type == 'drivers'? 'btn-primary': 'btn-outline-primary' }}" href="{{url('user/attendance/show/reports/drivers?date='. $dateFormat->format('Y-m') )}}">السائقين فقط</a>

        </div>
    </div>
</div>
<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الراتب الكلى</th>
                    <th>الإجر اليومى</th>
                    <th>الإستقطاع</th>
                    <th>التأمينات</th>
                    <th>الراتب الاساسى</th>
                    <th>ايام الإجازة</th>
                    <th>ايام الغياب</th>
                    <th>ايام التأخير</th>
                    <th>ساعات التأخير</th>
                    <th>الراتب المستحق</th>
                    @if(!$confirm)
                    <th>تاريخ الإعتماد</th>
                    <th>اعتمد بواسطة</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index=>$user)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $user->user_data->name }}</td>
                    <td>{{ $user->total_salary }}</td>
                    <td>{{ round($user->total_salary / 30 , 2) }}</td>
                    <td>{{ $user->deduction }}</td>
                    <td>{{ $user->insurances }}</td>
                    <td>{{ $user->basic_salary }}</td>
                    <td>{{ $user->vacation_days }}</td>
                    <td>{{ $user->absence_days }}</td>
                    <td>{{ $user->delay_days_hours }}</td>
                    <td>{{ $user->delay_hours }}</td>
                    <td>{{ $user->final_salary }}</td>
                    @if($confirm === 1)
                    <td>{{ $user->confirmed_date }}</td>
                    <td>{{ $user->confirmed->name  }}</td>
                    @endif
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
