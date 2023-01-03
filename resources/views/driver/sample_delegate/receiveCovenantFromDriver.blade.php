@extends('index')
@section('title','طباعة استلام عهده للسائق')
@section('content')


<div class="text-center text-danger " style="margin-top:40px;margin-bottom:10px;margin-right:50px; height:100px;">
    <button type="button" class="btn btn-primary printThis" id="printButton">طـبـاعـة</button>
</div>
<div class="panel panel-default " id="divPrint" style="padding:30px;border: thin solid black;">

    <table class="table table-responsive table-bordered  border-dark">
        <thead>
            <tr>

                <div class="clearfix">
                    <span style="font-size:16px;" class="float-start text-primary">مؤسسة الجواب لنقل البري </span>
                    <span style="font-size:16px;" class="float-end text-primary">Al Jawab Taxi Service </span>
                </div>

                <div class="clearfix">
                    <span style="font-size:15px;" class="float-start"> الرانوناء -المدينة المنورة</span>
                    <span style="font-size:15px;" class="float-end">Ar Ranuna-AlMadenah</span>

                </div>
            </tr>
        </thead>
        <tbody>
            <tr class="border">

            </tr>
            <tr>

                <div class="d-flex align-items-center justify-content-center"
                    style="margin-top:20px;margin-bottom:10px;margin-left:100px;margin-right:100px;">
                    <span style="font-size:16px;font-weight: bold"> استلام عهدة من سائق</span>
                </div>



                <div class="clearfix">
                    <p style="font-size:16px; padding:5px; line-height: 35px">
                        أقر انا الموظف: <span style="min-width: 250px; display:inline-block">{{ Auth::user()->name }}	&nbsp;&nbsp;</span>
                        بصفتي: {{Auth::guard('admin') -> user()->roles[0]->display_name}} &nbsp;&nbsp;
                        بإستلام جهاز من نوع: geidea برقم تسلسلى: {{ $covenant->serial_number }}&nbsp;&nbsp;&nbsp;
                        من السائق: <span style="min-width: 250px; display:inline-block">{{ $driver->name }} &nbsp;&nbsp;&nbsp;</span>
                        الجنسية: {{ $driver->nationality }} &nbsp;&nbsp;&nbsp;

                            والذى يعمل بالمركبة من نوع: <span style="min-width: 100px; display:inline-block">{{ $vechile->type }} &nbsp;&nbsp;&nbsp;</span>
                            موديل: <span style="min-width: 100px; display:inline-block">{{ $vechile->made_in }}</span>
                            رقم اللوحة: {{ $vechile->plate_number }}&nbsp;&nbsp;&nbsp;

                        وذلك بسبب توقف شريحة البيانات لعدم استخدام الجهاز من قبل السائق لمدة تجاوزت الـ ٣٠ يوم وعلى ذلك
                        أقر وأوقع،،،،،

                    </p>
                </div>
            </tr>

            <tr>
                <div style="margin-top:30px;margin-bottom:10px;margin-right:50px;">

                    <span style="font-size:17px;font-weight: bold;">المقر بما فيه</span>
                    <div class="clearfix">
                        <span style="font-size:16px; padding:5px;" class="float-start">الاسم : </span>
                        <span style="font-size:15px;font-weight: bold; padding:5px;"
                            class="float-start">{{$driver->name}}</span>

                    </div>
                    <div class="clearfix">
                        <span style="font-size:16px; padding:5px;" class="float-start">الصفة : </span>
                        <span style="font-size:15px; padding:5px;" class="float-start">{{Auth::guard('admin') -> user()->roles[0]->display_name}}</span>

                    </div>
                    <div class="clearfix">
                        <span style="font-size:16px; padding:5px;" class="float-start">التوقيع : </span>
                        <span style="font-size:15px; padding:5px;" class="float-start"></span>

                    </div>

                </div>

            </tr>

            <tr>
                <div style="margin-top:30px;margin-bottom:20px;margin-right:50px;">

                    <span style="font-size:17px;font-weight: bold;">المقر بما فيه</span>
                    <div class="clearfix">
                        <span style="font-size:16px; padding:5px;" class="float-start">اسم السائق : </span>
                        <span style="font-size:15px; padding:5px;" class="float-start">{{$driver->name}}</span>

                    </div>
                    <div class="clearfix">
                        <span style="font-size:16px; padding:5px;" class="float-start">الصفة : </span>
                        <span style="font-size:15px; padding:5px;" class="float-start">سائق</span>

                    </div>
                    <div class="clearfix">
                        <span style="font-size:16px; padding:5px;" class="float-start">التوقيع : </span>
                        <span style="font-size:14px; padding:5px;" class="float-start"></span>

                    </div>
                    <div class="clearfix">
                        <span style="font-size:14px; padding:5px;" class="float-start">البصمة : </span>
                        <span style="font-size:14px; padding:5px;" class="float-start"></span>

                    </div>

                </div>

            </tr>
            <tr>
                <div class="row">
                    <div class="col">
                        الرقم: .......................................
                    </div>
                    <div class="col">
                        المشفوعات: ...................................
                    </div>
                    <div class="col">
                        التاريخ: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;٢٠م
                    </div>
                </div>
                <div class="text-center">
                    <span>هاتف:&nbsp;&nbsp; ٠١٤٨٤٢٢٢٢٩</span>-
                    <span>جوال:&nbsp;&nbsp; ٠٥٠٩٠٤٠٩٥٤</span>
                </div>
            </tr>





        </tbody>




    </table>
</div>






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
<script src="{{ asset('assets/js/addimg.js') }}"></script>

@endsection
