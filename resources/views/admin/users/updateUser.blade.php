
@extends('index')
@section('title','إضافة مستخدم')
@section('content')
<div class="container">
  <h3 class="m-2 mt-4">تعديل بيانات مستخدم</h3>
</div>
<form method="POST" action="{{ url('user/update') }}">
  @csrf
  <input type="hidden" name="id" value="{{ $user->id}}">
  <div class="container">
    <div class="row">

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="department" class="form-label">القسم </label>
            <select value="{{ old('department') }}" name="department" id="department" class="form-select" aria-label="Default select example" id="department" required>
                <option  disabled >حدد القسم</option>
                <option value="management" {{ $user->department == 'management'? 'selected':''  }}>القسم الإدارى</option>
                <option value="developer" {{ $user->department == 'developer' ? 'selected':''  }}>القسم التقني</option>
                <option value="technical" {{ $user->department == 'technical' ? 'selected':''  }}>القسم الفنى</option>
                <option value="group_manager" {{ $user->department == 'group_manager' ? 'selected':''  }}>أدارة مجموعة</option>
            </select>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم المستخدم</label>
        <input type="text" value="{{ $user->name }}" name="name" class="form-control" id="name"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="role_id" class="form-label">حدد دور للمستخدم</label>
          <select value="{{ $user->role_id }}" name="role_id" id="role_id" class="form-select" aria-label="Default select example" id="role_id" required>
            @foreach($roles as $role)
            <option value="{{$role->id}}"  {{ $user->hasRole($role['name']) ? 'selected' : ''}}>{{$role->display_name}}     </option>
            @endforeach
          </select>
      </div>


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال</label>
        <input type="text" value="{{ $user->phone }}" name="phone" class="form-control" id="phone"  required>
      </div>


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <input type="text" value="{{ $user->nationality }}" name="nationality" class="form-control" id="nationality"  disabled>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <input type="text" name="ssd"  value="{{ $user->ssd }}" class="form-control" id="ssd"  disabled>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="password" class="form-label">الرقم السرى للمستخدم</label>
        <input type="password" name="password" class="form-control" id="password">
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="working_hours" class="form-label">عدد ساعات العمل المطلوبة</label>
        <input type="text" name="working_hours"  value="{{ $user->working_hours }}" class="form-control" id="working_hours"  required>
      </div>

      <div class="row" id="employee-only" style="display: {{ $user->department == 'group_manager' ? 'none' : '' }}">
        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="monthly_salary" class="form-label">الراتب الشهري</label>
            <input type="text" name="monthly_salary"  value="{{ $user->monthly_salary }}" class="form-control" id="monthly_salary"  >
          </div>

          <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mt-4 pt-3">
                <input type="checkbox" value="false" name="without_deduct" class="form-check-input" id="without_deduct" >
                <label for="without_deduct" class="form-check-label text-dark ms-2 without_deduct">بدون أستقطاع</label>
            </div>
          </div>

          <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="basic_salary" class="form-label">الراتب المستحق</label>
            <input type="text" name="basic_salary"  value="{{ $user->monthly_salary - $user->monthly_deduct }}" class="form-control" id="basic_salary" readonly  >
          </div>

          <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="monthly_deduct" class="form-label">قيمة الإستقطاع</label>
            <input type="text" name="monthly_deduct"  value="{{ $user->monthly_deduct }}" class="form-control" id="monthly_deduct" readonly  >
          </div>

          <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="vacation_days" class="form-label">إلاجازة السنوية</label>
            <input type="text" name="vacation_days"  value="{{ $user->vacation_days }}" class="form-control" id="vacation_days"  >
          </div>
      </div>

      <!-- <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <div style="position: relative">
            <label for="date_join" class="form-label">تاريخ الإلتحاق</label>
            <input type="text" value="{{\Carbon\Carbon::parse( $user->date_join )->format('d-m-Y')}}" class="form-control input-date" id="date_join"  required>
            <input type='hidden' name="date_join" value="{{\Carbon\Carbon::parse( $user->date_join ) }}" class="date_join" required />
        </div>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <div style="position: relative">
            <label for="Employment_contract_expiration_date" class="form-label">تاريخ إنتهاء عقد العمل</label>
            <input type="text" value="{{\Carbon\Carbon::parse($user->Employment_contract_expiration_date)->format('d-m-Y') }}" class="form-control input-date" id="Employment_contract_expiration_date"  >
            <input type='hidden' name="Employment_contract_expiration_date" value="{{\Carbon\Carbon::parse($user->Employment_contract_expiration_date) }}" class="Employment_contract_expiration_date" required />
        </div>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <div style="position: relative">
            <label for="final_clearance_exity_date" class="form-label">تاريخ إنتهاء المخالصة النهائية</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($user->final_clearance_exity_date)->format('d-m-Y')  }}" class="form-control input-date" id="final_clearance_exity_date"  required>
            <input type='hidden' name="final_clearance_exity_date" value="{{ \Carbon\Carbon::parse($user->final_clearance_exity_date) }}" class="final_clearance_exity_date" required />
        </div>
      </div>
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <div style="position: relative">
            <label for="id_expiration_date" class="form-label">تاريخ إنتهاء الإقامة</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($user->id_expiration_date)->format('d-m-Y')  }}" class="form-control input-date" id="id_expiration_date"  required>
            <input type='hidden' name="id_expiration_date" value="{{ \Carbon\Carbon::parse($user->id_expiration_date) }}" class="id_expiration_date" required />
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
  <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات المستخدم</button>
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on("change", '#department', function() {
            var department = $(this).val();
            if(department == 'group_manager'){
                $("#employee-only").hide();
            }
            else{
                $("#employee-only").show();

            }
        });


        $(".input-date").hijriDatePicker({});

        $(".input-date").on('dp.change', function(arg) {
            let date = arg.date;
            let className = $(this).attr('id');
            $('.' + className).val(date.format("YYYY/M/D"));

            // $("#selected-date").html(date.format("YYYY/M/D") + " Hijri:" + date.format("iYYYY/iM/iD"));
        });

        $('#monthly_salary').on('input', function(){
            var salary = $(this).val();
            var basic_salary = salary - (salary * 0.0975);
            $("#basic_salary").val(basic_salary);
            $("#monthly_deduct").val(salary- basic_salary);
        });

        $("#without_deduct").on('change', function(){
            var without_deduct = $(this).val();
            var totalSalary = $('#monthly_salary').val();
            if(without_deduct == 'false'){
                $(this).val(true);
                $("#basic_salary").val(totalSalary);
                $("#monthly_deduct").val(0);
            }
            else{
                $(this).val(false);
                var basic_salary = totalSalary - (totalSalary * 0.0975);
                $("#basic_salary").val(basic_salary);
                $("#monthly_deduct").val(totalSalary- basic_salary);

            }
        });
    });
</script>
@endsection
