
@extends('index')
@section('title','السائقين')
@section('content')
<div>
    <a  href="{{url('my/groups/show')}}" class="btn text-primary "> مجموعاتى الخاصة </a>
    <a href="{{ route('shared.groups.details', ['group' => $group]) }}" class="btn text-primary">{{$group->name}} </a>
  
  </div>
<div class="container clearfix">
    <h5 class=" mt-4 float-start"> تنبيهات السائقين</h5>
    <div class="float-end mt-3">
        <a href="{{url('shared/groups/driver/warning/id_expiration_date/'.$id)}}" class="btn {{$type === 'id_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء الهوية</a>
        <a href="{{url('shared/groups/driver/warning/license_expiration_date/'.$id)}}" class="btn {{$type === 'license_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء الرخصة</a>
        <a href="{{url('shared/groups/driver/warning/contract_end_date/'.$id)}}" class="btn {{$type === 'contract_end_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء عقد العمل</a>
        <a href="{{url('shared/groups/driver/warning/final_clearance_date/'.$id)}}" class="btn {{$type === 'final_clearance_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء المخالصة النهائية</a>
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
                                    <th>رقم</th>
                                    <th>السائق</th>
                                    <th>الجوال</th>
                                    <th> تاريخ الانتهاء</th>
                                    <th>الايام المتبقية او المنتهية</th>
                                    <th>تاريخ الأضافة</th>
                                    <th></th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->id }}</td>
                                    <td>{{ $driver->name }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>{{ $driver->ended_date }}</td>
                                    <td>{{ $driver->days }}</td>
                                    <td>{{ $driver->add_date }}</td>
                                    <td>
                                   
                                        <a href="{{ url('shared/groups/driver/detials/'.$driver->id .'/'. $group->id) }}" class="btn btn-primary m-1">عرض</a>
                      
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
                "order": {{ 4, "asc" }},
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

<script type="text/javascript" src="{{ asset('assets/js/charts.js') }}"></script>

@if ($type === 'id_expiration_date')
<script>
        var clear = @json($idClear ?? 0);
        var remains = @json($idRemains);
        var expired = @json($idExpired);
        var title = 'بيانات الهوية للسائقين';
        var title1 = "الهويات السارية";
        var title2 = "الهويات متبقى عليها اقل من شهرين";
        var title3 = "الهويات المنتهية";
        
</script>
@elseif ($type === 'license_expiration_date')  
<script>
        var clear = @json($licenseClear);
        var remains = @json($licenseRemains);
        var expired = @json($licenseExpired);   
        var title = 'بيانات الرخصة للسائقين';
        var title1 = "الرخصة السارية";
        var title2 = "الرخص متبقى عليها اقل من شهرين";
        var title3 = "الرخصة المنتهية"; 
</script> 
@elseif ($type === 'contract_end_date')
<script>
        var clear = @json($contractClear);
        var remains = @json($contractRemains);
        var expired = @json($contractExpired);
        var title = 'بيانات العقود للسائقين';
        var title1 = "العقود السارية";
        var title2 = "العقود متبقى عليها اقل من شهرين";
        var title3 = "العقود المنتهية";
</script>
@elseif ($type === 'final_clearance_date')
<script>
        var clear = @json($clearanceClear);
        var remains = @json($clearanceRemains);
        var expired = @json($clearanceExpired);
        var title = 'بيانات المخالصةالنهائية للسائقين';
        var title1 = "المخالصات السارية";
        var title2 = "المخالصات متبقى عليها اقل من شهرين";
        var title3 = "المخالصات المنتهية";
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