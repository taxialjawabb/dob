@extends('index')
@section('title', 'المركبات')
@section('content')
<div class="mt-2">
    <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>

  </div>
<div class="container clearfix">
    <div class="float-end mt-4">

        <a href="{{ url('shared/groups/add/vechile/'.$id) }}" class="btn btn-primary rounded-0 m-0">اضافه مركبه جديد</a>
    </div>
</div>
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>رقم</th>
                        <th>رقم اللوحة</th>
                        <th>سنة التصنيع</th>
                        <th>اللون</th>
                        <th>الحالة</th>
                        <th>الرصيد</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vechiles as $vechile)
                        <tr>
                            <td>{{ $vechile->id }}</td>
                            <td>{{ $vechile->plate_number }}</td>
                            <td>{{ $vechile->made_in }}</td>
                            <td>{{ $vechile->color }}</td>
                            <td>
                                @switch($vechile->state)
                                    @case('active')
                                        مركبة مستلم
                                    @break

                                    @case('waiting')
                                        مركبة انتظار
                                    @break

                                    @case('blocked')
                                        مركبة مستبعده
                                    @break

                                    @default
                                        Default case...
                                @endswitch
                            </td>
                            <td>{{ $vechile->group_balance }}</td>
                            <td>
                                <a href="{{ url('shared/groups/vechile/detials/'.$vechile->id.'/'.$id) }}" class="btn btn-primary m-1">عرض</a>
                                @if ($vechile->state=='waiting')
                                <a href="{{ url('shared/groups/vechile/state/'.$id.'/'.$vechile->id) }}" class="btn btn-primary m-1">استبعاد</a>
                                @endif

                                @if ($vechile->state=='blocked')
                                <a href="{{ url('shared/groups/vechile/state/'.$id.'/'.$vechile->id) }}" class="btn btn-primary m-1">الغاء الاستبعاد</a>
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
