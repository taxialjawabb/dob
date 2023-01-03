
@extends('index')
@section('title','اضافة مست للمستخدم')
@section('content')

<h5 class="mt-4">أضافة مستند للمستخدم</h5>

<form  method="POST" action="{{ url('user/documents/add/'. $user->id) }}"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}" require>
    <div class="row">
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="document_type" class="form-label">نــوع المستند</label>
            <input type="text" value="{{ old('document_type') }}" name="document_type" class="form-control" id="document_type"  required>
        </div>
    </div>
    <div class="row">
        <div class="mb-2 col-sm-12 col-lg-6">
            <label for="message-text" class="col-form-label">الـوصــف:</label>
            <textarea name="content"  value="{{ old('content') }}"  class="form-control" id="message-text" required></textarea>
        </div>
    </div>

    <div class="mb-2 mt-1 ">
        <label for="formFile" class="form-label">المرفق</label>
        <input class="form-control"type="file" name="image" value="{{old('image')}}"  id="file" required>
    </div>

    <div class="text-center image">
        <img src="{{ asset('assets/images/pleaceholder/image.png')}}" style="width: 200px; height: 200px" id="profile-img-tag" alt="المرفق">
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

    <button type="submit" class="btn btn-primary">حفظ التغير</button>
</form>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}" ></script>   

@endsection