
@extends('index')
@section('title','عرض بيانات المجموعة')
@section('content')
<div class="mt-2">
  <a  href="{{url('my/groups/show')}}" class="btn text-primary ">  مجموعاتي </a>


</div>
  <div class="container clearfix">
    <h4 class=" float-start">بيانات المجموعة </h4>

    <div class="float-end mt-3">
      <button class="btn btn-primary dropdown-toggle rounded-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
       التنبيهات
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

      <li>
          <a href="{{ url('shared/groups/driver/warning/id_expiration_date/'.$group->id) }}" class="dropdown-item">تنبيهات السائقين </a>
      </li>
      <li>
          <a href="{{ url('shared/groups/vechile/warning/driving_license_expiration_date/'.$group->id) }}"class="dropdown-item">تنبيهات المركبات </a>
      </li>


      </li>
  </ul>
      <a href="{{ url('shared/groups/show/contracts/'.$group->id."/valid") }}" class="btn btn-outline-primary m-1">عقود التأجير</a>
      <a href="{{ url('shared/groups/show/drivers/'.$group->id) }}" class="btn btn-outline-primary m-1">السائقين</a>
      <a href="{{ url('shared/groups/show/vechiles/'.$group->id) }}" class="btn btn-outline-primary m-1">المركبات</a>
      {{-- <a href="{{ url('my/groups/box/show/take/'.$group->id) }}" class="btn btn-outline-primary m-1">الصندوق</a> --}}
      <a href="{{ route('shared.groups.document.show', ['group' => $group]) }}" class="btn btn-outline-primary m-1">المستندات </a>
      <a href="{{ route('shared.groups.note.show', ['group' => $group]) }}" class="btn btn-outline-primary m-1">الملاحظات </a>

      <a href="{{ url('shared/groups/importandexport/show/export/'.$group->id) }}" class="btn btn-outline-primary m-1">الصادر</a>

      <a href="{{ route('my.groups.covenant.show', $group) }}" class="btn btn-outline-primary m-1">العهد</a>
      {{-- <a href="{{ url('my/groups/show/vechiles/'.$group->id) }}" class="btn btn-outline-primary m-1">الصيانة</a> --}}

      @if($group->id !== 1)
      <a href="{{ url('shared/groups/show/users/'.$group->id) }}" class="btn btn-outline-primary m-1">المستخدمين</a>
      <a href="{{ route('shared.groups.show.tax', [ 'group' => $group, 'year' => \Carbon\Carbon::now()->year]) }}" class="btn btn-outline-primary m-1">ضريبة القيمة المضافة</a>
      <a href="{{ route('shared.groups.general.box', $group) }}" class="btn btn-outline-primary m-1">الصندوق العام</a>
      @endif
    </div>

</div>

<div class="container">
    <div class="row">

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label"> اسم المنشأة</label>
        <p class="alert alert-secondary p-1">{{$group->name?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="city" class="form-label">  المدينة</label>
        <p class="alert alert-secondary p-1">{{$group->city?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="commercial_register" class="form-label"> رقم السجل التجاري</label>
        <p class="alert alert-secondary p-1">{{$group->commercial_register?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="expired_date_commercial_register" class="form-label"> تاريخ أنتهاء رقم السجل التجاري</label>
        <p class="alert alert-secondary p-1">{{$group->expired_date_commercial_register?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="transportation_license_number" class="form-label"> رقم ترخيص هيئة النقل</label>
        <p class="alert alert-secondary p-1">{{$group->transportation_license_number?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="expired_date_transportation_license_number" class="form-label">تاريخ أنتهاء رقم ترخيص هيئة النقل </label>
        <p class="alert alert-secondary p-1">{{$group->expired_date_transportation_license_number?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="municipal_license_number" class="form-label"> رقم رخصة البلدية</label>
        <p class="alert alert-secondary p-1">{{$group->municipal_license_number?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="expired_date_municipal_license_number" class="form-label"> تاريخ أنتهاء رقم رخصة البلدية</label>
        <p class="alert alert-secondary p-1">{{$group->expired_date_municipal_license_number?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label"> نوع المنشأة</label>
        <p class="alert alert-secondary p-1">
            @if ($group->facility_type == "individual")
                فردية
            @elseif ($group->facility_type == "company")
            شركة
            @else
                لم يتم التحديد بعد
            @endif
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="facility_type" class="form-label">  المستخدم المسؤال عن إدارة المجموعة</label>
        <p class="alert alert-secondary p-1">
           {{ $group->manager->name ?? 'غير محدد' ?? "لا يوجد"}}
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="responsible_name" class="form-label"> اسم المسؤول</label>
        <p class="alert alert-secondary p-1">{{$group->responsible_name?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال المسؤول </label>
        <p class="alert alert-secondary p-1">{{$group->phone?? "لا يوجد"}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label"> عدد المركبات فى المجموعة</label>
        <p class="alert alert-secondary p-1">{{$group->vechile_counter?? "لا يوجد"}}</p>
      </div>

    </div>
  </div>


  @endsection

@section('scripts')

@endsection
