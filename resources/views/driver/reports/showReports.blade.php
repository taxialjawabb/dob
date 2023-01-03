
@extends('index')
@section('title','تقارير اجمالى قبض السائقين')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">تقارير اجمالى قبض السائقين</h5>
</div>
<div class="clearfix "></div>
<div class="container">
    <div class="clearfix">

        <div class="float-end">
            <form action="{{ url('driver/reports/show') }}" method="GET">
                <div class="row">
                    <div class="col-5">
                        <label for="from_date" class="form-label">من</label>
                        <input type="date" style="text-direction:rtl" value="{{ old('from_date') }}" name="from_date" class="form-control" id="from_date"  required>
                    </div>
                    <div class="col-5">
                        <label for="to_date" class="form-label">ألى</label>
                        <input type="date" style="text-direction:rtl" value="{{ old('to_date') }}" name="to_date" class="form-control" id="to_date"  required>
                    </div>
                    <div class="col-2 mt-2">
                        <button type="submit" class="btn btn-primary mt-4 ">بحث</button>
                    </div>                
                </div>
            </form>
        </div>
    </div>
</div>
                <div class="panel panel-default mt-4">
                        <div class="table-responsive">
                            <table class="table " id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم السائق</th>
                                        <th>الهاتف</th>
                                        <th>أجمالى القبض</th>
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
                                        <td>{{ $d->total}}</td>
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