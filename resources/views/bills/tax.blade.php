@extends('index')
@section('title', 'ضريبة القيمة المضافة')
@section('content')
@if ($errors->any())
<div class="alert alert-danger m-3 mt-4">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="container mt-4">
    <div class="clearfix">
        <div class="float-start">
            <h5 class="h5 text-dark mt-2">ضريبة القيمة المضافة للمنشأة  </h5>
            <p>
                اجمالى الضربية المستحقة لهذا العام
            </p>
            <div class="bg-warning m-2 text-center p-2 ">
                {{ $firstPeriodic + $secondPeriodic + $thirdPeriodic + $fourthPeriodic }}
            </div>
        </div>


        <div class="float-end mt-3">
            <form method="GET" action="{{ route('tax.show') }}" id='form'>

                <div class="clearfix">
                    <div class="float-start">

                        <label for="date" class="form-label">السنة</label>
                        <input type="NUMBER" style="text-direction:rtl" value="" name="year" class="form-control"
                            id="date" min="2020" max="2050" required>
                    </div>
                    <div class="float-start mt-2 ms-3">
                        <button type="submit" class="btn btn-primary mt-4 ">بحث</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="panel panel-default mt-4">

    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>سنة</th>
                    <th>الفترة</th>
                    <th>بداية الفترة</th>
                    <th>نهاية الفترة</th>
                    <th>المبلغ المستحق</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
                <tr>
                    <form action="{{ route('company.show.tax.spend') }}" method="post">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">
                        <td>1</td>
                        <td>{{ $year }}</td>
                        <td>الفترة الإولى</td>
                        <td>
                            {{ $year }}-1-1
                            <input type="hidden" name="start_date" value="{{ $year }}-1-1">
                        </td>
                        <td>
                            {{ $year }}-3-31
                            <input type="hidden" name="end_date" value="{{ $year }}-3-31">
                        </td>
                        <td>
                            {{ $firstPeriodic }}
                            <input type="hidden" name="tax" value="{{ $firstPeriodic }}">
                            <input type="hidden" name="periodic" value="first">
                        </td>
                        <td>
                            @if(!isset($groupTax['first']) && $firstPeriodic > 0 &&
                            \Carbon\Carbon::parse($year."-3-31")->format('y-m-d') < \Carbon\Carbon::now()->
                                format('y-m-d'))
                                <button type="submit" class="btn btn-outline-primary">صرف</button>
                                @elseif(!isset($groupTax['first']) && $firstPeriodic > 0 &&
                                \Carbon\Carbon::parse($year."-12-31")->format('y-m-d') >
                                \Carbon\Carbon::now()->format('y-m-d'))
                                <a href="#" class="btn btn-outline-primary spend_tax" data="{{ $year }}-3-31">لم يحين
                                    ميعاد الصرف</a>
                                @endif
                        </td>
                    </form>
                </tr>
                <tr>
                    <form action="{{ route('company.show.tax.spend') }}" method="post">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">
                        <td>2</td>
                        <td>{{ $year }}</td>
                        <td>الفترة الثانية</td>
                        <td>
                            {{ $year }}-4-1
                            <input type="hidden" name="start_date" value="{{ $year }}-4-1">
                        </td>
                        <td>
                            {{ $year }}-6-30
                            <input type="hidden" name="end_date" value="{{ $year }}-6-30">
                        </td>
                        <td>
                            {{ $secondPeriodic }}
                            <input type="hidden" name="tax" value="{{ $secondPeriodic }}">
                            <input type="hidden" name="periodic" value="second">
                        </td>
                        <td>
                            @if(!isset($groupTax['second']) && $secondPeriodic > 0 &&
                            \Carbon\Carbon::parse($year."-6-30")->format('y-m-d') < \Carbon\Carbon::now()->
                                format('y-m-d'))
                                <button type="submit" class="btn btn-outline-primary">صرف</button>
                                @elseif(!isset($groupTax['second']) && $secondPeriodic > 0 &&
                                \Carbon\Carbon::parse($year."-12-31")->format('y-m-d') >
                                \Carbon\Carbon::now()->format('y-m-d'))
                                <a href="#" class="btn btn-outline-primary spend_tax" data="{{ $year }}-6-30">لم يحين
                                    ميعاد الصرف</a>
                                @endif
                        </td>
                    </form>
                </tr>
                <tr>
                    <form action="{{ route('company.show.tax.spend') }}" method="post">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">
                        <td>3</td>
                        <td>{{ $year }}</td>
                        <td>الفترة الثالثة</td>
                        <td>
                            {{ $year }}-7-1
                            <input type="hidden" name="start_date" value="{{ $year }}-7-1">
                        </td>
                        <td>
                            {{ $year }}-9-30
                            <input type="hidden" name="end_date" value="{{ $year }}-9-30">
                        </td>
                        <td>
                            {{ $thirdPeriodic }}
                            <input type="hidden" name="tax" value="{{ $thirdPeriodic }}">
                            <input type="hidden" name="periodic" value="third">
                        </td>
                        <td>
                            @if(!isset($groupTax['third']) && $thirdPeriodic > 0 &&
                            \Carbon\Carbon::parse($year."-9-30")->format('y-m-d') < \Carbon\Carbon::now()->
                                format('y-m-d'))
                                <button type="submit" class="btn btn-outline-primary">صرف</button>
                                @elseif(!isset($groupTax['third']) && $thirdPeriodic > 0 &&
                                \Carbon\Carbon::parse($year."-12-31")->format('y-m-d') >
                                \Carbon\Carbon::now()->format('y-m-d'))
                                <a href="#" class="btn btn-outline-primary spend_tax" data="{{ $year }}-9-30">لم يحين
                                    ميعاد الصرف</a>
                                @endif
                        </td>
                    </form>
                </tr>
                <tr>
                    <form action="{{ route('company.show.tax.spend') }}" method="post">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">
                        <td>4</td>
                        <td>{{ $year }}</td>
                        <td>الفترة الرابعة</td>
                        <td>
                            {{ $year }}-10-1
                            <input type="hidden" name="start_date" value="{{ $year }}-10-1">
                        </td>
                        <td>
                            {{ $year }}-12-31
                            <input type="hidden" name="end_date" value="{{ $year }}-12-31">
                        </td>
                        <td>
                            {{ $fourthPeriodic }}
                            <input type="hidden" name="tax" value="{{ $fourthPeriodic }}">
                            <input type="hidden" name="periodic" value="fourth">
                        </td>
                        <td>
                            @if(!isset($groupTax['fourth']) && $fourthPeriodic > 0 &&
                            \Carbon\Carbon::parse($year."-12-31")->format('y-m-d') < \Carbon\Carbon::now()->
                                format('y-m-d'))
                                <button type="submit" class="btn btn-outline-primary">صرف</button>
                                @elseif(!isset($groupTax['fourth']) && $fourthPeriodic > 0 &&
                                \Carbon\Carbon::parse($year."-12-31")->format('y-m-d') >
                                \Carbon\Carbon::now()->format('y-m-d'))
                                <a href="#" class="btn btn-outline-primary spend_tax" data="{{ $year }}-12-31">لم يحين
                                    ميعاد الصرف</a>
                                @endif
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
            $(".spend_tax").on('click', function(e){
                e.preventDefault();
                alert("لم يحين ميعاد صرف  هذا الربع من الضرائب حتى تاريخ : "+$(this).attr('data'));
            });


            $('#datatable').DataTable({
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
                    "sLengthMenu": "عـرض _MENU_ الفترات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الفترات من _START_ إلى _END_ من إجمالي _TOTAL_ من فترة",
                    "sInfoEmpty": "عرض الفترات من 0 إلى 0 من إجمالي 0 فترة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الفترات)",
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
