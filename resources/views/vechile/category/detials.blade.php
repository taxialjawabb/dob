
@extends('index')
@section('title','عرض التصنيف')
@section('content')
<div class="mt-3 mb-3 container clearfix">
  <h4 class=" float-start">بيانات المركبة </h4>
  <div class="float-end">

    @if(Auth::user()->isAbleTo('vechile_add_new_sub_category'))
    <a href="{{ url('vechile/add/cagegory/secondary/'.$cat->id) }}" class="btn btn-primary rounded-0 m-0">اضافة تصنيف داخلي</a>
    @endif
  </div>
</div>

  <div class="container">
    <div class="row">

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">اسم التصنيف</label>
        <p class="alert alert-secondary p-1">{{ $cat->category_name }}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="basic_price" class="form-label">السعر الاساسي للتصنيف</label>
        <p class="alert alert-secondary p-1">{{ $cat->basic_price }}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="km_cost" class="form-label">تكلفة الكيلو متر</label>
        <p class="alert alert-secondary p-1">{{ $cat->km_cost }}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="km_cost" class="form-label">تكلفة الدقيقة</label>
        <p class="alert alert-secondary p-1">{{ $cat->minute_cost }}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="reject_cost" class="form-label">تكلفة رفض الطلب للسائق</label>
        <p class="alert alert-secondary p-1">{{ $cat->reject_cost }}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="cancel_cost" class="form-label">تكلفة إلغاء الطلب للعميل</label>
        <p class="alert alert-secondary p-1">{{ $cat->cancel_cost }}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="minimum_order" class="form-label">تكلفة الحد الأدنى لأنشاء طلب</label>
        <p class="alert alert-secondary p-1">{{ $cat->minimum_order ?? 0 }}</p>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
        <div class="form-check " style="margin-top:36px">
            <input class="form-check-input" name="show_in_app" type="checkbox" {{$cat->show_in_app? 'checked':''}} id="show_in_app" disabled>
            <label class="form-check-label text-dark" for="show_in_app">
            ظهور التصنيف فى التطبيق
            </label>
        </div>
      </div>



    </div>
  </div>

  <div class="container mt-5">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">الاسم</th>
          <th scope="col">نوع النسبة</th>
          <th scope="col">النسبة</th>
          <th scope="col">تاريخ الاضافة</th>
          <th scope="col">تعديل</th>
        </tr>
      </thead>
      <tbody>
        @foreach($secondary as $s)
        <tr>
          <th scope="row">{{$s->id}}</th>
          <td>{{$s->name}}</td>
          <td>{{$s->percentage_type == 'fixed'? 'النسبة ثابتة':'النسبة مئوية'}}</td>
          <td>{{$s->category_percent}}</td>
          <td>{{$s->add_date}}</td>
          <td>
            @if(Auth::user()->isAbleTo('vechile_sub_category_update'))
            <a href="{{ url('vechile/update/secondary/cagegory/'.$s->id) }}" class="btn btn-danger">تعديل</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection

@section('scripts')

@endsection
