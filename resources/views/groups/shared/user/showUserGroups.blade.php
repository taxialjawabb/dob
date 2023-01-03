@extends('index')
@section('title', 'مجموعات المستخدم')
@section('content')

    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المجموعة</th>
                        <th>عدد المركبات</th>
                        <th>تاريخ الإضافة</th>
                        <th>تاريخ الإنتهاء</th>
                        <th>المدير المسؤال</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->id }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->vechile_counter }}</td>
                        <td>{{ $group->add_date }}</td>
                        <td>{{ $group->renew_date }}</td>
                        <td>{{ $group->manager->name ?? ''}}</td>
                        <td>
                            @if($group->manager->id == Auth::guard('admin')->user()->id)
                                <a href="{{ url('groups/show/users/'.$group->id) }}" class="btn btn-primary m-1">المستخدمين</a>
                            @endif
                            <a href="{{ url('driver/contract/show/contracts/'.$group->id) }}" class="btn btn-primary m-1">عقود التأجير</a>
                   
                            <a href="{{ url('groups/show/drivers/'.$group->id) }}" class="btn btn-primary m-1">السائقين</a>
                            <a href="{{ url('groups/show/vechiles/'.$group->id) }}" class="btn btn-primary m-1">المركبات</a>
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
