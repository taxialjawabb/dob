
@extends('index')
@section('title','تعديل صنف')
@section('content')
<div class="container">
  <h3 class="m-2 mt-4">تعديل الصنف : {{ $product->name }}</h3>
</div>
<form method="POST" action="{{ url('maintenance/center/update') }}" enctype="multipart/form-data">
  <input type="hidden" name="id"  value="{{ $product->id }}">
  @csrf
  <div class="container">
    <div class="row">

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم الصنف</label>
        <input type="text" value="{{ $product->name }}" name="name" class="form-control" id="name"  required>
      </div>
      
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="free_count" class="form-label">العدد المجانى</label>
        <input type="text" value="{{ $product->free_count }}" name="free_count" class="form-control" id="free_count"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="periodic_days" class="form-label">المدة الدورية للعدد المجانى</label>
        <select value="{{ $product->periodic_days }}" name="periodic_days" id="periodic_days" class="form-select" aria-label="Default select example" id="periodic_days">
            <option value="" selected disabled>حدد المدة المجانية للتغير </option>
            <option value="7" {{ $product->periodic_days === 7 ? 'selected' : ''}}>اسبوعى </option>
            <option value="14"  {{ $product->periodic_days === 14 ? 'selected' : ''}}>كل اسبوعين</option>
            <option value="30"  {{ $product->periodic_days === 30 ? 'selected' : ''}}>شهرى</option>
            <option value="183"  {{ $product->periodic_days === 183 ? 'selected' : ''}}>نصف سنوى</option>
            <option value="365"  {{ $product->periodic_days === 365 ? 'selected' : ''}}>سنوى</option>
        </select>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="price" class="form-label">سعر الاضافى</label>
        <input type="text" value="{{ $product->price }}" name="price" class="form-control" id="price"  required>
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
  




  <button type="submit" class="btn btn-primary m-4 ">حفظ التعديلات</button>
</form>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}" ></script>   

@endsection