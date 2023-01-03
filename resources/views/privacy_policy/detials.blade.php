@extends('index')
@section('title', $policy->belong_to == "policy" ? "سياسة الخصوصية": "الشروط و الأحكام")
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">
        @switch($policy->belong_to)
            @case('policy')
            سياسة الخصوصيــة
                @break
            @case('terms')
            الشروط و الأحكــــام
                @break
        @default
    @endswitch
    </h3>
</div>

    <div class="container">
        <div class="row">
            <div class="mt-5 col-12">
                <label class="form-check-label" for="type1">
                    خاصــة بـــ
                </label>
                <p class="alert alert-secondary mt-2 p-2">
                    @switch($policy->belong_to)
                        @case('policy')
                        سياسة الخصوصيــة
                            @break
                        @case('terms')
                        الشروط و الأحكــــام
                            @break
                        @default
                    @endswitch
                </p>

            </div>
        </div>
        <div class="row">
            <div class="mt-2 col-12">
                <label class="form-check-label" for="type1">
                    موجهة إلى
                </label>
                <p class="alert alert-secondary mt-2 p-2">
                    @switch($policy->type)
                        @case('driver')
                            السائق
                            @break
                        @case('rider')
                            العميل
                            @break
                        @case('all')
                            الجميع
                            @break
                        @default
                    @endswitch
                </p>

            </div>
        </div>

        <div class="row">

            <div class="mt-2 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="ar_title" class="form-label"> العنوان بالعربي</label>
                <p class="alert alert-secondary p-2">{{ $policy->ar_title }}</p>
            </div>

            <div class="mt-2 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="en_title" class="form-label"> العنوان بالانجليزي</label>
                <p class="alert alert-secondary p-2">{{ $policy->en_title }}</p>
            </div>

            <div class="mt-2 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="ar_content" class="form-label"> المحتوي بالعربي</label>
                <p class="alert alert-secondary p-2">{{ $policy->ar_content }}</p>
            </div>

            <div class="mt-2 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="en_content" class="form-label"> المحتوي بالانجليزي</label>
                <p class="alert alert-secondary p-2">{{ $policy->en_content }}</p>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
