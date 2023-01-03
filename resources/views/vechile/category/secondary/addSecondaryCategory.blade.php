
@extends('index')
@section('title','الركــاب')
@section('content')
<div class="container">
  <h3 class="m-2 mt-3">أضافة تصنيف فرعي الى التصنيف <span class="text-primary h3">{{$cat->name}}</span></h3>
</div>
<form method="POST" action="{{ url('vechile/add/cagegory/secondary') }}">
  <input type="hidden" name="category_id" value="{{ $cat->id }}">
  @csrf
  <div class="container">
    <div class="row">
      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم التصنيف الفرعي</label>
        <input type="text" value="{{ old('name') }}" name="name" class="form-control"  required>
      </div>

      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="percentage_type" class="form-label">نوع النسبة </label>
        <select value="{{ old('percentage_type') }}" name="percentage_type" class="form-select" aria-label="Default select example"  id="percentage_type"  required>
          <option selected value="percent">النسبة مئوية</option>
          <option value="fixed">النسبة ثابتة</option>
        </select>
      </div>
      
      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>

      <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6" id="category_percent">
        <label for="category_percent" class="form-label">النسبة  </label>
        <input type="text" value="{{ old('category_percent') }}" name="category_percent" class="form-control" >
      </div>
      
      <!-- <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6" id="fixed_percentage" style="display:none">
        <label for="fixed_percentage" class="form-label">النسبة الثابتة</label>
        <input type="text" value="{{ old('fixed_percentage') }}" name="fixed_percentage" class="form-control" >
      </div> -->


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
  




  <button type="submit" class="btn btn-primary m-4 ">حفظ التصنيف</button>
</form>
@endsection

@section('scripts')
<!-- <script type="text/javascript">
    $(document).ready(function(){
      $(document).on("change", '#percentage_type', function(){
        var val = $(this).val();
        if(val == 'fixed'){
          $('#category_percent').hide();
          $('#fixed_percentage').show();
        }
        else if( val == 'percent'){
          $('#category_percent').show();
          $('#fixed_percentage').hide();
        }
      });
    });
  </script> -->
@endsection