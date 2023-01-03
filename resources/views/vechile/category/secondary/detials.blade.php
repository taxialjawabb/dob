
@extends('index')
@section('title','عرض التصنيف الفرعية')
@section('content')
  <div class="container">
    <div class="row">
      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">اسم التصنيف</label>
        <input type="text" value="{{ $cat->category_name }}" name="category_name" class="form-control"  disabled>
      </div>

      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="basic_price" class="form-label">السعر الاساسي للتصنيف</label>
        <input type="text" name="basic_price"  value="{{ $cat->basic_price }}" class="form-control" id="basic_price"  disabled>
      </div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="km_cost" class="form-label">تكلفة الكيلو متر</label>
        <input type="text" value="{{ $cat->km_cost }}" name="km_cost" class="form-control" id="km_cost"  disabled>
      </div>

      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="reject_cost" class="form-label">تكلفة رفض الطلب للسائق</label>
        <input type="text" value="{{ $cat->reject_cost }}" name="reject_cost" class="form-control" id="reject_cost"  disabled>
        
      </div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="cancel_cost" class="form-label">تكلفة إلغاء الطلب للعميل</label>
        <input type="text" value="{{ $cat->cancel_cost }}" name="cancel_cost" class="form-control" id="cancel_cost"  disabled>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
        <div class="form-check mt-5">
            <input class="form-check-input" name="show_in_app" type="checkbox" {{$cat->show_in_app? 'checked':''}} id="show_in_app" disabled>
            <label class="form-check-label text-dark" for="show_in_app">
            ظهور التصنيف فى التطبيق
            </label>
        </div>
      </div>
      
      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="percentage_type" class="form-label">نوع النسبة </label>
        <input type="text" value="{{ $cat->percentage_type == 'fixed'? 'النسبة ثابتة':'النسبة مئوية' }}" name="percentage_type" class="form-control" id="percentage_type"  disabled>
      </div>

          
      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>
      <div class="mt-3 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <label for="daily_revenue_cost" class="form-label">تكلفة العائد اليومي</label>
        <input type="text" value="{{ $cat->daily_revenue_cost }}" name="daily_revenue_cost" class="form-control" id="daily_revenue_cost"  disabled>
      </div>

      <div class="mt-3 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <label for="category_percent" class="form-label">النسبة  </label>
        <input type="text" value="{{ $cat->category_percent }}" name="category_percent" class="form-control" id="category_percent"  disabled>
      </div>
      
      <!-- <div class="mt-3 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <label for="fixed_percentage" class="form-label">النسبة الثابتة</label>
        <input type="text" value="{{ $cat->fixed_percentage }}" name="fixed_percentage" class="form-control" id="fixed_percentage"  disabled>
      </div> -->


    </div>
  </div>

@endsection

@section('scripts')

@endsection