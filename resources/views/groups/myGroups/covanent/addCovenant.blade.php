
@extends('index')
@section('title','أضـافـة عهدة جديده')
@section('content')
<div>
    <a  href="{{url('my/groups/show')}}" class="btn text-primary "> مجموعاتى الخاصة </a>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary">{{$group->name}} </a>
    <a href="{{ route('my.groups.covenant.show', $group) }}" class="btn text-primary">العهد</a>

  </div>
<h5 class="mt-4">أضافة عهدة</h5>

<form  method="POST" action="{{ route('my.groups.covenant.save', $group) }}">
    @csrf
    <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="covenant_name" class="form-label">اسم العهدة</label>
        <input type="text" value="{{ old('covenant_name') }}" name="covenant_name" class="form-control" id="covenant_name"  required>
    </div>

    <div class="mt-3  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="covenant_name" class="form-label"> رقم المسلسل</label>
        <input type="text" value="{{ old('serial_number') }}" name="serial_number" class="form-control" id="covenant_name"  required>
        <input type="hidden" value="{{ $group->id }}" name="id" class="form-control" id="covenant_name"  required>
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
    <button type="submit" class="btn mt-4 btn-primary">حفظ </button>
</form>
@endsection

@section('scripts')

@endsection
