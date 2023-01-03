
@extends('index')
@section('title','أضافة مدينة')
@section('content')
<div class="container">
  <h3 class="m-2 mt-4">أضافة مدينة جديد للتصنيف {{$cat->category_name}}</h3>
</div>
<form method="POST" action="{{ url('vechile/add/city') }}">
  @csrf
  <input type="hidden" name="category_id" value="{{$cat->id}}" class="hidden">
  <div class="container">
    <div class="row">
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="city_name" class="form-label">اسم المدينــة</label>
        <input type="text" value="{{ old('city_name') }}" name="city" class="form-control"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="going_cost" class="form-label">تكلفة رحلة الذهاب</label>
        <input type="text" name="going_cost"  value="{{ old('going_cost') }}" class="form-control" id="going_cost"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="going_back_cost" class="form-label">تكلفة الذهاب و العودة</label>
        <input type="text" value="{{ old('going_back_cost') }}" name="going_back_cost" class="form-control" id="going_back_cost"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="city_cancel_cost" class="form-label">تكلفة الإلغاء</label>
        <input type="text" value="{{ old('city_cancel_cost') }}" name="city_cancel_cost" class="form-control" id="city_cancel_cost"  required>
        
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="city_regect_cost" class="form-label">تكلفة رفض الرحلة</label>
        <input type="text" value="{{ old('city_regect_cost') }}" name="city_regect_cost" class="form-control" id="city_regect_cost"  required>
      </div>
      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="percentage_type" class="form-label">نوع النسبة </label>
          <select value="{{ $cat->percentage_type}}" name="percentage_type" class="form-select" aria-label="Default select example" id="percentage_type">
            <option value="fixed" {{$cat->percentage_type =='fixed'? 'selected': ''}}>النسبة ثابتة</option>
            <option value="percent" {{$cat->percentage_type =='percent'? 'selected': ''}}>النسبة مئوية</option>
          </select>
      </div>
      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="city_percent" class="form-label">النسبة  </label>
        <input type="text" value="{{ old('city_percent') }}" name="city_percent" class="form-control" id="city_percent"  required>
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
  




  <button type="submit" class="btn btn-primary m-4 ">حفظ المدينة</button>
</form>
@endsection

@section('scripts')

@endsection