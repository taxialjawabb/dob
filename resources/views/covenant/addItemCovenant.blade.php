
@extends('index')
@section('title','إضافة مركبة')
@section('content')
<div class="container">
  <h3 class="m-2 mt-4">أضافة مركبة جديدة</h3>
</div>
<form method="POST" action="{{ url('vechile/add') }}">
  @csrf
  <div class="container">
    <div class="row">
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="covenant_name" class="form-label">حدد نوع العهدة</label>
          <select value="{{ old('covenant_name') }}" name="covenant_name" id="covenant_name" class="form-select" aria-label="Default select example" id="covenant_name" required>
          <option value="0" selected disabled> حدد العهدة </option>
          @foreach($covenants as $covenant)
            <option value="{{$covenant->id}}">{{$covenant->covenant_name}}</option>
            @endforeach
          </select>
      </div>
      


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="vechile_type" class="form-label">الرقم التسلسلى</label>
        <input type="text" value="{{ old('vechile_type') }}" name="vechile_type" class="form-control" id="vechile_type"  >
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
  <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات المركبة</button>
</form>
@endsection

@section('scripts')

@endsection