@extends('index')
@section('title', 'جدول الحضور')
@section('content')
@if ($errors->any())
<div class="alert alert-danger m-3 mt-4">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container mt-4">
    <div class="clearfix">
        <div class="float-start">
            @switch($request->absence_type)
                @case('vacation')
                    <h5 class="h5 text-dark mt-2">عرض أيام الأجازة للموظف</h5>
                    <p>
                        أجمالى عدد الأيام الإجازة فى شهر:  {{  \Carbon\Carbon::parse($request->date)->format('F Y') }}
                    </p>
                    <div class="bg-warning m-2 text-center p-2 ">
                        {{ $counted }}
                    </div>
                    @break
                @case('absence')
                    <h5 class=" mt-2">عرض أيام الغياب للموظف</h5>
                    <p>
                        أجمالى عدد الأيام الغياب فى شهر:  {{  \Carbon\Carbon::parse($request->date)->format('F Y') }}
                    </p>
                    <div class="bg-warning m-2 text-center p-2 ">
                        {{ $counted }}
                    </div>
                    @break
                @case('delay')
                    <h5 class=" mt-2">عرض ساعات التأخير للموظف</h5>
                    <p class="mb-2">
                        أجمالى عدد ساعات التأخير فى شهر:  {{  \Carbon\Carbon::parse($request->date)->format('F Y') }}
                    </p>
                    <div class="clearfix">
                       <div class="float-start me-3">
                            <h6>عدد أيام التأخير</h6>
                            <div class="bg-warning text-center p-2 ">
                                {{ $counted }}
                            </div>
                       </div>

                       <div class="float-start ms-2">
                            <h6>أجمالي عدد ساعات التأخير</h6>
                            <div class="bg-warning text-center p-2 ">
                                {{ $hours }}
                            </div>
                       </div>
                    </div>
                    @break

                @default
                    <h5 class=" mt-2 float-start">لم يتم تحديد نوع فلترت العرض</h5>
                    @break

            @endswitch

        </div>


        <div class="float-end mt-3">
            <form method="GET" action="{{ url('user/attendance/show') }}" id='form'>
                <input type="hidden" name="user_id" value="{{ $request->user_id }}">
                <div class="mb-3">
                    <div class="d-inline me-3">
                        <input class="form-check-input" type="radio" name="absence_type" value="vacation"
                            id="absence_type2"  @checked($request->absence_type ==='vacation') required>
                        <label class="form-check-label" for="absence_type2">
                            أجازة
                        </label>
                    </div>

                    <div class="d-inline me-3">
                        <input class="form-check-input" type="radio" name="absence_type" value="absence"
                            id="absence_type1"  @checked($request->absence_type ==='absence') required>
                        <label class="form-check-label" for="absence_type1">
                            غياب
                        </label>
                    </div>

                    <div class="d-inline me-3">
                        <input class="form-check-input" type="radio" name="absence_type" value="delay"
                            id="absence_type3" @checked($request->absence_type ==='delay') required>
                        <label class="form-check-label" for="absence_type3">
                            ساعات تأخير
                        </label>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="float-start">

                        <label for="date" class="form-label">فلترت الحضور بالشهر</label>
                        <input type="month" style="text-direction:rtl"
                            value="{{ \Carbon\Carbon::parse($request->date)->format('Y-m') }}" name="date"
                            class="form-control" id="date" min="2022-09"  max="{{ \Carbon\Carbon::now()->format('Y-m') }}" required>
                    </div>
                    <div class="float-start mt-2 ms-3">
                        <button type="submit" class="btn btn-primary mt-4 ">بحث</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>تاريخ</th>
                    <th>أضيف بواسطة</th>
                    <th>ساعات التأخير</th>
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach ($data as $index => $attendance)
                <tr class="bill{{ ++$index }}">
                    <td>{{ $index }}</td>
                    <td>{{ $attendance->date_is }}</td>
                    <td>{{ $attendance->admin_data->name }}</td>
                    <td>{{ $attendance->delay_hours }}</td>
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
                // 'lengthMenu' : [[10,25,50,100, -1],[10,25,50,100, 'All Rider']],
                dom: 'Blfrtip',
                buttons: [
                    // { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                    // {
                    //     extend: 'excel',
                    //     className: 'btn btn-success text-light',
                    //     text: 'Excel',
                    //     charset: "utf-8"
                    // },
                    // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                    // { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                ],
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
