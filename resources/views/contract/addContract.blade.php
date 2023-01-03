@extends('index')
@section('title', 'العقد')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start"> العقد</h5>

</div>

<form method="POST" action="{{ url('driver/contract/views') }}">
    @csrf
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="text-center text-danger">
    <h1>عقد تأجير سيارات</h1>
    <h2>Car Lease Contract</h2>
</div>
<div class="panel panel-default ">

 <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="6">

                <div class="clearfix">
                    <span class="float-start  text-primary h5">الطرف الثاني: (بيانات المستأجر) (3)</span>
                    <span class="float-end  text-primary h5">(3) Lessee Information: (Second Party)</span>
                    <select class="form-select" required value="{{ old('driver_id') }}" name="driver_id" >
                        <option disabled value="" selected>اختار المستأجر  </option>
                        @foreach ($driver as $item)
                         <option value="{{$item->id}}">{{$item->name.'  ---  '.$item->nationality.'  ---   '.$item->ssd }} </option>
                        @endforeach
                     </select>

                        </div>
            </td>
        </tr>
    </table>
    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="6">

                <div class="clearfix">
                    <span class="float-start  text-primary h5">بيانات السياره: (5)</span>
                    <span class="float-end  text-primary h5">(5) Car Information </span>
                    <select class="form-select" required value="{{ old('vechile_id') }}" name="vechile_id">
                        <option  disabled value="" selected>اختار السياره  </option>
                        @foreach ($vechile as $item)
                         <option value="{{$item->id}}">{{$item->plate_number.' ---  ' .$item->color}} </option>
                        @endforeach
                         </select>
                </div>
            </td>
        </tr>


    </table>
    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="6">

                <div class="clearfix">
                    <span class="float-start  text-primary h5">بيانات الايجار: (6)</span>
                    <span class="float-end  text-primary h5">(6) Lease Information </span>
                </div>

            </td>
        </tr>


        <tr>
            <td colspan="2">
                <div class="clearfix">
                    <span class="float-start">  مدة الايجار باليوم: </span>
                    <span class="float-end">:lease term in days</span>
                    <input type="text" pattern="[0-9]+"   maxlength="10" value="{{ old('lease_term') }}" name="lease_term" class="form-control" id="money" required>
                </div>
            </td>
            <td colspan="2">
                <div class="clearfix">
                    <span class="float-start p-1">  قيمه الايجار ف اليوم  (بالريال السعودي) : </span>
                    <span class="float-end p-1">:Cost Lease in day (S.R Saudi Arabi)</span>
                    <input type="text" maxlength="10" pattern="[0-9]+" value="{{ old('lease_cost_dar_hour') }}" name="lease_cost_dar_hour" class="form-control" id="money" required>
                </div>

            </td>
        </tr>
            <td colspan="4">
                <div class="clearfix">
                    <span class="float-start">عدد ساعات التأخيرالمسموح بها:</span>
                    <span class="float-end">:Number of delay hours allowed</span>

                        <input type="text" maxlength="10" pattern="[0-9]+" value="{{ old('lease_hours_delay_allowed') }}" name="lease_hours_delay_allowed" class="form-control" id="money" required>
                </div>
            </td>
        </tr>
       </tr>
    </table>



    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start  text-primary h5">بيانات استلام السياره: (7)</span>
                    <span class="float-end  text-primary h5">(7) Car receipt Information </span>
                </div>
            </td>
        </tr>



        <tr>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">قراءة العداد عند الخروج :</span>
                    <span class="float-end">:Odometer reading at exit</span>

                        <input type="text" value="{{ old('car_receipt_odometer_reading_at_exit') }}" name="car_receipt_odometer_reading_at_exit" class="form-control" id="money" required>

                </div>
            </td>


        </tr>





    </table>


    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="6">

                <div class="clearfix">
                    <span class="float-start  text-primary h5">ساسيه التأجير: (9)</span>
                    <span class="float-end  text-primary h5">(9) Car receipt Information </span>
                </div>

            </td>
        </tr>
        <input type="hidden" readonly value="سداد قيمة كامل العقد" name="leasing_policy_return_car_before_contract_expire"  class="form-control" id="money" required>

        <tr>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">تمديد العقد: مسموح/ غير مسموح :
                        </span>
                        <span class="float-end">:Contract extension: Allowed/ Not Allowed</span>
                    <span class="m-2" style="color:red">


                        <select class="form-select"  value="{{ old('leasing_policy_contract_extension') }}" name="leasing_policy_contract_extension" required>

                            <option disabled value="" selected>اختار هل مسموح بالتمديد </option>
                            <option value="1" >مسموح </option>
                            <option value="2">غير مسموح</option>

                          </select>

                    </span>

                </div>
            </td>


        </tr>

    </table>
    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="3">

                <div class="clearfix">
                    <span class="float-start  text-primary h5"> الحاله الفنيه لسيارة: (10)</span>
                    <span class="float-end  text-primary h5">(10) Car Technical condition </span>
                </div>

            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> العناصر</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> عند التأجير</span>
                    <span class="float-end">At lease</span>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">

                    <span class="float-end">Element</span>
                </div>
            </td>


        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله التكييف</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">


                        <select class="form-select" required  value="{{ old('car_technical_condition_at_lease_air_condition') }}" name="car_technical_condition_at_lease_air_condition">
                            <option   disabled value="" selected>اختار الحاله  </option>
                            <option value="1">ممتازه </option>
                            <option value="2"> جيده</option>
                            <option value="3"> متوسطه </option>
                            <option value="4"> ردئ</option>
                            <option value="5"> معطل</option>
                            <option value="6"> غير موجود</option>
                          </select>


                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">A.C condition</span>
                </div>
            </td>
        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله الراديو /المسجل</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_radio_recorder') }}" name="car_technical_condition_at_lease_radio_recorder">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">Radio/Recorder condition</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله  جهاز تسجيل الفديو dvr</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_dvr') }}" name="car_technical_condition_at_lease_dvr">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">video Recorder Dvr</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله الشاشه الداخليه </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_interior_screen') }}" name="car_technical_condition_at_lease_interior_screen">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">interior screen condition</span>
                </div>
            </td>
        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله عداد السرعه</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_speedometer') }}" name="car_technical_condition_at_lease_speedometer">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">speedometer condition</span>
                </div>
            </td>
        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله الفرش الداخلي</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_interior_upholstery') }}" name="car_technical_condition_at_lease_interior_upholstery">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">interior uphoistery condition</span>
                </div>
            </td>
        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله الكفر الاحتياطي</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_spare_cover_equipment') }}" name="car_technical_condition_at_lease_spare_cover_equipment">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">spare cover equipment condition</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله العجلات</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_wheel') }}" name="car_technical_condition_at_lease_wheel">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">Wheel condition</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله العجلات الاحتياطيه</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_spare_wheel') }}" name="car_technical_condition_at_lease_spare_wheel">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">spare Wheel condition</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله حقيبه الاسعافات الاوليه</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_first_aid_kit') }}" name="car_technical_condition_at_lease_first_aid_kit">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">First Aid kid condition</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> موعد تغيير الزيت</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <input type="date" value="{{ old('car_technical_condition_at_lease_oil_change_time') }}" name="car_technical_condition_at_lease_oil_change_time" class="form-control" id="money" required>

                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">oil change time</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله المفتاح</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_key') }}" name="car_technical_condition_at_lease_key">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">Key condition</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> توفر طفايه حريق </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_fire_extinguisher_availability') }}" name="car_technical_condition_at_lease_fire_extinguisher_availability">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">Fire Exinguisher Availability</span>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> توفر المثلث العاكس</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_availability_triangle_refactor') }}" name="car_technical_condition_at_lease_availability_triangle_refactor">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">Availability Triangle refector</span>
                </div>
            </td>
        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله طابعه الفواتير</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_printer') }}" name="car_technical_condition_at_lease_printer">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end"> billing printer </span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">حاله جهاز نقاط البيع</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_point_sale_device') }}" name="car_technical_condition_at_lease_point_sale_device">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">point sale device</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">الشاشه الاماميه</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_fornt_screen') }}" name="car_technical_condition_at_lease_fornt_screen">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">fornt screen</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">الكاميرا الاماميه</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_internal_camera') }}" name="car_technical_condition_at_lease_internal_camera">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">internal camera</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> الاربع حساسات للكراسي</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_4sensor_seat') }}" name="car_technical_condition_at_lease_4sensor_seat">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">4 sensor seat</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">زرار الطوارئ</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_button_emergency') }}" name="car_technical_condition_at_lease_button_emergency">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">button emergency</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">جهاز التتبع</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_device_tracking') }}" name="car_technical_condition_at_lease_device_tracking">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">device tracking</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> علامه تاكسي اجره</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <select class="form-select" required value="{{ old('car_technical_condition_at_lease_light_taxi_mark') }}" name="car_technical_condition_at_lease_light_taxi_mark">
                        <option  disabled value="" selected>اختار الحاله  </option>
                        <option value="1">ممتازه </option>
                        <option value="2"> جيده</option>
                        <option value="3"> متوسطه </option>
                        <option value="4"> ردئ</option>
                        <option value="5"> معطل</option>
                        <option value="6"> غير موجود</option>
                      </select>
                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-end">light taxi mark</span>
                </div>
            </td>
        </tr>





    </table>


    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="2">

                <div class="clearfix">
                    <span class="float-start text-primary h5">البيانات الماليه الرئيسيه (11)</span>
                    <span class="float-end text-primary h5">(11) Main Financial Data</span>
                </div>

            </td>
        </tr>



        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">الضريبه المضافه:</span>
                    <span class="float-end">:VAT</span>
                      <input type="text" value="{{ old('main_financial_vat') }}" name="main_financial_vat" class="form-control" id="money" required>                 </div>
            </td>
            <td>
                <span class="float-start">تكلفة السفر خارج مدينه الترخيص:</span>
                <span class="float-end">:cost travelling out city license</span>
                <input type="text" class="form-control"  value="{{ old('main_financial_cost_travelling_out_city')}}" name="main_financial_cost_travelling_out_city" required>

            </td>
        </tr>












    </table>

   <!--
    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="2">

                <div class="clearfix">
                    <span class="float-start text-primary h5">البيانات الماليه الاخري (12)</span>
                    <span class="float-end text-primary h5">(12) onter Financial Data</span>
                </div>

            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">اجمالي قيمه الكيلومترات الزياده:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_total_cost_extra_km') }}" name="other_financial_total_cost_extra_km" class="form-control" id="money" required></span>
                    <span class="float-end">:Total cost extra kilometer</span>

                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">قيمه مبلغ التحمل</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_deductible_amount_value') }}" name="other_financial_deductible_amount_value" class="form-control" id="money" required></span>
                    <span class="float-end">:Additional Services cost</span>

                </div>
            </td>
        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">قيمة الخدمات التكميليه:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_supplementary_service_cost') }}" name="other_financial_supplementary_service_cost" class="form-control" id="money" required></span>
                    <span class="float-end">:Supplementary services cost</span>

                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">قيمة قطع الغيار:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_spare_parts_cost') }}" name="other_financial_spare_parts_cost" class="form-control" id="money" required></span>
                    <span class="float-end">:Spare Parts Costs</span>

                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">قيمة سحب السياره:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_car_towing_cost') }}" name="other_financial_car_towing_cost" class="form-control" id="money" required></span>
                    <span class="float-end">:Car Towing Cost</span>

                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">قيمة تقييم أضرار السيارة:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_car_damage_assessment_value') }}" name="other_financial_car_damage_assessment_value" class="form-control" id="money" required></span>
                    <span class="float-end">:Car damage assessment Value </span>

                </div>
            </td>

        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">قيمة تغيير الزيت:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_oil_change_cost') }}" name="other_financial_oil_change_cost" class="form-control" id="money" required></span>
                    <span class="float-end">:Oil Change Cost</span>

                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">الخصم:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_discount') }}" name="other_financial_discount" class="form-control" id="money" required></span>
                    <span class="float-end">:Discount</span>

                </div>
            </td>
        </tr>

        <tr>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">قيمة الوقود:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_fuel_cost') }}" name="other_financial_fuel_cost" class="form-control" id="money" required></span>
                    <span class="float-end">:Fuel Cost</span>

                </div>
            </td>

            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">الضريبه المضافه:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_vat') }}" name="other_financial_vat" class="form-control" id="money" required></span>
                    <span class="float-end">:VAT</span>

                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">الاجمالي:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_total') }}" name="other_financial_total" class="form-control" id="money" required></span>
                    <span class="float-end">:Total</span>

                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">المدفوع:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_paid') }}" name="other_financial_paid" class="form-control" id="money" required></span>
                    <span class="float-end">:Paid</span>

                </div>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">المتبقي :</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_remaining') }}" name="other_financial_remaining" class="form-control" id="money" required></span>
                    <span class="float-end">:Remaining Amount</span>

                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">طريقة الدفع:</span>
                    <span class="m-2" style="color:red">  <input type="text" value="{{ old('other_financial_payment_mothed') }}" name="other_financial_payment_mothed" class="form-control" id="money" required></span>
                    <span class="float-end">: Payment Method</span>

                </div>
            </td>

        </tr>

    </table>

    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="2">

                <div class="clearfix">
                    <span class="float-start text-primary h5">الالتزامات الاطراف (13)</span>
                    <span class="float-end text-primary h5">(13)Parties Obligations</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="2">

                <div class="clearfix">
                    <span class="float-start">

                        <br /> المادة الأولى:
                        <br />
                        تُعد البيانات المذكورة أعلاه جزءاً لا يتجزأ من هذا العقد ومفسرة ومكملة له.
                        <br /> <br />
                        المادة الثانية: محل العقد:
                        <br />
                        اتفق المؤجر والمستأجر بموجب هذا العقد على تأجير السيارة المحددة بياناتها في البند رقم (٥
                        ،(ووفقاً لما هو محدد في البنود أعلاه ومطابقاً للشروط والأحكام والالتزامات المنصوص عليها في
                        العقد، ويقر المستأجر بمعاينته للسيارة المؤجرة،
                        وقبوله للتعاقد على استئجارها، وأنها صالحة للاستخدام والسير على الطرق.
                        <br /> <br /> <br /> <br />
                        المادة الثالثة: مدة العقد:
                        <br />
                        تبدأ مدة العقد من تاريخ ووقت بداية العقد المذكور أعلاه وينتهي في تاريخ ووقت نهاية العقد المذكور
                        أعلاه، ويحق للطرفين تمديد العقد من خلال البوابة الإلكترونية للهيئة العامة للنقل
                        <br /> <br /> <br /> <br />
                        المادة الرابعة:
                        <br />
                        ۱ .إجمالي قيمة العقد (رقما ) ( كتابة ) ريالاً سعودياً، يلتزم المستأجر بدفعها للمؤجر بحسب ما هو
                        مذكور في البند رقم (۱۱ (من هذا العقد
                        <br />
                        ٢ .يلتزم المستأجر بدفع المبالغ المحددة في البند رقم (۱٢ (من هذا العقد وفقاً لأحكام وشروط هذا
                        العقد.
                        <br /> <br /> <br /> <br />
                        المادة الخامسة: التأجير بسائق:
                        <br />
                        ۱ .يُعفى مستأجر السيارة بسائق من الالتزامات المحددة في البند رقم (۱٠ ،(وآلية الإبلاغ عن الحوادث
                        أو الأعطال الواردة في البند رقم (٩ (من هذا العقد
                        <br />
                        ٢ .لا يتحمل مستأجر السيارة بسائق أي أضرار أو أعطال تظهر عليها.

                        <br /> <br /> <br />
                        المادة السادسة: التزامات المؤجر:
                        <br />

                        ١-استلام السيارة في الوقت والمكان المحدد بالعقد عند انتهاء العقد أو عند رغبة المستأجر في تسليم
                        السيارة قبل انتهاء مدة العقد.
                        <br />

                        ٢ -توفير سيارة بديلة من ذات الفئة في حالة ظهور أي خلل فني ليس بسبب تقصير أو إهمال من قبل
                        المستأجر أو المفوضين، وفي حالة عدم توفر سيارة من ذات الفئة فيتم توفير سيارة بديلة من الفئة
                        الأعلى التي تليها، مع عدم تحميل المستأجر أي
                        تكاليف إضافية، وإلا فيتم توفير سيارة بديلة من فئة أقل وفقاً للتعرفة المعلنة، بعد موافقة المستأجر
                        على ذلك وإعادة فرق السعر للمسـتأجر.
                        <br />
                        ٣ -يتحمل المؤجر أي تكاليف دفعها المستأجر لاستلام السيارة البديلة وفقاً للفقرة
                        (٢ (من المادة السادسة من العقد.
                        <br />
                        ٤ -استلام السيارة عند إعادتها لأي سبب من الأسباب، مع احتفاظ المؤجر بحقه في المطالبة بحقوقه بموجب
                        العقد.
                        <br />
                        ٥ -حفظ المفقودات التي تركها أصحابها داخل السيارة وتسليمها إلى أصحابها أو تسليمها بأسرع وقت لأقرب
                        مركز شرطة بموجب محضر ضبط يتضمن أوصافها وكل البيانات المعرفة لها.
                        <br />
                        ٦ -إعادة المبالغ المحتجزة للمستأجر بعد خصم المستحقات المالية الواجبة عليه فور إعادة السيارة
                        بحالة فنية سليمة.
                        <br />
                        ٧ -إنهاء عقد تأجير السيارة وإلغاء التفويض فور استلام السيارة.
                        <br />
                        ٨ -عدم استحصال أي مبالغ غير منصوص عليها في العقد.
                        <br />
                        ٩ -تحمل تكاليف قطع الغيار الاستهلاكية واستبدالها مالم يثبت أن سوء استخدام المستأجر أو المفوض أدى
                        إلى إتلافها.
                        <br />
                        ۱٠ -تحمل تكاليف تغيير زيت محرك السيارة إذا تمت إعادتها حال قطع المسافة اللازمة لتغيره المنصوص
                        عليها بالعقد.
                        <br />
                        ۱١-تحمل قيمة نقل السيارة المتعطلة مالم تثبت مسئولية المستأجر أو المفوض عن العطل.
                        <br />
                        ۱٢ -تمكين مراقبي الخدمة من الاطلاع على سجلات النشاط أو تزويده بالمعلومات أو المستندات ذات
                        العلاقة.
                        <br />
                        ۱٣ -إخضاع السيارة لتغطية تأمينية بما يغطي -كحد أدنى- المسؤولية المدنية تجاه الغير وفق الوثيقة
                        الموحدة للتأمين الإلزامي على المركبات طيلة مدة التشغيل أو طيلة مدة العقد أو أي تمديد له، ولا
                        تنتقل المسئولية المترتبة على هذا النوع من
                        التغطية -بأي حال من الأحوال- إلى المستأجر، ويتحمل المؤجر كامل المسئولية المترتبة على تأجيرها
                        سيارة دون أي تغطية تأمينية.
                        <br />
                        ۱٤ -الإفصاح عن نوع التغطية التأمينية في العقد حسب وثيقة التأمين الصادرة للسيارة، وتحديد نسبة
                        التحمل في العقد (إن وجدت)، وأي تغطية تأمينية إضافية أخرى تزيد عن نوع التغطية التأمينية المنصوص
                        عليها في بنود وثيقة تأمين السيارة،
                        وتوقيع المستأجر على ذلك.
                        <br />
                        ۱٥ -تحديد نسبة التحمل في العقد بناءً على القدر المنصوص عليه في بنود وثيقة التأمين الصادرة
                        للسيارة من شركات التأمين المرخص لها بالعمل في المملكة.
                        <br />
                        ۱٦ -عدم تأجير سيارة بتغطية تأمينية أقل من نوع التغطية المنصوص عليه في بنود وثيقة تأمين السيارة.
                        <br />
                        ۱٧ -عدم تأجير السيارة في حال وجود أي خلل فني يؤثر على سلامة المستأجر وصلاحية وسلامة السيارة
                        فنياً للتأجير.
                        <br />
                        ۱٨ -تجهيز السيارة من حيث نظافتها من الداخل والخارج للتأجير.
                        <br />
                        ۱٩
                        -تحمل كامل المسئولية أمام الهيئة والجهات الأخرى ذات العلاقة، عن المخالفات التي تُقيد على السيارة
                        <br />
                        ٢٠ -تزويد المستأجر بنسخة من العقد بعد التوقيع عليه من كلا الطرفين، ونسخة من المخالصة عند إعادة
                        السيارة في حال طلب المستأجر.
                        <br />
                        ٢١-العناية التامة بصيانة السيارة وحالتها الفنية، والاحتفاظ بسجل الصيانة الدورية للسيارة.
                        <br />
                        ٢٢ -تجهيز السيارة بعجلة احتياطية، ومفتاح للعجل، وآلة رافعة، وإشارة الخطر العاكسة المثلثة الشكل،
                        وحقيبة إسعافات أولية، وطفاية حريق، على أن تكون جميعها صالحة للاستخدام.
                        <br />
                        ٢٣ -إخضاع السيارة للفحص الفني الدوري طيلة مدة العقد.
                        <br />
                        ٢٤ -الإفصاح عن سياسة إعادة واستلام السيارة قبل انتهاء مدة العقد الموضحة في البند (٩ (من العقد.
                        <br />
                        ٢٥ -الإفصاح عن سياسة تمديد عقد التأجير الموضحة في البند (٩ (من العقد.
                        <br />
                        ٢٦ -مراعاة خصوصية بيانات المستأجر، وعدم استخدامها لأغراض تسويقية إلا بعد موافقة المستأجر
                        المكتوبة.
                        <br /><br /><br /><br />


                        المادة السابعة: التزامات المستأجر:
                        <br />
                        ١-إعادة السيارة بنفس الحالة التي استأجرها بها وكامل تجهيزاتها.
                        <br />
                        ٢ -إعادة السيارة نظيفة داخلياً وخارجياً.
                        <br />
                        ٣ -إشعار المؤجر بأي عُطل فني يحدث للسيارة، وعدم إجراء أي إصلاحات عليها إلا بموافقته.
                        <br />
                        ٤ -إشعار المؤجر فور حجز السيارة من قبل الجهات المختصة لأي سبب من الأسباب.
                        <br />
                        ٥ -إشعار المؤجر والجهات الأمنية فور تعرض السيارة لحادث أو اكتشاف سرقتها.
                        <br />
                        ٦ -استخدام السيارة للأغراض الشخصية داخل نطاق حدود المنطقة الجغرافية المحددة في العقد.
                        <br />
                        ٧ -عدم استخدام السيارة بشكل يؤدي إلى الإضرار بمحرك السيارة أو أحد عناصرها، أو استخدامها لأغراض
                        غير مشروعة.
                        <br />
                        ٨ -عدم قيادة السيارة إذا كان المستأجر غير مخول لقيادتها لأي سبب كان، ويتحمل مسؤولية أي ضرر أو
                        تعويضات تنتج عن ذلك.
                        <br />
                        ٩ -عدم إجراء أي تعديلات على السيارة وتجهيزاتها، بما في ذلك العبث بعداد
                        <br />
                        ١٠ -استخدام نوع الوقود المحدد في العقد.
                        <br />
                        ١١ -عدم ترك السيارة في وضع التشغيل.
                        <br />
                        ١٢ -عدم التنازل عن حقوق المؤجر لأي طرف آخر.
                        <br />
                        ١٣ -عدم تمثيل المؤجر لدى الجهات المختصة دون موافقته.
                        <br />
                        ١٤ -تم إعادة السيارة في التاريخ والوقت المحدد في العقد، أو أي تمديد له.
                        <br />
                        ١٥ -عدم استخدام السيارة من قبل أشخاص غير مفوضين بموجب العقد بقيادة السيارة.
                        <br />
                        ١٦ -عدم نقل الأشخاص أو البضائع بأجر.
                        <br />
                        ١٧ -عدم الاشتراك في سباقات السيارات.
                        <br />
                        ١٨ -عدم دفع أو سحب سيارات أخرى أو سحب مقطورة.
                        <br />
                        ١٩ -عدم استخدام السيارة لأغراض التدريب على القيادة.
                        <br />
                        ٢٠ -عدم إعادة تأجير السيارة للغير.
                        <br />
                        ٢١ -تقديم تقرير للمؤجر عن السيارة من الجهة المختصة في حال وقوع الحوادث المرورية أو الأضرار
                        الناجمة عن الكوارث الطبيعية.
                        <br />
                        ٢٢ -تطبيق القواعد المرورية للسير على الطرق.
                        <br /><br /><br /><br /><br />


                        المادة الثامنة: الرسوم والتكاليف:
                        <br />
                        يتحمل المستأجر التكاليف الآتية:
                        <br />
                        ١ -استئجار السيارة طيلة مدة العقد، وأي تمديد له، حسبما ورد في نصوص العقد.
                        <br />
                        ٢ -تغيير زيت محرك السيارة في حال تجاوز المسافة المقطوعة اللازمة لتغير الزيت المنصوص عليها في
                        العقد.
                        <br />
                        ٣ -نسبة التحمل (إن وجدت) المشار لها في العقد.
                        <br />
                        ٤ -قيمة الوقود وتعبئة هواء الإطارات خلال فترة العقد.
                        <br />
                        ٥ -الأضرار الناجمة عن سوء استخدام السيارة.
                        <br />
                        ٦ -الأضرار الناجمة عن الحوادث المرورية حسب نسبة مسؤوليته في الحادث، والأضرار التي لا تغطيها
                        وثيقة التأمين أو التغطية التأمينية الإضافية المحددة بالعقد.
                        <br />
                        ٧ -الغرامات المالية الناتجة عن المخالفات المرورية.
                        <br />
                        ٨ -أجرة المواقف العامة المستخدمة.
                        <br />
                        ٩- فقد أو استبدال أو العبث بأي من قطع السيارة وتجهيزاتها.
                        <br />
                        ١٠- تأخير تسليم السيارة في التاريخ والوقت المحددين في هذا العقد.
                        <br />
                        ١١- قيمة الوقود الموجود في السيارة عند استئجارها وفق العقد.
                        <br />
                        ١٢- الحقوق المترتبة على التنازل عن حقوق المؤجر لأي طرف آخر
                        <br /><br /><br /><br />

                        :المادة التاسعة: التأخر في تسليم السيارة عند انتهاء العقد
                        <br />
                        :أ. إذا كان التأجير بالنظام اليومي وتأخر المستأجر في تسليم السيارة عن الموعد المحدد فيدفع
                        المستأجر مبلغاً وفق الحالات التالية
                        <br />
                        :١ .إذا تأخر المستأجر مدة لا تزيد عن أربع ساعات عن الموعد المحدد لتسليم السيارة فيكون احتساب
                        ساعات التأخير وفق المعادلة التالية
                        قيمة التأجير اليومي × عدد ساعات التأخير) / 24 × [ (2 = تكلفة قيمة ساعات التأخير)]
                        .ويحسب التأخير في أي جزء من الساعة الواحدة بساعة كاملة
                        <br />
                        .٢ .إذا تأخر المستأجر مدة تزيد عن أربع ساعات عن الموعد المحدد لتسليم السيارة فيدفع المستأجر
                        مبلغاً يعادل الأجرة اليومية كاملة عن كل يوم تأخير بالإضافة إلى الأجرة اليومية وتكاليف التأجير
                        المتفق عليها في العقد
                        <br />
                        <br />

                        :ب. إذا كان التأجير بنظام الساعات وتأخر المستأجر في تسليم السيارة عن الموعد المحدد فيلتزم
                        المستأجر بدفع مبلغ يكون حسابه على النحو التالي
                        <br />
                        .١ .إذا تأخر في تسليم السيارة لمدة ساعة أو أقل من الموعد المحدد فيلتزم بدفع ضعف أجرة الساعة
                        الموضحة في العقد
                        <br />
                        .٢ .إذا تأخر في تسليم السيارة لمدة تزيد عن ساعة ولا تتجاوز (٢٤ (أربع وعشرين ساعة من الموعد
                        المحدد فيلتزم بدفع قيمة التأجير اليومي للسيارة كاملة الموضحة في العقد
                        <br />
                        .٣ .إذا تأخر في تسليم السيارة لمدة تزيد عن (٢٤ (أربع وعشرين ساعة عن الموعد المحدد فيعامل وفق
                        الفقرة ( أ/٢ (من هذه المادة
                        <br /><br />
                        .ج. لا يجوز إجراء أي تعديل من قبل المؤجر على العقد بعد توقيعه إلا بموافقة ومصادقة المستأجر
                        <br /><br /><br />
                        المادة العاشرة: انتهاء العقد
                        <br />
                        :ينتهي العقد في الحالات التالية
                        <br />
                        :أ. إنهاء العقد قبل انتهاء مدته
                        <br />
                        .١ -للمؤجر إنهاء العقد قبل انتهاء مدته، وذلك في حال قيام المستأجر بتسليم السيارة، وفي هذه
                        الحالة، يحق للمؤجر مطالبة المستأجر بالأجرة للمدة الفعلية أو مدة العقد كاملاً حسب المتفق عليه في
                        العقد
                        <br />
                        .٢ -إذا رغب المستأجر في إنهاء العقد قبل انتهاء مدته ورفض المؤجر استلام السيارة، فيحق للمستأجر
                        تقديم بلاغ للهيئة العامة للنقل بطلب إنهاء العقد، وفي حال ثبت صحة عدم الاستلام يتم إنهاء العقد من
                        حين تقديم البلاغ
                        <br />
                        <br />
                        :ب. انتهاء مدة العقد
                        <br />
                        .١ -إذا سلم المستأجر السيارة في تاريخ ووقت نهاية العقد فيعد العقد منتهياً
                        <br />
                        .٢ -إذا لم يسلم المستأجر السيارة في تاريخ ووقت نهاية العقد المتفق عليه فيشعر المؤجر المستأجر
                        برسالة نصية تفيد بعدم تسليم السيارة، ويحق للمستأجر الاعتراض على ذلك خلال ٤ ساعات من إرسال
                        الإشعار، ويعد عدم اعتراضه على ذلك لدى الهيئة
                        خلال تلك المدة إقراراً منه بعدم تسليم السيارة واستحقاق غرامات التأخير بموجب العقد، وفي حال
                        اعتراضه لدى الهيئة وثبت أن المستأجر يرغب في تسليم السيارة مع رفض المؤجر ذلك فيعد العقد منتهياً
                        من حين تقديم البلاغ وفي هذه الحال يحق
                        للمؤجر مطالبة المستأجر بالأجرة الفعلية إلى حين تقديم البلاغ
                        <br />
                        <br />
                        :ج. وقوع حادث على السيارة
                        <br />
                        .١ -إذا وقع حادث على السيارة فعلى المستأجر إشعار المؤجر بذلك، وعلى المؤجر حينئذٍ إنهاء العقد
                        فوراً وإشعار المستأجر بذلك
                        <br />
                        .٢ -يحق للمستأجر -عند عدم إنهاء المؤجر للعقد بعد إشعاره بوقوع الحادث- تقديم اعتراض عن طريق
                        الهيئة، وتقوم الهيئة بدراسة الاعتراض وتحديد الوقت الفعلي لانتهاء العقد
                        <br />
                        <br />
                        <br />
                        <br />
                        :المادة الحادية عشرة: تسوية المنازعات
                        <br />
                        .١ -يخضع هذا العقد ويفسر وفقاً للأنظمة واللوائح المعمول بها في المملكة العربية السعودية
                        <br />
                        :٢ -للمؤجر طلب التنفيذ على المستأجر لدى محكمة التنفيذ بموجب نظام التنفيذ ولائحته التنفيذية وفقاً
                        لأحكام هذا العقد في الأحوال التالية
                        <br />
                        .أ. تسليم السيارة عند عدم قيام المستأجر تسليمها في الموعد المتفق عليه
                        <br />
                        .ب. قيمة التأجير سواء كان باليوم أو بالساعة
                        <br />
                        .ت. قيم تفويض سائق إضافي
                        <br />
                        .ث. أجرة السائق
                        <br />
                        .ج. قيمة التأخير في تسليم السيارة
                        <br />
                        .ح. قيمة الخدمات الإضافية
                        <br />
                        .خ. قيمة التفويض الدولي
                        <br />
                        .د. قيمة تسليم السيارة في مدينة أخرى
                        <br />
                        .٣ -في حال وجود خلاف بين أطراف العقد جراء تقدير الأضرار الناتجة عن الحوادث غير المرورية، أو سوء
                        الاستخدام، أو الاستهلاك، تلتزم المنشأة المرخص لها بممارسة النشاط بتقدير الضرر الواقع على السيارة
                        عن طريق جهة التقييم المعتمدة من الهيئة،
                        على أن يتحمل المتسبب بالضرر تكلفة نتيجة الفحص والتقرير
                        <br />
                        ٤ -باستثناء ما ورد في الفقرة (2 (من هذه المادة، في حال حدوث خلاف بين أطراف العقد حول تفسير، أو
                        تنفيذ هذا العقد، أو أي بند من بنوده فللطرفين حلَّه بالطرق الودية، أو اللجوء للجهة القضائية
                        المختصة
                        <br />
                        .٥ -باستثناء ما ورد في الفقرة (2 (من هذه المادة، في حال حدوث خلاف بين أطراف العقد حول تفسير، أو
                        تنفيذ هذا العقد، أو أي بند من بنوده فللطرفين حلَّه بالطرق الودية، وينعقد الاختصاص إذا لم يتم حله
                        بالطرق الودية إلى التحكيم وفقاً لنظام
                        التحكيم
                        <br />
                        <br />
                        <br /><br />
                        :المادة الثانية عشرة: العنوان الرسمي والمراسلات
                        <br />
                        .جميع الإخطارات والتبليغات يوجهها أحد الطرفين للآخر من خلال البوابة الإلكترونية للهيئة العامة
                        للنقل ولا يعتد بأي وسيلة بخلاف ذلك
                        <br />
                        <br />
                        <br />
                        <br />
                        :المادة الثالثة عشرة: نسخ العقد
                        <br />
                        .يحرر هذا العقد كنسخة متطابقة لكلٍّ من المؤجر والمستأجر، وموقعة من طرفي العقد، وقد تسلم كل طرف
                        نسخته إلكترونياً للعمل بموجبها، ويجوز للهيئة العامة للنقل تبادل بيانات هذا العقد مع الجهات ذات
                        العلاقة، ووكالات التصنيف، والجهات
                        المختصة بالمعلومات
                        <br />
                        <br />






                    </span>

                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="clearfix">
                    <span class="float-start">
                        يقر أطراف العقد بقراءة البنود السابقة والإلتزام بها:
                    </span>

                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> توقيع الطرف الاول:</span>
                    <span class="float-end">:Signature of First Party</span>

                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> توقيع الطرف الثاني:</span>
                    <span class="float-end">:Signature of Second Party</span>

                </div>
            </td>
        </tr>

    </table>

    <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="8">

                <div class="clearfix">
                    <span class="float-start text-primary h5"> الملحق(14)</span>
                    <span class="float-end text-primary h5">(14)Annex</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> البند </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> الحقل </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> التوضيح</span>
                </div>
            </td>

        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 1 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> رقم العقد
                    </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> رقم تسلسلي غير مستخدم في عقود أخرى </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 1 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">

                    <span class="float-start"> مكان إبرام العقد

                    </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix"> يدون أمام هذه العبارة مدينة إبرام العقد، على سبيل الذكر لا الحصر (الرياض/ المدينة
                    المنورة /الدمام). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">1 </span>
                </div>
            </td>


            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> تاريخ ووقت بدايه العقد </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> التاريخ والوقت الفعلي لاستلام المستأجر السيارة من المؤجر </span>
                </div>
            </td>

        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">1 </span>
                </div>
            </td>


            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> تاريخ ووقت نهاية العقد </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> التاريخ والوقت الفعلي تسليم المستأجر السيارة لل المؤجر </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 1 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> تاريخ ووقت نهاية العقد الفعلي </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">التاريخ والوقت الفعلي لتسليم المستأجر السيارة للمؤجر.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 1 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> نوع العقد</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> التوضيح يتم تحديد خيار واحد من كل مجموعة (جديد/ تمديد) (يومي/ ساعة/
                        بسائق)</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 1 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة العقد </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> توضيح بتم تحديد خيار واحد (ساري / مقفل / مطالبة/لم يجدد). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 2 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">رقم الترخيص </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم كتابة رقم ترخيص المنشأة الصادر من الهيئة لمزاولة نشاط تأجير السيارات
                    </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 2 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> رقم هوية المنشأة </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> تم كتابة رقم (700 (الصادر عن وزارة التجارة والاستثمار.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 2 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> فئة الترخيص </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تحديد الفئة وفقاً لما نص عليه ترخيص المنشأة الصادر من الهيئة لمزاولة
                        نشاط تأجير السيارات (أ/ب/ج/د/هـ). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">3 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> نوع الهوية </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين نوع الهوية بحسب ما يحمله المستأجر (هوية وطنية/ هوية مقيم / جواز
                        السفر). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 3 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> نوع الرخصة </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين نوع الرخصة بحسب ما هو محدد في رخصة المستأجر (نقل عام / نقل
                        خاص). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 4 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> نوع الهوية </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين نوع الهوية بحسب ما يحمله سائق المنشأة (هوية وطنية/ هوية مقيم /
                        جواز السفر).</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">4 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">نوع الرخصة </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين نوع الرخصة بحسب ما هو محدد في رخصة سائق المنشأة (نقل عام / نقل
                        خاص). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> نوع السيارة </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> تم تدوين نوع السيارة وطرازها في هذه الخانة، مثال ذلك (تويوتا/ كامري).
                    </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> نوع التسجيل </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين نوع التسجيل بحسب ما هو محدد في رخصة السير (نقل عام / نقل خاص/
                        خصوصي). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> رقم بطاقة التشغيل </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين الرقم المسجل على بطاقة التشغيل الخاصة بالسيارة. </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> نوع الوقود </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> حدد من قبل المؤجر نوع الوقود الخاص لكل سيارة بهذه الخانة (95/91) .
                    </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> كمية الوقود الموجودة </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> حدد المؤجر الكمية الموجودة فعلياً في خران الوقود عند التأجير. </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> موعد استدعاء </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد المؤجر موعد لحضور السيارة لمقر المنشأة لأجراء الفحوصات اللازمة لها
                        ومثال على (موعد تغير الزيت). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> رقم وثيقة التأمين</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يسجل رقم وثيقة التأمين الخاص بالسيارة في هذه الخانة. </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 5 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> مبلغ التحمل</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد مبلغ التحمل كما نصت علية وثيقة التأمين. </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 6 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">مدة الايجار </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">يحدد في هذه الخانة بحسب نوع العقد إذا عقد يومي يذكر به عدد الأيام وإذا كان
                        عقد بالساعة تذكر عدد الساعات بما لا يتجاوز عدد
                        الساعات المسموح بها للتأجير بالساعة. </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 6 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة كيلو متر الزائد </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد المؤجر عن كل كيلو متر زائد مبلغ مالي. </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 6 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> عدد ساعات التأخير المسموح بها </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد عدد الساعات المسموحة بعد إنتهاء مدة العقد، وبعد ذلك يبدأ أحتساب
                        ساعات التأخير على المستأجر </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 7 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> موقع الخروج </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد امام هذه العبارة الفرع والمدينة التي استلم المستأجر السيارة منه
                    </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start">8 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> موقع الوصول </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد امام هذه العبارة الفرع والمدينة التي سلم المستأجر السيارة فيها.
                    </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 9</span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> سياسة إعادة السيارة قبل انتهاء مدة العقد </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد المؤجر طريقة استرجاع المبالغ للمستأجر عن المدة المتبقية في العقد عند
                        تسليم السيارة للمؤجر قبل انتهاء مدة العقد </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 9 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> آلية الإبلاغ عن الحوادث أو الأعطال</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد المؤجر آلية الإبلاغ عن الحوادث والأعطال بأحد الخيارات التالية:(اتصال
                        هاتفي، رسالة قصيرة، فاكس، بريد الكتروني) </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة التكييف </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (ممتاز/ جيد/ ضعيف
                        /متعطل). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة الراديو/المسجل </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (ممتاز/ جيد/ ضعيف
                        /متعطل). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة الشاشة الداخلية </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (ممتاز/ جيد/ ضعيف
                        /متعطل). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة عداد السرعة </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (يعمل/متعطل). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة الفرش الداخلي</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (نظيف/ متسخ). </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> معدات الكفر الاحتياطية</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (يوجد /لا يوجد).</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة العجلات </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (ممتاز/ جيد/
                        ضعيف).</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حاله العجلات الاحتياطية </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (ممتاز/ جيد/
                        ضعيف).</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة حقيبة الإسعافات الأولية </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (يوجد /لا يوجد).</span>
                </div>
            </td>

        </tr>


        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> موعد تغيير الزيت </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> تم تحديد الكيلو متر التي يجب تغير زيت السيارة فور الوصل له </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> حالة المفتاح </span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (يعمل/متعطل) </span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> توفر طفاية الحريق</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (يوجد /لا يوجد)</span>
                </div>
            </td>

        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 10 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> توفر المثلث العاكس</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (يوجد /لا يوجد)</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 11 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة تفويض سائق إضافي</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> يحدد المؤجر في حال رغبة المستأجر إضافة سائق غيره على العقد.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 11 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> إجمالي قيمة التأخير</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">يتم احتساب إجمالي قيمة التأخير في حال إعادة السيارة بعد أنهاء العقد كما هو
                        منصوص علية في المادة التاسعة من العقد</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 11 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> إجمالي أجرة السائق</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> مجموع أجرة التأجير بسائق عن جميع الأيام</span>
                </div>
            </td>

        </tr>

        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 11 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة الخدمات الاضافية</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> قيمة تقديم أحد الخدمات التالية: مقعد أطفال، وسائل خاصة لذوي الإعاقة، قيمة
                        توصيل للسيارة، نظام الملاحة، الانترنت.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 11 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة التفويض الدولي</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> القيمة المقدرة من الجهة المعتمدة للسماح باستخدام السيارة دوليا.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 11 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة تسليم السيارة فى مدينة اخرى</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> اجرة تسليم المستأجر السيارة في مدينة خلاف المدينة التي تم التأجير
                        منه</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 12 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة سحب السيارة</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> أجرة نقل أو قطر السيارة المتعطلة أو المحتجزة بسبب المستأجر أو
                        المفوض.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 12 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة الخدمات التكميلية</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> قيمة تقديم أي خدمات يتفق عليها الطرفان وليست ضمن الخدمات الإضافية.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 12 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة تغيير الزيت</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> اجرة تغيير الزيت في حال لم يلتزم المستأجر بإعادة السيارة في حال استدعائه
                        من قبل المؤجر</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 12 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة الوقود</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> أجرة تعبئة الوقود الناقصة عن الكمية المستلمة</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 12 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> إجمالي قيمة الكيلومترات الزائدة</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> مجموع أجرة الكيلومترات الزائدة والمستهلكة.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 12 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة قطع الغيار</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> الأجرة المقدرة من جهة التقييم المعتمدة ويتحمل المتسبب قيمة قطع
                        الغيار.</span>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> 12 </span>
                </div>
            </td>
            <td colspan="1">
                <div class="clearfix">
                    <span class="float-start"> قيمة تقييم أضرار السيارة</span>
                </div>
            </td>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start"> الأجرة المقدرة من جهة التقييم المعتمدة ويتحمل المتسبب بالضرر تكلفة نتيجة
                        الفحص والتقدير.</span>
                </div>
            </td>

        </tr>



    </table>
    -->

    <div style="height:20px;"></div>
    <Center>
        <button type="submit" class="btn btn-primary  ">التالى</button>
    </Center>
    <div style="height:120px;"></div>
    </form>
</div>



@endsection

@section('scripts')
<script>

    $(document).ready(function() {


            $('#datatable').DataTable({
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ سائقين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض سائقين من _START_ إلى _END_ من إجمالي _TOTAL_ من سائق",
                    "sInfoEmpty": "عرض سائقين من 0 إلى 0 من إجمالي 0 سائق",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من سائقين)",
                    "sInfoPostFix": "",
                    "sSearch": "بـحــث:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "التحميل...",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sLast": "الأخير",
                        "sNext": "التالى",
                        "sPrevious": "السابق"
                    },
                    "oAria": {
                        "sSortAscending": ": التفعيل لفرز العمود بترتيب تصاعدي",
                        "sSortDescending": ": التفعيل لفرز العمود بترتيب تنازلي"
                    }
                }
            });

            $('#datatable_length').addClass('mb-3');
        });



</script>
@endsection
