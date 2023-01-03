@extends('index')
@section('title','أضافة ملاحظة')
@section('content')
<div class="mt-2">
    <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.note.show', ['group' => $group]) }}" class="btn text-primary p-1">الملاحظات </a>

  </div>
<h5 class="mt-4">أضافة ملاحظة للمجموعات</h5>

<form method="POST" action="{{ route('shared.groups.note', $group->id) }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="group_id" value="{{ $group->id }}" required>
    <div class="row">
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="note_type" class="form-label">نــوع الملاحظة</label>
            <input type="text" value="{{ old('note_type') }}" name="note_type" class="form-control" id="note_type"
                required>
        </div>
    </div>
    <div class="row">
        <div class="mb-2 col-sm-12 col-lg-6">
            <label for="message-text" class="col-form-label">الـوصــف:</label>
            <textarea name="content" value="{{ old('content') }}" class="form-control" id="message-text"
                required></textarea>
        </div>
    </div>

    <div class="mb-2 mt-1 ">
        <label for="formFile" class="form-label">المرفق</label>
        <input class="form-control" type="file" name="image" value="{{old('image')}}" id="file">

        <div class="text-center image">
            <img src="{{ asset('assets/images/pleaceholder/image.png')}}" style="width: 200px; height: 200px"
                id="profile-img-tag" alt="المرفق">
        </div>

        <button type="submit" class="btn btn-primary">حفظ التغير</button>
</form>
@if ($errors->any())
<div class="alert alert-danger m-3 mt-4">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}"></script>

@endsection
