
@extends('index')
@section('title','تنبيهات المستخدمين')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">تنبيهات المستخدمين</h5>
</div>
<div class="clearfix "></div>
<div class="container">
  <div id="piechart" style="width: 100%; height: 500px;"></div>
</div>



@endsection

@section('scripts')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
   $(document).ready(function(){
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        let clear = @json($idClear);
        let remains = @json($idRemains);
        let expired = @json($idExpired);

        console.log(clear);
        console.log(remains);
        console.log(expired);
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ["الهويات السارية", clear],
          ["الهويات متبقى عليها اقل من شهرين" , remains],
          ["الهويات المنتهية" ,  expired]
        ]);

        var options = {
          title: 'بيانات الهوية للسائقين',
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