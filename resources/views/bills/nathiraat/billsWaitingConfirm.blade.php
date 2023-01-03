
@extends('index')
@section('title','الفواتير')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">فـواتـيـر بإنتظار التأكيد</h5>
    <div class="float-end mt-3">        
        <a href="{{url('bills/waiting/confrim/vechile')}}"   class="btn {{$type === 'vechile' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >مركبات</a>
        <a href="{{url('bills/waiting/confrim/driver')}}"    class="btn {{$type === 'driver' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >سائقين</a>
        <a href="{{url('bills/waiting/confrim/rider')}}"     class="btn {{$type === 'rider' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >عملاء</a>
        <a href="{{url('bills/waiting/confrim/nathiraat')}}" class="btn {{$type === 'nathiraat' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >نثريـات</a>
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
            <form method="POST" action="{{ url('bills/waiting/confrim') }}">
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
                                    <th>الوصـف</th>
                                    <th>تاريخ الإضافة</th>
                                    <th>أضيف بواسطة</th>
                                    <th>
                                        <button id="confirm-all" class="btn btn-light m-0 p-0">تحديد الجميع</button>
                                        <button type="submint" class="btn btn-primary">تأكيد الفواتير المحددة</button>
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
                                            Default case...
                                    @endswitch
                                    </td>
                                    <td>{{ $bill->total_money}}</td>
                                    <td>{{ $bill->descrpition}}</td>
                                    <td>{{ $bill->add_date}}</td>
                                    <td>{{ $bill->name}}</td>
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