
@extends('index')
@section('title','تقارير  المركبات ')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">تقارير  المركبات</h5>
          
    <a href="#" class="btn btn-success float-end rounded-0 mt-4"  id="printButton" >تحميل pdf</a>
     
</div>

<div class="panel panel-default mt-4 border"  id="divPrint">
    <div class="table-responsive">
        <table class="table " id="datatable" >
            <thead>
                <tr>
                   
                    <th>نوع السيارة</th>
                    <th>رقم المسلسل</th>
                    <th>رقم اللوحة</th>
                    <th>تاريخ انتهاء رخصة السير</th>
                    <th>تاريخ انتهاء بطاقة التشغيل</th>
                    <th>تاريخ انتهاء التأمين </th>
                    <th>تاريخ انتهاء الفحص الدوري </th>
                    <th>الحالة</th>
                  
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $car)
                    <tr>
                        
                        <td>{{ $car->vechile_type }}</td>
                        <td>{{ $car->serial_number  }}</td>
                        <td>{{ $car->plate_number  }}</td>
                        <td>{{ \Carbon\Carbon::parse($car->operating_card_expiry_date)->format('d-m-Y')}}</td>
                        <td>{{ \Carbon\Carbon::parse($car->contract_end_date)->format('d-m-Y')}}</td>
                        <td>{{ \Carbon\Carbon::parse($car->insurance_card_expiration_date)->format('d-m-Y')}}</td>
                        <td>{{ \Carbon\Carbon::parse($car->periodic_examination_expiration_date)->format('d-m-Y')}}</td>
                        <td>
                            @switch($car->state)
                            @case('active')
                                 مستلم
                                @break
                            @case('waiting')
                                 انتظار
                                @break
                            @case('blocked')
                                 مستبعد
                                @break
                            @case('pending')
                                 انتظار الموافقة 
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
<style>
    #exampleModal .table>:not(caption)>*>* {
        padding: 5px !important;
    }
  
    #exampleModal .table>:not(caption)>*>* p {
        padding: 0px !important;
        margin: 5px !important;
    }
  
    @media print {
        #divPrint {
            padding: 5px;
            margin: 5px;
        }
  
        .modal-footer {
            display: none;
        }
  
        #divPrint * {
            direction: rtl;
        }
  
    }
  </style>
<script src="{{ asset('assets/js/jQuery.print.min.js') }}"></script>
<script>
    $(function() {

                $("#printButton").on('click', function() { $.print("#divPrint");});
            });
       


   
</script>
<script src="{{ asset('assets/js/addimg.js') }}" ></script> 

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