
@extends('index')
@section('title','طباعة تفويض سائق')
@section('content')


<div class="text-center text-danger "  style="margin-top:40px;margin-bottom:10px;margin-right:50px; height:100px;" >
  <button type="button" class="btn btn-primary printThis" id="printButton">طـبـاعـة</button>
</div>
<div class="panel panel-default border-print" id="divPrint" style="padding:30px; border:2px solid black;">

  <table class="table table-responsive table-bordered  border-dark" >
    <thead >
      <tr>

              <div class="clearfix">
                  <span style="font-size:20px;"  class="float-start text-primary">مؤسسة الجواب لنقل البري  </span>
                  <span style="font-size:18px;"  class="float-end text-primary">Al Jawab Taxi Service </span>
              </div>

              <div class="clearfix">
                  <span style="font-size:17px;"  class="float-start"> الرانوناء -المدينة المنورة</span>
                  <span style="font-size:15px;"  class="float-end">Ar Ranuna-AlMadenah</span>

              </div>
              <div class="clearfix" >

                <span style="font-size:15px; padding:5px;" class="float-start">  الجوال  : ٠٥٠٩٠٤٠٩٥٤  </span>
                <span style="font-size:12px; padding:5px;" class="float-end">Phone Number : 0509040954</span>

            </div>
              <div class="clearfix" >

                <span style="font-size:14px; padding:5px;" class="float-start">  تليفون  : ٠١٤٨٤٢٢٢٢٩  </span>
                <span style="font-size:12px; padding:5px;" class="float-end">Tel : 0148422229</span>

            </div>
              <div style="border: 1px solid black;height:1px;" ></div>

      </tr>
    </thead>
      <tbody>
               <tr>

                  <div class="d-flex align-items-center justify-content-center" style="margin-top:50px;margin-bottom:20px;margin-left:100px;margin-right:100px;">
                    <span style="font-size:20px;font-weight: bold">مخالصة مالية</span>
                  </div>


                    <div class="clearfix">
                      <span class="float-start" style="font-size:16px; line-height: 25px">

                        أقر انا الموقع أدناه بأنني قد استلمت جميع مستحقاتي المالية والإدارية الناتجة عن عقد عملي وحتى إنهاء فتره خدمتي بناء علي طلبي سواء كان مصدرها الرواتب الأساسية أو الاضافية أو البدلات النقدية أو العينية أو ساعات العمل الإضافية أو الإجازات السنوية أو مدة الإنذار أو التعويض أو أي مصدر اخر عادي أو استثنائي وتبعا لذلك فأنني أبرئ ذمة صاحب العمل ابراء شامل عام لا رجوع منه مطلقا لأي حق أو مطالبة حالية أو مستقبلية ومن أي نوع أو شكل كان الى تاريخ

                        {{date('d-m-Y')}}
                        م
                      </span>

                    </div>
              </tr>

              <tr>
                <div  style="margin-top:30px;margin-bottom:10px;margin-right:50px;">

                  <span style="font-size:17px;font-weight: bold;">بيانات المقر بما فيه</span>
                    <div class="clearfix">
                      <span style="font-size:16px; padding:5px;" class="float-start">الاسم : </span>
                      <span style="font-size:15px;font-weight: bold; padding:5px;" class="float-start">{{$driver->name}}</span>

                  </div>
                  <div class="clearfix">
                    <span style="font-size:16px; padding:5px;" class="float-start">رقم إالاقامة : </span>
                    <span style="font-size:15px; padding:5px;" class="float-start">{{$driver->ssd}}</span>

                </div>
                <div class="clearfix">
                  <span style="font-size:16px; padding:5px;" class="float-start">التوقيع : </span>
                  <span style="font-size:15px; padding:5px;" class="float-start"></span>

              </div>
              <div class="clearfix">
                <span style="font-size:14px; padding:5px;" class="float-start">البصمة : </span>
                <span style="font-size:14px; padding:5px;" class="float-start"></span>

            </div>
            </div>

              </tr>

              <tr>
                <div  style="margin-top:30px;margin-bottom:20px;margin-right:50px;">

                  <span style="font-size:17px;font-weight: bold;">اسم المسؤول الإداري عن صحه التوقيع</span>
                    <div class="clearfix">
                      <span style="font-size:16px; padding:5px;" class="float-start">الاسم : </span>
                      <span style="font-size:15px; padding:5px;" class="float-start">{{$user->name}}</span>

                  </div>
                  <div class="clearfix">
                    <span style="font-size:16px; padding:5px;" class="float-start">رقم إالاقامة : </span>
                    <span style="font-size:15px; padding:5px;" class="float-start">{{$user->ssd}}</span>

                </div>
                <div class="clearfix">
                  <span style="font-size:16px; padding:5px;" class="float-start">التوقيع : </span>
                  <span style="font-size:14px; padding:5px;" class="float-start"></span>

              </div>

            </div>

              </tr>

      </tbody>




  </table></div>




<div class="m-5"></div>

@endsection

@section('scripts')

<style>
  #exampleModal .table>:not(caption)>*>* {
      padding: 5px !important;
  }

  #exampleModal .table>:not(caption)>*>* p {
      padding: 0px !important;
      margin: 5px !important;
  }

  @media print {
      #divPrint {
          padding: 5px;
          margin: 5px;
      }

      .modal-footer {
          display: none;
      }

      #divPrint * {
          direction: rtl;
      }

  }
</style>
<script src="{{ asset('assets/js/jQuery.print.min.js') }}"></script>
<script>
    $(function() {

                $("#printButton").on('click', function() { $.print("#divPrint");});
            });




</script>
<script src="{{ asset('assets/js/addimg.js') }}" ></script>

@endsection
