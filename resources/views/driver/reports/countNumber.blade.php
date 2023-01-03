@extends('index')
@section('title', 'تقرير')
@section('content')
    <div class="container clearfix">
        <h5 class=" mt-4 float-start">تقارير عن اعداد العملاء والسائقين</h5>
    </div>
    <div id="chart_div" style="width: 1200px; height: 800px;"></div>
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المدينة</th>
                        <th>عدد العملاء</th>
                        <th>عدد السائقين</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($data as $index => $d)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $d->address }}</td>
                            <td>{{ $d->rider_count }}</td>
                            <td>{{ $d->driver_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

  function drawMultSeries() {
    var data = new google.visualization.DataTable();
      data.addColumn('string', 'اعداد المستخدمين والسائقين');
      data.addColumn('number', 'السائقين');
      data.addColumn('number', 'المستخدمين');
    @json($data).forEach((element) => {
        data.addRow([element.address,Number(element.driver_count),Number(element.rider_count)]);
     });



     var options = {
        title: 'تقرير اعداد السائقين ,والعملاء لكل مدينة',
        hAxis: {
          title: 'المدينة',

        },
        vAxis: {
          title: '  100 من 0 الي '
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));
      chart.draw(data, options);



  }
</script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "order": {{ 3, 'asc' }},
                // 'lengthMenu' : [[10,25,50,100, -1],[10,25,50,100, 'All Rider']],
                dom: 'Blfrtip',
                buttons: [
                    // { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                    // {
                    //     extend: 'excel',
                    //     className: 'btn btn-success text-light',
                    //     text: 'Excel',
                    //     charset: "utf-8"
                    // },
                    // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                    // { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ السائقين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض السائقين من _START_ إلى _END_ من إجمالي _TOTAL_ من سائق",
                    "sInfoEmpty": "عرض السائقين من 0 إلى 0 من إجمالي 0 سائق",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من السائقين)",
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
