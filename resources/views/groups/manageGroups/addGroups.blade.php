@extends('index')
@section('title','إضافة مجموعة')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">أضافة مجموعة جديد</h3>
</div>
<form method="POST" action="{{ route('manage.groups.add') }}">
    @csrf

    <div class="container">
        <div class="row">
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="name" class="form-label">اسم المنشأة</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name" required>
            </div>


            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="city" class="form-label">اسم المدينة</label>
                <select value="{{ old('city') }}" name="city" id="city" class="form-select" aria-label="Default select example" id="city" required>
                    <option value="" selected disabled>حدد المدينة</option>
                    <option value="الرياض" {{ old('city') == 'الرياض' ? 'selected' : '' }}>الرياض </option>
                    <option value="جدة" {{ old('city') == 'جدة' ? 'selected' : '' }}>جدة </option>
                    <option value="مكه" {{ old('city') == 'مكه' ? 'selected' : '' }}>مكه </option>
                    <option value="المدينة المنورة" {{ old('city') == 'المدينة المنورة' ? 'selected' : ''
                            }}>المدينة المنورة </option>
                    <option value="الدمام" {{ old('city') == 'الدمام' ? 'selected' : '' }}>الدمام </option>
                    <option value="الهفوف" {{ old('city') == 'الهفوف' ? 'selected' : '' }}>الهفوف </option>
                    <option value="بريده" {{ old('city') == 'بريده' ? 'selected' : '' }}>بريده </option>
                    <option value="الحله" {{ old('city') == 'الحله' ? 'selected' : '' }}>الحله </option>
                    <option value="الطائف" {{ old('city') == 'الطائف' ? 'selected' : '' }}>الطائف </option>
                    <option value="تبوك" {{ old('city') == 'تبوك' ? 'selected' : '' }}>تبوك </option>
                    <option value="خميس مشيط" {{ old('city') == 'خميس مشيط' ? 'selected' : '' }}>خميس مشيط
                    </option>
                    <option value="حائل" {{ old('city') == 'حائل' ? 'selected' : '' }}>حائل </option>
                    <option value="القطيف" {{ old('city') == 'القطيف' ? 'selected' : '' }}>القطيف </option>
                    <option value="المبرز" {{ old('city') == 'المبرز' ? 'selected' : '' }}>المبرز </option>
                    <option value="الخرج" {{ old('city') == 'الخرج' ? 'selected' : '' }}>الخرج </option>
                    <option value="نجران" {{ old('city') == 'نجران' ? 'selected' : '' }}>نجران </option>
                    <option value="ينبع" {{ old('city') == 'ينبع' ? 'selected' : '' }}>ينبع </option>
                    <option value="ابها" {{ old('city') == 'ابها' ? 'selected' : '' }}>ابها </option>
                    <option value="عرعر" {{ old('city') == 'عرعر' ? 'selected' : '' }}>عرعر </option>
                    <option value="جزان" {{ old('city') == 'جزان' ? 'selected' : '' }}>جزان </option>
                    <option value="سكاكا" {{ old('city') == 'سكاكا' ? 'selected' : '' }}>سكاكا </option>
                    <option value="الباحه" {{ old('city') == 'الباحه' ? 'selected' : '' }}>الباحه </option>
                    <option value="اخري" {{ old('city') == 'اخري' ? 'selected' : '' }}>اخري </option>
                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="commercial_register" class="form-label">رقم السجل التجاري </label>
                <input type="text" value="{{ old('commercial_register') }}" name="commercial_register" class="form-control" id="commercial_register" >
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                  <div style="position: relative">
                      <label for="expired_date_commercial_register" class="form-label">تاريخ أنتهاء رقم السجل التجاري </label>
                      <input type="text" value="{{ old('expired_date_commercial_register') }}" name="expired_date_commercial_register" class="form-control input-date" id="expired_date_commercial_register"  required>
                      <input type='hidden' name="expired_date_commercial_register" class="form-control expired_date_commercial_register"
                      required />
                  </div>
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="transportation_license_number" class="form-label">رقم ترخيص هيئة النقل</label>
                <input type="text" value="{{ old('transportation_license_number') }}" name="transportation_license_number" class="form-control" id="transportation_license_number" >
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                  <div style="position: relative">
                      <label for="expired_date_transportation_license_number" class="form-label">تاريخ أنتهاء رقم ترخيص هيئة النقل</label>
                      <input type="text" value="{{ old('expired_date_transportation_license_number') }}" name="expired_date_transportation_license_number" class="form-control input-date" id="expired_date_transportation_license_number"  required>
                      <input type='hidden' name="expired_date_transportation_license_number" class="form-control expired_date_transportation_license_number"
                      required />
                  </div>
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="municipal_license_number" class="form-label">رقم رخصة البلدية</label>
                <input type="text" value="{{ old('municipal_license_number') }}" name="municipal_license_number" class="form-control" id="municipal_license_number" >
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                  <div style="position: relative">
                      <label for="expired_date_municipal_license_number" class="form-label">تاريخ أنتهاء رقم رخصة البلدية</label>
                      <input type="text" value="{{ old('expired_date_municipal_license_number') }}" name="expired_date_municipal_license_number" class="form-control input-date" id="expired_date_municipal_license_number"  required>
                      <input type='hidden' name="expired_date_municipal_license_number" class="form-control expired_date_municipal_license_number"
                      required />
                  </div>
              </div>

              <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="facility_type" class="form-label">  نوع المنشأة</label>
                <select value="{{ old('facility_type') }}" name="facility_type" id="facility_type" class="form-select"
                    aria-label="Default select example" id="facility_type" required>
                    <option value="" selected disabled>حدد نوع المنشأة</option>
                    <option value="individual">فردية</option>
                    <option value="campony">شركة</option>

                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="manager_id" class="form-label">حدد المستخدم المسؤال عن إدارة المجموعة </label>
                <select value="{{ old('manager_id') }}" name="manager_id" id="manager_id" class="form-select"
                    aria-label="Default select example" id="manager_id" required>
                    <option    disabled value="" selected hidden>حدد المستخدم المسؤال </option>
                    @foreach ($users as $user )
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="responsible_name" class="form-label">اسم المسؤول</label>
                <input type="text" value="{{ old('responsible_name') }}" name="responsible_name" class="form-control" id="responsible_name" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="phone" class="form-label">رقم الجوال المسؤول</label>
                <input type="text" value="{{ old('phone') }}" name="phone" class="form-control" id="phone" required>
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
    <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات المركبة</button>
</form>
@endsection

@section('scripts')

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
