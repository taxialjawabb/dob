
@extends('index')
@section('title','تعديل بيانات الراكب')
@section('content')

<h5 class="mt-4">تحويل حالة السائق</h5>

<form  method="POST" action="{{ url('vechile/state') }}">
    @csrf
    <div class="row">
        <input type="hidden" name="id" value="{{$id}}">
        <div class="mt-4 mb-3 col-sm-12 col-lg-6">
        <label for="state" class="form-label">تغير الحالة الى</label>
        <select  name="state" value="{{ old('state') }}" class="form-select" aria-label="Default select example" id="state" required>
            <option value="waiting">مركبة انتظار</option>
            <option value="blocked">مركبة مستبعد</option>
        </select>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-12 col-lg-6">
            <label for="message-text" class="col-form-label">السبب:</label>
            <textarea name="reason" class="form-control" id="message-text" required></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">حفظ التغير</button>
</form>
@endsection

@section('scripts')

@endsection