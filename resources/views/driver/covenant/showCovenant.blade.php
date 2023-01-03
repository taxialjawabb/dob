
@extends('index')
@section('title','العهد ')
@section('content')
<div class="container clearfix">
    <h3 class="m-2 mt-4 float-start">عرض  العهد المستلمة للسائق</h3>
    <div class="float-end">
        @if(Auth::user()->isAbleTo('driver_add_convenant')||Auth::user()->isAbleTo('user_group')||Auth::user()->isAbleTo('manage_group')) 
        <a href="#" class="btn btn-primary rounded-0 m-0 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">اضافة عهد للسائق</a>
        @endif
    </div>
</div>

                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم </th>
                                    <th>العهده </th>
                                    <th>رقم التسلسلى </th>
                                    <th>حالة العهدة</th>
                                    <th>تاريخ التسلم</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($covenants as $covenant)
                                <tr>
                                    <td>{{ $covenant->id }}</td>
                                    <td>{{ $covenant->covenant_name }}</td>
                                    <td>{{ $covenant->serial_number }}</td>
                                    <td>
                                    @switch($covenant->state)
                                        @case('active')
                                            مستلمة
                                            @break
                                        @case('waiting')
                                            المخزن          
                                            @break
                                        @case('broken')
                                            معطلة
                                            @break
                                        @default
                                            غير مستلمة
                                    @endswitch
                                    </td>
                                    <td>{{ $covenant->delivery_date }}</td>
                                    <td>
                                        @if(Auth::user()->isAbleTo('driver_show_convenant_note')) 
                                        <a href="{{ url('covenant/show/note/'.$covenant->id) }}" class="btn btn-primary">الملاحظات</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="container-fluid mt-1 element-center" id="printable">
            <p  class="mb-1 mt-3 pt-1 text-center "  style="color: black; font-size: 16px;">أضافة عهد للسائق</p>
            <form  method="POST" action="{{ url('covenant/delivery/add') }}" id='form'>
                <input type="hidden" class="id"  name="id" value="{{$id}}" required>
                @csrf
                <p >الارقام التسلسلية</p>
                <div class="container mycontainer row">
                    <div class="col-12 ">
                        <label for="main-category" class="form-label">نوع العهده</label>
                        <select name="covenant_name" id="covenant_name" class="form-select mycovenant" required>
                            <option  disabled value="" selected hidden> حدد نوع العهده </option>
                            @foreach($allCovenant as $c)
                            <option value="{{$c->covenant_name}}">{{$c->covenant_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-12 ">
                        <label for="secondary-category" class="form-label">العهد المستلمة</label>
                        <select  name="covenant_item" id="covenant_item" class="form-select" required>
                            <option  disabled value="" selected hidden> حدد العهده المستلمة</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
            </form>
        </div>  
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
      $(document).on("change", '#covenant_name', function(){
        var covenant = $(this).val();
        var op = " ";
        $.ajax({
          type: 'get',
          url: '{!!URL::to("covenant/select/item")!!}',
          data: {'id':covenant},
          success: function(data){
             op += '<option  disabled value="" selected hidden> حدد العهده المستلمة</option>';
            for(var i =0 ; i < data.length; i++){
                var serial = data[i].serial_number == null ? 'لا يوجد رقم تسلسلى': data[i].serial_number;
                op += '<option value="'+data[i].id+'">'+data[i].id+' : '+serial+'</option>';
            }
            $("#covenant_item").html(op);
          },
          error:function(e){
            console.log('error');
            console.log(e);
          }
        });
      });
    });
  </script>

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
                    "sLengthMenu": "عـرض _MENU_ العهد",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض العهد من _START_ إلى _END_ من إجمالي _TOTAL_ من عهده",
                    "sInfoEmpty": "عرض العهد من 0 إلى 0 من إجمالي 0 عهده",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من العهد)",
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