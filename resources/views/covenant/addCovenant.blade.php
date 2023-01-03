
@extends('index')
@section('title','أضـافـة عهدة جديده')
@section('content')

<h5 class="mt-4">أضافة عهدة</h5>

<form  method="POST" action="{{ url('covenant/add') }}">
    @csrf
    <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="covenant_name" class="form-label">اسم العهدة</label>
        <input type="text" value="{{ old('covenant_name') }}" name="covenant_name" class="form-control" id="covenant_name"  required>
    </div>
      
    <button type="submit" class="btn mt-4 btn-primary">حفظ </button>
</form>
@endsection

@section('scripts')

@endsection