@extends('index')
@section('title','المستخدمين')
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
<div class="container clearfix">
    <div class="float-start">
        <h5 class="mt-4">موظفين : {{ $type =='active'? 'على رأس العمل': 'مستبعدين' }}</h5>
    </div>
    <div class="float-end mt-3">
        <div class="dropdown float-start ms-1 me-2">
            <button class="btn btn-primary dropdown-toggle rounded-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                عرض المستخدمين
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a  class="dropdown-item" href="{{url('user/show/active')}}" >المستخدمين على رأس العمل</a>
                </li>
                <li>
                    <a  class="dropdown-item" href="{{url('user/show/blocked')}}"> المستخدمين المستبعدين</a>
                </li>
                <li>
                    <a  class="dropdown-item" href="{{url('user/driver/employee/show/active')}}"> السائقين الموظفين على رأس العمل</a>
                </li>
                <li>
                    <a  class="dropdown-item" href="{{url('user/driver/employee/show/unactive')}}"> السائقين الموظفين مستبعدين</a>
                </li>
            </ul>
        </div>
        @if(Auth::user()->isAbleTo('manage_covenant_system'))
        <a href="{{url('covenant/show')}}" class="btn btn-primary rounded-0 m-0">العهد</a>
        @endif
        <a href="{{url('user/activity/log')}}" class="btn btn-primary rounded-0 m-0">سجل الإحداث للمستخدمين</a>
        <a href="{{url('user/add')}}" class="btn btn-success rounded-0 m-0">أضـافـة مستخدم</a>
        <a href="{{url('user/reports')}}" class="btn btn-success rounded-0 m-0"> تقرير المستخدمين</a>
         <div class="dropdown float-end ms-1 me-2">
            <button class="btn btn-primary dropdown-toggle rounded-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                تقارير الحضور
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a  class="dropdown-item" href="{{url('user/attendance/show/report/all')}}" >عرض تقارير الحضور للجميع</a>
                </li>
                <li>
                    <a  class="dropdown-item" href="{{url('user/attendance/show/report/users')}}">عرض تقارير الحضور للمستخدمين</a>
                </li>
                <li>
                    <a  class="dropdown-item" href="{{url('user/attendance/show/report/drivers')}}">عرض تقارير الحضور للسائقين</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="clearfix "></div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم المستخدم</th>
                    <th>اسم المستخدم</th>
                    <th>رقم الجوال</th>
                    <th>الادوار</th>
                    <th>تاريخ الأضافة</th>
                    <th>اضيف بواسطة</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                <tr class="user{{ $user->id }}">
                    <td class="id">{{ $user->id }}</td>
                    <td class="name">{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @foreach($user->roles as $roles)
                        {{ $roles->display_name }}
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $user->add_by }}</td>
                    <td>
                        <a href="{{ url('user/detials/'.$user->id) }}" class="btn btn-primary m-1">عـرض</a>
                        <a href="{{ url('user/update/'.$user->id) }}" class="btn btn-danger m-1">تعديل</a>
                        <form method="GET" action="{{ url('user/attendance/show') }}" class="d-inline">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="absence_type" value="absence">
                            <input type="hidden" name="date" value="{{ \Carbon\Carbon::now() }}">
                            <button type="submit" class="btn btn-primary m-1">عرض الحضور</button>
                        </form>
                        @if($type === 'active')
                            <a href="#" class="btn user-absence btn-success m-1" id="user{{ $user->id }}" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">أضافة غياب</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="container-fluid mt-1 " id="printable">
                <p class="mb-2 mt-4" style="color: black; font-size: 16px;">تسجيل اليوم للموظف: <spand id="username"></spand></p>
                <p class="mb-4" style="color: black; font-size: 16px;">تاريخ اليوم: {{ \Carbon\Carbon::now()->format('d-m-y') }}</p>
                <form method="POST" action="{{ url('user/attendance/add') }}" id='form'>
                    <input type="hidden" class="user_id" id="user_id" name="user_id" required>
                    @csrf
                    <div class="row">
                        <div class="col col-xs-12">
                            <input class="form-check-input" type="radio" name="absence_type" value="vacation" id="absence_type2" required >
                            <label class="form-check-label" for="absence_type2">
                              أجازة
                            </label>
                        </div>

                        <div class="col col-xs-12">
                            <input class="form-check-input" type="radio" name="absence_type" value="absence" id="absence_type1" required>
                            <label class="form-check-label" for="absence_type1">
                              غياب
                            </label>
                          </div>

                          <div class="col col-xs-12">
                            <input class="form-check-input" type="radio" name="absence_type" value="delay" id="absence_type3" required >
                            <label class="form-check-label" for="absence_type3">
                              ساعات تأخير
                            </label>
                          </div>
                    </div>
                    <div id="delay-hours" class="row">

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="reason" class="col-form-label">السبب:</label>
                            <textarea name="reason"  value="{{ old('reason') }}"  class="form-control" id="reason" required></textarea>
                        </div>
                    </div>
                    <button type="submit" id="save-form" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(function() {


    var listItem = $(".user-absence");
    for (var i = 0; i < listItem.length; i++) {
        listItem[i].addEventListener('click', function(e) {
            console.log(e.target.id);
            var id = $("." + e.target.id + " .id").text();
            var name = $("." + e.target.id + " .name").text();
            $("#username").text(name);
            $("#user_id").val(id);
        });
    }
    $("input:radio[name='absence_type']").on('click', function(){
        if ($("#absence_type3").prop("checked")) {
            $("#delay-hours").html(`
                                <div class="col mt-3 mb-2">
                                    <label for="delay_hours" class="form-label">عدد ساعات التأخير</label>
                                    <input type="text" value="{{ old('delay_hours') }}" name="delay_hours" class="form-control" id="delay_hours"  required>
                                </div>
            `);
        }
        else{
            $("#delay-hours").html(``);
        }
    });

});
</script>
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
