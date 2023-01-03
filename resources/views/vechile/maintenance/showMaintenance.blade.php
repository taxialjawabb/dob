
@extends('index')
@section('title','الصيانة')
@section('content')
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم</th>
                                    <th>نوع الصيانة</th>
                                    <th>رقم العداد</th>
                                    <th>صورة العداد</th>
                                    <th>صورة الفاتورة</th>                                    
                                    <th>تاريخ الاضافة</th>                                    
                                    <th>ملاحظة </th>                                    
                                    <th></th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $maintenance)
                                <tr>
                                    <td>{{ $maintenance->id }}</td>
                                    <td>{{ $maintenance->maintenance_type }}</td>
                                    <td>{{ $maintenance->counter_number }}</td>
                                    <td><img class="counter" id="{{$maintenance->counter_photo}}" src="{{asset($maintenance->counter_photo)}}" alt="صورة العداد"  style="width:120px; height:90px"></td>
                                    
                                    <td><img class="bill" id="{{$maintenance->bill_photo}}" src="{{asset($maintenance->bill_photo)}}" alt="صورة الفاتورة"  style="width:120px; height:90px"></td>
                                    <td>{{ $maintenance->added_date }}</td>
                                    <td>{{ $maintenance->maintenance_note }}</td>
                                    <td>
                                        <a href="{{ url('driver/notes/show/'.$maintenance->id) }}" class="btn btn-primary">عرض</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <img src="" alt="المرفق" id="photo" style="width:100%; height:380px" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
$( "body" ).click(function( event ) {
    if(event.target.className == 'bill' || event.target.className == 'counter'){
        $('.modal-body #photo').attr('src', event.target.src)
        $('#exampleModal').modal('show');
    }
});
</script>

    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                // "order": {{ 3, "desc" }},
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