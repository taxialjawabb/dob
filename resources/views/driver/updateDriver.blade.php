@extends('index')
@section('title','إضافة سائق')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">تعديل سائق </h3>
</div>
<form method="POST" action="{{ url('driver/update') }}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row">
            <input type="hidden" name="id" value="{{ $driver->id }}">
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="stakeholder" class="form-label">حدد جهة السائق </label>
                <select value="{{ old('stakeholder') }}" name="stakeholder" id="stakeholder" class="form-select"
                    aria-label="Default select example" id="stakeholder" required>
                    <option value="" disabled>حدد جهة السائق</option>
                    <option value="0">الجواب للنقل البرى</option>
                    @foreach (\App\Models\Groups\Group::select(['id','name'])->get() as $group )
                    <option value="{{ $group->id }}" @selected($driver->group_id == $group->id)>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="mt-4 pt-3">
                    <input type="checkbox" @checked($driver->on_company ==1) name="on_company" class="form-check-input"
                        id="on_company">
                    <label for="on_company" class="form-check-label text-dark ms-2 on_company">
                        على كفالة الشركة</label>
                </div>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="name" class="form-label">اسم السائق</label>
                <input type="text" value="{{ $driver->name }}" name="name" class="form-control" id="name" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="address" class="form-label"> الجنسية</label>
                <select value="{{ old('nationality') }}" name="nationality" id="nationality" class="form-select" aria-label="Default select example" id="nationality" required>
                    <option value="" selected disabled>حدد الجنسية</option>
                    <option value="سعودى" {{ $driver->nationality == 'سعودى' ? 'selected' : '' }}>سعودى </option>
                    <option value="باكستانى" {{ $driver->nationality == 'باكستانى' ? 'selected' : '' }}>باكستانى
                    </option>
                    <option value="يمنى" {{ $driver->nationality == 'يمنى' ? 'selected' : '' }}>يمنى </option>
                    <option value="هندى" {{ $driver->nationality == 'هندى' ? 'selected' : '' }}>هندى </option>
                    <option value="سودانى" {{ $driver->nationality == 'سودانى' ? 'selected' : '' }}>سودانى </option>
                    <option value="اثيوبى" {{ $driver->nationality == 'اثيوبى' ? 'selected' : '' }}> اثيوبى </option>
                    <option value="بنغالى" {{ $driver->nationality == 'بنغالى' ? 'selected' : '' }}> بنغالى </option>
                    <option value="مصرى" {{ $driver->nationality == 'مصرى' ? 'selected' : '' }}> مصرى </option>

                </select>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" value="{{ $driver->phone }}" class="form-control" id="phone" required>
            </div>

            {{-- <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="address" class="form-label">عنوان السكن</label>
                <input type="text" name="address" value="{{ $driver->address }}" class="form-control" id="address"
            required>
        </div> --}}

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="address" class="form-label">اسم مدينة الإقامة</label>
            <select value="{{ old('address') }}" name="address" id="address" class="form-select" aria-label="Default select example" id="address" required>
                <option value="" selected disabled>حدد المدينة</option>
                <option value="الرياض" {{ $driver->address == 'الرياض' ? 'selected' : '' }}>الرياض </option>
                <option value="جدة" {{ $driver->address == 'جدة' ? 'selected' : '' }}>جدة </option>
                <option value="مكه" {{ $driver->address == 'مكه' ? 'selected' : '' }}>مكه </option>
                <option value="المدينة المنورة" {{ $driver->address == 'المدينة المنورة' ? 'selected' : ''
                        }}>المدينة المنورة </option>
                <option value="الدمام" {{ $driver->address == 'الدمام' ? 'selected' : '' }}>الدمام </option>
                <option value="الهفوف" {{ $driver->address == 'الهفوف' ? 'selected' : '' }}>الهفوف </option>
                <option value="بريده" {{ $driver->address == 'بريده' ? 'selected' : '' }}>بريده </option>
                <option value="الحله" {{ $driver->address == 'الحله' ? 'selected' : '' }}>الحله </option>
                <option value="الطائف" {{ $driver->address == 'الطائف' ? 'selected' : '' }}>الطائف </option>
                <option value="تبوك" {{ $driver->address == 'تبوك' ? 'selected' : '' }}>تبوك </option>
                <option value="خميس مشيط" {{ $driver->address == 'خميس مشيط' ? 'selected' : '' }}>خميس مشيط
                </option>
                <option value="حائل" {{ $driver->address == 'حائل' ? 'selected' : '' }}>حائل </option>
                <option value="القطيف" {{ $driver->address == 'القطيف' ? 'selected' : '' }}>القطيف </option>
                <option value="المبرز" {{ $driver->address == 'المبرز' ? 'selected' : '' }}>المبرز </option>
                <option value="الخرج" {{ $driver->address == 'الخرج' ? 'selected' : '' }}>الخرج </option>
                <option value="نجران" {{ $driver->address == 'نجران' ? 'selected' : '' }}>نجران </option>
                <option value="ينبع" {{ $driver->address == 'ينبع' ? 'selected' : '' }}>ينبع </option>
                <option value="ابها" {{ $driver->address == 'ابها' ? 'selected' : '' }}>ابها </option>
                <option value="عرعر" {{ $driver->address == 'عرعر' ? 'selected' : '' }}>عرعر </option>
                <option value="جزان" {{ $driver->address == 'جزان' ? 'selected' : '' }}>جزان </option>
                <option value="سكاكا" {{ $driver->address == 'سكاكا' ? 'selected' : '' }}>سكاكا </option>
                <option value="الباحه" {{ $driver->address == 'الباحه' ? 'selected' : '' }}>الباحه </option>
                <option value="اخري" {{ $driver->address == 'اخري' ? 'selected' : '' }}>اخري </option>
            </select>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="address" class="form-label"> نوع الهوية</label>
            <select value="{{ old('id_type') }}" name="id_type" id="id_type" class="form-select" aria-label="Default select example" id="id_type" required>
                <option value="" selected disabled>حدد الهوية</option>
                <option value="هوية وطنية" {{ $driver->id_type == 'هوية وطنية' ? 'selected' : '' }}>هوية وطنية
                </option>
                <option value="هوية مقيم" {{ $driver->id_type == 'هوية مقيم' ? 'selected' : '' }}>هوية مقيم</option>
                <option value="رقم حدود" {{ $driver->id_type == 'رقم حدود' ? 'selected' : '' }}>رقم حدود</option>

            </select>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="ssd" class="form-label">رقم الهوية</label>
            <input type="text" value="{{ $driver->ssd }}" name="ssd" class="form-control" id="ssd" required>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="place_issue" class="form-label">مكان الإصدار</label>
            <input type="text" value="{{ $driver->place_issue }}" name="place_issue" class="form-control" id="place_issue" required>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="id_copy_no" class="form-label">رقم نسخة الهوية</label>
            <input type="text" name="id_copy_no" value="{{ $driver->id_copy_no }}" class="form-control" id="id_copy_no" required>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div style="position: relative">
                <label for="id_expiration_date" class="form-label">تاريخ انتهاء الهوية</label>
                <input type="text" value="{{ $driver->id_expiration_date != null ? $driver->id_expiration_date->format('d-m-Y') : '' }}" class="form-control input-date" id="id_expiration_date" required>
                <input type='hidden' name="id_expiration_date" value="{{ $driver->id_expiration_date ?? '' }}" class="id_expiration_date" required />
            </div>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="license_type" class="form-label">نوع الرخصة</label>
            <input type="text" value="{{ $driver->license_type }}" name="license_type" class="form-control" id="license_type" required>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <label for="license_number" class="form-label">رقم الرخصة</label>
            <input type="text" value="{{ $driver->license_number }}" name="license_number" class="form-control" id="license_number" required>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <div style="position: relative">
                <label for="license_expiration_date" class="form-label">تاريخ إنتهاء الرخصة</label>
                <input type="text" value="{{ $driver->license_expiration_date != null ? $driver->license_expiration_date->format('d-m-Y') : '' }}" class="form-control input-date" id="license_expiration_date" required>
                <input type='hidden' name="license_expiration_date" value="{{ $driver->license_expiration_date ?? '' }}" class="license_expiration_date" required />
            </div>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <div style="position: relative">
                <label for="birth_date" class="form-label">تاريخ الميلاد</label>
                <input type="text" value="{{ $driver->birth_date != null ? $driver->birth_date->format('d-m-Y') : '' }}" name="birth_date" class="form-control input-date" id="birth_date" required>
                <input type='hidden' name="birth_date" value="{{ $driver->birth_date ?? '' }}" class="birth_date" required />
            </div>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <div style="position: relative">
                <label for="start_working_date" class="form-label">تاريخ بداية العمل</label>
                <input type="text" style="text-direction:rtl" value="{{ $driver->start_working_date != null ? $driver->start_working_date->format('d-m-Y') : '' }}" class="form-control input-date" id="start_working_date" required>
                <input type='hidden' name="start_working_date" value="{{ $driver->start_working_date ?? '' }}" class="start_working_date" required />
            </div>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <div style="position: relative">
                <label for="contract_end_date" class="form-label">تاريخ انتهاء عقد العمل</label>
                <input type="text" style="text-direction:rtl" value="{{ $driver->contract_end_date != null ? $driver->contract_end_date->format('d-m-Y') : '' }}" class="form-control input-date" id="contract_end_date" required>
                <input type='hidden' name="contract_end_date" value="{{ $driver->contract_end_date ?? '' }}" class="contract_end_date" required />
            </div>
        </div>

        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <div style="position: relative">
                <label for="final_clearance_date" class="form-label">تاريخ انتهاء المخالصة النهائية</label>
                <input type="text" style="text-direction:rtl" value="{{ $driver->final_clearance_date != null ? $driver->final_clearance_date->format('d-m-Y') : '' }}" class="form-control input-date" id="final_clearance_date" required>
                <input type='hidden' name="final_clearance_date" value="{{ $driver->final_clearance_date ?? '' }}" class="final_clearance_date" required />
            </div>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="weekly_amount" class="form-label">الدفع الأسبوع المستحق</label>
            <input type="text" name="weekly_amount" value="{{$driver->weekly_amount }}" class="form-control"
                id="weekly_amount" required>
        </div>
        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="monthly_salary" class="form-label">الراتب الشهري</label>
            <input type="text" name="monthly_salary" value="{{$driver->monthly_salary }}" class="form-control"
                id="monthly_salary" required>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mt-4 pt-3">
                <input type="checkbox" @checked($driver->monthly_deduct == 0) value="{{ $driver->monthly_deduct >0 ?'false': 'true' }}" name="without_deduct" class="form-check-input"
                    id="without_deduct">
                <label for="without_deduct" class="form-check-label text-dark ms-2 without_deduct">بدون
                    أستقطاع</label>
            </div>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="monthly_deduct" class="form-label">قيمة الإستقطاع</label>
            <input type="text" name="monthly_deduct" value="{{ $driver->monthly_deduct }}" class="form-control"
                id="monthly_deduct" readonly required>
        </div>
        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="insurances" class="form-label">التأمينات</label>
            <input type="text" name="insurances" value="{{ $driver->insurances }}" class="form-control"
                id="insurances" required>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="basic_salary" class="form-label">الراتب المستحق</label>
            <input type="text" name="basic_salary" value="{{ $driver->monthly_salary - $driver->monthly_deduct - $driver->insurances}}" class="form-control"
                id="basic_salary" readonly required>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="vacation_days" class="form-label">إلاجازة السنوية</label>
            <input type="text" name="vacation_days" value="{{ $driver->vacation_days }}" class="form-control"
                id="vacation_days" required>
        </div>

        <div class="mb-3 mt-4 ">
            <label for="formFile" class="form-label">صورة شخصية للسائق</label>
            <input class="form-control" type="file" name="image" value="{{old('image')}}" id="file">
        </div>


        @if($driver->persnol_photo && File::exists('public/assets/images/drivers/personal_phonto/'.$driver->persnol_photo))
        <div class="text-center image m-3">
            <img src="{{ asset('assets/images/drivers/personal_phonto/'.$driver->persnol_photo)}}" style="width: 120px; height: 150px" id="profile-img-tag" alt="صورة السائق">
        </div>
        @endif


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





    <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات السائق</button>
</form>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}"></script>
<script>
    $(function() {
        $('#profile-img-tag').show();

        $(".input-date").hijriDatePicker({});

        $(".input-date").on('dp.change', function(arg) {
            let date = arg.date;
            let className = $(this).attr('id');
            $('.' + className).val(date.format("YYYY/M/D"));

            // $("#selected-date").html(date.format("YYYY/M/D") + " Hijri:" + date.format("iYYYY/iM/iD"));
        });


        $('#monthly_salary').on('input', function(){
            var salary = $(this).val();
            var insurances = $("#insurances").val();
            var basic_salary = salary - (salary * 0.0975) ;
            $("#basic_salary").val(basic_salary-insurances);
            $("#monthly_deduct").val(salary- basic_salary);
        });
        $("#insurances").on('input', function(){
            var salary = $('#monthly_salary').val();
            var insurances = $(this).val();
            var basic_salary = salary - (salary * 0.0975);
            $("#basic_salary").val(basic_salary -insurances);
            $("#monthly_deduct").val(salary- basic_salary);
        });

        $("#without_deduct").on('change', function(){
            var without_deduct = $(this).val();
            var totalSalary = $('#monthly_salary').val();
            var insurances = $("#insurances").val();

            if(without_deduct == 'false'){
                $(this).val(true);
                $("#basic_salary").val(totalSalary-insurances);
                $("#monthly_deduct").val(0);
            }
            else{
                $(this).val(false);
                var basic_salary = totalSalary - (totalSalary * 0.0975) ;
                $("#basic_salary").val(basic_salary - insurances);
                $("#monthly_deduct").val(totalSalary- basic_salary);

            }
        });
    });

</script>

@endsection
