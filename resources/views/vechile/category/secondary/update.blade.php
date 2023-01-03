
@extends('index')
@section('title','تعديل تصنيف')
@section('content')
<div class="container">
  <h3 class="m-2 mt-3">تعديل التصنيف رقم {{$cat->id}}</h3>
</div>
<form method="POST" action="{{ url('vechile/update/secondary/cagegory')}}">
  @csrf
  <input type="hidden" class="hidden" name="id" value="{{$cat->id}}">
  <div class="container">
    <div class="row">
      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم التصنيف</label>
        <input type="text" value="{{ $cat->name}}" name="name" class="form-control"  required>
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

      <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="category_percent" class="form-label">النسبة  </label>
        <input type="text" value="{{ $cat->category_percent}}" name="category_percent" class="form-control">
      </div>
      
      <!-- <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6" id="fixed_percentage" {{$cat->percentage_type =='percent'? 'style=display:none': ''}}>
        <label for="fixed_percentage" class="form-label">النسبة الثابتة</label>
        <input type="text" value="{{ $cat->fixed_percentage}}" name="fixed_percentage" class="form-control" >
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
  




  <button type="submit" class="btn btn-primary m-4 ">حفظ التعديلات</button>
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