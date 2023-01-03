@extends('index')
@section('title','السندات')
@section('content')
<div class="mt-2">
    <a href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}}
    </a>
    <i class="arrow left "></i>
    <a href="{{ url('shared/groups/show/vechiles/'.$group->id) }}" class="btn text-primary p-1 ">المركبات</a>
    <i class="arrow left "></i>
    <a href="{{ url($vechile->group_id === null? 'vechile/details/' . $vechile->id:'shared/groups/vechile/detials/'.$vechile->id .'/'. $vechile->group_id) }}"
        class="btn text-primary p-1">{{$vechile->name}}</a>

</div>
<div class="container clearfix">
    <h5 class=" mt-4 float-start">عرض السندات من النوع <span class="bond-type">{{$type === 'take'?
            'قـبـض':'صــرف'}}</span></h5>
    <div class="float-end mt-3">
        <a href="{{ route('shared.groups.vechile.box.show', [ 'vechile'=> $vechile, 'group'=>$group,'type' => 'take'])  }}"
            class="btn {{$type === 'take'? 'btn-primary': ''}} rounded-0 m-0">قـبـض</a>
        <a href="{{ route('shared.groups.vechile.box.show', [ 'vechile'=> $vechile, 'group'=>$group,'type' => 'spend'])  }}"
            class="btn {{$type === 'spend'? 'btn-primary': ''}} rounded-0 m-0">صــرف</a>
        <a href="{{ route('shared.groups.vechile.box.add',['vechile' => $vechile , 'group' => $group]) }}"
            class="btn btn-success rounded-0 m-0">أضـافـة سند</a>
    </div>
</div>
<div class="clearfix "></div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-5">
            <h6>
                رقم اللوحة : <span class="mt-2 bond-name">{{$vechile->plate_number}}</span>
            </h6>
        </div>
        <div class="col-xs-12 col-7">
            <h6>
                <span class="bg-warning p-2 ">
                    الرصيد الحالى :
                    {{$vechile->group_balance}}
                </span>
            </h6>
        </div>
    </div>
</div>
<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم السند</th>
                    <th>طريقة الدفع</th>
                    <th>المبلغ</th>
                    <th>الضريبة</th>
                    <th>اجمالى المبلغ</th>
                    <th>الوصف</th>
                    <th>تاريخ الأضافة</th>
                    <th>أضيف بواسطة</th>
                    <th>طباعة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bonds as $bond)
                <tr class="print{{$bond->id}}">
                    <td class="bond-id">{{ $bond->id }}</td>
                    <td class="payment-type">
                        @switch($bond->payment_type)
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
                    <td class="money">{{ $bond->money }}</td>
                    <td class="tax">{{ $bond->tax }}</td>
                    <td class="total-money">{{ $bond->total_money }}</td>
                    <td class="descrpition">{{ $bond->descrpition }}</td>
                    <td class="add-date">{{ $bond->add_date }}</td>
                    <td class="admin-name">{{ $bond->admin_name }}</td>
                    <td>
                        <button id="print{{$bond->id}}" type="button" class="btn btn-primary print"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">طباعة</button>
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
                <p class="mb-1 pt-1 element-center  text-center"
                    style="color: black; font-size: 22px; font-weight:bold">{{ $group->name }} </p>
                <p class="mb-1 pt-1 text-center " style="color: black; font-size: 16px;">فاتورة رقم * <span
                        id="bond-number"></span> * </p>
                <table class="table table-bordered element-center">
                    <thead>
                        <tr>
                            <th>
                                <p class="m-1" style="color: black; font-size: 16px;">اسم المستفيد</p>
                            </th>
                            <th colspan="3">
                                <p style="color: black; font-size: 21px;" id="bill-name">

                                </p>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p class="m-1" style="color: black; font-size: 16px;">التاريخ</p>
                            </td>
                            <td colspan="3" style="color: black; font-size: 16px;" id="bill-date">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="m-1" style="color: black; font-size: 16px;">الوصف</p>
                            </td>
                            <td colspan="3" style="color: black; font-size: 16px;" id="descrpition">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="m-1" style="color: black; font-size: 16px;">نـوع السـند</p>

                            </td>
                            <td colspan="3" style="color: black; font-size: 16px;" id="bond-type">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="m-1" style="color: black; font-size: 16px;">طريقة الدفع</p>
                            </td>
                            <td colspan="3" style="color: black; font-size: 16px;" id="payment-type">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="m-1" style="color: black; font-size: 16px;">المبلغ</p>

                            </td>
                            <td style="color: black; font-size: 16px;" id="bill-money">

                            </td>
                            <td style="color: black; font-size: 16px;">
                                <p class="m-1" style="color: black; font-size: 16px;">الضرائب%</p>
                            </td>
                            <td style="color: black; font-size: 16px;">
                                <span id="bill-tax"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="color: black; font-size: 18px;"> المبلغ الكلى</p>
                            </td>
                            <td colspan="3">
                                <p style="color: black; font-size: 18px;">
                                    <span id="total-money"></span> ريال سعودى
                                </p>
                            </td>
                        </tr>
                        <tr id="confirmed-by">
                            <td>
                                <p style="color: black; font-size: 16px;"> اسم المحصل</p>
                            </td>
                            <td colspan="3">
                                <p style="color: black; font-size: 18px;" id="admin-name">

                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center">
                                <p style="color: black; font-size: 18px;">
                                    {{ $group->city }}
                                </p>
                                <p style="color: black; font-size: 18px;">
                                    الهاتف: {{ $group->phone }}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلاق</button>
                <button type="button" class="btn btn-primary printThis">طـبـاعـة</button>
            </div>
        </div>
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
        #printable {
            padding: 5px;
            margin: 5px;
        }

        .modal-footer {
            display: none;
        }

        #exampleModal * {
            direction: rtl;
        }

    }
</style>

<script src="{{ asset('assets/js/jQuery.print.min.js') }}"></script>
<script>
    $(function() {

            var listItem = $(".print");
            for(var i =0 ; i < listItem.length; i++){
                listItem[i].addEventListener('click', function(e){
                    var id = $("."+e.target.id+" .bond-id").text();
                    var bondName = $(".bond-name").text();
                    var bondType = $(".bond-type").text();
                    var  paymentType= $("."+e.target.id+" .payment-type").text();
                    var money = $("."+e.target.id+" .money").text();
                    var tax = $("."+e.target.id+" .tax").text();
                    var totalMoney = $("."+e.target.id+" .total-money").text();
                    var descripition = $("."+e.target.id+" .descrpition").text();
                    var addDate = $("."+e.target.id+" .add-date").text();
                    var adminName = $("."+e.target.id+" .admin-name").text();
                    $("#bond-number").text(id);
                    $("#bill-name").text(bondName);
                    $("#bill-date").text(addDate);
                    $("#descrpition").text(descripition);
                    $("#bond-type").text(bondType);
                    $("#payment-type").text(paymentType);
                    $("#bill-money").text(money);
                    $("#bill-tax").text(tax);
                    $("#total-money").text(totalMoney);
                    if(adminName == ""){
                        $("#confirmed-by").hide();
                    }
                    else{
                        $("#confirmed-by").show();
                    }

                    $("#admin-name").text(adminName);
                    // $("#").text(bondName);
                    $("#exampleModal").find('.printThis').on('click', function() {
                        $.print("#exampleModal");
                    });
                });
            }


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
                    "sLengthMenu": "عـرض _MENU_ السندات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض السندات من _START_ إلى _END_ من إجمالي _TOTAL_ من سند",
                    "sInfoEmpty": "عرض السندات من 0 إلى 0 من إجمالي 0 سند",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من السندات)",
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
