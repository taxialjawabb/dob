@extends('index')
@section('title','المجموعات')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">طلبات تحديث الترخيص</h5>
    <div class="float-end mt-3">
        <a href="{{ route('manage.groups.license.show', 'pending') }}" class="btn {{ $type == 'pending'? 'btn-primary' : 'btn-outline-primary' }} rounded-0 m-0">قيد المراجعة</a>
        <a href="{{ route('manage.groups.license.show', 'accepted') }}" class="btn {{ $type == 'accepted'? 'btn-primary' : 'btn-outline-primary' }} rounded-0 m-0">طلبات مقبولة</a>
        <a href="{{ route('manage.groups.license.show', 'rejected') }}" class="btn {{ $type == 'rejected'? 'btn-primary' : 'btn-outline-primary' }} rounded-0 m-0">طلبات مرفوضة</a>
    </div>
</div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المنشأة</th>
                    <th>نوع الترخيص</th>
                    <th>تاريخ نهاية الترخيص</th>
                    <th>المرفق</th>
                    <th> حالة الترخيص</th>
                    @if($type == 'pending')
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @foreach($data as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->name }}</td>
                    <td>
                        @switch($d->type)
                            @case('commercial_register')
                                ترخيص  السجل التجاري
                                @break
                            @case('transportation_license_number')
                                ترخيص هيئة النقل
                                @break
                            @case('municipal_license_number')
                                رخصة البلدية
                                @break
                            @default
                        @endswitch
                    </td>
                    <td>{{ $d->expire_date }}</td>
                    <td>
                        <form  method="GET" action="{{ url('show/pdf') }}">
                                @csrf
                            <input type="hidden" name="url" value="{{'assets/images/groups/documents/'.$d->attached}}">
                            <button type="submit" class="btn btn-light" >عرض المرفق</button>
                        </form>
                    </td>
                    <td>
                        @switch($d->state)
                            @case('pending')
                                قيد المراجعة
                                @break
                            @case('rejected')
                                 تم رفضة
                                @break
                            @case('accepted')
                               تم الموافقة علية
                            @break
                            @default
                        @endswitch
                    </td>
                    @if($type == 'pending')
                    <td>

                        <a href="{{ route('manage.groups.license.change', ['type' => 'accepted', 'id' => $d->id]) }}"
                            class="btn btn-outline-primary m-1">قبول  </a>

                        <a href="{{ route('manage.groups.license.change', ['type' => 'rejected', 'id' => $d->id]) }}"
                            class="btn btn-outline-primary m-1">رفض </a>

                    </td>
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
                    "sLengthMenu": "عـرض _MENU_ النسبة",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض النسبة من _START_ إلى _END_ من إجمالي _TOTAL_ من مستند",
                    "sInfoEmpty": "عرض النسبة من 0 إلى 0 من إجمالي 0 نسبة خصم",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من النسبة)",
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
