@extends('index')
@section('title','فاتورة صيانة')
@section('content')
<div id="alert">

</div>



<div class="container">
    <h3 class="m-2 mt-4 ">أضافة فاتورة صيانة</h3>
    <div class="clearfix">
        <p class="h5 float-start">
            اسم السائق : {{$driver->name}}
        </p>

    </div>
</div>
<form method="POST" action="{{ url('driver/center/item/save') }}">
    <div class="row">
        <div class="mt-2  col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="counter_number" class="form-label">رقم العداد</label>
            <input type="text" value="{{ old('counter_number') }}" name="counter_number" class="form-control counter_number" id="counter_number"  required>
        </div>
        <div class="mt-4   col-sm-12 col-md-6 col-lg-6 col-xl-6" id="counter_number_alert">
        </div>
    </div>
    @csrf

    <input type="hidden" name="driver_id" value="{{ $driver->id }}">
    <input type="hidden" name="vechile_id" value="{{ $driver->current_vechile }}">
    <table class="table table-striped table-sm table-bordered-1 " style="display: none" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الخدمة</th>
                <th scope="col">الكمية</th>
                <th scope="col">الزيادة</th>
                <th scope="col">السعر الإضافى</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <tr id="table">
                <th scope="row"></th>
                <td>الإجمالى</th>
                <td colspan="3"><span></span> ريال سعودى</td>
                <td>
                    <button type="submit" id="save-bill" class="btn btn-primary">حفظ الفاتورة</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<form method="POST" id="myform" action="{{ url('driver/center/item') }}">
    @csrf

    <input type="hidden" name="driver_id" value="{{ $driver->id }}">
    <input type="hidden" name="vechile_id" value="{{ $driver->current_vechile }}">
    <div class="panel mycontainer panel-default row">

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="main-category" class="form-label">نوع الخدمة</label>
            <select name="service" id="service"   class="tools form-select  " required>
                <option    disabled value="" selected hidden>حدد نوع الخدمة </option>
                @foreach($services as $c)
                <option value="{{$c->id}}">{{$c->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="quantity" class="form-label">الكمية</label>
            <input type="text" value="{{ old('quantity') }}" name="quantity" class="form-control quantity" id="quantity"  required>
        </div>
        <div class="mt-4  col-12 ">
            <button type="submit" class="btn btn-primary p-2 pl-6 mt-4 pr-6" id="save-changes">أضافة خدمة </button>
        </div>

    </div>

</form>


@endsection

@section('scripts')
<script>
    function finalBill(service, service_id, quantity, price, bons)
    {
        this.service=service;
        this.service_id=service_id;
        this.quantity=quantity;
        this.price=price;
        this.bons=bons;
    }
    $(document).ready( function () {
        var index = 1;
        var counterReaded = false;
        // $('table').hide();
        const finalBalls = [];
        // $(document).on("keyup paste", '.quantity', function(){
        //         this.value = this.value.replace(/\D/g,'');
        //     });

            $(document).on("click", '#save-changes', function(e){

                e.preventDefault();
                $('#alert').html('');
                var covenant = $("#myform").serializeArray();

                let x = finalBalls.find(finalBall => finalBall.service_id == $('#service').val())
                if(x !== undefined){
                    $('#alert').html('<div class="alert alert-danger m-3">هذا العنصر موجود بالفعل فى الفاتورة </div>');
                }
                else if (covenant.length != 5)
                {
                    $('#alert').html('<div class="alert alert-danger m-3">الرجاء ادخال جميع البيانات</div>');
                }
                else  if (covenant[3].value === '')
                {
                    $('#alert').html('<div class="alert alert-danger m-3">الرجاء تحديد نوع الخدمة</div>');
                }
                else if (covenant[4].value == '' || covenant[4].value <= 0)
                {
                    $('#alert').html('<div class="alert alert-danger m-3">الرجاء ادخال الكمية او عدد الخدمة رقم صحيح</div>');
                }
                else{
                    $(this).attr('disabled');
                    if(counterReaded === false){
                    var counter_number = $("#counter_number");
                    counter_number.attr('readonly', true);
                    counterReaded = true;
                    covenant[5] = {name: 'counter_number', value: counter_number.val()};
                    console.log(covenant);

                    }
                    $.ajax({
                    type: 'post',
                    url: '{!! URL::to("maintenance/center/item") !!}',
                    data: covenant,
                    success: function(data){
                        console.log(data);
                        // return 0;
                        if(data.success){
                            if(data.message !== ''){
                                $("#counter_number_alert").html('<div class="alert alert-danger"> '+data.message+' </div>');
                            }
                            finalBalls.push(new finalBill(data.data.service, data.data.service_id, data.data.quantity, data.data.price, data.data.bons));
                            $('#table').before(`
                            <tr class='row${index}'>
                                <th scope="row">
                                    ${index}
                                </th>
                                <td>
                                    ${data.data.service}
                                    <input type="hidden" name="service_id[]" value="${data.data.service_id}">
                                </td>
                                <td>
                                    ${data.data.quantity}
                                    <input type="hidden" name="quantity[]" value="${data.data.quantity}">
                                    <input type="hidden" name="bons[]" value="${data.data.bons}">
                                </td>
                                <td>
                                    ${data.data.bons}
                                </td>
                                <td>
                                    ${data.data.price}
                                    <input type="hidden" name="price[]" value="${data.data.price}">
                                </td>
                                <td>
                                    <a href='#' class="btn text-primary remove" id="row${index}"> إزالة</a>
                                </td>
                            </tr>
                            `);
                            $('#table span').html(`
                                <input type="hidden" name="total_price" value="${totalPrice()}">
                                ${totalPrice()}
                                `);
                            index++;
                            $('table').show();
                            $(this).attr('enabled');
                        }else{
                            $('#alert').html('<div class="alert alert-danger m-3">'+data.message+'</div>');
                        }
                        $("#myform")[0].reset();
                    },
                    error:function(e){
                        console.log('error');
                        console.log(e);
                    }
                    });
                }
            });

            $(document).on("click",".remove", function (e) {
                $('#alert').html('');
                let element =  $( '.'+e.target.id);
                element.hide();

                var data = $('.'+e.target.id +" input").serializeArray();
                for( var i = 0; i < finalBalls.length; i++){
                    if ( finalBalls[i].service_id === parseInt(data[0].value)) {
                        finalBalls.splice(i, 1);
                        i--;
                    }
                }
                index = 1;
                if(finalBalls.length !== 0){
                    $('table tbody').html('');
                    for( var i = 0; i < finalBalls.length; i++){
                        $('table tbody').append(`
                                <tr class='row${index}'>
                                    <th scope="row">
                                        ${index}
                                    </th>
                                    <td>
                                        ${finalBalls[i].service}
                                        <input type="hidden" name="service_id[]" value="${finalBalls[i].service_id}">
                                    </td>
                                    <td>
                                        ${finalBalls[i].quantity}
                                        <input type="hidden" name="quantity[]" value="${finalBalls[i].quantity}">
                                        <input type="hidden" name="bons[]" value="${finalBalls[i].bons}">
                                    </td>
                                    <td>
                                        ${finalBalls[i].bons}
                                    </td>
                                    <td>
                                        ${finalBalls[i].price}
                                        <input type="hidden" name="price[]" value="${finalBalls[i].price}">
                                    </td>
                                    <td>
                                        <a href='#' class="btn text-primary remove" id="row${index}"> إزالة</a>
                                    </td>
                                </tr>
                        `);
                        index++;

                    }
                    $('table tbody').append(`
                    <tr id="table">
                        <th scope="row"></th>
                        <td>الإجمالى</th>
                        <td colspan="3"><span>
                            <input type="hidden" name="total_price" value="${totalPrice()}">
                            ${totalPrice()}</span> ريال سعودى</td>
                        <td>
                            <button type="submit" id="save-bill" class="btn btn-primary">حفظ الفاتورة</button>
                        </td>
                    </tr>
                    `);
                }else{
                    $('table').hide();
                }

        });
        function totalPrice(){
            var total = 0;
            finalBalls.forEach(element => {
                total +=element.price;
            });
            return total;
        }
        // $("#save-bill").on('click', function(e){
        //     e.preventDefault();
        //     $.ajax({
        //             type: 'post',
        //             url: '{!! route("items", ['+
        //             JSON.stringify($finalBalls+)']) !!}',
        //             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //             data: finalBalls,
        //             success: function(data){
        //                 console.log(data);

        //             },
        //             error:function(e){
        //                 console.log('error');
        //                 console.log(e);
        //             }
        //             });
        // });
    });

</script>



@endsection

@section('scripts')

@endsection
