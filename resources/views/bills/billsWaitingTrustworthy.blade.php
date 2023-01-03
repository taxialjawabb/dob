
@extends('index')
@section('title','الفواتير')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">فـواتـيـر بإنتظار الأعتماد</h5>
    <div class="float-end mt-3">        
        
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
                <div class="panel panel-default mt-4">
                        <div class="table-responsive">
                            <table class="table " id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>تأكيد بواسطة</th>
                                        <th>تاريخ الاضافة</th>
                                        <th>اجمالى القبض</th>
                                        <th>اجمالى الصرف</th>
                                        <th>اجمالى المتبقى</th>
                                        <th>عدد الفواتير</th>
                                        <th>
                                            اعتماد
                                            {{-- <button id="confirm-all" class="btn btn-light m-0 p-0">تحديد الجميع</button>
                                            <button type="submint" class="btn btn-primary">تأكيد الفواتير المحددة</button> --}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bills as $index=>$bill)
                                    <tr class="bill{{ ++$index }}">
                                        <td class="id" id="{{ $bill->id }}">{{ $index }}</td>
                                        <td class="name">{{ $bill->name }}</td>
                                        <td class="date">{{ $bill->confirmed_date }}</td>
                                        <td>{{ $bill->take_money}}</td>
                                        <td>{{ $bill->spend_money}}</td>
                                        <td>{{ $bill->take_money - $bill->spend_money}}</td>
                                        <td class="bonds">{{ $bill->take_bonds + $bill->spend_bonds}}</td>
                                        <td>
                                            @if(Auth::user()->isAbleTo('bill_trustworthy'))   
                                            <input type="button" id="bill{{ $index }}" class="btn btn-primary m-1 checkbox"  value="اعتماد">
                                            @endif
                                            @if(Auth::user()->isAbleTo('bill_trustworthy_show'))   
                                            <input type="button" id="bill{{ $index }}" class="btn btn-primary m-1 showBonds"  value="عـرض">
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </form>


<!-- Modal -->
 
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="modal-body" class="modal-body table-responsive">
            <table class="table table-striped ">
                <thead>
                  <tr>
                    <th scope="col">رقم السند</th>
                    <th scope="col">الجهة</th>
                    <th scope="col">الاسم</th>
                    <th scope="col">نوع السند</th>
                    <th scope="col">طريقة الدفع</th>
                    <th scope="col">المبلغ</th>
                    <th scope="col">الوصف</th>
                    <th scope="col">وقت التأكيد</th>
                    <th scope="col">تأكيد بواسطة</th>
                  </tr>
                </thead>
                <tbody>
                 
                </tbody>
              </table>
              
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
    $(function() {

    var listItem = $(".checkbox");
    for(var i =0 ; i < listItem.length; i++){
        listItem[i].addEventListener('click', function(e){
                e.preventDefault();
                $(this).attr('disabled','true');
                var id =  $('.'+e.target.id + ' .id').attr('id');
                var date = $('.'+e.target.id + ' .date').html();
                var bonds = $('.'+e.target.id + ' .bonds').html();
                $.ajax({
                    type: 'post',
                    url: '{!!URL::to("bills/waiting/trustworthy")!!}',
                    data: {
                            "_token": "{{ csrf_token() }}",
                            'id':id,
                            'date':date,
                            'bonds':bonds
                        },
                    success: function(data){
                        if(data == 1){
                            $('.'+e.target.id ).hide();
                        }else{
                            alert(' الرجاء المحاولة مرة ');
                        }
                    },
                    error:function(e){
                        console.log('error');
                        console.log(e);
                    }
                    });
        }); 
    }

    var listItem = $(".showBonds");
    for(var i =0 ; i < listItem.length; i++){
        listItem[i].addEventListener('click', function(e){
                e.preventDefault();
                var id =  $('.'+e.target.id + ' .id').attr('id');
                var date = $('.'+e.target.id + ' .date').html();
                var bonds = $('.'+e.target.id + ' .bonds').html();
                $.ajax({
                    type: 'post',
                    url: '{!!URL::to("bills/waiting/trustworthy/show")!!}',
                    data: {
                            "_token": "{{ csrf_token() }}",
                            'id':id,
                            'date':date,
                            'bonds':bonds
                        },
                    success: function(data){
                        var htmlContent = '';
                        var type ='';
                        var payment_type ='';
                        var confirmedBy ='';
                        for (let index = 0; index < data.length; index++) {
                            type = ( data[index].bond_type == 'take')?'قبض': 'صرف';
                            switch(data[index].payment_type){
                                case 'cash':payment_type = ' كــاش'; break ;
                                case 'bank transfer':payment_type = ' تحويل بنكى'; break ;
                                case 'internal transfer':payment_type = ' تحويل داخلى'; break ;
                                case 'selling points':payment_type = ' نقاط بيع'; break ;
                                case 'electronic payment':payment_type = ' دفع إلكترونى'; break ;
                                default:  break;
                            }
                            
                            confirmedBy = ( data[index].confirmedBy !== null)?data[index].confirmedBy: '';
                            htmlContent += `<tr>
                                                <th scope="row">`+data[index].id+`</th>
                                                <td>`+data[index].type+`</td>
                                                <td>`+data[index].name+`</td>
                                                <td>`+type+`</td>
                                                <td>`+payment_type+`</td>
                                                <td>`+data[index].total_money+`</td>
                                                <td>`+data[index].descrpition+`</td>
                                                <td>`+data[index].confirm_date+`</td>
                                                <td>`+confirmedBy+`</td>                                                
                                            </tr>`;
                        }

                        $('#exampleModal table tbody').html(htmlContent);
                        $('#exampleModal').modal('show');

                    },
                    error:function(e){
                        console.log('error');
                        console.log(e);
                    }
                    });
        }); 
    }

    });
</script>
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