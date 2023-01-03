@extends('index')
@section('title', 'العقد')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">انهاء تعاقد</h5>

</div>

<form method="POST" action="{{ url('driver/contract/end/endview') }}">
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
  <input type="hidden" value="{{$contract_id}}" name="contract_id" readonly required>
  <table class="table table-responsive table-bordered border-dark">
        <tr>
            <td colspan="6">

                <div class="clearfix">
                    <span class="float-start  text-primary h5">بيانات تسليم السياره: (8)</span>
                    <span class="float-end  text-primary h5">(8) Car Deliver Information </span>
                </div>

            </td>
        </tr>



        <tr>
            <td colspan="6">
                <div class="clearfix">
                    <span class="float-start">قراءة العداد عند التسليم :</span>
                    <span class="float-end">:Odometer reading at Delivery</span>

                        <input type="text" value="{{ old('car_return_odometer_reading_at_entery') }}" name="car_return_odometer_reading_at_entery" class="form-control" id="money" required>

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


                        <select class="form-select" required value="{{ old('car_technical_condition_at_return_air_condition') }}" name="car_technical_condition_at_return_air_condition">
                            <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_radio_recorder') }}" name="car_technical_condition_at_return_radio_recorder">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_dvr') }}" name="car_technical_condition_at_return_dvr">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_interior_screen') }}" name="car_technical_condition_at_return_interior_screen">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_speedometer') }}" name="car_technical_condition_at_return_speedometer">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_interior_upholstery') }}" name="car_technical_condition_at_return_interior_upholstery">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_spare_cover_equipment') }}" name="car_technical_condition_at_return_spare_cover_equipment">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_wheel') }}" name="car_technical_condition_at_return_wheel">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_spare_wheel') }}" name="car_technical_condition_at_return_spare_wheel">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_first_aid_kit') }}" name="car_technical_condition_at_return_first_aid_kit">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <input type="date" value="{{ old('car_technical_condition_at_return_oil_change_time') }}" name="car_technical_condition_at_return_oil_change_time" class="form-control" id="money" required>

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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_key') }}" name="car_technical_condition_at_return_key">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_fire_extinguisher_availability') }}" name="car_technical_condition_at_return_fire_extinguisher_availability">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_availability_triangle_refactor') }}" name="car_technical_condition_at_return_availability_triangle_refactor">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_printer') }}" name="car_technical_condition_at_return_printer">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_point_sale_device') }}" name="car_technical_condition_at_return_point_sale_device">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_fornt_screen') }}" name="car_technical_condition_at_return_fornt_screen">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_internal_camera') }}" name="car_technical_condition_at_return_internal_camera">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_4sensor_seat') }}" name="car_technical_condition_at_return_4sensor_seat">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_button_emergency') }}" name="car_technical_condition_at_return_button_emergency">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_device_tracking') }}" name="car_technical_condition_at_return_device_tracking">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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
                    <select class="form-select" required value="{{ old('car_technical_condition_at_return_light_taxi_mark') }}" name="car_technical_condition_at_return_light_taxi_mark">
                        <option value="-1" selected disabled>اختار الحاله  </option>
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

        <tr>

            <td colspan="3">
                <div class="clearfix">
                    <span class="float-start">ملاحظات :</span>
                    <span class="float-end">:Notes</span>

                        <input type="text" value="{{ old('car_technical_condition_at_return_notes') }}" name="car_technical_condition_at_return_notes" class="form-control" id="money" required>

                </div>
            </td>


        </tr>



    </table>


















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
