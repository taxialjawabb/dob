@extends('index')
@section('title', 'العقد')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">العقود</h5>
    <div class="float-end mt-3">
        @if ($id!=null)
        <a href="{{url('driver/contract/'.$id)}}" class="btn btn-success rounded-0 m-0">انشاء عقد</a>
        @else
        <a href="{{url('driver/contract')}}" class="btn btn-success rounded-0 m-0">انشاء عقد</a>
        @endif
    </div>

</div>


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="panel panel-default ">
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>رقم العقد</th>
                        <th>حاله العقد</th>
                        <th>تاريخ بدايه العقد</th>
                        <th>تاريخ نهايه العقد</th>
                        <th>أضيف بواسطة</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                    <tr class="contract{{ $contract->id }}">
                        <td>
                            {{ $contract->contract_number }}
                            <input type="hidden" class="contract_id" name="contract_id" value="{{ $contract->id }}">
                        </td>

                        @if ($contract->contract_data[0]->contract_status=='لاغي')
                        <td id="statusContract">تم انهاء التعاقد</td>
                        @else
                        <td id="statusContract"> {{$contract->contract_data[0]->contract_end_datetime>=
                            \Carbon\Carbon::now()?'ساري':'منتهي' }}</td>
                        @endif

                        <td>{{ date('Y-m-d', strtotime($contract->contract_data[0]->contract_start_datetime)) }}</td>
                        <td>{{ date('Y-m-d', strtotime($contract->contract_data[0]->contract_end_datetime))}}</td>
                        <td>{{ $contract->contract_data[0]->add_by}}</td>
                        <td>
                            <a href="{{url('driver/contract/show/details/'.$contract->id)}}"
                                class="btn btn-primary rounded-1 m-0">عرض</a>
                            @if ($contract->contract_data[0]->contract_status!='لاغي')
                            <button type="button" id="contract{{ $contract->id }}"
                                class="btn btn-success extensionButton contract" data-bs-toggle="modal"
                                data-id="{{ $contract->id }}" data-bs-target="#exampleModal">تمديد</button>
                            <a href="{{ url('driver/contract/end/'.$contract->id) }}" class="btn btn-danger">انهاء
                                تعاقد</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('driver/contract/extension')}}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تمديد التعاقد</h5>

                </div>
                <div class="modal-body content1" data-id='1'>
                    <label for="">مدة التجديد باليوم</label>

                    <input type="hidden" value="{{ old('id') }}" name="contract_id" id="contract_id"
                        class="form-control" required>
                    <input type="text" value="{{ old('lease_term') }}" name="lease_term" id="in3" class="form-control"
                        required>
                    <label for=""> قيمه التجديد باليوم</label>

                    <input type="text" value="{{ old('lease_cost_dar_hour') }}" name="lease_cost_dar_hour" id="in2"
                        class="form-control" required>
                    <label for=""> الضريبه المضافه</label>
                    <input type="text" value="{{ old('main_financial_vat') }}" name="main_financial_vat" id="in1"
                        class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-primary" class="btn btn-success btnnext" data-bs-toggle="modal"
                        data-bs-target="#exampleModal2">التالي</button>
                </div>
            </form>
        </div>
    </div>
</div>






@endsection

@section('scripts')
<script>
    $(document).ready(function() {
      var listItem = $(".contract");
            for (var i = 0; i < listItem.length; i++) {
                listItem[i].addEventListener('click', function(e) {
                    var id = $("." + e.target.id + " .contract_id").val();
                    $("#contract_id").val(id);
                });
            }



                  $(".extensionButton").click(function(){ // Click to only happen on announce links
                $("#idcontract").val($(this).data('id'));

              });
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
