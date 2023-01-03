
@extends('index')
@section('title','الصندوق العام')
@section('content')

<div class="mt-2">
    <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>

  </div>
<div class="container clearfix">
    <h5 class=" mt-4 float-start">الـصـنـدوق الــعــام</h5>
    <input type="hidden" name="groupId" value="{{ $group->id }}">
</div>
<div class="clearfix "></div>
<div class="container">
    <div class="clearfix">
        <div class="float-start">
            <h6 style="margin: 10px">
                إجمالي القبض
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{$box[0]->take_money ?? 0 }}
            </div>
        </div>
        <div class="float-start">
            <h6 style="margin: 10px">
                إجمالي الصرف
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{$box[0]->spend_money ?? 0 }}
            </div>
        </div>
        <div class="float-start text-center">
            <h6 style="margin: 10px">
                الأجــمــالـــي
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{$box[0]->take_money  - $box[0]->spend_money }}
            </div>
        </div>
        {{-- <div class="float-end">
            <form action="{{ url('general/box') }}" method="GET">
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
        </div> --}}
    </div>
</div>
                <div class="panel panel-default mt-4">
                        <div class="table-responsive">
                            <table class="table " id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th >إضيف بواسطة</th>
                                        <th>تاريخ الإضافة</th>
                                        <th>اجمالى القبض</th>
                                        <th>اجمالى الصرف</th>
                                        <th>اجمالى المتبقى</th>
                                        <th>عدد الفواتير</th>
                                        <th>
                                            عرض
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @foreach($data as $index=>$bill)
                                    <tr class="bill{{ ++$index }}">
                                        <td class="id" id="{{ $bill->id }}">{{ $index }}</td>
                                        <td class="name">{{ $bill->name }}</td>
                                        <td class="date">{{ $bill->added_date }}</td>
                                        <td>{{ $bill->take_money}}</td>
                                        <td>{{ $bill->spend_money}}</td>
                                        <td>{{ $bill->take_money - $bill->spend_money}}</td>
                                        <td class="bonds">{{ $bill->take_bonds + $bill->spend_bonds}}</td>
                                        <td>
                                            <input type="button" id="bill{{ $index }}" class="btn btn-primary m-1 showBonds"  value="عـرض">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
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
                    <th scope="col">وقت الإضافة</th>
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
    var listItem = $(".showBonds");
    for(var i =0 ; i < listItem.length; i++){
        listItem[i].addEventListener('click', function(e){
                e.preventDefault();
                var id =  $('.'+e.target.id + ' .id').attr('id');
                var date = $('.'+e.target.id + ' .date').html();
                var bonds = $('.'+e.target.id + ' .bonds').html();
                var id = $("input[name=groupId]").val();

                var url = '{{ route("shared.groups.general.box.search", ':id') }}';
                var url = url.replace(':id', id);
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                            "_token": "{{ csrf_token() }}",
                            'id':id,
                            'date':date,
                            'bonds':bonds
                        },
                    success: function(data){
                        // console.log(data);
                        // return 0;
                        var htmlContent = '';
                        var type ='';
                        var payment_type ='';
                        var depositedBy ='';
                        var depositedDate ='';
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

                            depositedBy = ( data[index].depositedBy !== null)?data[index].depositedBy: '';
                            depositedDate = ( data[index].deposit_date !== null)?data[index].deposit_date: '';
                            htmlContent += `<tr>
                                                <th scope="row">`+data[index].id+`</th>
                                                <td>`+data[index].type+`</td>
                                                <td>`+data[index].name+`</td>
                                                <td>`+type+`</td>
                                                <td>`+payment_type+`</td>
                                                <td>`+data[index].total_money+`</td>
                                                <td>`+data[index].descrpition+`</td>
                                                <td>`+depositedDate+`</td>
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
                dom: 'Blfrtip',
                buttons: [
                            // { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                            { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                            // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                            // { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                        ],
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


    </script>
<script>
    $(document).ready(function(){
        $("#from_date , #to_date").on('change', function(){
            var startDate = $("#from_date").val();
            var endDate = $("#to_date").val();
        if(startDate !== '' && endDate !== ''){
            $.ajax({
                    type: 'post',
                    url: "",
                    data: {
                            "_token": "{{ csrf_token() }}",
                            'from' : startDate,
                            'to' : endDate,
                        },
                    success: function(data){
                        console.log(data);
                    },
                    error:function(e){
                        console.log('error');
                        console.log(e);
                    }
                    });
        }
        });
    });
</script>
@endsection

