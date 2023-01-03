
@extends('index')
@section('title','أضافة سند')
@section('content')

<h5 class="mt-4">أضافة سند للمركبة</h5>

<form  method="POST" action="{{ url('vechile/box/add/'. $vechile->id) }}"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="stakeholder_id" name="vechile_id" value="{{ $vechile->id }}" required>
    <div class="row">
        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="bond_type" class="form-label">نوع السند</label>
            <select value="{{ old('bond_type') }}" name="bond_type" id="bond_type" class="form-select" aria-label="Default select example" id="bond_type" required>
                <option value="take">قـبـض</option>
                <option value="spend">صــرف</option>
            </select>
        </div>
        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="payment_type" class="form-label">طريقة الدفع</label>
            <select value="{{ old('payment_type') }}" name="payment_type" id="payment_type" class="form-select" aria-label="Default select example" id="payment_type" required>
                <option value="cash">كــاش</option>
                <option value="bank transfer">تحويل بنكى</option>
                <option value="internal transfer">تحويل داخلى</option>
                <option value="selling points">نقاط بيع</option>
                <option value="electronic payment">دفع إلكترونى</option>
            </select>
        </div>
        <div class="row" id="internal-transfer" style="display: none">
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="stakeholder" class="form-label">الجهة المستهدفة</label>
                <select value="{{ old('stakeholder') }}" name="stakeholder" id="stakeholder" class="form-select" aria-label="Default select example" id="stakeholder">
                    <option value="" selected disabled>حدد الجهة المستهدفة</option>
                    <option value="driver">السائقين</option>
                    <option value="vechile">المركبات</option>
                    <option value="rider">العملاء</option>
                    <option value="user">المستخدمين</option>
                    <option value="stakeholder">الجهات</option>
                </select>
            </div>
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="user" class="form-label">الشخص او الجهة المستهدفة</label>
                <select value="{{ old('user') }}" name="user" id="user" class="form-select" aria-label="Default select example" id="user" >
                    <option value="" selected disabled>حدد الشخص المستهدف</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="money" class="form-label">المبلغ</label>
            <input type="text" value="{{ old('money') }}" name="money" class="form-control" id="money"  required>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="tax" class="form-label">الضرائب</label>
            <input type="text" value="{{ old('tax') ?? 0 }}" name="tax" class="form-control" id="tax"  required>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="total_money" class="form-label">المبلغ الكلى</label>
            <input type="text" value="{{ old('total_money') }}" name="total_money" class="form-control" id="total_money"  disabled>
        </div>

        <div class="row">
            <div class="mb-2 col-sm-12 col-lg-6">
                <label for="message-text" class="col-form-label">الـوصــف:</label>
                <textarea name="descrpition"  value="{{ old('descrpition') }}"  class="form-control" id="message-text" required>{{ old('descrpition') }}</textarea>
            </div>
        </div>

        <div id="spend_bond">
            <div class="row" style="display: none">
                <div class="mb-3 mt-4 ">
                    <label for="formFile" class="form-label">صورة فاتور الصرف</label>
                    <input class="form-control" type="file" name="image"  id="file">
                </div>
                <div class="text-center image">
                    <img src="{{ asset('assets/images/pleaceholder/image.png')}}" style="width: 200px; height: 200px" id="profile-img-tag" alt="صورة السائق">
                </div>
            </div>
        </div>

    </div>    
    <button type="submit" class="btn btn-primary">حفظ السند</button>
</form>
@if ($errors->any())
    <div class="alert alert-danger m-3 mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  
@endsection

@section('scripts')

<script src="{{ asset('assets/js/addimg.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on("change", '#bond_type', function() {
            var bond_type = $(this).val();
            if (bond_type === 'spend') {
                $('#spend_bond div').show();
                $('#spend_bond div #file').attr('required',true);
            } else {
                $('#spend_bond div').hide();
                $('#spend_bond div #file').attr('required',false);
            }
        });


        $(document).on("change", '#payment_type', function() {
            var payment_type = $(this).val();
            if(payment_type === 'internal transfer'){
                $("#internal-transfer").show();
                $('#stakeholder').prop('required',true);
                $('#user').prop('required',true);
            }else{
                $("#internal-transfer").hide();
                $('#stakeholder').prop('required',false);
                $('#user').prop('required',false);
            }
        });

        $(document).on("change", '#stakeholder', function(){
        var stakeholder = $(this).val();
        var stakeholder_id = $("#stakeholder_id").val();
        var op = " ";
        $.ajax({
            type: 'get',
            url: '{!!URL::to("stakeholders/show")!!}',
            data: {'from': 'vechile', 'to':stakeholder, 'id': stakeholder_id},
            success: function(data){
                console.log(data);
                
            op += '<option value="" selected disabled>حدد الشخص المستهدف</option>';
            for(var i =0 ; i < data.length; i++){
              op += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#user").html(op);
          },
          error:function(e){
            console.log('error');
            console.log(e);
          }
        });
      });

        $("#tax").focus(function(){
            $(this).val('');
        });
        $("#tax ,#money").on('input',function(){
            var money = new Number($('#money').val());
            var percentage =new Number( $("#tax").val()/100) ;
            var tax = percentage * money;
            var total_money = money + tax;
            $('#total_money').val(total_money);
        });
    });
</script>
@endsection