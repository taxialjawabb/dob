@extends('index')
@section('title','تعديل')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">تعديل بيانات مجموعة</h3>
</div>
<form method="POST" action="{{ route('manage.groups.update', $group) }}">
    @csrf

    <div class="container">
        <div class="row">
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="name" class="form-label">اسم المنشأة</label>
                <input type="text" value="{{ $group->name }}" name="name" class="form-control" id="name" required>
            </div>


            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="city" class="form-label">اسم المدينة</label>
                <select value="{{ $group->city }}" name="city" id="city" class="form-select" aria-label="Default select example" id="city" required>
                    <option value="" selected disabled>حدد المدينة</option>
                    <option value="الرياض" {{ $group->city == 'الرياض' ? 'selected' : '' }}>الرياض </option>
                    <option value="جدة" {{ $group->city == 'جدة' ? 'selected' : '' }}>جدة </option>
                    <option value="مكه" {{ $group->city == 'مكه' ? 'selected' : '' }}>مكه </option>
                    <option value="المدينة المنورة" {{ $group->city == 'المدينة المنورة' ? 'selected' : ''
                            }}>المدينة المنورة </option>
                    <option value="الدمام" {{ $group->city == 'الدمام' ? 'selected' : '' }}>الدمام </option>
                    <option value="الهفوف" {{ $group->city == 'الهفوف' ? 'selected' : '' }}>الهفوف </option>
                    <option value="بريده" {{ $group->city == 'بريده' ? 'selected' : '' }}>بريده </option>
                    <option value="الحله" {{ $group->city == 'الحله' ? 'selected' : '' }}>الحله </option>
                    <option value="الطائف" {{ $group->city == 'الطائف' ? 'selected' : '' }}>الطائف </option>
                    <option value="تبوك" {{ $group->city == 'تبوك' ? 'selected' : '' }}>تبوك </option>
                    <option value="خميس مشيط" {{ $group->city == 'خميس مشيط' ? 'selected' : '' }}>خميس مشيط
                    </option>
                    <option value="حائل" {{ $group->city == 'حائل' ? 'selected' : '' }}>حائل </option>
                    <option value="القطيف" {{ $group->city == 'القطيف' ? 'selected' : '' }}>القطيف </option>
                    <option value="المبرز" {{ $group->city == 'المبرز' ? 'selected' : '' }}>المبرز </option>
                    <option value="الخرج" {{ $group->city == 'الخرج' ? 'selected' : '' }}>الخرج </option>
                    <option value="نجران" {{ $group->city == 'نجران' ? 'selected' : '' }}>نجران </option>
                    <option value="ينبع" {{ $group->city == 'ينبع' ? 'selected' : '' }}>ينبع </option>
                    <option value="ابها" {{ $group->city == 'ابها' ? 'selected' : '' }}>ابها </option>
                    <option value="عرعر" {{ $group->city == 'عرعر' ? 'selected' : '' }}>عرعر </option>
                    <option value="جزان" {{ $group->city == 'جزان' ? 'selected' : '' }}>جزان </option>
                    <option value="سكاكا" {{ $group->city == 'سكاكا' ? 'selected' : '' }}>سكاكا </option>
                    <option value="الباحه" {{ $group->city == 'الباحه' ? 'selected' : '' }}>الباحه </option>
                    <option value="اخري" {{ $group->city == 'اخري' ? 'selected' : '' }}>اخري </option>
                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="commercial_register" class="form-label">رقم السجل التجاري </label>
                <input type="text" value="{{ $group->commercial_register }}" name="commercial_register" class="form-control" id="commercial_register" >
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                  <div style="position: relative">
                      <label for="expired_date_commercial_register" class="form-label">تاريخ أنتهاء رقم السجل التجاري </label>
                      <input type="text" value="{{ !$group->expired_date_commercial_register ??$group->expired_date_commercial_register->format('d-m-Y') }}" name="expired_date_commercial_register" class="form-control input-date" id="expired_date_commercial_register"  required>
                      <input type='hidden' name="expired_date_commercial_register" class="form-control expired_date_commercial_register" value="{{ $group->expired_date_commercial_register }}" required />
                  </div>
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="transportation_license_number" class="form-label">رقم ترخيص هيئة النقل</label>
                <input type="text" value="{{ $group->transportation_license_number }}" name="transportation_license_number" class="form-control" id="transportation_license_number" >
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                  <div style="position: relative">
                      <label for="expired_date_transportation_license_number" class="form-label">تاريخ أنتهاء رقم ترخيص هيئة النقل</label>
                      <input type="text" value="{{ !$group->expired_date_transportation_license_number ?? $group->expired_date_transportation_license_number->format('d-m-Y') }}" name="expired_date_transportation_license_number" class="form-control input-date" id="expired_date_transportation_license_number"  required>
                      <input type='hidden' name="expired_date_transportation_license_number" value="{{ $group->expired_date_transportation_license_number }}" class="form-control expired_date_transportation_license_number"
                      required />
                  </div>
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="municipal_license_number" class="form-label">رقم رخصة البلدية</label>
                <input type="text" value="{{ $group->municipal_license_number }}" name="municipal_license_number" class="form-control" id="municipal_license_number" >
              </div>

              <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                  <div style="position: relative">
                      <label for="expired_date_municipal_license_number" class="form-label">تاريخ أنتهاء رقم رخصة البلدية</label>
                      <input type="text" value="{{ !$group->expired_date_municipal_license_number ?? $group->expired_date_municipal_license_number->format('d-m-Y') }}" name="expired_date_municipal_license_number" class="form-control input-date" id="expired_date_municipal_license_number"  required>
                      <input type='hidden' name="expired_date_municipal_license_number"  value="{{ $group->expired_date_municipal_license_number }}" class="form-control expired_date_municipal_license_number"
                      required />
                  </div>
              </div>

              <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="facility_type" class="form-label">  نوع المنشأة</label>
                <select value="{{ old('facility_type') }}" name="facility_type" id="facility_type" class="form-select"
                    aria-label="Default select example" id="facility_type" required>
                    <option value="" selected disabled>حدد نوع المنشأة</option>
                    <option value="individual" @selected($group->facility_type == 'individual')>فردية</option>
                    <option value="campony"  @selected($group->facility_type == 'campony')>شركة</option>

                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="manager_id" class="form-label">حدد المستخدم المسؤال عن إدارة المجموعة </label>
                <select value="{{ old('manager_id') }}" name="manager_id" id="manager_id" class="form-select"
                    aria-label="Default select example" id="manager_id" required>
                    <option    disabled value="" selected hidden>حدد المستخدم المسؤال </option>
                    @foreach ($users as $user )
                        <option value="{{ $user->id }}"  @selected($group->manager_id == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="responsible_name" class="form-label">اسم المسؤول</label>
                <input type="text" value="{{ $group->responsible_name }}" name="responsible_name" class="form-control" id="responsible_name" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="phone" class="form-label">رقم الجوال المسؤول</label>
                <input type="text" value="{{ $group->phone }}" name="phone" class="form-control" id="phone" required>
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
