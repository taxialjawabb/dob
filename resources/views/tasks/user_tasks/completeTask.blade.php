
@extends('index')
@section('title','تعديل بيانات الراكب')
@section('content')

<h5 class="mt-4">تحويل حالة السائق</h5>

<form  method="POST" action="{{ url('tasks/user/add') }}">
    @csrf
    <div class="row">
        <input type="hidden" name="id" value="$id">
        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="type" value="{{$type}}">
        <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="state" class="form-label">حالة المهمة</label>
            <select value="{{ old('state') }}" name="state" id="state" class="form-select" aria-label="Default select example" id="state" required>
            <option value="uncomplete">لم تكتمل</option>
            <option value="complete">انهاء للمهمة</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-12 col-lg-6">
            <label for="message-text" class="col-form-label">النتيجة:</label>
            <textarea name="result" class="form-control" id="message-text" required>{{ old('result') }}</textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">حفظ </button>
</form>
@endsection

@section('scripts')

@endsection