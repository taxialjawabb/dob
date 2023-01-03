
@extends('index')
@section('title','إضافة جهة')
@section('content')
<div class="container">
  <h3 class="m-2 mt-4">أضافة جهة جديد</h3>
</div>
<form method="POST" action="{{ url('nathiraat/stakeholders/add') }}">
  @csrf
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="mt-4 ">
          <label for="name" class="form-label">اسم الجهة المعنية</label>
          <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name"  required>
        </div>

        <div class="mt-4 ">
          <label for="record_number" class="form-label">رقم السجل</label>
          <input type="text" value="{{ old('record_number') }}" name="record_number" class="form-control" id="record_number" >
        </div>

        <div class="mt-4 ">
            <div style="position: relative">
                <label for="expire_date" class="form-label">تاريخ الأنتهاء</label>
                <input type="text" value="{{ old('expire_date') }}" name="expire_date" class="form-control input-date" id="expire_date"  required>
                <input type='hidden' name="expire_date" class="form-control expire_date"
                required />
            </div>
        </div>
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
  <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات </button>
</form>
@endsection

@section('scripts')
<script>
    $(function () {
        $(".input-date").hijriDatePicker({
            hijri:true
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
