
@extends('index')
@section('title','إضافة صنف')
@section('content')
<div class="container">
  <h3 class="m-2 mt-4">أضافة صنف جديد</h3>
</div>
<form method="POST" action="{{ url('maintenance/center/add') }}" enctype="multipart/form-data">
  @csrf
  <div class="container">
    <div class="row">

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم الصنف</label>
        <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name"  required>
      </div>
      
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="free_count" class="form-label">العدد المجانى</label>
        <input type="text" value="{{ old('free_count') }}" name="free_count" class="form-control" id="free_count"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="periodic_days" class="form-label">المدة الدورية للعدد المجانى</label>
        <select value="{{ old('periodic_days') }}" name="periodic_days" id="periodic_days" class="form-select" aria-label="Default select example" id="periodic_days">
            <option value="" selected disabled>حدد المدة المجانية للتغير</option>
            <option value="7">اسبوعى </option>
            <option value="14">كل اسبوعين</option>
            <option value="30">شهرى</option>
            <option value="183">نصف سنوى</option>
            <option value="365">سنوى</option>
        </select>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="price" class="form-label">سعر الاضافى</label>
        <input type="text" value="{{ old('price') }}" name="price" class="form-control" id="price"  required>
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
  




  <button type="submit" class="btn btn-primary m-4 ">حفظ </button>
</form>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}" ></script>   

@endsection