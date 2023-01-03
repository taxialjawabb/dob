
@extends('index')
@section('title', 'حالة المجموعة')
@section('content')

<h5 class="mt-4">تغير حالة المجموعة</h5>

<form  method="POST" action="{{ route('manage.groups.state', ['group' => $group]) }}"  enctype="multipart/form-data">
    @csrf

    <div class="row">

        <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            @if ($group->state == 'active')
            <label for="document_type" class="form-label"> أستبعاد هذه المجموعة</label>

            @else
            <label for="document_type" class="form-label"> إلغاء استبعاد هذه المجموعة</label>

            @endif
        </div>



        <div class="mb-2 col-sm-12 col-lg-6"></div>
        <div class="mb-2 col-sm-12 col-lg-6">
            <label for="content" class="col-form-label">الإسباب:</label>
            <textarea name="content"  value="{{ old('content') }}"  class="form-control" id="message-text" ></textarea>
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

    <button type="submit" class="btn btn-primary">حفظ التغير</button>
</form>
@endsection

@section('scripts')
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
