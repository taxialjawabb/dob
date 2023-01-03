
@extends('index')
@section('title','إضافة مستخدم')
@section('content')
<div class="mt-2">
  <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
  <i class="arrow left "></i>
  <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>
  <i class="arrow left "></i>
  <a href="{{ url('shared/groups/show/users/'.$group->id) }}" class="btn text-primary p-1 ">المستخدمين</a>


</div>
<div class="container">
  <h3 class="m-2 mt-4">أضافة مستخدم جديد</h3>
</div>
<form method="POST" action="{{ url('shared/groups/save/user') }}">
  @csrf
  <div class="container">
    <div class="row">

      <input type="hidden" value="{{$id}}" name="group_id" class="form-control" id="department"  required>


    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم المستخدم</label>
        <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name"  required>
      </div>

      <input type="hidden" value="1" name="role_id" class="form-control" id="department"  required>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال</label>
        <input type="text" value="{{ old('phone') }}" name="phone" class="form-control" id="phone"  required>
      </div>


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <input type="text" value="{{ old('nationality') }}" name="nationality" class="form-control" id="nationality"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <input type="text" name="ssd"  value="{{ old('ssd') }}" class="form-control" id="ssd"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="password" class="form-label">الرقم السرى للمستخدم</label>
        <input type="password" name="password"  value="{{ old('password') }}" class="form-control" id="password"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="working_hours" class="form-label">عدد ساعات العمل المطلوبة</label>
        <input type="text" name="working_hours"  value="{{ old('working_hours') }}" class="form-control" id="working_hours"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="monthly_salary" class="form-label">الراتب الشهري</label>
        <input type="text" name="monthly_salary"  value="{{ old('monthly_salary') }}" class="form-control" id="monthly_salary"  required>
      </div>

      <!-- <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="date_join" class="form-label">تاريخ الإلتحاق</label>
        <input type="date" value="{{ old('date_join') }}" name="date_join" class="form-control" id="date_join"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="Employment_contract_expiration_date" class="form-label">تاريخ إنتهاء عقد العمل</label>
        <input type="date" value="{{ old('Employment_contract_expiration_date') }}" name="Employment_contract_expiration_date" class="form-control" id="Employment_contract_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_exity_date" class="form-label">تاريخ إنتهاء المخالصة النهاشية</label>
        <input type="date" value="{{ old('final_clearance_exity_date') }}" name="final_clearance_exity_date" class="form-control" id="final_clearance_exity_date"  required>
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

@endsection
