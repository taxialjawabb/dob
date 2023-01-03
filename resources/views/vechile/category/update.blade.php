
@extends('index')
@section('title','تعديل تصنيف')
@section('content')
<div class="container">
  <h3 class="m-2 mt-3">تعديل التصنيف رقم {{$cat->id}}</h3>
</div>
<form method="POST" action="{{ url('vechile/update/cagegory')}}">
  @csrf
  <input type="hidden" class="hidden" name="id" value="{{$cat->id}}">
  <div class="container">
    <div class="row">
      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">اسم التصنيف</label>
        <input type="text" value="{{ $cat->category_name}}" name="category_name" class="form-control"  required>
      </div>

      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="basic_price" class="form-label">السعر الاساسي للتصنيف</label>
        <input type="text" name="basic_price"  value="{{ $cat->basic_price}}" class="form-control" id="basic_price"  required>
      </div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="km_cost" class="form-label">تكلفة الكيلو متر</label>
        <input type="text" value="{{ $cat->km_cost}}" name="km_cost" class="form-control" id="km_cost"  required>
      </div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="minute_cost" class="form-label">تكلفة الدقيقة</label>
        <input type="text" value="{{ $cat->minute_cost }}" name="minute_cost" class="form-control" id="minute_cost"  required>
      </div>

      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="reject_cost" class="form-label">تكلفة رفض الطلب للسائق</label>
        <input type="text" value="{{ $cat->reject_cost}}" name="reject_cost" class="form-control" id="reject_cost"  required>

      </div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="cancel_cost" class="form-label">تكلفة إلغاء الطلب للعميل</label>
        <input type="text" value="{{ $cat->cancel_cost}}" name="cancel_cost" class="form-control" id="cancel_cost"  required>
      </div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="minimum_order" class="form-label">تكلفة الحد الأدنى لأنشاء طلب</label>
        <input type="text" value="{{ $cat->minimum_order }}" name="minimum_order" class="form-control" id="minimum_order"  required>
      </div>


      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
        <div class="form-check mt-5">
            <input class="form-check-input" name="show_in_app" type="checkbox" {{$cat->show_in_app? 'checked':''}} id="show_in_app" >
            <label class="form-check-label text-dark" for="show_in_app">
            ظهور التصنيف فى التطبيق
            </label>
        </div>
      </div>

    </div>
  </div>
  @if ($errors->any())
    <div class="alert alert-danger m-3 mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif





  <button type="submit" class="btn btn-primary m-4 ">حفظ التعديلات</button>
</form>
@endsection

@section('scripts')

@endsection
