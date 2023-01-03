@extends('index')
@section('title', 'العقد')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start"> العقد</h5>

</div>
<form method="POST" id="form-contract" action="{{ url('driver/contract/adddata') }}">
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

        <table class="table table-responsive table-bordered  border-dark">
            <tr>
                <td colspan="4">

                    <div class="clearfix">
                        <span class="float-start text-primary">بيانات العقد (1)</span>
                        <span class="float-end text-primary">(1) Contract Information </span>
                    </div>
                </td>

            </tr>

            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start"> رقم العقد</span>
                        <span class="float-end">contract number</span>
                        <input type="text" value="{{ 'Jawab'.$driver->id.$vechile->id.time() }}" name="contract_number"
                            readonly class="form-control" id="contract_number" required>

                    </div>


                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start"> :مكان إبرام العقد</span>
                        <span class="float-end">:Contract Location </span>
                        <input type="text" readonly value="الاحداثيات:  (  24.472008  ,  39.5931931 )"
                            name="contract_location" class="form-control" id="location" required>

                    </div>


                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start">: تاريخ ووقت بدايه العقد</span>
                        <span class="float-end">:start date and time of the contract </span>
                        <input type="text" readonly value="{{ \Carbon\Carbon::now() }}"
                            id="startDate" name="contract_start_datetime" class="form-control" required>


                    </div>


                </td>

                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start"> :تاريخ ووقت نهايه العقد</span>
                        <span class="float-end">:End date and time of the contract </span>
                        <input type="text" readonly value="{{ \Carbon\Carbon::now()->addDays($request->lease_term-1) }}"
                            id="endDate" name="contract_end_datetime" class="form-control" required>

                    </div>
                </td>

            </tr>

            <tr>
                <td colspan="4">

                    <div class="clearfix">
                        <span class="float-start h5">نوع العقد</span>
                        <span class="float-end">Contract type</span>
                        <input type="text" value="جديد" name="contract_type" readonly class="form-control" id="money"
                            required>

                    </div>
                </td>

            </tr>

            <tr>
                <td colspan="4">

                    <div class="clearfix">
                        <span class="float-start">حاله العقد</span>
                        <span class="float-end">Contract status</span>
                        <input type="text" value="ساري" name="contract_status" readonly class="form-control" id="money"
                            required>

                    </div>
                </td>

            </tr>



        </table>
        <div style="height:50px;"></div>
        <table class="table table-responsive table-bordered border-dark">
            <tr>
                <td colspan="6">

                    <div class="clearfix">
                        <span class="float-start text-primary h5"> الطرف الأول: ( بيانات المؤجر ) (2)</span>
                        <span class="float-end  text-primary h5">(2) Lessor Information: (First Party)</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start">الاسم:</span>
                        <span class="float-end p-1">:Commercial Register</span>
                        <input type="text" readonly value="{{$company->name}}" name="company_name" class="form-control">

                    </div>
                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم السجل التجاري: </span>
                        <span class="float-end p-1">:Commercial Register</span>
                        <input type="text" readonly value="{{$company->commerical_register}}" class="form-control"
                            name="company_commerical_register">

                    </div>

                </td>

            </tr>

            <tr>

                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم السجل الضريبي: </span>
                        <span class="float-end p-1">:VAT Registerion</span>
                        <input type="text" readonly value="{{ $company->record_number }}" class="form-control"
                            name="company_vat_register">

                    </div>

                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم هوية المنشأه: </span>

                        <span class="float-end p-1">:Establishment ID Nunmber </span>
                        <input type="text" readonly value="{{$company->id_number }}" class="form-control"
                            name="company_id_number">

                    </div>

                </td>
            </tr>


            <tr>

                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم الترخيص: </span>
                        <span class="float-end p-1">:License No</span>
                        <input type="text" readonly value="{{$company->license_number }}" class="form-control"
                            name="company_license_number">

                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">فئه الترخيص: </span>
                        <span class="float-end p-1">License Categoty </span>

                        <input type="text" readonly value="{{$company->license_category }}" class="form-control"
                            name="company_license_category">

                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم الهاتف/الجوال : </span>
                        <span class="float-end p-1">:phone/mobile </span>
                        <input type="text" readonly value="{{$company->phone }}" class="form-control"
                            name="company_phone">

                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start p-1">العنوان : </span>

                        <span class="float-end p-1">:Address</span>

                        <input type="text" readonly value="{{$company->address }}" class="form-control"
                            name="company_address">

                    </div>
                </td>
            </tr>

            <tr>

                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">فاكس: </span>
                        <span class="float-end p-1">:Fax</span>
                        <input type="text" readonly value="{{$company->company_fax }}" class="form-control"
                            name="company_fax">

                    </div>

                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <div class="float-start p-1">البريد الالكتروني: </div>
                        <div class="float-end p-1">:E-mail </div>
                        <input type="text" readonly value="{{$company->email }}" class="form-control"
                            name="company_email">

                    </div>

                </td>
            </tr>




        </table>
        <div style="height:50px;"></div>
        <table class="table table-responsive table-bordered border-dark">
            <tr>
                <td colspan="6">

                    <div class="clearfix">
                        <span class="float-start  text-primary h5">الطرف الثاني: (بيانات المستأجر) (3)</span>
                        <span class="float-end  text-primary h5">(3) Lessee Information: (Second Party)</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">الاسم:</span>
                        <span class="float-end">:name</span>
                        <input type="text" readonly class="form-control" value="{{ $driver->name }}"
                            name="tenant_name_ar">
                        <input type="hidden" readonly class="form-control" value="{{ $driver->id }}" name="id_driver"
                            id="driver-id">
                        <input type="hidden" readonly class="form-control" value="{{ $vechile->id }}" name="vechile_id">


                    </div>
                </td>



            </tr>

            <tr>

                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">تاريخ الميلاد: </span>
                        <span class="float-end p-1">:Birth Date</span>
                        <input type="text" readonly class="form-control" value="{{ $driver->birth_date }}"
                            name="tenant_brith_date">

                    </div>

                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">الجنسيه: </span>
                        <span class="float-end p-1">:Nationality </span>

                        <input type="text" readonly class="form-control" value="{{ $driver->nationality }}"
                            name="tenant_nationality">

                    </div>

                </td>
            </tr>


            <tr>

                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> نوع الهويه: </span>

                        <span class="float-end p-1">:ID Type</span>
                        <input type="text" readonly class="form-control" value="{{ $driver->id_type }}"
                            name="tenant_id_type">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> رقم الهوية: </span>

                        <span class="float-end p-1">:ID Number</span>
                        <input type="text" readonly class="form-control" value="{{ $driver->ssd }}"
                            name="tenant_id_number">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">تاريخ انتهاء الهوية: </span>
                        <span class="float-end p-1">:ID Expiry Date </span>
                        <input type="text" readonly class="form-control" value="{{ $driver->id_expiration_date }}"
                            name="tenant_id_date_expire">
                    </div>

                </td>
            </tr>
            <input type="hidden" value="{{ $driver->id }}" name="id_driver">
            <tr>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">النسخه عدد: </span>

                        <span class="float-end p-1">:Version No</span>
                        <input type="text" readonly class="form-control" value="{{ $driver->id_copy_no }}"
                            name="tenant_id_version_number">
                    </div>

                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">مكان الاصدار: </span>

                        <span class="m-1" style="color:red"></span>
                        <span class="float-end p-1">:Place Of Issue </span>
                        <input type="text" readonly class="form-control" value="{{ $driver->place_issue }}"
                            name="tenant_place_issue">
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="clearfix">
                        <span class="float-start p-1">العنوان : </span>

                        <span class="float-end p-1">:Address</address> </span>
                        <input type="text" readonly class="form-control" value="{{ $driver->address }}"
                            name="tenant_address">
                    </div>
                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم الهاتف/الجوال : </span>
                        <span class="float-end p-1">:phone/mobile </span>
                        <input type="text" readonly class="form-control" value="{{ $driver->phone }}"
                            name="tenant_mobile">
                    </div>

                </td>
            </tr>

            <tr>

                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> نوع الرخصه: </span>


                        <span class="float-end p-1">:License Type</span>
                        <input type="text" readonly class="form-control" value="{{ $driver->license_type }}"
                            name="tenant_license_type">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> رقم الرخصه: </span>

                        <span class="float-end p-1">:License Number</span>
                        <input type="text" readonly class="form-control" value="{{ $driver->license_number }}"
                            name="tenant_license_number">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">تاريخ انتهاء الرخصة: </span>
                        <span class="float-end p-1">:License Expiry Date </span>
                        <input type="text" readonly class="form-control" value="{{ $driver->license_expiration_date }}"
                            name="tenant_license_date_expire">
                    </div>

                </td>
            </tr>



            {{-- <tr>
                <td colspan="6">

                    <div class="clearfix">
                        <span class="float-start"> (بيانات السائق الاضافي) (3)</span>
                        <span class="float-end">Additional Driver Information</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start">الاسم:</span>
                        <span class="float-end" style="color:red">محمد جابر يوسف</span>

                    </div>
                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-end">:name</span>
                        <span class="float-start" style="color:red">mohamed gaber yousef</span>

                    </div>
                </td>


            </tr>

            <tr>

                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">تاريخ الميلاد: </span>

                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end p-1">:Birth Date</span>
                    </div>

                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">الجنسيه: </span>

                        <span class="m-1" style="color:red">56465646564645</span>
                        <span class="float-end p-1">:Nationality </span>
                    </div>

                </td>
            </tr>


            <tr>

                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> نوع الهويه: </span>

                        <span class="m-1" style="color:red">5556656565</span>

                        <span class="float-end p-1">:ID Type</span>
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> رقم الهوية: <span class="m-1" style="color:red">ج</span></span>
                        <span class="float-end p-1">:ID Number<span class="m-1" style="color:red">C</span></span>
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">تاريخ انتهاء الهوية: </span>

                        <span class="m-1" style="color:red">96665040658</span>
                        <span class="float-end p-1">:ID Expiry Date </span>
                    </div>

                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">النسخه عدد: </span>

                        <span class="m-2" style="color:red"></span>
                        <span class="float-end p-1">:Version No</span>
                    </div>

                </td>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">مكان الاصدار: </span>

                        <span class="m-1" style="color:red">تنننننن</span>
                        <span class="m-1" style="color:red">info@gmsd.com</span>
                        <span class="float-end p-1">:Place Of Issue </span>
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="clearfix">
                        <span class="float-start p-1">العنوان : </span>

                        <span class="m-1" style="color:red">hgkjdsdfskjdskj kjdskjdsjkds kjdsjds</span>
                        <span class="float-end p-1">:Address</address> </span>
                    </div>
                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم الهاتف/الجوال : </span>

                        <span class="m-1" style="color:red">96665040658</span>
                        <span class="float-end p-1">:phone/mobile </span>
                    </div>

                </td>
            </tr>

            <tr>

                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> نوع الرخصه: </span>

                        <span class="m-1" style="color:red">5556656565</span>

                        <span class="float-end p-1">:License Type</span>
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> رقم الرخصه: </span>

                        <span class="m-1" style="color:red">5556656565</span>

                        <span class="float-end p-1">:License Number</span>
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">تاريخ انتهاء الرخصة: </span>

                        <span class="m-1" style="color:red">96665040658</span>
                        <span class="float-end p-1">:License Expiry Date </span>
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="6" rowspan="3">
                    <div class="clearfix">
                        <span class="float-start p-1">توقيع السائق الاضافي: </span>


                        <span class="float-end p-1">:Signature Of Additional Driver</span>
                    </div>

                </td>
            </tr> --}}




        </table>
        <div style="height:50px;"></div>
        <table class="table table-responsive table-bordered border-dark">
            <tr>
                <td colspan="6">

                    <div class="clearfix">
                        <span class="float-start  text-primary h5">بيانات السياره: (5)</span>
                        <span class="float-end  text-primary h5">(5) Car Information </span>
                    </div>

                </td>
            </tr>


            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start">نوع السياره:</span>

                        <span class="float-end">:Car Type</span>

                        <input type="text" readonly class="form-control" value="{{ $vechile->vechile_type }}"
                            name="car_type">
                    </div>
                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> رقم اللوحه : </span>

                        <span class="float-end p-1">:Plate number</span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->plate_number }}"
                            name="car_plate_number" id="plate_number">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">سنه الصنع: </span>

                        <span class="float-end p-1">:Manufacture Year </span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->made_in }}"
                            name="car_manufacture_year">
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start">اللون:</span>
                        <span class="float-end" ">:color</span>
                    <input type=" text" readonly class="form-control" value="{{ $vechile->color }}" name="car_color">
                    </div>
                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">نوع التسجيل: </span>

                        <span class="float-end p-1">:Registerion Type </span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->registration_type }}"
                            name="car_registerion_type">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم بطاقه التشغيل: </span>

                        <span class="float-end p-1">:Operating Card No </span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->operation_card_number }}"
                            name="car_operating_card_number">
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start">تاريخ انتهاء بطاقه التشغيل:</span>
                        <span class="float-end">:Operating Card Expiry Date</span>
                        <input type="text" readonly class="form-control"
                            value="{{ $vechile->operating_card_expiry_date }}"
                            name="car_operating_card_number_date_expire">
                    </div>
                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">نوع الوقود: </span>

                        <span class="float-end p-1">:Fuel Type</span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->fuel_type }}"
                            name="car_fuel_type">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">كميه الوقود الموجوده: </span>

                        <span class="float-end p-1">:Amount of fuel presen </span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->amount_fuel }}"
                            name="car_amount_fuel_present">
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start">موعد الاستدعاء:</span>
                        <span class="float-end">:Appointment call for maintenanc</span>
                        <input type="text" readonly class="form-control"
                            value="{{ $vechile->periodic_examination_expiration_date }}"
                            name="car_appointment_maintenanc_date">
                    </div>
                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">رقم وثيقه التأمين : </span>

                        <span class="float-end p-1">:Insurance Policy No</span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->insurance_policy_number }}"
                            name="car_insurance_policy_number">
                    </div>

                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1">تاريخ انتهاء التأمين: </span>
                        <span class="float-end p-1">:Insurance Expiry Date </span>
                        <input type="text" readonly class="form-control"
                            value="{{ $vechile->insurance_card_expiration_date }}"
                            name="car_insurance_policy_number_date_expire">
                    </div>

                </td>
            </tr>
            <tr>

                <td colspan="5">
                    <div class="clearfix">
                        <span class="float-start p-1">نوع التأمين: </span>

                        <span class="float-end p-1">:Insurance Type</span>
                        <input type="text" readonly class="form-control" value="{{ $vechile->insurance_type }}"
                            name="car_insurance_type">
                    </div>

                </td>
            </tr>


        </table>

        <div style="height:50px;"></div>

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
                        <span class="float-start"> مدة الايجار:</span>
                        <span class="float-end">:lease term</span>

                        <input type="text" value="{{ $request->lease_term}}" readonly name="lease_term"
                            class="form-control" id="money" required>

                    </div>
                </td>
                <td colspan="2">
                    <div class="clearfix">
                        <span class="float-start p-1"> قيمه الايجار (يوم) : </span>

                        <span class="float-end p-1">:Cost Lease(day)</span>

                        <input type="text" value="{{ $request->lease_cost_dar_hour }}" readonly
                            name="lease_cost_dar_hour" class="form-control" id="money" required>

                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="clearfix">
                        <span class="float-start">عدد ساعات التأخيرالمسموح بها:</span>
                        <span class="float-end">:Number of delay hours allowed</span>
                        <input type="text" value="{{ $request->lease_hours_delay_allowed }}" readonly
                            name="lease_hours_delay_allowed" class="form-control" id="money" required>




                    </div>
                </td>

            </tr>

            {{-- <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">المنطقة الجغرافية المسموح للسيارة التنقل بها :</span>
                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end">:Allowed Geographical are of car</span>
                    </div>
                </td>


            </tr>
            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">قيمة التفويض الدولي :</span>
                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end">:international authorization value</span>
                    </div>
                </td>


            </tr>
            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">الخدمات الاضافيه :</span>
                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end">:Additional Services</span>
                    </div>
                </td>


            </tr>


            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">قيمه الخدمات الاضافيه:</span>
                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end">:Additional Services value</span>
                    </div>
                </td>


            </tr>


            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">الخدمات التكميليه :</span>
                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end">:Supplementary Services</span>
                    </div>
                </td>


            </tr>

            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start"> قيمة الخدمات التكميليه :</span>
                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end">:Supplementary Services value</span>
                    </div>
                </td>


            </tr>

            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">قيمة تفويض سائق اضافي :</span>
                        <span class="m-2" style="color:red">56465646564645</span>
                        <span class="float-end">:Additional driver authorization cost</span>
                    </div>
                </td>


            </tr> --}}





        </table>

        <div style="height:50px;"></div>

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
                        <input type="text" readonly value="{{ $request->car_receipt_odometer_reading_at_exit }}"
                            name="car_receipt_odometer_reading_at_exit" class="form-control" id="money" required>

                    </div>
                </td>


            </tr>
            <tr>
                <td colspan="6">
                    <div class="clearfix">
                        <span class="float-start">موقع الخروج:</span>

                        <span class="float-end">:location exit</span>
                        <input type="text" readonly value="مؤسسه الجواب لنقل البري- المدينه المنوره- السيح"
                            class="form-control" id="money" required>

                    </div>
                </td>


            </tr>






            <table class="table table-responsive table-bordered border-dark">
                <tr>
                    <td colspan="6">

                        <div class="clearfix">
                            <span class="float-start  text-primary h5">ساسيه التأجير: (9)</span>
                            <span class="float-end  text-primary h5">(9) Car receipt Information </span>
                        </div>

                    </td>
                </tr>

                <tr>
                    <td colspan="6">
                        <div class="clearfix">
                            <span class="float-start">سياسة إعادة السيارة قبل انتهاء مدة العقد: سداد قيمة كامل العقد /
                                سداد
                                القيمة الفعلية :</span>
                            <span class="float-end">:Policy of returning the car before the contract expiry: Payment of
                                full
                                contract amount/payment of actual amount</span>

                            <input type="text" readonly
                                value="{{ $request->leasing_policy_return_car_before_contract_expire }}"
                                name="leasing_policy_return_car_before_contract_expire" class="form-control" id="money"
                                required>



                        </div>
                    </td>


                </tr>
                <tr>
                    <td colspan="6">
                        <div class="clearfix">
                            <span class="float-start">تمديد العقد: مسموح/ غير مسموح :الزمن اللازم لتقديم طلب التمديد:
                                :</span>
                            <span class="float-end">:Contract extension: Allowed/ Not Allowed Time required to submit an
                                extension request:
                            </span>
                            <input type="text" readonly value="
                        @if($request->leasing_policy_contract_extension=='1')
                        مسموح
                        @else
                        غير مسموح
                        @endif
                        " class="form-control" id="money" required>

                            <input type="hidden" readonly value="{{$request->leasing_policy_contract_extension}}"
                                name="leasing_policy_contract_extension" class="form-control" id="money" required>
                            <input type="text" readonly value=" تقديم طلب تمديد العقد قبل انتهاء مدته بـ 24 ساعة"
                                class="form-control" id="money" required>
                            <input type="text" readonly value="من خلال الحضور الي مكتب الجواب لنقل البري  "
                                class="form-control" id="money" required>




                        </div>
                    </td>


                </tr>

                <tr>
                    <td colspan="6">
                        <div class="clearfix">
                            <span class="float-start">آلية الإبلاغ عن الحوادث أو الأعطال:</span>
                            <span class="float-end">:Mechanism for reporting accidents or malfunctions</span>
                            <input type="text" readonly
                                value="  من خلال رسالة نصية على الهاتف المحمول رقم : 0509040954 " class="form-control"
                                id="money" required>

                        </div>
                    </td>


                </tr>
                <tr>
                    <td colspan="6">
                        <div class="clearfix">
                            <span class="float-start">اعاده الوقود:</span>
                            <span class="float-end">:Fuel Return Mechanism </span>
                            <input type="text" readonly
                                value="اعاده السيارة وفق كمية الوقود الموجودة عند استلامها والمحددة في العقد، وتحمل فرق التكلفة في حال الإخلال بذلك"
                                class="form-control" id="money" required>

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

                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_air_condition=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_air_condition=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_air_condition=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_air_condition=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_air_condition=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_air_condition=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif
                        " class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_air_condition }}"
                                name="car_technical_condition_at_lease_air_condition" class="form-control" id="money"
                                required>





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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_radio_recorder=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_radio_recorder=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_radio_recorder=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_radio_recorder=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_radio_recorder=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_radio_recorder=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_radio_recorder }}"
                                name="car_technical_condition_at_lease_radio_recorder" class="form-control" id="money"
                                required>

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
                            <span class="float-start"> حاله الشاشه الداخليه </span>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_interior_screen=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_interior_screen=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_interior_screen=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_interior_screen=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_interior_screen=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_interior_screen=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_interior_screen }}"
                                name="car_technical_condition_at_lease_interior_screen" class="form-control" id="money"
                                required>

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
                            <span class="float-start"> حاله جهاز تسجيل الفديو dvr </span>
                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_dvr=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_dvr=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_dvr=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_dvr=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_dvr=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_dvr=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly value="{{ $request->car_technical_condition_at_lease_dvr }}"
                                name="car_technical_condition_at_lease_dvr" class="form-control" id="money" required>

                        </div>
                    </td>

                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-end">Video Recorder Dvr</span>
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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_speedometer=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_speedometer=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_speedometer=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_speedometer=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_speedometer=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_speedometer=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_speedometer   }}"
                                name="car_technical_condition_at_lease_speedometer" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_interior_upholstery=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_interior_upholstery=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_interior_upholstery=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_interior_upholstery=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_interior_upholstery=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_interior_upholstery=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_interior_upholstery   }}"
                                name="car_technical_condition_at_lease_interior_upholstery" class="form-control"
                                id="money" required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_spare_cover_equipment=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_spare_cover_equipment=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_spare_cover_equipment=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_spare_cover_equipment=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_spare_cover_equipment=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_spare_cover_equipment=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_spare_cover_equipment   }}"
                                name="car_technical_condition_at_lease_spare_cover_equipment" class="form-control"
                                id="money" required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_wheel=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_wheel=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_wheel=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_wheel=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_wheel=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_wheel=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_wheel   }}"
                                name="car_technical_condition_at_lease_wheel" class="form-control" id="money" required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_spare_wheel=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_spare_wheel=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_spare_wheel=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_spare_wheel=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_spare_wheel=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_spare_wheel=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_spare_wheel   }}"
                                name="car_technical_condition_at_lease_spare_wheel" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_first_aid_kit=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_first_aid_kit=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_first_aid_kit=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_first_aid_kit=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_first_aid_kit=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_first_aid_kit=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_first_aid_kit   }}"
                                name="car_technical_condition_at_lease_first_aid_kit" class="form-control" id="money"
                                required>
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
                        <div class="clearfix text-center">
                            <input type="text" readonly
                                value="{{$request->car_technical_condition_at_lease_oil_change_time}}"
                                class="form-control text-center pl-3" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_oil_change_time   }}"
                                name="car_technical_condition_at_lease_oil_change_time" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_key=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_key=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_key=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_key=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_key=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_key=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly value="{{ $request->car_technical_condition_at_lease_key   }}"
                                name="car_technical_condition_at_lease_key" class="form-control" id="money" required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_fire_extinguisher_availability=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_fire_extinguisher_availability=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_fire_extinguisher_availability=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_fire_extinguisher_availability=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_fire_extinguisher_availability=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_fire_extinguisher_availability=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_fire_extinguisher_availability   }}"
                                name="car_technical_condition_at_lease_fire_extinguisher_availability"
                                class="form-control" id="money" required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_availability_triangle_refactor=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_availability_triangle_refactor=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_availability_triangle_refactor=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_availability_triangle_refactor=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_availability_triangle_refactor=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_availability_triangle_refactor=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{$request->car_technical_condition_at_lease_availability_triangle_refactor}}"
                                name="car_technical_condition_at_lease_availability_triangle_refactor"
                                class="form-control" id="money" required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_printer=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_printer=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_printer=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_printer=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_printer=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_printer=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_printer   }}"
                                name="car_technical_condition_at_lease_printer" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_point_sale_device=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_point_sale_device=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_point_sale_device=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_point_sale_device=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_point_sale_device=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_point_sale_device=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_point_sale_device   }}"
                                name="car_technical_condition_at_lease_point_sale_device" class="form-control"
                                id="money" required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_fornt_screen=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_fornt_screen=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_fornt_screen=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_fornt_screen=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_fornt_screen=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_fornt_screen=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_fornt_screen   }}"
                                name="car_technical_condition_at_lease_fornt_screen" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_internal_camera=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_internal_camera=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_internal_camera=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_internal_camera=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_internal_camera=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_internal_camera=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_internal_camera   }}"
                                name="car_technical_condition_at_lease_internal_camera" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_4sensor_seat=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_4sensor_seat=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_4sensor_seat=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_4sensor_seat=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_4sensor_seat=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_4sensor_seat=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_4sensor_seat   }}"
                                name="car_technical_condition_at_lease_4sensor_seat" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_button_emergency=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_button_emergency=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_button_emergency=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_button_emergency=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_button_emergency=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_button_emergency=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_button_emergency   }}"
                                name="car_technical_condition_at_lease_button_emergency" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_device_tracking=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_device_tracking=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_device_tracking=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_device_tracking=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_device_tracking=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_device_tracking=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif" class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_device_tracking   }}"
                                name="car_technical_condition_at_lease_device_tracking" class="form-control" id="money"
                                required>

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
                            <input type="text" readonly value="
                        @if($request->car_technical_condition_at_lease_light_taxi_mark=='1')
                        ممتازه
                        @elseif($request->car_technical_condition_at_lease_light_taxi_mark=='2')
                        جيده
                        @elseif($request->car_technical_condition_at_lease_light_taxi_mark=='3')
                        متوسطه
                        @elseif($request->car_technical_condition_at_lease_light_taxi_mark=='4')
                        ردئ
                        @elseif($request->car_technical_condition_at_lease_light_taxi_mark=='5')
                        معطل
                        @elseif($request->car_technical_condition_at_lease_light_taxi_mark=='6')
                        غير موجود
                        @else
                        غير محدد هذا العنصر
                        @endif
                        " class="form-control" id="money" required>
                            <input type="hidden" readonly
                                value="{{ $request->car_technical_condition_at_lease_light_taxi_mark   }}"
                                name="car_technical_condition_at_lease_light_taxi_mark" class="form-control" id="money"
                                required>

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
                    <td colspan="2">
                        <div class="clearfix">
                            <span class="float-start">اجمالي قيمه التأجير مده العقد</span>
                            <span class="float-end">:Total Lease cost (day/hour)</span>

                            <input type="text" readonly value="{{ $request->lease_cost_dar_hour*$request->lease_term }}"
                                name="main_financial_total_lease_cost_day_hour" class="form-control" id="money"
                                required>



                        </div>
                    </td>

                </tr>






                <tr>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">الضريبه المضافه:</span>
                            <span class="float-end">:VAT</span>
                            <input type="text" value="{{ $request->main_financial_vat }}" readonly
                                name="main_financial_vat" class="form-control" id="money" required readonly>

                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">الاجمالي:</span>
                            <span class="float-end">:Total</span>

                            <input type="text" readonly
                                value="{{ ($request->lease_cost_dar_hour*$request->lease_term)+(($request->lease_cost_dar_hour*$request->lease_term*$request->main_financial_vat)/100) }}"
                                name="main_financial_total" class="form-control" id="money" required>


                        </div>
                    </td>

                </tr>

                {{-- <tr>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">المتبقي :</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('main_financial_remaining_amount') }}"
                                    name="main_financial_remaining_amount" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Remaining Amount</span>

                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">المدفوع:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('main_financial_paid') }}" name="main_financial_paid"
                                    class="form-control" id="money" required></span>
                            <span class="float-end">:Paid</span>

                        </div>
                    </td>
                </tr> --}}

                {{-- <tr>
                    <td colspan="1">



                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">طريقة الدفع:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('main_financial_payment_method') }}"
                                    name="main_financial_payment_method" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">: Payment Method</span>

                        </div>
                    </td>

                </tr> --}}











            </table>

            {{--
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
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_total_cost_extra_km') }}"
                                    name="other_financial_total_cost_extra_km" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Total cost extra kilometer</span>

                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">قيمه مبلغ التحمل</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_deductible_amount_value') }}"
                                    name="other_financial_deductible_amount_value" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Additional Services cost</span>

                        </div>
                    </td>
                </tr>


                <tr>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">قيمة الخدمات التكميليه:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_supplementary_service_cost') }}"
                                    name="other_financial_supplementary_service_cost" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Supplementary services cost</span>

                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">قيمة قطع الغيار:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_spare_parts_cost') }}"
                                    name="other_financial_spare_parts_cost" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Spare Parts Costs</span>

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">قيمة سحب السياره:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_car_towing_cost') }}"
                                    name="other_financial_car_towing_cost" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Car Towing Cost</span>

                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">قيمة تقييم أضرار السيارة:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_car_damage_assessment_value') }}"
                                    name="other_financial_car_damage_assessment_value" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Car damage assessment Value </span>

                        </div>
                    </td>

                </tr>

                <tr>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">قيمة تغيير الزيت:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_oil_change_cost') }}"
                                    name="other_financial_oil_change_cost" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">:Oil Change Cost</span>

                        </div>
                    </td>

                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">الخصم:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_discount') }}" name="other_financial_discount"
                                    class="form-control" id="money" required></span>
                            <span class="float-end">:Discount</span>

                        </div>
                    </td>
                </tr>

                <tr>

                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">قيمة الوقود:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_fuel_cost') }}" name="other_financial_fuel_cost"
                                    class="form-control" id="money" required></span>
                            <span class="float-end">:Fuel Cost</span>

                        </div>
                    </td>

                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">الضريبه المضافه:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_vat') }}" name="other_financial_vat"
                                    class="form-control" id="money" required></span>
                            <span class="float-end">:VAT</span>

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">الاجمالي:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_total') }}" name="other_financial_total"
                                    class="form-control" id="money" required></span>
                            <span class="float-end">:Total</span>

                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">المدفوع:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_paid') }}" name="other_financial_paid"
                                    class="form-control" id="money" required></span>
                            <span class="float-end">:Paid</span>

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">المتبقي :</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_remaining') }}" name="other_financial_remaining"
                                    class="form-control" id="money" required></span>
                            <span class="float-end">:Remaining Amount</span>

                        </div>
                    </td>
                    <td colspan="1">
                        <div class="clearfix">
                            <span class="float-start">طريقة الدفع:</span>
                            <span class="m-2" style="color:red"> <input type="text"
                                    value="{{ old('other_financial_payment_mothed') }}"
                                    name="other_financial_payment_mothed" class="form-control" id="money"
                                    required></span>
                            <span class="float-end">: Payment Method</span>

                        </div>
                    </td>

                </tr>

            </table> --}}

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
                                ،(ووفقاً لما هو محدد في البنود أعلاه ومطابقاً للشروط والأحكام والالتزامات المنصوص عليها
                                في
                                العقد، ويقر المستأجر بمعاينته للسيارة المؤجرة،
                                وقبوله للتعاقد على استئجارها، وأنها صالحة للاستخدام والسير على الطرق.
                                <br /> <br /> <br /> <br />
                                المادة الثالثة: مدة العقد:
                                <br />
                                تبدأ مدة العقد من تاريخ ووقت بداية العقد المذكور أعلاه وينتهي في تاريخ ووقت نهاية العقد
                                المذكور
                                أعلاه، ويحق للطرفين تمديد العقد من خلال البوابة الإلكترونية للهيئة العامة للنقل
                                <br /> <br /> <br /> <br />
                                المادة الرابعة:
                                <br />
                                ۱ .إجمالي قيمة العقد (رقما ) ( كتابة ) ريالاً سعودياً، يلتزم المستأجر بدفعها للمؤجر بحسب
                                ما هو
                                مذكور في البند رقم (۱۱ (من هذا العقد
                                <br />
                                ٢ .يلتزم المستأجر بدفع المبالغ المحددة في البند رقم (۱٢ (من هذا العقد وفقاً لأحكام وشروط
                                هذا
                                العقد.
                                <br /> <br /> <br /> <br />
                                المادة الخامسة: التأجير بسائق:
                                <br />
                                ۱ .يُعفى مستأجر السيارة بسائق من الالتزامات المحددة في البند رقم (۱٠ ،(وآلية الإبلاغ عن
                                الحوادث
                                أو الأعطال الواردة في البند رقم (٩ (من هذا العقد
                                <br />
                                ٢ .لا يتحمل مستأجر السيارة بسائق أي أضرار أو أعطال تظهر عليها.

                                <br /> <br /> <br />
                                المادة السادسة: التزامات المؤجر:
                                <br />

                                ١-استلام السيارة في الوقت والمكان المحدد بالعقد عند انتهاء العقد أو عند رغبة المستأجر في
                                تسليم
                                السيارة قبل انتهاء مدة العقد.
                                <br />

                                ٢ -توفير سيارة بديلة من ذات الفئة في حالة ظهور أي خلل فني ليس بسبب تقصير أو إهمال من قبل
                                المستأجر أو المفوضين، وفي حالة عدم توفر سيارة من ذات الفئة فيتم توفير سيارة بديلة من
                                الفئة
                                الأعلى التي تليها، مع عدم تحميل المستأجر أي
                                تكاليف إضافية، وإلا فيتم توفير سيارة بديلة من فئة أقل وفقاً للتعرفة المعلنة، بعد موافقة
                                المستأجر
                                على ذلك وإعادة فرق السعر للمسـتأجر.
                                <br />
                                ٣ -يتحمل المؤجر أي تكاليف دفعها المستأجر لاستلام السيارة البديلة وفقاً للفقرة
                                (٢ (من المادة السادسة من العقد.
                                <br />
                                ٤ -استلام السيارة عند إعادتها لأي سبب من الأسباب، مع احتفاظ المؤجر بحقه في المطالبة
                                بحقوقه بموجب
                                العقد.
                                <br />
                                ٥ -حفظ المفقودات التي تركها أصحابها داخل السيارة وتسليمها إلى أصحابها أو تسليمها بأسرع
                                وقت لأقرب
                                مركز شرطة بموجب محضر ضبط يتضمن أوصافها وكل البيانات المعرفة لها.
                                <br />
                                ٦ -إعادة المبالغ المحتجزة للمستأجر بعد خصم المستحقات المالية الواجبة عليه فور إعادة
                                السيارة
                                بحالة فنية سليمة.
                                <br />
                                ٧ -إنهاء عقد تأجير السيارة وإلغاء التفويض فور استلام السيارة.
                                <br />
                                ٨ -عدم استحصال أي مبالغ غير منصوص عليها في العقد.
                                <br />
                                ٩ -تحمل تكاليف قطع الغيار الاستهلاكية واستبدالها مالم يثبت أن سوء استخدام المستأجر أو
                                المفوض أدى
                                إلى إتلافها.
                                <br />
                                ۱٠ -تحمل تكاليف تغيير زيت محرك السيارة إذا تمت إعادتها حال قطع المسافة اللازمة لتغيره
                                المنصوص
                                عليها بالعقد.
                                <br />
                                ۱١-تحمل قيمة نقل السيارة المتعطلة مالم تثبت مسئولية المستأجر أو المفوض عن العطل.
                                <br />
                                ۱٢ -تمكين مراقبي الخدمة من الاطلاع على سجلات النشاط أو تزويده بالمعلومات أو المستندات
                                ذات
                                العلاقة.
                                <br />
                                ۱٣ -إخضاع السيارة لتغطية تأمينية بما يغطي -كحد أدنى- المسؤولية المدنية تجاه الغير وفق
                                الوثيقة
                                الموحدة للتأمين الإلزامي على المركبات طيلة مدة التشغيل أو طيلة مدة العقد أو أي تمديد له،
                                ولا
                                تنتقل المسئولية المترتبة على هذا النوع من
                                التغطية -بأي حال من الأحوال- إلى المستأجر، ويتحمل المؤجر كامل المسئولية المترتبة على
                                تأجيرها
                                سيارة دون أي تغطية تأمينية.
                                <br />
                                ۱٤ -الإفصاح عن نوع التغطية التأمينية في العقد حسب وثيقة التأمين الصادرة للسيارة، وتحديد
                                نسبة
                                التحمل في العقد (إن وجدت)، وأي تغطية تأمينية إضافية أخرى تزيد عن نوع التغطية التأمينية
                                المنصوص
                                عليها في بنود وثيقة تأمين السيارة،
                                وتوقيع المستأجر على ذلك.
                                <br />
                                ۱٥ -تحديد نسبة التحمل في العقد بناءً على القدر المنصوص عليه في بنود وثيقة التأمين
                                الصادرة
                                للسيارة من شركات التأمين المرخص لها بالعمل في المملكة.
                                <br />
                                ۱٦ -عدم تأجير سيارة بتغطية تأمينية أقل من نوع التغطية المنصوص عليه في بنود وثيقة تأمين
                                السيارة.
                                <br />
                                ۱٧ -عدم تأجير السيارة في حال وجود أي خلل فني يؤثر على سلامة المستأجر وصلاحية وسلامة
                                السيارة
                                فنياً للتأجير.
                                <br />
                                ۱٨ -تجهيز السيارة من حيث نظافتها من الداخل والخارج للتأجير.
                                <br />
                                ۱٩
                                -تحمل كامل المسئولية أمام الهيئة والجهات الأخرى ذات العلاقة، عن المخالفات التي تُقيد على
                                السيارة
                                <br />
                                ٢٠ -تزويد المستأجر بنسخة من العقد بعد التوقيع عليه من كلا الطرفين، ونسخة من المخالصة عند
                                إعادة
                                السيارة في حال طلب المستأجر.
                                <br />
                                ٢١-العناية التامة بصيانة السيارة وحالتها الفنية، والاحتفاظ بسجل الصيانة الدورية للسيارة.
                                <br />
                                ٢٢ -تجهيز السيارة بعجلة احتياطية، ومفتاح للعجل، وآلة رافعة، وإشارة الخطر العاكسة المثلثة
                                الشكل،
                                وحقيبة إسعافات أولية، وطفاية حريق، على أن تكون جميعها صالحة للاستخدام.
                                <br />
                                ٢٣ -إخضاع السيارة للفحص الفني الدوري طيلة مدة العقد.
                                <br />
                                ٢٤ -الإفصاح عن سياسة إعادة واستلام السيارة قبل انتهاء مدة العقد الموضحة في البند (٩ (من
                                العقد.
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
                                ٧ -عدم استخدام السيارة بشكل يؤدي إلى الإضرار بمحرك السيارة أو أحد عناصرها، أو استخدامها
                                لأغراض
                                غير مشروعة.
                                <br />
                                ٨ -عدم قيادة السيارة إذا كان المستأجر غير مخول لقيادتها لأي سبب كان، ويتحمل مسؤولية أي
                                ضرر أو
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
                                ٢١ -تقديم تقرير للمؤجر عن السيارة من الجهة المختصة في حال وقوع الحوادث المرورية أو
                                الأضرار
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
                                ٢ -تغيير زيت محرك السيارة في حال تجاوز المسافة المقطوعة اللازمة لتغير الزيت المنصوص
                                عليها في
                                العقد.
                                <br />
                                ٣ -نسبة التحمل (إن وجدت) المشار لها في العقد.
                                <br />
                                ٤ -قيمة الوقود وتعبئة هواء الإطارات خلال فترة العقد.
                                <br />
                                ٥ -الأضرار الناجمة عن سوء استخدام السيارة.
                                <br />
                                ٦ -الأضرار الناجمة عن الحوادث المرورية حسب نسبة مسؤوليته في الحادث، والأضرار التي لا
                                تغطيها
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
                                :أ. إذا كان التأجير بالنظام اليومي وتأخر المستأجر في تسليم السيارة عن الموعد المحدد
                                فيدفع
                                المستأجر مبلغاً وفق الحالات التالية
                                <br />
                                :١ .إذا تأخر المستأجر مدة لا تزيد عن أربع ساعات عن الموعد المحدد لتسليم السيارة فيكون
                                احتساب
                                ساعات التأخير وفق المعادلة التالية
                                قيمة التأجير اليومي × عدد ساعات التأخير) / 24 × [ (2 = تكلفة قيمة ساعات التأخير)]
                                .ويحسب التأخير في أي جزء من الساعة الواحدة بساعة كاملة
                                <br />
                                .٢ .إذا تأخر المستأجر مدة تزيد عن أربع ساعات عن الموعد المحدد لتسليم السيارة فيدفع
                                المستأجر
                                مبلغاً يعادل الأجرة اليومية كاملة عن كل يوم تأخير بالإضافة إلى الأجرة اليومية وتكاليف
                                التأجير
                                المتفق عليها في العقد
                                <br />
                                <br />

                                :ب. إذا كان التأجير بنظام الساعات وتأخر المستأجر في تسليم السيارة عن الموعد المحدد
                                فيلتزم
                                المستأجر بدفع مبلغ يكون حسابه على النحو التالي
                                <br />
                                .١ .إذا تأخر في تسليم السيارة لمدة ساعة أو أقل من الموعد المحدد فيلتزم بدفع ضعف أجرة
                                الساعة
                                الموضحة في العقد
                                <br />
                                .٢ .إذا تأخر في تسليم السيارة لمدة تزيد عن ساعة ولا تتجاوز (٢٤ (أربع وعشرين ساعة من
                                الموعد
                                المحدد فيلتزم بدفع قيمة التأجير اليومي للسيارة كاملة الموضحة في العقد
                                <br />
                                .٣ .إذا تأخر في تسليم السيارة لمدة تزيد عن (٢٤ (أربع وعشرين ساعة عن الموعد المحدد فيعامل
                                وفق
                                الفقرة ( أ/٢ (من هذه المادة
                                <br /><br />
                                .ج. لا يجوز إجراء أي تعديل من قبل المؤجر على العقد بعد توقيعه إلا بموافقة ومصادقة
                                المستأجر
                                <br /><br /><br />
                                المادة العاشرة: انتهاء العقد
                                <br />
                                :ينتهي العقد في الحالات التالية
                                <br />
                                :أ. إنهاء العقد قبل انتهاء مدته
                                <br />
                                .١ -للمؤجر إنهاء العقد قبل انتهاء مدته، وذلك في حال قيام المستأجر بتسليم السيارة، وفي
                                هذه
                                الحالة، يحق للمؤجر مطالبة المستأجر بالأجرة للمدة الفعلية أو مدة العقد كاملاً حسب المتفق
                                عليه في
                                العقد
                                <br />
                                .٢ -إذا رغب المستأجر في إنهاء العقد قبل انتهاء مدته ورفض المؤجر استلام السيارة، فيحق
                                للمستأجر
                                تقديم بلاغ للهيئة العامة للنقل بطلب إنهاء العقد، وفي حال ثبت صحة عدم الاستلام يتم إنهاء
                                العقد من
                                حين تقديم البلاغ
                                <br />
                                <br />
                                :ب. انتهاء مدة العقد
                                <br />
                                .١ -إذا سلم المستأجر السيارة في تاريخ ووقت نهاية العقد فيعد العقد منتهياً
                                <br />
                                .٢ -إذا لم يسلم المستأجر السيارة في تاريخ ووقت نهاية العقد المتفق عليه فيشعر المؤجر
                                المستأجر
                                برسالة نصية تفيد بعدم تسليم السيارة، ويحق للمستأجر الاعتراض على ذلك خلال ٤ ساعات من
                                إرسال
                                الإشعار، ويعد عدم اعتراضه على ذلك لدى الهيئة
                                خلال تلك المدة إقراراً منه بعدم تسليم السيارة واستحقاق غرامات التأخير بموجب العقد، وفي
                                حال
                                اعتراضه لدى الهيئة وثبت أن المستأجر يرغب في تسليم السيارة مع رفض المؤجر ذلك فيعد العقد
                                منتهياً
                                من حين تقديم البلاغ وفي هذه الحال يحق
                                للمؤجر مطالبة المستأجر بالأجرة الفعلية إلى حين تقديم البلاغ
                                <br />
                                <br />
                                :ج. وقوع حادث على السيارة
                                <br />
                                .١ -إذا وقع حادث على السيارة فعلى المستأجر إشعار المؤجر بذلك، وعلى المؤجر حينئذٍ إنهاء
                                العقد
                                فوراً وإشعار المستأجر بذلك
                                <br />
                                .٢ -يحق للمستأجر -عند عدم إنهاء المؤجر للعقد بعد إشعاره بوقوع الحادث- تقديم اعتراض عن
                                طريق
                                الهيئة، وتقوم الهيئة بدراسة الاعتراض وتحديد الوقت الفعلي لانتهاء العقد
                                <br />
                                <br />
                                <br />
                                <br />
                                :المادة الحادية عشرة: تسوية المنازعات
                                <br />
                                .١ -يخضع هذا العقد ويفسر وفقاً للأنظمة واللوائح المعمول بها في المملكة العربية السعودية
                                <br />
                                :٢ -للمؤجر طلب التنفيذ على المستأجر لدى محكمة التنفيذ بموجب نظام التنفيذ ولائحته
                                التنفيذية وفقاً
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
                                .٣ -في حال وجود خلاف بين أطراف العقد جراء تقدير الأضرار الناتجة عن الحوادث غير المرورية،
                                أو سوء
                                الاستخدام، أو الاستهلاك، تلتزم المنشأة المرخص لها بممارسة النشاط بتقدير الضرر الواقع على
                                السيارة
                                عن طريق جهة التقييم المعتمدة من الهيئة،
                                على أن يتحمل المتسبب بالضرر تكلفة نتيجة الفحص والتقرير
                                <br />
                                ٤ -باستثناء ما ورد في الفقرة (2 (من هذه المادة، في حال حدوث خلاف بين أطراف العقد حول
                                تفسير، أو
                                تنفيذ هذا العقد، أو أي بند من بنوده فللطرفين حلَّه بالطرق الودية، أو اللجوء للجهة
                                القضائية
                                المختصة
                                <br />
                                .٥ -باستثناء ما ورد في الفقرة (2 (من هذه المادة، في حال حدوث خلاف بين أطراف العقد حول
                                تفسير، أو
                                تنفيذ هذا العقد، أو أي بند من بنوده فللطرفين حلَّه بالطرق الودية، وينعقد الاختصاص إذا لم
                                يتم حله
                                بالطرق الودية إلى التحكيم وفقاً لنظام
                                التحكيم
                                <br />
                                <br />
                                <br /><br />
                                :المادة الثانية عشرة: العنوان الرسمي والمراسلات
                                <br />
                                .جميع الإخطارات والتبليغات يوجهها أحد الطرفين للآخر من خلال البوابة الإلكترونية للهيئة
                                العامة
                                للنقل ولا يعتد بأي وسيلة بخلاف ذلك
                                <br />
                                <br />
                                <br />
                                <br />
                                :المادة الثالثة عشرة: نسخ العقد
                                <br />
                                .يحرر هذا العقد كنسخة متطابقة لكلٍّ من المؤجر والمستأجر، وموقعة من طرفي العقد، وقد تسلم
                                كل طرف
                                نسخته إلكترونياً للعمل بموجبها، ويجوز للهيئة العامة للنقل تبادل بيانات هذا العقد مع
                                الجهات ذات
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
                        <div class="clearfix"> يدون أمام هذه العبارة مدينة إبرام العقد، على سبيل الذكر لا الحصر (الرياض/
                            المدينة
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
                            <span class="float-start"> التوضيح يتم تحديد خيار واحد من كل مجموعة (جديد/ تمديد) (يومي/
                                ساعة/
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
                            <span class="float-start"> يتم كتابة رقم ترخيص المنشأة الصادر من الهيئة لمزاولة نشاط تأجير
                                السيارات
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
                            <span class="float-start"> يتم تحديد الفئة وفقاً لما نص عليه ترخيص المنشأة الصادر من الهيئة
                                لمزاولة
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
                            <span class="float-start"> يتم تدوين نوع الهوية بحسب ما يحمله المستأجر (هوية وطنية/ هوية
                                مقيم / جواز
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
                            <span class="float-start"> يتم تدوين نوع الرخصة بحسب ما هو محدد في رخصة المستأجر (نقل عام /
                                نقل
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
                            <span class="float-start"> يتم تدوين نوع الهوية بحسب ما يحمله سائق المنشأة (هوية وطنية/ هوية
                                مقيم /
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
                            <span class="float-start"> يتم تدوين نوع الرخصة بحسب ما هو محدد في رخصة سائق المنشأة (نقل
                                عام / نقل
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
                            <span class="float-start"> تم تدوين نوع السيارة وطرازها في هذه الخانة، مثال ذلك (تويوتا/
                                كامري).
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
                            <span class="float-start"> يتم تدوين نوع التسجيل بحسب ما هو محدد في رخصة السير (نقل عام /
                                نقل خاص/
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
                            <span class="float-start"> حدد من قبل المؤجر نوع الوقود الخاص لكل سيارة بهذه الخانة (95/91)
                                .
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
                            <span class="float-start"> حدد المؤجر الكمية الموجودة فعلياً في خران الوقود عند التأجير.
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
                            <span class="float-start"> موعد استدعاء </span>
                        </div>
                    </td>
                    <td colspan="6">
                        <div class="clearfix">
                            <span class="float-start"> يحدد المؤجر موعد لحضور السيارة لمقر المنشأة لأجراء الفحوصات
                                اللازمة لها
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
                            <span class="float-start">يحدد في هذه الخانة بحسب نوع العقد إذا عقد يومي يذكر به عدد الأيام
                                وإذا كان
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
                            <span class="float-start"> يحدد عدد الساعات المسموحة بعد إنتهاء مدة العقد، وبعد ذلك يبدأ
                                أحتساب
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
                            <span class="float-start"> يحدد امام هذه العبارة الفرع والمدينة التي استلم المستأجر السيارة
                                منه
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
                            <span class="float-start"> يحدد امام هذه العبارة الفرع والمدينة التي سلم المستأجر السيارة
                                فيها.
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
                            <span class="float-start"> يحدد المؤجر طريقة استرجاع المبالغ للمستأجر عن المدة المتبقية في
                                العقد عند
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
                            <span class="float-start"> يحدد المؤجر آلية الإبلاغ عن الحوادث والأعطال بأحد الخيارات
                                التالية:(اتصال
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
                            <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (يعمل/متعطل).
                            </span>
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
                            <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (نظيف/ متسخ).
                            </span>
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
                            <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (يوجد /لا
                                يوجد).</span>
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
                            <span class="float-start">يتم تدوين امام هذه العبارة أحد الخيارين التالية (يوجد /لا
                                يوجد).</span>
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
                            <span class="float-start"> تم تحديد الكيلو متر التي يجب تغير زيت السيارة فور الوصل له
                            </span>
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
                            <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (يعمل/متعطل)
                            </span>
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
                            <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (يوجد /لا
                                يوجد)</span>
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
                            <span class="float-start"> يتم تدوين امام هذه العبارة أحد الخيارات التالية (يوجد /لا
                                يوجد)</span>
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
                            <span class="float-start"> يحدد المؤجر في حال رغبة المستأجر إضافة سائق غيره على
                                العقد.</span>
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
                            <span class="float-start">يتم احتساب إجمالي قيمة التأخير في حال إعادة السيارة بعد أنهاء
                                العقد كما هو
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
                            <span class="float-start"> قيمة تقديم أحد الخدمات التالية: مقعد أطفال، وسائل خاصة لذوي
                                الإعاقة، قيمة
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
                            <span class="float-start"> القيمة المقدرة من الجهة المعتمدة للسماح باستخدام السيارة
                                دوليا.</span>
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
                            <span class="float-start"> قيمة تقديم أي خدمات يتفق عليها الطرفان وليست ضمن الخدمات
                                الإضافية.</span>
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
                            <span class="float-start"> اجرة تغيير الزيت في حال لم يلتزم المستأجر بإعادة السيارة في حال
                                استدعائه
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
                            <span class="float-start"> الأجرة المقدرة من جهة التقييم المعتمدة ويتحمل المتسبب بالضرر
                                تكلفة نتيجة
                                الفحص والتقدير.</span>
                        </div>
                    </td>

                </tr>



            </table>

            <div style="height:20px;"></div>
            <Center>
                <button type="submit" class="btn btn-primary  " id="save-contract">حفظ بيانات العقد</button>
            </Center>
            <div style="height:20px;"></div>
</form>
</div>

<!-- Modal -->
<div class="modal fade" id="sendMessageVerfication" tabindex="-1" role="dialog"
    aria-labelledby="sendMessageVerficationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMessageVerficationLabel">توقيع العقد إلكترونيا </h5>
            </div>
            <div class="modal-body">
                <div  id="alert-danger">
                </div>
                <div class="row">
                    <div class="mt-2 col-9 ">
                        <label for="driver_confirm" class="form-label">رسالة تأكيد السائق </label>
                        <input type="text" value="{{ old('driver_confirm') }}" name="driver_confirm"
                            class="form-control" id="driver_confirm_input" required>
                    </div>
                    <div class="mt-4 col-3 ">
                        <a href="#" class="btn btn-outline-success mt-3" id="driver_confirm">تأكيد</a>
                    </div>
                </div>
                <div id="alert-driver" class="col-9">

                </div>
                <div class="mb-3">
                    <button class="btn " id="resend-driver-code">أعادة ارسال الكود</button>
                </div>
                <div class="row">
                    <div class="mt-2 col-9 ">
                        <label for="user_confirm" class="form-label">رسالة تأكيد الموظف</label>
                        <input type="text" value="{{ old('user_confirm') }}" name="user_confirm" class="form-control"
                            id="user_confirm_input" required>
                    </div>
                    <div class="mt-4 col-3 ">
                        <button class="btn btn-outline-success mt-3" id="user_confirm">تأكيد</button>
                    </div>
                </div>
                <div id="alert-user" class="col-9">

                </div>
                <div class="mb-3">
                    <button type="submit" class="btn " id="resend-user-code">أعادة ارسال الكود</button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="save-contract-final">حفظ العقد </button>
                    <a class="btn btn-secondary close-modal" data-dismiss="modal">إلغاء</a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        var driverCode ;
        var userCode ;
        var confirmDriverCode = false ;
        var confirmUserCode = false ;
        var driverCodeTime ;
        var userCodeTime ;
        $("#save-contract").click(function(e){
            e.preventDefault();
            var afterfive = isAfterFiveMin(driverCodeTime);
            if(!afterfive){
                $('#alert-driver').html(`<p class="text-success m-2">تم ارسال الكود قد يستغرق 5 دقايق</p>`);
                driverCodeTime =  new Date();
                sendCodeToDriver(e);
            }
            else if(afterfive){
                $('#alert-driver').html(`<div class="alert alert-danger p-1 m-1">يتم أعادة ارسال الكود بعد 5 دقائق</div>`);
            }

            $('#sendMessageVerfication').modal('show');
        });
        $("#resend-driver-code").click(function(e){
            var afterfive = isAfterFiveMin(driverCodeTime);
            if(!afterfive){
                $('#alert-driver').html(`<p class="text-success m-2">تم ارسال الكود قد يستغرق 5 دقايق</p>`);
                driverCodeTime =  new Date();
                sendCodeToDriver(e);
            }
            else if(afterfive){
                $('#alert-driver').html(`<p class="text-danger m-2">يتم أعادة ارسال الكود بعد 5 دقائق</p>`);
            }
        });
        $("#resend-user-code").click(function(e){
            var afterfive = isAfterFiveMin(userCodeTime);
            if(!afterfive){
                $('#alert-user').html(`<p class="text-success m-2">تم ارسال الكود قد يستغرق 5 دقايق</p>`);
                userCodeTime =  new Date();
                sendCodeToUser(e);
            }
            else if(afterfive){
                $('#alert-user').html(`<p class="text-danger m-2">يتم أعادة ارسال الكود بعد 5 دقائق</p>`);
            }
        });
        function isAfterFiveMin(d){
            if(d == null){
                return false;
            }
            var dateNowAfter = new Date();
            var min = ((dateNowAfter - d)/60000);
            return min < 1;
        }
      $("#driver_confirm").click(function(e){
            var codeInp = $("#driver_confirm_input").val();
            console.log(codeInp);
            console.log(driverCode);
            if(codeInp == driverCode){
                $(this).text('تم التأكيد');
                $('#alert-driver').html(' ');
                $(this).attr('readonly');
                $(this).removeClass('btn-outline-success');
                $(this).addClass('btn-success');
                $("#driver_confirm_input").addClass('input-style');
                confirmDriverCode = true;
                var afterfive = isAfterFiveMin(userCodeTime);
                if(!afterfive){
                $('#alert-user').html(`<p class="text-success m-2">تم ارسال الكود قد يستغرق 5 دقايق</p>`);
                userCodeTime =  new Date();
                sendCodeToUser(e);
                }
                else if(afterfive){
                    $('#alert-user').html(`<p class="text-danger m-2">يتم أعادة ارسال الكود بعد 5 دقائق</p>`);
                }
            }
            else{
                $('#alert-driver').html(`<div class="alert alert-danger p-1 m-1">الكود المدخل غير صحيح</div>`);
            }
        });
      $("#user_confirm").click(function(e){
            e.preventDefault();
            var codeInp = $("#user_confirm_input").val();
            console.log(codeInp);
            console.log(userCode);
            if(codeInp == userCode){
                $(this).text('تم التأكيد');
                $('#alert-user').html(``);
                $(this).attr('readonly');
                $(this).removeClass('btn-outline-success');
                $(this).addClass('btn-success');
                $("#user_confirm_input").addClass('input-style');
                confirmUserCode = true;
            }
            else{
                $('#alert-driver').html(`<div class="alert alert-danger p-1 m-1">الكود المدخل غير صحيح</div>`);
            }
        });

        $("#save-contract-final").click(function(e){
            e.preventDefault();
            if(confirmDriverCode && confirmUserCode){
                var inp = $("#form-contract").serializeArray();
                console.log(inp);
                $.ajax({
                type: 'post',
                url: '{!!URL::to("driver/contract/adddata")!!}',
                data: inp,
                success: function(data){
                    if(data.success === true){
                        console.log("############---form--#################");
                        driverCode = null;
                        userCode = null;
                        confirmDriverCode = false ;
                        confirmUserCode = false ;

                        window.location.href = '{!!URL::to("driver/show/contracts/valid")!!}';
                    }
                },
                error:function(e){
                    console.log('error');
                    console.log(e);
                }
            });
            }
        });

        function sendCodeToUser(e){
            e.preventDefault();
            var userId = $('#user-id').val();
            var contract_number = $('#contract_number').val();
            $.ajax({
                type: 'post',
                url: '{!!URL::to("driver/user/contract/send/code")!!}',
                data: {
                        "_token": "{{ csrf_token() }}",
                        'id': userId,
                        'contract_number': contract_number,

                    },
                success: function(data){
                    if(data.success === true){
                        console.log("############");
                        userCode = data.code;
                        console.log(data);
                    }else{
                        console.log(data.success);
                    }
                },
                error:function(error){
                    var error_message = $("#alert-danger");

                    error_message.addClass("alert alert-danger m-;")
                    var message = '';
                    $.each(error.responseJSON.errors, function(index, v){
                        switch (index) {
                            case 'contract_number':
                                message += `<p>الرجاء التأكد من رقم العقد</p>`;
                                break;
                            default:
                                message += `<p>حدث خطاء فى ارسال بيانات المستخدم</p>`;
                                break;
                        }
                    });
                    error_message.html(message);
                }
            });
        }

        function sendCodeToDriver(e){
            e.preventDefault();
            var driverId = $('#driver-id').val();
            var plate_number = $('#plate_number').val();
            var contract_number = $('#contract_number').val();
            var start_contract = $('#startDate').val();
            var end_contract = $('#endDate').val();
            $.ajax({
                type: 'post',
                url: '{!!URL::to("driver/contract/send/code")!!}',
                data: {
                        "_token": "{{ csrf_token() }}",
                        'id': driverId,
                        'plate_number': plate_number,
                        'contract_number': contract_number,
                        'start_contract': start_contract,
                        'end_contract': end_contract
                    },
                success: function(data){
                    if(data.success === true){
                        driverCode = data.code;
                        console.log(data);
                    }else{
                        console.log(data.success);
                    }
                },
                error:function(error){
                    var error_message = $("#alert-danger");

                    error_message.addClass("alert alert-danger m-;")
                    var message = '';
                    $.each(error.responseJSON.errors, function(index, v){
                        switch (index) {
                            case 'id':
                                message += `<p>حدث خطاء فى ارسال بيانات السائق</p>`;
                                break;
                            case 'contract_number':
                                message += `<p>الرجاء التأكد من رقم العقد</p>`;
                                break;
                            case 'plate_number':
                                message += `<p>الرجاء التأكد من رقم اللوحة للمركبة</p>`;
                                break;
                            case 'start_contract':
                                message += `<p>الرجاء التأكد من تاريخ بداية العقد</p>`;
                                break;
                            case 'end_contract':
                                message += `<p>الرجاء التأكد من تاريخ نهاية العقد</p>`;
                                break;
                            default:
                                break;
                        }
                    });
                    error_message.html(message);
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {

        if ("geolocation" in navigator){ //check geolocation available

        navigator.geolocation.getCurrentPosition(function(position){
       $("#location").val("   الاحداثيات:  (  "+position.coords.latitude+"  ,  "+position.coords.longitude+" )");
           });
           }else{
            $("#location").val("لم تحدد المكان ");

           }


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
