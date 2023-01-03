
@extends('index')
@section('title','إضافة سائق')
@section('content')
<div class="mt-2">
  <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
  <i class="arrow left "></i>
  <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>
  <i class="arrow left "></i>
  <a href="{{ url('shared/groups/show/drivers/'.$group->id) }}" class="btn text-primary p-1">السائقين</a>

</div>
<div class="container">
  <h3 class="m-2 mt-4">أضافة سائق جديدة</h3>
</div>
<form method="POST" action="{{ url('shared/groups/save/drivers') }}" enctype="multipart/form-data">
  @csrf
  <div class="container">
    <div class="row">



      <input type="hidden" value="{{$id}}" name="group_id" class="form-control" id="group_id"  required>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم السائق</label>
        <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <input type="text" value="{{ old('nationality') }}" name="nationality" class="form-control" id="nationality"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="phone" class="form-label">رقم الهاتف</label>
        <input type="text" name="phone"  value="{{ old('phone') }}" class="form-control" id="phone"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="address" class="form-label">اسم مدينة الإقامة</label>
        <select value="{{ old('address') }}" name="address" id="address" class="form-select" aria-label="Default select example" id="address" required>
            <option value="" selected disabled >حدد المدينة</option>
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
        <label for="ssd" class="form-label">رقم الهوية</label>
        <input type="text" value="{{ old('ssd') }}" name="ssd" class="form-control" id="ssd"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_copy_no" class="form-label">رقم نسخة الهوية</label>
        <input type="text" name="id_copy_no"  value="{{ old('id_copy_no') }}" class="form-control" id="id_copy_no"  >
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_expiration_date" class="form-label">تاريخ انتهاء الهوية</label>
        <input type="date" value="{{ old('id_expiration_date') }}" name="id_expiration_date" class="form-control" id="id_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_type" class="form-label">نوع الرخصة</label>
        <input type="text" value="{{ old('license_type') }}" name="license_type" class="form-control" id="license_type"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_expiration_date" class="form-label">تاريخ إنتهاء الرخصة</label>
        <input type="date" value="{{ old('license_expiration_date') }}" name="license_expiration_date" class="form-control" id="license_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="birth_date" class="form-label">تاريخ الميلاد</label>
        <input type="date" value="{{ old('birth_date') }}" name="birth_date" class="form-control" id="birth_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="start_working_date" class="form-label">تاريخ بداية العمل</label>
        <input type="date" style="text-direction:rtl" value="{{ old('start_working_date') }}" name="start_working_date" class="form-control" id="start_working_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="contract_end_date" class="form-label">تاريخ انتهاء عقد العمل</label>
        <input type="date" style="text-direction:rtl" value="{{ old('contract_end_date') }}" name="contract_end_date" class="form-control" id="contract_end_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_date" class="form-label">تاريخ انتهاء المخالصة النهائية</label>
        <input type="date" style="text-direction:rtl" value="{{ old('final_clearance_date') }}" name="final_clearance_date" class="form-control" id="final_clearance_date"  required>
      </div>

      <div class="mb-3 mt-4 ">
        <label for="formFile" class="form-label">صورة شخصية للسائق</label>
        <input class="form-control"type="file" name="image" value="{{old('image')}}"  id="file">
    </div>



    <div class="text-center image">
        <img src="{{ asset('assets/images/pleaceholder/image.png')}}" style="width: 200px; height: 200px" id="profile-img-tag" alt="صورة السائق">
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
<script src="{{ asset('assets/js/addimg.js') }}" ></script>

@endsection
