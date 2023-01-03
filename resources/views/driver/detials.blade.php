
@extends('index')
@section('title','بيانات السائق')
@section('content')
<div class="container clearfix">
    <h3 class="m-2 mt-4 float-start">عرض بيانات السائق</h3>
    <div class="float-end mt-4">

    @if(Auth::user()->isAbleTo('driver_box'))
    <a href="{{ url('driver/box/show/take/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">الصندوق</a>
    @endif
    @if(Auth::user()->isAbleTo('driver_box'))
    <a href="{{ route('driver.delayed.weekly.payment', $driver) }}" class="btn btn-primary rounded-0 m-1">تأخيرات الدفع الأسبوعية</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_document_notes'))
    <a href="{{ url('driver/notes/show/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">الملاحظات</a>
    <a href="{{ url('driver/documents/show/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">المستندات</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_take_vechile'))
    <a href="{{ url('driver/take/vechile/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1" >تسليم مركبة</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_convert_status'))
    <a href="{{ url('driver/state/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1" >تحويل حالة السائق</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_delegate_data'))
    <a href="{{ url('driver/delegate/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">التفويض</a>
    @endif
    <a href="{{ route('driver.receive.covenant',[ 'driver' => $driver, 'vechile' => $vechile->id?? null]) }}" class="btn btn-primary rounded-0 m-1">أقرار استلام عهدة</a>
    @if(Auth::user()->isAbleTo('driver_sample_data'))
    <a href="{{ url('driver/sample/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">مخالصة مالية</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_vechial_delivered'))
    <a href="{{ url('driver/vechile/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">عرض المركبات المستلمة</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_maintain_show'))
    <a href="{{ url('driver/vechile/maintenance/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">صيانة</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_covenant_delivered'))
    <a href="{{ url('covenant/delivery/'.$driver->id) }}" class="btn btn-primary rounded-0 m-1">عرض العهد المستلمة</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_update_data'))
    <a href="{{ url('driver/update/'.$driver->id) }}" class="btn btn-danger rounded-0 m-1">تعديل</a>
    @endif




    {{-- <a href="{{ url('driver/contract/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0">العقد</a> --}}


  </div>
</div>

  <div class="container">
    <div class="row">

    @if($driver->persnol_photo && File::exists('public/assets/images/drivers/personal_phonto/'.$driver->persnol_photo))
    <div class="text-center-1 image m-1">
        <img src="{{ asset('assets/images/drivers/personal_phonto/'.$driver->persnol_photo)}}" style="width: 80px; height: 100px" id="profile-img-tag" alt="صورة السائق">
    </div>
    @endif

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم السائق</label>
        <p class="alert alert-secondary p-1">{{$driver->name}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="phone" class="form-label">الحالة الحالية</label>
        <p class="alert alert-secondary p-1">
        @switch($driver->state)
          @case('active')
              سائق مستلم
              @break
          @case('waiting')
              سائق انتظار
              @break
          @case('blocked')
              سائق مستبعد
              @break
          @case('pending')
              سائق قيد المراجعة
              @break
          @default
              Default case...
        @endswitch
        </p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="phone" class="form-label">رقم الهاتف</label>
        <p class="alert alert-secondary p-1">{{$driver->phone}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <p class="alert alert-secondary p-1">{{$driver->nationality}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="address" class="form-label">عنوان السكن</label>
        <p class="alert alert-secondary p-1">{{$driver->address}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="id_type" class="form-label">نوع الهوية</label>
        <p class="alert alert-secondary p-1">{{$driver->id_type}}</p>
      </div>
      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <p class="alert alert-secondary p-1">{{$driver->ssd}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_copy_no" class="form-label">رقم نسخة الهوية</label>
        <p class="alert alert-secondary p-1">{{$driver->id_copy_no}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_expiration_date" class="form-label">تاريخ انتهاء الهوية</label>
        <p class="alert alert-secondary p-1">{{$driver->id_expiration_date}}</p>
      </div>

      <!-- <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_type" class="form-label">نوع الرخصة</label>
        <p class="alert alert-secondary p-1">{{$driver->license_type}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_expiration_date" class="form-label">تاريخ إنتهاء الرخصة</label>
        <p class="alert alert-secondary p-1">{{$driver->license_expiration_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="birth_date" class="form-label">تاريخ الميلاد</label>
        <p class="alert alert-secondary p-1">{{$driver->birth_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="start_working_date" class="form-label">تاريخ بداية العمل</label>
        <p class="alert alert-secondary p-1">{{$driver->start_working_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="contract_end_date" class="form-label">تاريخ انتهاء عقد العمل</label>
        <p class="alert alert-secondary p-1">{{$driver->contract_end_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_date" class="form-label">تاريخ انتهاء المخالصة النهائية</label>
        <p class="alert alert-secondary p-1">{{$driver->final_clearance_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="driver_rate" class="form-label">تقيم السائق</label>
        <p class="alert alert-secondary p-1">{{$driver->driver_rate}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="vechile_rate" class="form-label">تقيم المركبة</label>
        <p class="alert alert-secondary p-1">{{$driver->vechile_rate}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="time_rate" class="form-label">تقيم الوقت</label>
        <p class="alert alert-secondary p-1">{{$driver->time_rate}}</p>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="mt-1 pt-1">
            <input type="checkbox" name="on_company" class="form-check-input"
                id="on_company"  @checked($driver->on_company==1) disabled>
            <label for="on_company" class="form-check-label text-dark ms-2 on_company" >
                على كفالة الشركة</label>
        </div>
    </div>

      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="time_rate" class="form-label">الراتب الكلى</label>
        <p class="alert alert-secondary p-1">{{$driver->monthly_salary}}</p>
      </div>
      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="time_rate" class="form-label">الاستقطاع</label>
        <p class="alert alert-secondary p-1">{{$driver->monthly_deduct}}</p>
      </div>
      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="time_rate" class="form-label">التأمينات</label>
        <p class="alert alert-secondary p-1">{{$driver->insurances}}</p>
      </div>
      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="time_rate" class="form-label">الراتب المستحق</label>
        <p class="alert alert-secondary p-1">{{$driver->monthly_salary - ($driver->monthly_deduct + $driver->insurances)}}</p>
      </div>
      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="time_rate" class="form-label">ايام الاجازة</label>
        <p class="alert alert-secondary p-1">{{$driver->vacation_days}}</p>
      </div>
      <div class="mt-0  col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
        <label for="time_rate" class="form-label">ايام المتبقى من الاجازة</label>
        <p class="alert alert-secondary p-1">{{$driver->vacation_days_remains}}</p>
      </div>

    </div>
  </div>

@if($vechile !== null)

  <h5> بيانات المركبة  الحالية للسائق</h5>

<div class="container">
    <div class="row">

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="daily_revenue_cost" class="form-label">تكلفة العائد اليومي للمركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->daily_revenue_cost}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="maintenance_revenue_cost" class="form-label">تكلفة العائد اليومي للصيانة</label>
        <p class="alert alert-secondary p-1">{{$vechile->maintenance_revenue_cost??'لا يوجد'}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="identity_revenue_cost" class="form-label">تكلفة العائد اليومي للأقامة</label>
        <p class="alert alert-secondary p-1">{{$vechile->identity_revenue_cost}}</p>
      </div>


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
        <p class="alert alert-secondary p-1">{{$vechile->state}}</p>
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
@endif





@endsection

@section('scripts')

@endsection
