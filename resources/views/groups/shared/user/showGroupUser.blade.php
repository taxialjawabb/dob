@extends('index')
@section('title', 'المستخدمين')
@section('content')
<div class="mt-2">
    <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>


  </div>
<div class="container clearfix">
    <div class="float-end mt-4">
    <a href="{{ url('shared/groups/add/user/'.$id) }}" class="btn btn-primary rounded-0 m-0">اضافه مستخدم جديد</a>

</div>
</div>
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>رقم</th>
                        <th>المستخدم</th>
                        <th>الجوال</th>
                        <th>الجنسية</th>
                        <th>الحالة</th>
                        <th>الرصيد</th>
                        <th>الحالة</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->nationality }}</td>
                        <td>
                            @switch($user->state)
                            @case('active')
                                مستخدم نشط
                                @break
                            @case('blocked')
                                مستخدم مستبعد
                                @break
                            @default
                                Default case...
                            @endswitch
                        </td>
                        <td>{{ $user->group_balance }}</td>

                        <td>

                            @if(App\Models\Groups\Group::find($id)->manager_id !== $user->pivot->user_id)
                                <a href="{{ url('shared/groups/user/state/'.$id.'/'.$user->pivot->user_id) }}" class="btn btn-primary m-1">{{ $user->state=='active'?'استبعاد':'الغاء الاستبعاد'}}</a>
                            @endif

                        </td>
                        <td>
                            <a href="{{ url('shared/groups/user/detials/'.$id.'/'.$user->pivot->user_id) }}" class="btn btn-primary m-1">عرض</a>
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
