
@extends('index')
@section('title','إضافة جهة')
@section('content')
<div class="container">
  <h3 class="m-2 mt-4">أضافة جهة جديد</h3>
</div>
<form method="POST" action="{{ url('nathiraat/stakeholders/update') }}">
  @csrf
  <input type="hidden" name="id" value="{{ $stakeholder->id }}">
  <div class="container">
    <div class="row">
        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="name" class="form-label">اسم الجهة المعنية</label>
          <input type="text" value="{{ $stakeholder->name }}" name="name" class="form-control" id="name"  required>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div style="position: relative">
                <label for="expire_date" class="form-label">تاريخ الأنتهاء الصلاحية</label>
                <input type="text" value="{{ $stakeholder->expire_date->format('d-m-Y') }}" class="form-control input-date" id="expire_date"  required>
                <input type='hidden' name="expire_date" class="form-control expire_date"
                required />
            </div>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="commerical_register" class="form-label">رقم السجل التجاري</label>
          <input type="text" value="{{ $stakeholder->commerical_register }}" name="commerical_register" class="form-control" id="commerical_register" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="record_number" class="form-label">رقم السجل الضريبي</label>
          <input type="text" value="{{ $stakeholder->record_number }}" name="record_number" class="form-control" id="record_number" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="id_number" class="form-label">رقم هوية المنشأه</label>
          <input type="text" value="{{ $stakeholder->id_number }}" name="id_number" class="form-control" id="id_number" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="license_number" class="form-label">رقم الترخيص</label>
          <input type="text" value="{{ $stakeholder->license_number }}" name="license_number" class="form-control" id="license_number" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="license_category" class="form-label">فئه الترخيص</label>
          <input type="text" value="{{ $stakeholder->license_category }}" name="license_category" class="form-control" id="license_category" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="phone" class="form-label">رقم الهاتف/الجوال</label>
          <input type="text" value="{{ $stakeholder->phone }}" name="phone" class="form-control" id="phone" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="address" class="form-label">العنوان</label>
          <input type="text" value="{{ $stakeholder->address  }}" name="address" class="form-control" id="address" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="company_fax" class="form-label">فاكس</label>
          <input type="text" value="{{ $stakeholder->company_fax }}" name="company_fax" class="form-control" id="company_fax" >
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <label for="email" class="form-label">البريد الالكتروني</label>
          <input type="text" value="{{ $stakeholder->email }}" name="email" class="form-control" id="email" >
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
            //hijri:true
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
