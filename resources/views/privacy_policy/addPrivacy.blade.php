@extends('index')
@section('title','إضافة جديدة')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">أضافة جديدة</h3>
</div>
<form method="POST" action="{{ url('privacy/policy/show/add') }}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row">
            <div class="mt-4 mb-1 col-12">
                <p class="h5">
                    خاصــة بـــ
                </p>
            </div>
            <div class="mb-3 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <input class="form-check-input" type="radio" name="belong_to" value="policy" id="belong_to1" required @checked(old('belong_to') == 'policy')>
                <label class="form-check-label" for="belong_to1">
                    سياسة الخصوصيــة
                </label>
            </div>
            <div class="mb-3 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <input class="form-check-input" type="radio" name="belong_to" value="terms" id="belong_to2" required @checked(old('belong_to') == 'terms')>
                <label class="form-check-label" for="belong_to2">
                    الشروط و الأحكــــام
                </label>
            </div>
        </div>
        <div class="row">
            <div class="mt-4 mb-1 col-12">
                <p class="h5">
                    موجـــه إلــى
                </p>
            </div>
            <div class="mb-3 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <input class="form-check-input" type="radio" name="type" value="driver" id="type1" required @checked(old('type') == 'driver')>
                <label class="form-check-label" for="type1">
                    سائق
                </label>
            </div>
            <div class="mb-3 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <input class="form-check-input" type="radio" name="type" value="rider" id="type2" required @checked(old('type') == 'rider')>
                <label class="form-check-label" for="type2">
                    عميل
                </label>
            </div>
            <div class="mb-3 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <input class="form-check-input" type="radio" name="type" value="all" id="type3" required @checked(old('type') == 'all')>
                <label class="form-check-label" for="type3">
                    الجميع
                </label>
            </div>
        </div>

        <div class="row">

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="ar_title" class="form-label"> العنوان بالعربي</label>
                <input type="text" name="ar_title" maxlength="250" value="{{ old('ar_title') }}" class="form-control" id="ar_title" required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="en_title" class="form-label"> العنوان بالانجليزي</label>
                <input type="text" name="en_title" maxlength="250" value="{{ old('en_title') }}" class="form-control" id="en_title" required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="ar_content" class="form-label"> المحتوي بالعربي</label>
                <textarea class="form-control" maxlength="3000" name="ar_content" id="ar_content" rows="6"></textarea>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="en_content" class="form-label"> المحتوي بالانجليزي</label>
                <textarea class="form-control" maxlength="3000" name="en_content" id="en_content" rows="6"></textarea>
            </div>







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





    <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات </button>
</form>
@endsection

@section('scripts')

@endsection
