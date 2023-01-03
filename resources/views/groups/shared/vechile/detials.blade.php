
@extends('index')
@section('title','إضافة مركبة')
@section('content')
<div class="mt-2">
  <a  href="{{url('my/groups/show')}}" class="btn text-primary p-1 "> مجموعاتى الخاصة </a>
  <i class="arrow left "></i>
  <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary p-1">{{$group->name}} </a>
  <i class="arrow left "></i>
  <a href="{{ url('shared/groups/show/vechiles/'.$group->id) }}" class="btn text-primary p-1 ">المركبات</a>
</div>
<div class="mt-3 mb-3 container clearfix">
  <h4 class=" float-start">بيانات المركبة </h4>
  <div class="float-end">

    <a href="{{ route('shared.groups.vechile.box.show', [ 'vechile'=> $vechile->id, 'group'=>$group->id,'type' => 'take']) }}" class="btn btn-primary rounded-0 m-0">الصندوق</a>
    <a href="{{ url('vechile/notes/show/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">الملاحظات</a>
    <a href="{{ url('vechile/documents/show/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">المستندات</a>

    <a href="{{ url('shared/groups/maintenance/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">الصيانة</a>
    <a href="{{ url('shared/groups/vechile/drivers/'.$vechile->id) }}" class="btn btn-primary rounded-0 m-0">عرض السائقين المستلمين</a>
    <a href="{{ url('shared/groups/vechile/update/'.$vechile->id) }}" class="btn btn-danger rounded-0 m-0">تعديل</a>
  </div>
</div>

<div class="container">
    <div class="row">

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">التصنيف</label>
        <p class="alert alert-secondary p-1">{{$vechile->category->category_name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">التصنيف الفرعي</label>
        <p class="alert alert-secondary p-1">{{$vechile->secondary_category->name??'لا يوجد'}}</p>
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
        <p class="alert alert-secondary p-1">{{$vechile->added_by->name}}</p>
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
