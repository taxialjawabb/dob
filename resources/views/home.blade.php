@extends('index')
@section('title','الصفحة الشخصية')
@section('content')
<div class="mt-3 mb-3 container clearfix">
  <h4 class=" float-start">بيانات المستخدم </h4>
</div>

<div class="container">
    <div class="row">
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">الاســم</label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال</label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->phone}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label"> الـصـلاحـيـات</label>
        <p class="alert alert-secondary p-1">
          @foreach(Auth::guard('admin') -> user()->allPermissions() as $index=>$p)
          {{$p->display_name}} 
          {{  $index+1 < Auth::guard('admin') -> user()->allPermissions()->count() ? ' , ': ' '}}
          @endforeach
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label"> الأدوار</label>
        <p class="alert alert-secondary p-1">
          @foreach(Auth::guard('admin') -> user()->roles as $role)
          {{$role->display_name}}
          @endforeach
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->ssd}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="date_join" class="form-label">تاريخ الإلتحاق</label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->date_join}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="Employment_contract_expiration_date" class="form-label">تاريخ انتهاء عقد العمل</label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->Employment_contract_expiration_date}}</p>
      </div>

      <!-- <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_exity_date" class="form-label">تاريخ انتهاء المخالصة النهائية</label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->final_clearance_exity_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="working_hours" class="form-label">ساعات العمل </label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->working_hours}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="monthly_salary" class="form-label">الراتب الشهري</label>
        <p class="alert alert-secondary p-1">{{Auth::guard('admin') -> user()->monthly_salary}}</p>
      </div>
     
    </div>
  </div>
 @endsection

@section('scripts')
@endsection