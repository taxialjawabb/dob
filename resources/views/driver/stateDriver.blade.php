
@extends('index')
@section('title','تعديل بيانات الراكب')
@section('content')
<h5 class="mt-4">تحويل حالة السائق</h5>

<form  method="POST" action="{{ url('driver/state') }}">
    @csrf
    <div class="row">
        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="length" value="{{count($covenants)}}">
        <div class="mt-4 mb-3 col-sm-12 col-lg-6">
        <label for="state" class="form-label">تغير الحالة الى</label>
        <select  name="state" value="{{ old('state') }}" class="form-select" aria-label="Default select example" id="state" required>
            <option value="waiting">سائق انتظار</option>
            <option value="blocked">سائق مستبعد</option>
        </select>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-12 col-lg-6">
            <label for="message-text" class="col-form-label">السبب:</label>
            <textarea name="reason" class="form-control" id="message-text" required></textarea>
        </div>

        
    </div>
    <div class="row">
    @foreach($covenants as $item)
        <div class="mt-4  col-sm-12 col-md-6 col-lg-4 col-xl-4 ">
            <input type="checkbox" name="item[]" id="item{{$item->id}}" value="{{$item->id}}" required >
            <label for="item{{$item->id}}"  class="form-label">{{$item->id}} : {{$item->covenant_name}}  {{$item->serial_number === null? "": "  رقم تسلسلى $item->serial_number "}}</label>
            
        </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary">حفظ التغير</button>
</form>
@endsection

@section('scripts')

@endsection