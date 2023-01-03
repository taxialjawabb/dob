@extends('index')
@section('title','السائقين')
@section('content')
<div class="mt-2">
    <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>

  </div>
<div class="container clearfix">
    <div class="float-end mt-4">
        <a href="{{ url('shared/groups/add/driver/'.$id) }}" class="btn btn-primary rounded-0 m-0">اضافه سائق جديد</a>
  </div>
</div>
<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم</th>
                    <th>السائق</th>
                    <th>الجوال</th>
                    <th>الجنسية</th>
                    <th>الحالة</th>
                    <th>الرصيد</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                <tr>
                    <td>{{ $driver->id }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->phone }}</td>
                    <td>{{ $driver->nationality }}</td>
                    <td>
                        @switch($driver->state)
                        @case('active')
                            سائق مستلم
                            @break
                        @case('waiting')
                            سائق انتظار
                            @break
                        @case('blocked')
                            سائق مستبعد
                            @break
                        @case('pending')
                            سائق قيد المراجعة
                            @break
                        @default
                            Default case...
                        @endswitch
                    </td>
                    <td>{{ $driver->group_balance }}</td>
                    <td>
                        @if ($driver->state!='blocked')
                        <a href="{{ url($driver->group_id === null? 'driver/details/' . $driver->id:'shared/groups/driver/detials/'.$driver->id .'/'. $driver->group_id) }}" class="btn btn-primary m-1">عرض</a>
                        <a href="{{ url('shared/groups/driver/update/'.$driver->id.'/'.$id) }}" class="btn btn-danger m-1">تعديل</a>
                        @endif
                        @if ($driver->state=='waiting')
                        <a href="{{ url('shared/groups/driver/state/'.$id.'/'.$driver->id) }}" class="btn btn-primary m-1">استبعاد</a>
                        @endif

                        @if ($driver->state=='blocked')
                        <a href="{{ url('shared/groups/driver/state/'.$id.'/'.$driver->id) }}" class="btn btn-primary m-1">الغاء الاستبعاد</a>
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
                    "sLengthMenu": "عـرض _MENU_ سائقين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض سائقين من _START_ إلى _END_ من إجمالي _TOTAL_ من سائق",
                    "sInfoEmpty": "عرض سائقين من 0 إلى 0 من إجمالي 0 سائق",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من سائقين)",
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
