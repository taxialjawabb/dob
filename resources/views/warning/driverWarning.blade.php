@extends('index')
@section('title','السائقين')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start"> تنبيهات السائقين على {{ $typeName }}</h5>
    <div class="float-end mt-3">
        <a href="{{url('warning/driver/id_expiration_date')}}"
            class="btn {{$type === 'id_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0">انتهاء الهوية</a>
        <a href="{{url('warning/driver/license_expiration_date')}}"
            class="btn {{$type === 'license_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0">انتهاء
            الرخصة</a>
        <a href="{{url('warning/driver/contract_end_date')}}"
            class="btn {{$type === 'contract_end_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0">انتهاء عقد
            العمل</a>
        <a href="{{url('warning/driver/final_clearance_date')}}"
            class="btn {{$type === 'final_clearance_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0">انتهاء المخالصة
            النهائية</a>
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
                    <th>تاريخ الانتهاء</th>
                    <th>الايام المتبقية او المنتهية</th>
                    <th>تاريخ الأضافة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                <tr class="update{{ $driver->id }}">
                    <td class="driver-id">{{ $driver->id }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->phone }}</td>
                    <td class="date">{{ \Carbon\Carbon::parse($driver->ended_date)->format('d-m-Y') }}</td>
                    <td>{{ $driver->days }}</td>
                    <td>{{ $driver->add_date }}</td>
                    <td>

                        @if(Auth::user()->isAbleTo('driver_data_show'))
                        <button id="update{{ $driver->id }}" class="m-1 btn btn-primary update">تعديل التاريخ</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="update_date_div" tabindex="-1" role="dialog" aria-labelledby="update_date_divLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update_date_divLabel">تعديل {{ $typeName }} </h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('warning/driver/update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="driver_id" id="driver_id">
                    <input type="hidden" name="warning_type" value="{{ $type }}">
                    <div class="row">
                        <div class="m-2 ">
                            <div style="position: relative">
                                <label for="update_date" class="form-label m-1">أدخال تاريخ {{$typeName}}</label>

                                <input id="update_date_inp" type="text" class="form-control input-date m-1"
                                   value="{{ old('update_date') }}">
                                <input type='hidden' name="update_date" class="form-control update_date_inp"
                                    required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success " id="update_date">
                            حفظ التعديل
                        </button>
                        <a class="btn btn-secondary close-modal" data-dismiss="modal">إلغاء</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var listItem = $(".update");
        for (var i = 0; i < listItem.length; i++) {
            listItem[i].addEventListener('click', function(e) {
                var id = $("." + e.target.id + " .driver-id").text();
                var dateUpdated = $("." + e.target.id + " .date").text();
                $("#driver_id").val(id);
                $(".form-control").val(dateUpdated);
                $("#update_date_div").modal('show');

            });
        }

        $(".input-date").hijriDatePicker({
            //hijri:true
        });

        $(".input-date").on('dp.change', function (arg) {
            let date = arg.date;
            let className = $(this).attr('id');
            $('.'+className).val(date.format("YYYY/M/D"));

            // $("#selected-date").html(date.format("YYYY/M/D") + " Hijri:" + date.format("iYYYY/iM/iD"));
        });
    });

</script>
<script>
    $(document).ready(function() {



        $('#datatable').DataTable({
            "order":[
               [
                    4
                    , "asc"
                ]
            ],
            // dom: 'Blfrtip',
            // buttons: [
            //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
            //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
            //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
            //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
            //         ],
            language: {
                "sProcessing": "جاري التحميل..."
                , "sLengthMenu": "عـرض _MENU_ سائقين"
                , "sZeroRecords": "لم يتم العثور على نتائج"
                , "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول"
                , "sInfo": "عرض سائقين من _START_ إلى _END_ من إجمالي _TOTAL_ من سائق"
                , "sInfoEmpty": "عرض سائقين من 0 إلى 0 من إجمالي 0 سائق"
                , "sInfoFiltered": "(تصفية إجمالي _MAX_ من سائقين)"
                , "sInfoPostFix": ""
                , "sSearch": "بـحــث:"
                , "sUrl": ""
                , "sInfoThousands": ","
                , "sLoadingRecords": "التحميل..."
                , "oPaginate": {
                    "sFirst": "الأول"
                    , "sLast": "الأخير"
                    , "sNext": "التالى"
                    , "sPrevious": "السابق"
                }
                , "oAria": {
                    "sSortAscending": ": التفعيل لفرز العمود بترتيب تصاعدي"
                    , "sSortDescending": ": التفعيل لفرز العمود بترتيب تنازلي"
                }
            }
        });

        $('#datatable_length').addClass('mb-3');
    });

</script>

<script type="text/javascript" src="{{ asset('assets/js/charts.js') }}"></script>

@if ($type === 'id_expiration_date')
<script>
    var clear = @json($idClear);
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
    $(document).ready(function() {
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day']
                , [title1, clear]
                , [title2, remains]
                , [title3, expired]
            ]);

            var options = {
                title: title
                , legend: {
                    display: true
                    , position: "right"
                    , labels: {
                        fontSize: 16
                        , fontColor: 'black'
                    }
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);

        }
    });

</script>
@endsection
