
@extends('index')
@section('title','أضافة سند')
@section('content')

<h5 class="mt-4">أضافة سند </h5>

<form  method="POST" action="{{ url('manage/groups/box/add') }}">
    @csrf
    <input type="hidden" id="group_id" name="group_id" value="{{ $group->id }}" required>
    <div class="row" id="printable">
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
                {{-- <option value="internal transfer">تحويل داخلى</option> --}}
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

    </div>
    <button type="submit"  class="btn btn-primary">حفظ السند</button>
</form>
<!-- <button id="print">print</button> -->
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
<script>
    $(document).ready(function(){
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
