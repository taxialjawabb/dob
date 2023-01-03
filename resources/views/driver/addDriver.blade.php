@extends('index')
@section('title','إضافة سائق')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">أضافة سائق جديدة</h3>
</div>
<form method="POST" action="{{ url('driver/add') }}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row">

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="stakeholder" class="form-label">حدد جهة السائق </label>
                <select value="{{ old('stakeholder') }}" name="stakeholder" id="stakeholder" class="form-select"
                    aria-label="Default select example" id="stakeholder" required>
                    <option value="" selected disabled>حدد جهة السائق</option>
                    <option value="0">الجواب للنقل البرى</option>
                    @foreach (\App\Models\Groups\Group::select(['id','name'])->get() as $group )
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="mt-4 pt-3">
                    <input type="checkbox" value="false" name="on_company" class="form-check-input"
                        id="on_company">
                    <label for="on_company" class="form-check-label text-dark ms-2 on_company">
                        على كفالة الشركة</label>
                </div>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="name" class="form-label">اسم السائق</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="address" class="form-label"> الجنسية</label>
                <select value="{{ old('nationality') }}" name="nationality" id="nationality" class="form-select"
                    aria-label="Default select example" id="nationality" required>
                    <option value="" selected disabled>حدد الجنسية</option>
                    <option value="سعودى">سعودى </option>
                    <option value="باكستانى">باكستانى </option>
                    <option value="يمنى">يمنى </option>
                    <option value="هندى">هندى </option>
                    <option value="سودانى">سودانى </option>
                    <option value="اثيوبى"> اثيوبى </option>
                    <option value="بنغالى"> بنغالى </option>
                    <option value="مصرى"> مصرى </option>

                </select>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="phone" required>
            </div>

            {{-- <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="address" class="form-label">عنوان السكن</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control" id="address"
                    required>
            </div> --}}
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="address" class="form-label">اسم مدينة الإقامة</label>
                <select value="{{ old('address') }}" name="address" id="address" class="form-select"
                    aria-label="Default select example" id="address" required>
                    <option value="" selected disabled>حدد المدينة</option>
                    <option value="الرياض">الرياض </option>
                    <option value="جدة">جدة </option>
                    <option value="مكه">مكه </option>
                    <option value="المدينة المنورة">المدينة المنورة </option>
                    <option value="الدمام">الدمام </option>
                    <option value="الهفوف">الهفوف </option>
                    <option value="بريده">بريده </option>
                    <option value="الحله">الحله </option>
                    <option value="الطائف">الطائف </option>
                    <option value="تبوك">تبوك </option>
                    <option value="خميس مشيط">خميس مشيط </option>
                    <option value="حائل">حائل </option>
                    <option value="القطيف">القطيف </option>
                    <option value="المبرز">المبرز </option>
                    <option value="الخرج">الخرج </option>
                    <option value="نجران">نجران </option>
                    <option value="ينبع">ينبع </option>
                    <option value="ابها">ابها </option>
                    <option value="عرعر">عرعر </option>
                    <option value="جزان">جزان </option>
                    <option value="سكاكا">سكاكا </option>
                    <option value="الباحه">الباحه </option>
                    <option value="اخري">اخري </option>
                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="address" class="form-label"> نوع الهوية</label>
                <select value="{{ old('id_type') }}" name="id_type" id="id_type" class="form-select"
                    aria-label="Default select example" id="id_type" required>
                    <option value="" selected disabled>حدد الهوية</option>
                    <option value="هوية وطنية">هوية وطنية</option>
                    <option value="هوية مقيم">هوية مقيم </option>
                    <option value="رقم حدود">رقم حدود </option>

                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="ssd" class="form-label">رقم الهوية</label>
                <input type="text" value="{{ old('ssd') }}" name="ssd" class="form-control" id="ssd" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="place_issue" class="form-label">مكان الإصدار</label>
                <input type="text" value="{{  old('place_issue') }}" name="place_issue" class="form-control"
                    id="place_issue" required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="id_copy_no" class="form-label">رقم نسخة الهوية</label>
                <input type="text" name="id_copy_no" value="{{ old('id_copy_no') }}" class="form-control"
                    id="id_copy_no">
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div style="position: relative">
                    <label for="id_expiration_date" class="form-label">تاريخ انتهاء الهوية</label>
                    <input type="text" value="{{ old('id_expiration_date') }}" class="form-control input-date"
                        id="id_expiration_date" required>
                    <input type='hidden' name="id_expiration_date" class="form-control id_expiration_date" required />
                </div>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="license_type" class="form-label">نوع الرخصة</label>
                <input type="text" value="{{ old('license_type') }}" name="license_type" class="form-control"
                    id="license_type" required>
            </div>
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="license_number" class="form-label">رقم الرخصة</label>
                <input type="text" value="{{ old('license_number')  }}" name="license_number" class="form-control"
                    id="license_number" required>
            </div>


            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="license_expiration_date" class="form-label">تاريخ إنتهاء الرخصة</label>
                    <input type="text" value="{{ old('license_expiration_date') }}" class="form-control input-date"
                        id="license_expiration_date">
                    <input type='hidden' name="license_expiration_date" class="form-control license_expiration_date"
                        required />
                </div>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="birth_date" class="form-label">تاريخ الميلاد</label>
                    <input type="text" value="{{ old('birth_date') }}" class="form-control input-date" id="birth_date">
                    <input type='hidden' name="birth_date" class="form-control birth_date" required />
                </div>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="start_working_date" class="form-label">تاريخ بداية العمل</label>
                    <input type="text" style="text-direction:rtl" value="{{ old('start_working_date') }}"
                        class="form-control input-date" id="start_working_date">
                    <input type='hidden' name="start_working_date" class="form-control start_working_date" required />
                </div>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="contract_end_date" class="form-label">تاريخ انتهاء عقد العمل</label>
                    <input type="text" style="text-direction:rtl" value="{{ old('contract_end_date') }}"
                        class="form-control input-date" id="contract_end_date">
                    <input type='hidden' name="contract_end_date" class="form-control contract_end_date" required />
                </div>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="final_clearance_date" class="form-label">تاريخ انتهاء المخالصة النهائية</label>
                    <input type="text" style="text-direction:rtl" value="{{ old('final_clearance_date') }}"
                        class="form-control input-date" id="final_clearance_date">
                    <input type='hidden' name="final_clearance_date" class="final_clearance_date" required />
                </div>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="weekly_amount" class="form-label">الدفع الأسبوع المستحق</label>
                <input type="text" name="weekly_amount" value="{{ old('weekly_amount') }}" class="form-control"
                    id="weekly_amount" required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>
            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="monthly_salary" class="form-label">الراتب الشهري</label>
                <input type="text" name="monthly_salary" value="{{old('monthly_salary') }}" class="form-control"
                    id="monthly_salary" required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="mt-4 pt-3">
                    <input type="checkbox" value="false" name="without_deduct" class="form-check-input"
                        id="without_deduct">
                    <label for="without_deduct" class="form-check-label text-dark ms-2 without_deduct">بدون
                        أستقطاع</label>
                </div>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="monthly_deduct" class="form-label">قيمة الإستقطاع</label>
                <input type="text" name="monthly_deduct" value="{{ old('monthly_deduct') }}" class="form-control"
                    id="monthly_deduct" readonly required>
            </div>
            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="insurances" class="form-label">التأمينات</label>
                <input type="text" name="insurances" value="{{ old('insurances') }}" class="form-control"
                    id="insurances" required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="basic_salary" class="form-label">الراتب المستحق</label>
                <input type="text" name="basic_salary" value="{{ old('basic_salary') }}" class="form-control"
                    id="basic_salary" readonly required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="vacation_days" class="form-label">إلاجازة السنوية</label>
                <input type="text" name="vacation_days" value="{{ old('vacation_days') }}" class="form-control"
                    id="vacation_days" required>
            </div>


            <div class="mb-3 mt-4 ">
                <label for="formFile" class="form-label">صورة شخصية للسائق</label>
                <input class="form-control" type="file" name="image" value="{{old('image')}}" id="file">
            </div>

            <div class="text-center image">
                <img src="{{ asset('assets/images/pleaceholder/image.png')}}" style="width: 200px; height: 200px"
                    id="profile-img-tag" alt="صورة السائق">
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





    <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات السائق</button>
</form>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}"></script>
<script>
    $(function () {
        $(".input-date").hijriDatePicker({
          //  hijri:true
        });

        $(".input-date").on('dp.change', function (arg) {
            let date = arg.date;
            let className = $(this).attr('id');
            $('.'+className).val(date.format("YYYY/M/D"));

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
                var basic_salary = totalSalary - (totalSalary * 0.0975);
                $("#basic_salary").val(basic_salary  - insurances);
                $("#monthly_deduct").val(totalSalary- basic_salary);

            }
        });
    });
</script>

@endsection
