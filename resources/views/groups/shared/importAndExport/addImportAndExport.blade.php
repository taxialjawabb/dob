
@extends('index')
@section('title','أضافة صادر و وارد')
@section('content')
<div class="mt-2">
    <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
    <i class="arrow left "></i>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>
    <i class="arrow left "></i>

    <a href="{{ url('shared/groups/importandexport/show/export/'.$group->id) }}" class="btn text-primary p-1 ">الصادر</a>
  </div>
<h5 class="mt-4">أضافة صادر و وارد</h5>

<form  method="POST" action="{{ url('shared/groups/importandexport/add' ) }}"  enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mt-5 mb-3 col-sm-6 col-lg-3">
            <input class="form-check-input" type="radio" name="type" value="export" id="type1" required>
            <label class="form-check-label" for="type1">
              صادر
            </label>
          </div>
          <div class="mt-5 mb-3 col-sm-6 col-lg-3">
            <input class="form-check-input" type="radio" name="type" value="import" id="type2" required >
            <label class="form-check-label" for="type2">
              وارد
            </label>
          </div>
    </div>

    <div class="row">
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="title" class="form-label">حدد الجهة الموجه او الصادر إليها</label>
            <input type="text" value="{{ old('stackholder') }}" name="stackholder" class="form-control" id="title"  required>
            <input type="hidden" value="{{$id}}" name="group_id" class="form-control" id="title"  required>
        </div>
    </div>
    <div class="row">
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="title" class="form-label">العنوان</label>
            <input type="text" value="{{ old('title') }}" name="title" class="form-control" id="title"  required>
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-12 col-lg-6">
            <label for="content" class="col-form-label">الـوصــف:</label>
            <textarea name="content"  value="{{ old('content') }}"  class="form-control" id="content" required></textarea>
        </div>
    </div>

    <div class="mt-3 col-sm-12 col-lg-6">
        <label for="formFile" class="form-label">المرفق (أختيارى)</label>
        <input class="form-control"type="file" name="image" value="{{old('image')}}"  id="file">

    <div class="text-center image mt-2">
        <img src="{{ asset('assets/images/pleaceholder/image.png')}}" style="width: 200px; height: 200px" id="profile-img-tag" alt="المرفق">
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
<script src="{{ asset('assets/js/addimg.js') }}" ></script>

@endsection
