
@extends('index')
@section('title','الفواتير')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">فـواتـيـر بإنتظار الأعتماد</h5>
    <div class="float-end mt-3">        
        <a href="{{url('bills/waiting/trustworthy/vechile')}}"   class="btn {{$type === 'vechile' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >مركبات</a>
        <a href="{{url('bills/waiting/trustworthy/driver')}}"    class="btn {{$type === 'driver' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >سائقين</a>
        <a href="{{url('bills/waiting/trustworthy/rider')}}"     class="btn {{$type === 'rider' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >عملاء</a>
        <a href="{{url('bills/waiting/trustworthy/nathiraat')}}" class="btn {{$type === 'nathiraat' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >نثريـات</a>
    </div>
</div>
<div class="clearfix "></div>
<div class="container">
    <div class="clearfix">
        <div class="float-start">  
            <h6 style="margin: 10px">
                إجمالي القبض
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                
                {{$take ?? 0}}
            </div>
        </div>
        <div class="float-start">  
            <h6 style="margin: 10px">
                إجمالي الصرف
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{$spend ?? 0}}
            </div>
        </div>
        <div class="float-start text-center">  
            <h6 style="margin: 10px">
                الأجــمــالـــي
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{($take ?? 0) - ($spend ?? 0)}}
            </div>
        </div>
    </div>
</div>
            <form method="POST" action="{{ url('bills/waiting/trustworthy') }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="panel panel-default mt-4">
                        <div class="table-responsive">
                            <table class="table " id="datatable">
                                <thead>
                                    <tr>
                                        <th>رقم السند</th>
                                        <th>نوع السند</th>
                                        <th>طريقة الدفع</th>
                                        <th>المبلغ</th>
                                        <th>الوصف</th>
                                        <th>اسم المحصل</th>
                                        <th>تاريخ تاريخ التحصيل</th>
                                        <th>
                                            <button id="confirm-all" class="btn btn-light m-0 p-0">تحديد الجميع</button>
                                            <button type="submint" class="btn btn-primary">أعتماد الفواتير المحددة</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->id }}</td>
                                        <td>
                                        @switch($bill->bond_type)
                                            @case('spend')
                                                صــرف
                                                @break
                                            @case('take')
                                                قـبــض
                                                @break
                                            @default
                                                Default case...
                                        @endswitch
                                        </td>
                                        <td>
                                        @switch($bill->payment_type)
                                            @case('cash')
                                                كــاش
                                                @break
                                            @case('bank transfer')
                                                تحويل بنكى
                                                @break
                                            @case('internal transfer')
                                                تحويل داخلى
                                                @break
                                            @case('selling points')
                                                نقاط بيع
                                                @break
                                            @case('electronic payment')
                                                دفع إلكترونى
                                                @break
                                            @default
                                                
                                        @endswitch
                                        </td>
                                        <td>{{ $bill->total_money}}</td>
                                        <td>{{ $bill->descrpition}}</td>
                                        <td>{{ $bill->confirmed_by}}</td>
                                        <td>{{ $bill->confirm_date}}</td>
                                        <td>
                                            <input type="checkbox" name="id[]" value="{{$bill->id}}" >
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </form>

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                // 'lengthMenu' : [[10,25,50,100, -1],[10,25,50,100, 'All Rider']],
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ الفواتير",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الفواتير من _START_ إلى _END_ من إجمالي _TOTAL_ من فاتورة",
                    "sInfoEmpty": "عرض الفواتير من 0 إلى 0 من إجمالي 0 فاتورة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الفواتير)",
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

        $(document).ready(function(){
            var selectAll = false ;
            $("#confirm-all").click(function(e){
                e.preventDefault();
                
                if(selectAll == false){
                    selectAll = true;
                    $(this).text('إلغاء التحديد للجميع');
                    $("#datatable input").attr('checked','checked');
                }else{
                    $(this).html('تحديد الجميع');
                    selectAll = false;
                    $("#datatable input").removeAttr('checked');

                }
            });
        });
    </script>
@endsection