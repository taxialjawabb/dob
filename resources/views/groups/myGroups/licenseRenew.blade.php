
@extends('index')
@section('title', 'تجديد رخصة')
@section('content')

<h5 class="mt-4">تجديد رخصة</h5>

<form  method="POST" action="{{ route('my.groups.license', ['group' => $group]) }}"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="driver_id" value="{{ $group->id }}" required>


    <div class="row">

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label for="document_type" class="form-label"> نوع الرخصة المراد تجديدها</label>
            <select value="{{ old('document_type') }}" name="document_type" id="document_type" class="form-select"
                aria-label="Default select example" id="document_type" required>
                <option value="" selected disabled>حدد نوع الرخصة المراد تجديدها</option>
                <option value="commercial_register">السجل التجاري</option>
                <option value="transportation_license_number"> ترخيص هيئة النقل</option>
                <option value="municipal_license_number">رخصة البلدية</option>
            </select>
        </div>

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div style="position: relative">
                <label for="expire_date" class="form-label">تاريخ انتهاء الرخصة</label>
                <input type="text" value="{{ old('expire_date') }}" class="form-control input-date"
                    id="expire_date" required  autocomplete="off">
                <input type='hidden' name="expire_date" class="form-control expire_date" required />
            </div>
        </div>

        <div class="mb-2 col-sm-12 col-lg-6">
            <label for="content" class="col-form-label">الـوصــف:</label>
            <textarea name="content"  value="{{ old('content') }}"  class="form-control" id="message-text" ></textarea>
        </div>
    </div>

    <div class="mb-2 mt-1 ">
        <label for="formFile" class="form-label">ملف الرخصة </label>
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
<script>
    $(document).ready(function(){
        $(".input-date").hijriDatePicker({
          //  hijri:true
        });

        $(".input-date").on('dp.change', function (arg) {
            let date = arg.date;
            let className = $(this).attr('id');
            $('.'+className).val(date.format("YYYY/M/D"));

            // $("#selected-date").html(date.format("YYYY/M/D") + " Hijri:" + date.format("iYYYY/iM/iD"));
        });
    });
</script>
@endsection
