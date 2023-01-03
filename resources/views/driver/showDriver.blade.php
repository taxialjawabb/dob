@extends('index')
@section('title', 'السائقين')
@section('content')
    <div class="container clearfix">
        <h5 class=" mt-4 float-start">{{ $title }}</h5>
        <div class="float-end mt-3">
            {{-- <a href="{{url('driver/show')}}"
            class="btn {{$title == 'عرض بيانات السائقين' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0">جميع
            السائقين</a> --}}

            @if(Auth::user()->isAbleTo('driver_data'))
            <div class="dropdown float-start ms-1 ">
                @if(Auth::user()->isAbleTo(['driver_show_active|driver_show_watting|driver_show_blocked|recently_driver']))

                <button class="btn btn-primary dropdown-toggle rounded-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    حالة السائقين
                </button>
                @endif

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @if(Auth::user()->isAbleTo('driver_show_active'))
                    <li>
                        <a href="{{ url('driver/show/active') }}" class="dropdown-item">السائقين المستلمين</a>
                    </li>
                    @endif
                    @if(Auth::user()->isAbleTo('driver_show_watting'))
                    <li>
                        <a href="{{ url('driver/show/waiting') }}"class="dropdown-item">انتظار السائقين </a>
                    </li>
                    @endif
                    @if(Auth::user()->isAbleTo('driver_show_blocked'))
                    <li>
                        <a href="{{ url('driver/show/blocked') }}" class="dropdown-item">السائقين المستبعدين</a>
                    </li>
                    @endif
                    @if(Auth::user()->isAbleTo('recently_driver'))
                    <li>
                        <a href="{{ url('driver/show/pending') }}" class="dropdown-item">السائقين  بأنتظار الموافقة</a>
                    @endif
                    </li>
                </ul>

            </div>
            @endif



            @if( Auth::user()->isAbleTo('driver_show_available') )

                <a href="{{ url('driver/availables') }}" class="btn btn-success rounded-0 ms-1">السائقين المتاحيين</a>
            @endif
            @if( Auth::user()->isAbleTo('driver_add_new_driver') )
                <a href="{{ url('driver/add') }}" class="btn btn-success rounded-0 ms-1">أضـافـة سائق جديد</a>
            @endif




            <div class="dropdown float-start ms-1">
                @if(Auth::user()->isAbleTo(['contract_manage|driver_counts|driver_show_notes|driver_reports|driver_debits']))

                <button class="btn btn-primary dropdown-toggle rounded-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    تقرير السائقين
                </button>
                @endif
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @if(Auth::user()->isAbleTo('contract_manage'))
                    <li>
                        <a  class="dropdown-item" href="{{ route('driver.show.contracts','valid')}}" > عقود التأجير</a>
                    </li>
                    @endif
                    @if(Auth::user()->isAbleTo('driver_counts'))
                    <li>
                        <a  class="dropdown-item" href="{{url('driver/count/users')}}"> احصائية السائقين العملاء</a>
                    </li>
                    @endif

                    @if(Auth::user()->isAbleTo('driver_show_notes'))
                        <li>
                            <a class="dropdown-item" href="{{url('driver/records/notes')}}">ملاحظات السائقين</a>
                        </li>
                    @endif
                    <li>
                        <a  class="dropdown-item" href="{{url('driver/reports/status/show')}}">تقرير حالات السائقين</a>

                    </li>
                    @if(Auth::user()->isAbleTo('driver_reports'))
                        <li>
                            <a  class="dropdown-item" href="{{url('driver/reports/show')}}">تقرير قبض السائقين</a>
                        </li>
                    @endif
                    @if(Auth::user()->isAbleTo('driver_debits'))
                        <li>
                            <a   class="dropdown-item"  href="{{url('driver/debits')}}">السائقين المتعثرين</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>رقم</th>
                        <th>السائق</th>
                        <th>الجوال</th>
                        <th>رقم الهوية</th>
                        <th>نوع المركبة</th>
                        <th>سنة الصنع</th>
                        <th>رقم اللوحة</th>
                        <th>التقيم</th>
                        <th>تاريخ الأضافة</th>
                        <th>أضيف بواسطة</th>
                        @if ($state == "active")
                        <th>المتبقى دفعه هذا الأسبوع</th>
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                        <tr>
                            <td>{{ $driver->id }}</td>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->phone }}</td>
                            <td>{{ $driver->ssd }}</td>
                            <td>{{ $driver->vechile_type }}</td>
                            <td>{{ $driver->made_in }}</td>
                            <td>{{ $driver->plate_number }}</td>
                            <td>{{ $driver->rate }}</td>
                            <td>{{ $driver->add_date }}</td>
                            <td>{{ $driver->admin_name }}</td>
                            @if ($state == "active")
                            <td>{{ $driver->weekly_remains }}</td>
                            @endif
                            <td>

                                @if(Auth::user()->isAbleTo('driver_maintain_show'))
                                <a href="{{ url('driver/center/bill/' . $driver->id) }}"
                                    class="btn btn-primary rounded-0 m-0">صيانة المركز</a>
                                @endif
                                @if ($driver->state === 'pending')
                                    <a href="{{ url('driver/pending/active/' . $driver->id) }}"
                                        class="m-1 btn btn-danger">قبول</a>
                                @endif
                                @if(Auth::user()->isAbleTo('driver_data_show'))
                                <a href="{{ url('driver/details/' . $driver->id) }}" class="m-1 btn btn-primary">عرض</a>
                                @endif
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
        $(document).ready(function() {
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
@endsection
