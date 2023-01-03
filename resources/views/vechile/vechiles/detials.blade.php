
@extends('index')
@section('title','إضافة مركبة')
@section('content')
<div class="mt-3 mb-3 container clearfix">
  <h4 class=" float-start">بيانات المركبة </h4>
  <div class="float-end">
    @if(Auth::user()->isAbleTo('vechile_box'))
    <a href="{{ url('vechile/box/show/take/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">الصندوق</a>
    @endif

    @if(Auth::user()->isAbleTo('vechile_document_notes|user_group'))
    <a href="{{ url('vechile/notes/show/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">الملاحظات</a>
    <a href="{{ url('vechile/documents/show/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">المستندات</a>
    @endif

    @if($vechile->state != 'active'&&Auth::user()->isAbleTo('vechile_convert_status'))
    <a href="{{ url('vechile/state/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0" >تحويل حالة المركبة</a>
    @endif
    @if(Auth::user()->isAbleTo('vechile_show_maintain'))
    <a href="{{ url('vechile/maintenance/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">الصيانة</a>
    @endif
    @if(Auth::user()->isAbleTo('vechile_show_driver_delivered'))
    <a href="{{ url('vechile/drivers/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">عرض السائقين المستلمين</a>
    @endif
    @if(Auth::user()->isAbleTo('vechile_update'))
    <a href="{{ url('vechile/update/'.$vechile->id) }}" class="btn btn-danger rounded-0 m-0">تعديل</a>
    @endif

  </div>
</div>

<div class="container">
    <div class="row">

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">التصنيف</label>
        <p class="alert alert-secondary p-1">{{$vechile->category_name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">التصنيف الفرعي</label>
        <p class="alert alert-secondary p-1">{{$vechile->name??'لا يوجد'}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="state" class="form-label">حالة المركبة</label>
        <p class="alert alert-secondary p-1">
        @switch($vechile->state)
          @case('active')
              مركبة مستلم
              @break
          @case('waiting')
              مركبة انتظار
              @break
          @case('blocked')
              مركبة مستبعده
              @break
          @default
              Default case...
      @endswitch
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="vechile_type" class="form-label">نوع المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->vechile_type}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="plate_number" class="form-label">رقم لوحة المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->plate_number}}</p>
      </div>


      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="made_in" class="form-label">سنة تصنيع المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->made_in}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="serial_number" class="form-label">الرقم التسلسلى</label>
        <p class="alert alert-secondary p-1">{{$vechile->serial_number}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="color" class="form-label">لـون المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->color}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="driving_license_expiration_date" class="form-label">تاريخ إنتهاء رخصة السير</label>
        <p class="alert alert-secondary p-1">{{$vechile->driving_license_expiration_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="periodic_examination_expiration_date" class="form-label">تاريخ إنتهاء الفحص الدورى</label>
        <p class="alert alert-secondary p-1">{{$vechile->periodic_examination_expiration_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="insurance_card_expiration_date" class="form-label">تاريخ إنتهاء التأمين</label>
        <p class="alert alert-secondary p-1">{{$vechile->insurance_card_expiration_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="operating_card_expiry_date" class="form-label">تاريخ إنتهاء بطاقة التشغيل</label>
        <p class="alert alert-secondary p-1">{{$vechile->operating_card_expiry_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="admin_name" class="form-label">تم الأضافة بواسطة</label>
        <p class="alert alert-secondary p-1">{{$vechile->admin_name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="add_date" class="form-label">تاريخ الإضافة</label>
        <p class="alert alert-secondary p-1">{{$vechile->add_date}}</p>
      </div>


    </div>
  </div>

@endsection

@section('scripts')

@endsection

