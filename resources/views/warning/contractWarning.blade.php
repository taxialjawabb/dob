@extends('index')
@section('title','تنبيهات العقود')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">تنبيهات عقود تأجير </h5>
</div>
<div class="clearfix "></div>
<div class="contriner">
    <div id="piechart" style="width: 100%; height: 500px;"></div>
</div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم العقد</th>
                    <th>رقم اللوحة</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الايام المتبقية او المنتهية</th>
                    {{-- <th>عرض</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($data as $contract)
                <tr class="update{{ $contract->id }}">
                    <td class="user-id">{{ $contract->contract_number }}</td>
                    <td>{{ $contract->car_plate_number }}</td>
                    <td class="date">{{ $contract->expire_date }}</td>
                    <td>{{ $contract->days }}</td>
                    {{-- <td>
                        @if(Auth::user()->isAbleTo('user_show'))
                        <button id="update{{ $contract->id }}" class="m-1 btn btn-primary update">تعديل التاريخ</button>
                        @endif
                    </td> --}}
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
                    "sLengthMenu": "عـرض _MENU_ المستخدمين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المستخدمين من _START_ إلى _END_ من إجمالي _TOTAL_ من مستخدم",
                    "sInfoEmpty": "عرض المستخدمين من 0 إلى 0 من إجمالي 0 مستخدم",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المستخدمين)",
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

<script>
        var contractActive = @json($contractActive);
        var contractCloseToExpired = @json($contractCloseToExpired);
        var contractNotEnded = @json($contractNotEnded);
        var contractExpired = @json($contractExpired);
        var title = 'بيانات العقود التأجير';
        var title1 = "العقود السارية";
        var title2 = "العقود متبقى عليها اقل من تلاث ايام";
        var title3 = "العقود منتهي ولو يتم تجديدها";
        var title4 = "العقود المنتهية";
</script>


<script type="text/javascript">
    $(document).ready(function(){
google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      [title1, contractActive],
      [title2 , contractCloseToExpired],
      [title3 ,  contractNotEnded],
      [title4 ,  contractExpired]
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
