@extends('index')
@section('title','إضافة مجموعة')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">أضافة عدد مركبات جديد</h3>
</div>
<form method="POST" action="{{ route('my.groups.renew', ['group' => $group]) }}">
    @csrf
    <input type="hidden" name="daily_price_vechile" id="daily_price_vechile" value="{{ $vechilePrice->vechile_price }}">
    <input type="hidden" name="days" id="days" value="{{ $days }}">
    <div class="container">
        <div class="row">

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="vechile_counter" class="form-label">عدد المركبات فى المجموعة</label>
                <input type="text" value="{{ old('vechile_counter') }}" name="vechile_counter" class="form-control"
                    id="vechile_counter" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            </div>
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="payment_type" class="form-label">طريقة الدفع</label>
                <select value="{{ old('payment_type') }}" name="payment_type" id="payment_type" class="form-select"
                    aria-label="Default select example" id="payment_type" required>
                    <option value="cash">كــاش</option>
                    <option value="bank transfer">تحويل بنكى</option>
                    <option value="electronic payment">دفع إلكترونى</option>
                </select>
            </div>
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="group_price" class="form-label">السعر </label>
                <input type="text" value="{{ old('group_price') }}" name="group_price" class="form-control"
                    id="group_price" required readonly>
            </div>

        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger m-3 mt-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <button type="submit" class="btn btn-primary m-4 ">حفظ  </button>
</form>
@endsection

@section('scripts')
<script>
    $("#vechile_counter").on('input', function() {
            var counter = new Number($(this).val());
            var daily_price = new Number($('#daily_price_vechile').val());
            var days = new Number($('#days').val());

            var total_money = counter * daily_price * days;
            $('#group_price').val(total_money);
        });
</script>
<script>
    $(function () {
        $(".input-date").hijriDatePicker({
        });

        $(".input-date").on('dp.change', function (arg) {
            let date = arg.date;
            let className = $(this).attr('id');
            $('.'+className).val(date.format("YYYY/M/D"));

            // $("#selected-date").html(date.format("YYYY/M/D") + " Hijri:" + date.format("iYYYY/iM/iD"));
        });
    });
</script>
@endsection
