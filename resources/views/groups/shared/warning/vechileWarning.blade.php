
@extends('index')
@section('title',' تنبيهات المركبات')
@section('content')
<div>
    <a  href="{{url('my/groups/show')}}" class="btn text-primary "> مجموعاتى الخاصة </a>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary">{{$group->name}} </a>
  
  </div>
<div class="container clearfix">
    <h5 class=" mt-4 float-start">تنبيهات المركبات</h5>
    <div class="float-end mt-3">        
        <a href="{{url('shared/groups/vechile/warning/driving_license_expiration_date/'. $id)}}" class="btn {{$type === 'driving_license_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء رخصة السير</a>
        <a href="{{url('shared/groups/vechile/warning/insurance_card_expiration_date/'. $id)}}" class="btn {{$type === 'insurance_card_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء التأمين</a>
        <a href="{{url('shared/groups/vechile/warning/periodic_examination_expiration_date/'. $id)}}" class="btn {{$type === 'periodic_examination_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء الفحص الدورى</a>
        <a href="{{url('shared/groups/vechile/warning/operating_card_expiry_date/'. $id)}}" class="btn {{$type === 'operating_card_expiry_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء بطاقة التشغيل</a>
    </div>
</div>
<div class="contriner">
    <div id="piechart" style="width: 100%; height: 500px;"></div>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم </th>
                                    <th>النوع</th>
                                    <th>سنة الصنع</th>
                                    <th>رقم اللوحة</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th>الايام المتبقية او المنتهية</th>
                                    <th>اضيفة بواسطة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vechiles as $vechile)
                                <tr>
                                    <td>{{ $vechile->id }}</td>
                                    <td>{{ $vechile->vechile_type }}</td>
                                    <td>{{ $vechile->made_in }}</td>
                                    <td>{{ $vechile->plate_number }}</td>
                                    <td>{{ $vechile->ended_date }}</td>
                                    <td>{{ $vechile->days }}</td>
                                    <td>{{ $vechile->add_date}}</td>
                                    <td>
                                        <a href="{{ url('shared/groups/vechile/detials/'.$vechile->id.'/'.$group->id) }}" class="btn btn-primary m-1">عرض</a>
                            
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
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
                    "sLengthMenu": "عـرض _MENU_ المركبات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المركبات من _START_ إلى _END_ من إجمالي _TOTAL_ من مركبة",
                    "sInfoEmpty": "عرض المركبات من 0 إلى 0 من إجمالي 0 مركبة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المركبات)",
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

<script type="text/javascript" src="{{ asset('assets/js/charts.js') }}"></script>

@if ($type === 'driving_license_expiration_date')
<script>
        var clear = @json($licenseClear ?? 0);
        var remains = @json($licenseRemains);
        var expired = @json($licenseExpired);
        var title  = 'بيانات رخصة السير للمركبات';
        var title1 = "رخصة السير السارية";
        var title2 = "رخصة السير متبقى عليها اقل من شهرين";
        var title3 = "رخصة السير المنتهية"; 
        
</script>
@elseif ($type === 'insurance_card_expiration_date')  
<script>
        var clear = @json($insuranceClear);
        var remains = @json($insuranceRemains);
        var expired = @json($insuranceExpired);   
        var title  = 'بيانات التأمين للمركبات';
        var title1 = "التأمين السارية";
        var title2 = "التأمين متبقى عليها اقل من شهرين";
        var title3 = "التأمين المنتهية"; 
</script> 
@elseif ($type === 'periodic_examination_expiration_date')
<script>
        var clear = @json($examinationClear);
        var remains = @json($examinationRemains);
        var expired = @json($examinationExpired);
        var title = 'بيانات الفحص الدورى للمركبات';
        var title1 = "الفحص الدورى السارية";
        var title2 = "الفحص الدورى متبقى عليها اقل من شهرين";
        var title3 = "الفحص الدورى المنتهية";
</script>
@elseif ($type === 'operating_card_expiry_date')
<script>
        var clear = @json($operatingClear);
        var remains = @json($operatingRemains);
        var expired = @json($operatingExpired);
        var title = 'بيانات بطاقة التشغيل للمركبات';
        var title1 = "بطاقة التشغيل السارية";
        var title2 = "بطاقة التشغيل متبقى عليها اقل من شهرين";
        var title3 = "بطاقة التشغيل المنتهية";
</script>
@endif

<script type="text/javascript">
$(document).ready(function(){
google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      [title1, clear],
      [title2 , remains],
      [title3 ,  expired]
    ]);

    var options = {
      title: title,
      legend : {
      display : true,
      position : "right",
            labels: {
                fontSize:16,
                fontColor:'black'
            }
          }
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
    
  }
});
</script>

@endsection