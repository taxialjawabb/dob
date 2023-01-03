

@extends('index')
@section('title','طباعة تفويض سائق')
@section('content')


<div class="text-center text-danger "  style="margin-top:40px;margin-bottom:10px;margin-right:50px; height:100px;" >
  <button type="button" class="btn btn-primary printThis" id="printButton">طـبـاعـة</button>
</div>
<div class="panel panel-default " id="divPrint" style="padding:30px;border: thin solid black;">

  <table class="table table-responsive table-bordered  border-dark" >
    <thead >
      <tr>
          
              <div class="clearfix">
                  <span style="font-size:18px;"  class="float-start text-primary">مؤسسة الجواب لنقل البري  </span>
                  <span style="font-size:18px;"  class="float-end text-primary">Al Jawab Taxi Service </span>
              </div>
          
              <div class="clearfix">
                  <span style="font-size:15px;"  class="float-start"> الرانوناء -المدينة المنورة</span>
                  <span style="font-size:15px;"  class="float-end">Ar Ranuna-AlMadenah</span>
                    
              </div>
              <div class="clearfix" >
               
                <span style="font-size:12px; padding:5px;" class="float-start">  الجوال  : ٠٥٠٩٠٤٠٩٥٤  </span>
                <span style="font-size:12px; padding:5px;" class="float-end">Phone Number : 0509040954</span>
                  
            </div>
              <div class="clearfix" >
               
                <span style="font-size:12px; padding:5px;" class="float-start">  تليفون  : ٠١٤٨٤٢٢٢٢٩  </span>
                <span style="font-size:12px; padding:5px;" class="float-end">Tel : 0148422229</span>
                  
            </div>
              <div style="border: 1px solid black;height:1px;" ></div>
            
      </tr>
    </thead> 
      <tbody>
               <tr>
              
                  <div class="d-flex align-items-center justify-content-center" style="margin-top:60px;margin-bottom:30px;margin-left:100px;margin-right:100px;">
                  <span style="font-size:18px;font-weight: bold"> (تفويض قيادة)</span>
                  </div> 
                
                   
                    <div class="clearfix">
                  
                          <span style="font-size:16px; padding:5px;" class="float-start">  تاريخ بداية التفويض  :  {{ date('Y-m-d', strtotime($contract->contract_start_datetime))}}  م</span>
                          <span style="font-size:16px; padding:5px;" class="float-end">  تاريخ نهاية التفويض  : {{ date('Y-m-d', strtotime($contract->contract_end_datetime)) }}  م </span>
                    </div> 
                    <div class="clearfix">
                  
                    <span style="font-size:16px; padding:5px;" class="float-start"> نفيدكم نحن مؤسسة الجواب للأجره العامة  بأننا نفوض السيد / </span>
                    <span style="font-size:16px; padding:5px;" class="float-start"> {{$contract->tenant_name_ar}}</span>
                    </div>
                    <div class="clearfix">
                  
                      <span style="font-size:16px; padding:5px;" class="float-start">   الجنسية /   </span>
                      <span style="font-size:16px; padding:5px;" class="float-start"> {{$contract->tenant_nationality}}</span>
                      <span style="font-size:16px; padding:5px;" class="float-start">  رقم الهوية /  </span>
                      <span style="font-size:16px; padding:5px;" class="float-start"> {{$contract->tenant_id_number}}</span>
                      
                      <span style="font-size:16px; padding:5px;" class="float-start">   بقيادة السيارة النوع /  </span>
                      <span style="font-size:16px; padding:5px;" class="float-start"> {{$contract->car_type}}</span>
                      
                      </div>
                    <div class="clearfix">
                  
                      <span style="font-size:16px; padding:5px;" class="float-start">   اللون /   </span>
                      <span style="font-size:16px; padding:5px;" class="float-start"> {{$contract->car_color}}</span>
                      <span style="font-size:16px; padding:5px;" class="float-start">  رقم اللوحة /   </span>
                      <span style="font-size:16px; padding:5px;" class="float-start"> {{$contract->car_plate_number}}</span>
                      
                      <span style="font-size:16px; padding:5px;" class="float-start">   سنة الصنع /  </span>
                      <span style="font-size:16px; padding:5px;" class="float-start"> {{$contract->car_manufacture_year}}</span>
                      
                      <span style="font-size:16px; padding:5px;" class="float-start">    النوع /   </span>
                      <span style="font-size:16px; padding:5px;" class="float-start">{{$contract->car_registerion_type}}</span>
                      
                      <span style="font-size:16px; padding:5px;" class="float-start">بأنه لامانع لدينا  </span>
                      
                      </div>
                      <div class="clearfix">
                  
                        <span style="font-size:16px; padding:5px;" class="float-start">  من قيادة السيارة وهذا تفويض منا بذلك نرجو تسهيل امره</span>
                         
                        </div>

                      <div class="d-flex align-items-center justify-content-center" style="margin-top:60px;margin-bottom:30px;margin-left:100px;margin-right:100px;">
                        <span style="font-size:18px; font-weight: bold">  وتقبلوا تحياتنا ؛؛؛؛؛؛</span>
                        </div>    

              </tr>  

            <tr>

              <div class="clearfix">
                  
                <span style="font-size:16px;font-weight: bold; padding:5px;" class="float-end">الجواب لأجرة العامة والنقل البري</span>
               
                 
                </div>
              <div class="clearfix">
                <span style="font-size:16px;font-weight: bold; padding-left:45px;padding-top:15px;" class="float-end"> ٠٥٠٩٠٤٠٩٥٤</span>
              </div>
              <div class="clearfix">
                <span style="font-size:16px;font-weight: bold; padding-left:45px;padding-top:15px;padding-bottom:60px;" class="float-end">٠٥٠٠٦٣٣٨٥٢</span>  
              </div>
            </tr>

            
              
            
      
      </tbody>
     
    
      
    
  </table></div>            




  

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