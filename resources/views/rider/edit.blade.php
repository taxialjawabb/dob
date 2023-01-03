
@extends('index')
@section('title','تعديل بيانات الراكب')
@section('content')
<div>
    <div class="row">
        <div class="col-12 mt-5"></div>
        <div class="col-6">
            الاسم: {{$rider->name}}
        </div>
        <div class="col-6">
            الهاتف: {{$rider->phone}}
        </div>
        <div class="col-12 mt-3"></div>
        <div class="col-6">
            حالة العميل الحالية: <span class="alert alert-secondary p-2">{{$rider->state == 'active'?'نشط' : 'محظور'}}</span>
        </div>
        <div class="col-6">
            البريد الإلكترونى: {{$rider->email}}
        </div>
        <div class="col-12 mt-4"></div>
        <div class="col-12 mt-4">
            <form action="{{ route('update.rder.city', $rider) }}" method="post">
                @csrf
                <div class="row">
                    <div class="mt-2  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                        <label for="address" class="form-label">اسم مدينة الإقامة</label>
                        <select value="{{ old('address') }}" name="address" id="address" class="form-select"
                            aria-label="Default select example" id="address" required>
                            <option value="" selected disabled>حدد المدينة</option>
                            <option value="الرياض" {{ $rider->address =='الرياض' ? 'selected' : '' }}>الرياض </option>
                            <option value="جدة" {{ $rider->address =='جدة' ? 'selected' : '' }}>جدة </option>
                            <option value="مكه" {{ $rider->address =='مكه' ? 'selected' : '' }}>مكه </option>
                            <option value="المدينة المنورة" {{ $rider->address =='المدينة المنورة' ? 'selected' : '' }}>المدينة المنورة </option>
                            <option value="الدمام" {{ $rider->address =='الدمام' ? 'selected' : '' }}>الدمام </option>
                            <option value="الهفوف" {{ $rider->address =='الهفوف' ? 'selected' : '' }}>الهفوف </option>
                            <option value="بريده" {{ $rider->address =='بريده' ? 'selected' : '' }}>بريده </option>
                            <option value="الحله" {{ $rider->address =='الحله' ? 'selected' : '' }}>الحله </option>
                            <option value="الطائف" {{ $rider->address =='الطائف' ? 'selected' : '' }}>الطائف </option>
                            <option value="تبوك" {{ $rider->address =='تبوك' ? 'selected' : '' }}>تبوك </option>
                            <option value="خميس مشيط" {{ $rider->address =='خميس مشيط' ? 'selected' : '' }}>خميس مشيط </option>
                            <option value="حائل" {{ $rider->address =='حائل' ? 'selected' : '' }}>حائل </option>
                            <option value="القطيف" {{ $rider->address =='القطيف' ? 'selected' : '' }}>القطيف </option>
                            <option value="المبرز" {{ $rider->address =='المبرز' ? 'selected' : '' }}>المبرز </option>
                            <option value="الخرج" {{ $rider->address =='الخرج' ? 'selected' : '' }}>الخرج </option>
                            <option value="نجران" {{ $rider->address =='نجران' ? 'selected' : '' }}>نجران </option>
                            <option value="ينبع" {{ $rider->address =='ينبع' ? 'selected' : '' }}>ينبع </option>
                            <option value="ابها" {{ $rider->address =='ابها' ? 'selected' : '' }}>ابها </option>
                            <option value="عرعر" {{ $rider->address =='عرعر' ? 'selected' : '' }}>عرعر </option>
                            <option value="جزان" {{ $rider->address =='جزان' ? 'selected' : '' }}>جزان </option>
                            <option value="سكاكا" {{ $rider->address =='سكاكا' ? 'selected' : '' }}>سكاكا </option>
                            <option value="الباحه" {{ $rider->address =='الباحه' ? 'selected' : '' }}>الباحه </option>
                            <option value="اخري" {{ $rider->address =='اخري' ? 'selected' : '' }}>اخري </option>
                        </select>
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
                   <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4">
                       <button type="submit" class="btn btn-primary mt-3">حفظ التعديل</button>
                   </div>
                </div>
            </form>
        </div>

        <div class="col ">تعديل حالة العميل الـى</div>
        <div class="col m-4"></div>
    </div>
    @if($rider->state == 'blocked')
    <a href="{{ url('rider/edit/state/'.$rider->id)}}" class="btn btn-success mb-3"> تحويل حالة العميل إلى نشط</a>
    <p class="alert alert-success ml-6 mr-6">يتمكن العميل من الدخول للتطبيق وعمل رحلات</p>
    @else
    <a href="{{ url('rider/edit/state/'.$rider->id)}}" class="btn btn-danger mb-3 ">حظر العميل </a>
    <p class="alert alert-danger ml-6 mr-6">لا يتمكن العميل من الدخول للتطبيق وعمل رحلات</p>
    @endif
</div>

@endsection

@section('scripts')

@endsection
