

@extends('index')
@section('title','أضافة سند')
@section('content')
<div class="container-fluid mt-1 element-center" id="printable">
    <p  class="mb-3 pt-1 element-center  text-center" style="color: black; font-size: 30px; font-weight:bold">شركة الجواب للنقل البري </p>
    <p  class="mb-3 pt-1 text-center "  style="color: black; font-size: 20px;">فاتورة رقم * {{$boxNathiraat->id}} *  </p>
    <table class="table table-bordered element-center" >
    <thead>
      <tr>
        <th >
        <p class="m-1"  style="color: black; font-size: 20px;">الـوصـف</p>
        </th>
        <th colspan="3">
            <p  style="color: black; font-size: 21px;">
            {{$boxNathiraat->descrpition}}
            </p>
        </th>
        
      </tr>
    </thead>
    <tbody>
        <tr>
            <td >
                <p class="m-1"  style="color: black; font-size: 20px;">التاريخ</p>
            </td>
            <td  colspan="3"  style="color: black; font-size: 20px;">
                {{$boxNathiraat->boxNathiraat_date}}
            </td>
        </tr>
      <tr>
        <td>
        <p class="m-1"  style="color: black; font-size: 20px;">نـوع السـند</p>

        </td>
        <td colspan="3"  style="color: black; font-size: 20px;">
        @switch($boxNathiraat->bond_type)
            @case('spend')
                صــرف
                @break
            @case('take')
                قـبــض
                @break
            @default
        @endswitch
        </td>
      </tr>
      <tr>
      <td>
        <p  class="m-1"  style="color: black; font-size: 20px;">طريقة الدفع</p>
        </td>
        <td colspan="3"  style="color: black; font-size: 20px;"> 
            @switch($boxNathiraat->payment_type)
                @case('cash')
                    كــاش
                    @break
                @case('bank transfer')
                    تحويل بنكى
                    @break
                @case('internal transfer')
                    تحويل داخلى
                    @break
                @case('selling points')
                    نقاط بيع
                    @break
                @case('electronic payment')
                    دفع إلكترونى
                    @break
                @default

            @endswitch

        </td>
      </tr>
      <tr>
        <td>
        <p class="m-1"  style="color: black; font-size: 20px;">المبلغ</p>

        </td>
        <td  style="color: black; font-size: 20px;">
            {{$boxNathiraat->money}}
        </td>
        <td  style="color: black; font-size: 20px;">
        <p  class="m-1"  style="color: black; font-size: 20px;">الضرائب%</p>
        </td>
        <td  style="color: black; font-size: 20px;"> {{$boxNathiraat->tax}} %</td>
      </tr>
      <tr>
        <td>
        <p  style="color: black; font-size: 20px;"> المبلغ الكلى</p>
        </td>
        <td  colspan="3">
            <p  style="color: black; font-size: 22px;">
                {{$boxNathiraat->total_money}} ريال سعودى
            </p>
        </td>
      </tr>
      <tr>
        <td>
        <p  style="color: black; font-size: 20px;"> اسم المحصل</p>
        </td>
        <td  colspan="3">
            <p  style="color: black; font-size: 22px;">
                {{$boxNathiraat->admin_name}}
            </p>
        </td>
      </tr>
      <tr>
        <td  colspan="4" class="text-center">
            <p  style="color: black; font-size: 24px;">
                العنوان: المدينة المنورة- حي السيح
            </p>
            <p  style="color: black; font-size: 24px;">
                الهاتف: 0509040954
            </p>
        </td>
      </tr>
    </tbody>
  </table>    
</div>  
<button id="print" class="btn btn-primary btn-submit ms-4 no-print">طـبـاعـة الـفـاتـورة </button>
<!-- <a href="#" class="btn btn-danger ms-1 no-print">إلــغــاء</a> -->

</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
    
        $("*").css('direction','rtl');
        $("#print").on('click', function(){
            window.print();
        });

    });
</script>
@endsection 