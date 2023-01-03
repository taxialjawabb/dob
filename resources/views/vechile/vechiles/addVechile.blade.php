@extends('index')
@section('title','إضافة مركبة')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">أضافة مركبة جديدة</h3>
</div>
<form method="POST" action="{{ url('vechile/add') }}">
    @csrf
    <div class="container">
        <div class="row">

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="stakeholder" class="form-label">حدد جهة السائق </label>
                <select value="{{ old('stakeholder') }}" name="stakeholder" id="stakeholder" class="form-select"
                    aria-label="Default select example" id="stakeholder" required>
                    <option value="" selected disabled>حدد جهة السائق</option>
                    <option value="0">الجواب للنقل البرى</option>
                    @foreach (\App\Models\Groups\Group::select(['id','name'])->get() as $group )
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="main-category" class="form-label">حدد نوع التصنيف</label>
                <select value="{{ old('category_id') }}" name="category_id" id="main-category" class="form-select"
                    aria-label="Default select example" id="category_id" required>
                    <option value="0" selected disabled> حدد التصنيف </option>
                    @foreach($cat as $category)
                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="secondary-category" class="form-label">حدد التصنيف الفرعي</label>
                <select value="{{ old('secondary_id') }}" name="secondary_id" id="secondary-category"
                    class="form-select" aria-label="Default select example" id="secondary_id" required>
                    <option value="0" selected disabled> اختر التصنيف الفرعي</option>
                </select>
            </div>


            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="vechile_type" class="form-label">نوع المركبة</label>
                <input type="text" value="{{ old('vechile_type') }}" name="vechile_type" class="form-control"
                    id="vechile_type" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="plate_number" class="form-label">رقم لوحة المركبة</label>
                <input type="text" value="{{ old('plate_number') }}" name="plate_number" class="form-control"
                    id="plate_number" required>
            </div>


          <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="address" class="form-label">  نوع الرخصة</label>
                <select value="{{ old('registration_type') }}" name="registration_type" id="id_type" class="form-select" aria-label="Default select example" id="id_type" required>
                    <option value="" selected disabled >حدد نوع الرخصة</option>
                    <option value="رخصة سير">رخصة سير</option>
                    <option value="بطاقة جمركية">بطاقة جمركية</option>


                </select>
            </div>


            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="made_in" class="form-label">سنة تصنيع المركبة</label>
                <input type="text" value="{{ old('made_in') }}" name="made_in" class="form-control" id="made_in"
                    required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="serial_number" class="form-label">الرقم التسلسلى</label>
                <input type="text" name="serial_number" value="{{ old('serial_number') }}" class="form-control"
                    id="serial_number" required>
            </div>

            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="color" class="form-label">لـون المركبة</label>
                <input type="text" value="{{ old('color') }}" name="color" class="form-control" id="color" required>
            </div>
            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="fuel_type" class="form-label">نوع الوقود</label>
                <input type="text" value="{{ old('fuel_type')}}" name="fuel_type" class="form-control" id="fuel_type"
                    required>
            </div>
            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="amount_fuel" class="form-label">كمية الوقود</label>
                <input type="text" value="{{ old('amount_fuel')}}" name="amount_fuel" class="form-control"
                    id="amount_fuel" required>
            </div>
            <!-- <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="driving_license_expiration_date" class="form-label">تاريخ إنتهاء رخصة السير</label>
                    <input type="text" value="{{ old('driving_license_expiration_date') }}"
                        name="driving_license_expiration_date" class="form-control input-date"
                        id="driving_license_expiration_date" required>
                </div>
                <input type='hidden' name="driving_license_expiration_date"
                    class="form-control driving_license_expiration_date" required />
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="periodic_examination_expiration_date" class="form-label">تاريخ إنتهاء الفحص
                        الدورى</label>
                    <input type="text" value="{{ old('periodic_examination_expiration_date') }}"
                        name="periodic_examination_expiration_date" class="form-control input-date"
                        id="periodic_examination_expiration_date" required>
                </div>
                <input type='hidden' name="periodic_examination_expiration_date"
                    class="form-control periodic_examination_expiration_date" required />
            </div>
            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="insurance_policy_number" class="form-label">رقم وثيقة التأمين</label>
                <input type="text" value="{{ old(" insurance_policy_number") }}" name="insurance_policy_number"
                    class="form-control" id="insurance_policy_number" required>
            </div>
            <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="insurance_type" class="form-label">نوع التأمين</label>
                <input type="text" value="{{ old(" insurance_type") }}" name="insurance_type" class="form-control"
                    id="insurance_type" required>
            </div>
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="insurance_card_expiration_date" class="form-label">تاريخ إنتهاء التأمين</label>
                    <input type="text" value="{{ old('insurance_card_expiration_date') }}"
                        name="insurance_card_expiration_date" class="form-control input-date"
                        id="insurance_card_expiration_date" required>
                </div>
                <input type='hidden' name="insurance_card_expiration_date" class="form-control insurance_card_expiration_date" required />
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <div style="position: relative">
                    <label for="operating_card_expiry_date" class="form-label">تاريخ إنتهاء بطاقة التشغيل</label>
                    <input type="text" style="text-direction:rtl" value="{{ old('operating_card_expiry_date') }}"
                        name="operating_card_expiry_date" class="form-control input-date"
                        id="operating_card_expiry_date" required>
                </div>
                <input type='hidden' name="operating_card_expiry_date" class="form-control operating_card_expiry_date"
                    required />
            </div>
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="operation_card_number" class="form-label">رقم بطاقة التشغيل</label>
                <input type="text" value="{{old('operation_card_number')  }}" name="operation_card_number"
                    class="form-control" id="operation_card_number" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="daily_revenue_cost" class="form-label">تكلفة العائد اليومي للمركبة</label>
                <input type="text" value="{{old('daily_revenue_cost') }}" name="daily_revenue_cost" class="form-control"
                    id="daily_revenue_cost" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="maintenance_revenue_cost" class="form-label">تكلفة العائد اليومي للصيانة</label>
                <input type="text" value="{{ old('maintenance_revenue_cost')}}" name="maintenance_revenue_cost"
                    class="form-control" id="maintenance_revenue_cost" required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="identity_revenue_cost" class="form-label">تكلفة العائد اليومي للأقامة</label>
                <input type="text" value="{{ old('identity_revenue_cost')   }}" name="identity_revenue_cost"
                    class="form-control" id="identity_revenue_cost" required>
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
    <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات المركبة</button>
</form>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $(".input-date").hijriDatePicker({
            //hijri:true
        });

        $(".input-date").on('dp.change', function (arg) {
            let date = arg.date;
            let className = $(this).attr('id');
            $('.'+className).val(date.format("YYYY/M/D"));

            // $("#selected-date").html(date.format("YYYY/M/D") + " Hijri:" + date.format("iYYYY/iM/iD"));
        });

      $(document).on("change", '#main-category', function(){
        var main_category = $(this).val();
        var op = " ";
        $.ajax({
          type: 'get',
          url: '{!!URL::to("vechile/secondary/category")!!}',
          data: {'id':main_category},
          success: function(data){
            // op += '<option value="0" selected disabled> اختر التصنيف الفرعي</option>';
            for(var i =0 ; i < data.length; i++){
              op += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#secondary-category").html(op);
          },
          error:function(e){
            console.log('error');
            console.log(e);
          }
        });
      });
    });
</script>
@endsection
