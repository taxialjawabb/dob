@extends('index')
@section('title', 'الدفع الأسبوعي')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">
        تأخيرات الدفع الأسبوعي
    </h5>

</div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>بداية الأسبوع</th>
                    <th>نهاية الأسبوع</th>
                    <th>المبلغ المستحق</th>
                    <th>المبلغ المدفوع</th>
                    <th>الملغ المتبقى</th>
                    <th>حالة التاخير</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $delay)
                <tr>
                    <td>{{ $delay->id }}</td>
                    <td>{{ $delay->start_week }}</td>
                    <td>{{ $delay->end_week }}</td>
                    <td>{{ $delay->weekly_money_due }}</td>
                    <td>{{ $delay->payed }}</td>
                    <td>{{ $delay->remains }}</td>
                    <td>
                        @switch($delay->state)
                        @case('pending')
                        قيد المراجعة
                        @break

                        @case('active')
                        تمت المراجعة
                        @break
                        @default
                        Default case...
                        @endswitch
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
                    "sLengthMenu": "عـرض _MENU_ الأسابيع",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الأسابيع من _START_ إلى _END_ من إجمالي _TOTAL_ من أسبوع",
                    "sInfoEmpty": "عرض الأسابيع من 0 إلى 0 من إجمالي 0 أسبوع",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الأسابيع)",
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
