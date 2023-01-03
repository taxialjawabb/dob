@extends('index')
@section('title','صرف الكميات')
@section('content')
<div class="container clearfix">
    <div class=" mt-4 float-start">
        <h5 class=" mt-2">عرض صرف الكميات : {{ $product->name }}</h5>

        <div class="clearfix">
            <div class="float-start me-3">
                <h6>الكمية الكلية</h6>
                <div class="bg-warning text-center p-2 ">
                    {{ $product->total }}
                </div>
            </div>

            <div class="float-start ms-2 me-3">
                <h6>الكمية المتبقي</h6>
                <div class="bg-warning text-center p-2 ">
                    {{ $product->stored }}
                </div>
            </div>

            <div class="float-start ms-2">
                <h6>الكمية المصروفة</h6>
                <div class="bg-warning text-center p-2 ">
                    {{ $product->used }}
                </div>
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
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>السائق المستلم</th>
                    <th>رقم اللوحة</th>
                    <th>تاريخ الصرف</th>
                    <th>صرف بواسطة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->count }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->driver->name }}</td>
                    <td>{{ $item->vechile->plate_number }}</td>
                    <td>{{ $item->add_date }}</td>
                    <td>{{ $item->added_by->name }}</td>

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
                    "sLengthMenu": "عـرض _MENU_ الكميات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الكميات من _START_ إلى _END_ من إجمالي _TOTAL_ من الكمية",
                    "sInfoEmpty": "عرض الكميات من 0 إلى 0 من إجمالي 0 الكمية",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الكميات)",
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
