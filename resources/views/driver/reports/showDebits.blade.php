
@extends('index')
@section('title','الصندوق العام')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">تقارير السائقين المتعثرين</h5>
</div>
                <div class="panel panel-default mt-4">
                        <div class="table-responsive">
                            <table class="table " id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم السائق</th>
                                        <th>الهاتف</th>
                                        <th>الرصيد</th>
                                        <th>
                                            عرض
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @foreach($data as $index=>$d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->phone }}</td>
                                        <td>{{ $d->account}}</td>
                                        <td>
                                            <a href="{{ url('driver/details/'.$d->id) }}" class="m-1 btn btn-primary">عرض</a>
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
                "order": {{ 3, 'asc'}},
                // 'lengthMenu' : [[10,25,50,100, -1],[10,25,50,100, 'All Rider']],
                dom: 'Blfrtip',
                buttons: [
                            // { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                            { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                            // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                            // { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                        ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ السائقين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض السائقين من _START_ إلى _END_ من إجمالي _TOTAL_ من سائق",
                    "sInfoEmpty": "عرض السائقين من 0 إلى 0 من إجمالي 0 سائق",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من السائقين)",
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
<script>
    // $(document).ready(function(){
    //     $("#from_date , #to_date").on('change', function(){
    //         var startDate = $("#from_date").val();
    //         var endDate = $("#to_date").val();
    //     if(startDate !== '' && endDate !== ''){
    //         $.ajax({
    //                 type: 'post',
    //                 url: '{!!URL::to("general/box/search")!!}',
    //                 data: {
    //                         "_token": "{{ csrf_token() }}",
    //                         'from' : startDate,
    //                         'to' : endDate,
    //                     },
    //                 success: function(data){
    //                     console.log(data);
    //                 },
    //                 error:function(e){
    //                     console.log('error');
    //                     console.log(e);
    //                 }
    //                 });
    //     }
    //     });
    // });
</script>
@endsection