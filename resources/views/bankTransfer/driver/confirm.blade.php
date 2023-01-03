
@extends('index')
@section('title','ـاكيد حفظ سند')
@section('content')

<h5 class="mt-4">تأكيد حفظ سند للسائق : {{ $d['name'] }}</h5>

<form  method="POST" action="{{ url('bank/transfer/driver/add') }}">
    @csrf
    <input type="hidden" id="driver_id" name="driver_id" value="{{ $d['driver_id'] }}" required>
    <input type="hidden" id="banktransfer_id" name="banktransfer_id" value="{{ $d['id'] }}" required>
    <div class="row" id="printable">
        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="bond_type" class="form-label">نوع السند</label>
            <select value="{{ old('bond_type') }}" name="bond_type" id="bond_type" class="form-select" aria-label="Default select example" id="bond_type" readonly>
                <option value="take" selected>قـبـض</option>
            </select>
        </div>
        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="payment_type" class="form-label">طريقة الدفع</label>
            <select value="{{ old('payment_type') }}" name="payment_type" id="payment_type" class="form-select" aria-label="Default select example" id="payment_type" readonly>
                <option value="bank transfer" selected>تحويل بنكى</option>
            </select>
        </div>        
        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="money" class="form-label">المبلغ</label>
            <input type="text" value="{{ $d['money'] }}" name="money" class="form-control" id="money"  readonly>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="tax" class="form-label">الضرائب</label>
            <input type="text" value="0" name="tax" class="form-control" id="tax"  readonly>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="total_money" class="form-label">المبلغ الكلى</label>
            <input type="text" value="{{ $d['money'] }}" name="total_money" class="form-control" id="total_money"  readonly>
        </div>

        <div class="row">
            <div class="mb-2 col-sm-12 col-lg-6">
                <label for="message-text" class="col-form-label">الـوصــف:</label>
                <textarea name="descrpition"  value="فاتورة أضافة رصيد عن طريق تحويل بنكى"  class="form-control" id="message-text" readonly>فاتورة أضافة رصيد عن طريق تحويل بنكى</textarea>
            </div>
        </div>

    </div>    
    <button type="submit"  class="btn btn-primary">تأكيد حفظ السند</button>
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

<div class="text-center image m-3">
    <img src="{{ asset('assets/images/drivers/banktransfer/'.$d['transfer_photo'])}}" style="width: 500px; height: 500px" id="profile-img-tag" alt="صورة السائق">
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}" ></script>   

@endsection