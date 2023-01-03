@extends('index')
@section('title', 'المجموعات')
@section('content')
    <div class="container clearfix">


        <h5 class=" mt-4 float-start">عرض المجموعات</h5>


    </div>

    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المنشأة</th>
                        <th>المدينة</th>
                        <th>تاريخ بداية الاشتراك</th>
                        <th>تاريخ نهاية الاشتراك</th>
                        <th>عدد المركبات</th>
                        <th> حالة الترخيص</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->city }}</td>
                            <td>{{ $group->add_date }}</td>
                            <td>{{ $group->renew_date }}</td>
                            <td>{{ $group->vechile_counter }}</td>
                            {{-- <td>{{ $group->manager->name ?? ''}}</td> --}}
                            @if ($group->expired_date_transportation_license_number != null)
                                <td>
                                    {{ date($group->expired_date_transportation_license_number) > \Carbon\Carbon::now() ? 'سارى' : 'منتهى' }}
                                </td>
                            @else
                                <td>
                                    لم يتم رفع الترخيص بعد
                                </td>
                            @endif
                            <td>

                                @if ($group->expired_date_transportation_license_number != null &&
                                    $group->expired_date_commercial_register != null &&
                                    $group->expired_date_municipal_license_number != null )
                                    @if (date($group->expired_date_transportation_license_number) > \Carbon\Carbon::now() &&
                                        date($group->expired_date_commercial_register) > \Carbon\Carbon::now() &&
                                        date($group->expired_date_municipal_license_number) > \Carbon\Carbon::now() && $group->vechile_counter != null && $group->vechile_counter != 0)

                                        <a href="{{ route('shared.groups.details', ['group' => $group]) }}"
                                            class="btn btn-outline-primary m-1">دخول </a>
                                        <a href="{{ route('my.groups.renew', ['group' => $group]) }}"
                                            class="btn btn-outline-primary m-1">اضافة مركبة </a>
                                        <a href="{{ route('shared.groups.renew', ['group' => $group]) }}"
                                            class="btn btn-outline-primary m-1">تجديد </a>

                                    @else
                                        <p>
                                            <span class="d-inline-block">
                                                {{ date($group->expired_date_commercial_register) < \Carbon\Carbon::now() ? 'انتهاء ترخيص السجل التجاري  ' : '' }}
                                            </span>
                                            <span class="d-inline-block">
                                                {{ date($group->expired_date_transportation_license_number) < \Carbon\Carbon::now()
                                                    ? 'انتهاء  ترخيص هيئة النقل  '
                                                    : '' }}
                                            </span>
                                            <span class="d-inline-block">
                                                {{ date($group->expired_date_municipal_license_number) < \Carbon\Carbon::now() ? 'انتهاء رخصة البلدية ' : '' }}
                                            </span>
                                        </p>
                                    @endif
                                @else
                                    <p>
                                        <span class="d-inline-block">
                                            انتهاء ترخيص السجل التجاري
                                        </span>
                                        <span class="d-inline-block">
                                            انتهاء ترخيص هيئة النقل
                                        </span>
                                        <span class="d-inline-block">
                                            انتهاء رخصة البلدية
                                        </span>
                                    </p>
                                @endif

                                @if ($group->vechile_counter == null or $group->vechile_counter == 0)
                                    <a href="{{ route('my.groups.renew', ['group' => $group]) }}"
                                        class="btn btn-outline-primary m-1">اضافة مركبة </a>
                                @endif
                                <a href="{{ route('my.groups.license', ['group' => $group]) }}"
                                    class="btn btn-outline-primary m-1">تحديث التراخيص </a>
                                <a href="{{ route('shared.groups.license.show', ['group' => $group]) }}"
                                    class="btn btn-outline-primary m-1">طلبات التراخيص </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container-fluid mt-1 element-center" id="printable">
                    <p class="mb-1 mt-3 pt-1 text-center " style="color: black; font-size: 16px;">أضافة سعر المركبة لليوم
                        الواحد
                    </p>
                    <form method="POST" action="{{ url('groups/daily/price') }}" id='form'>
                        @csrf
                        <input type="hidden" name="id" value="{{ $vechilePrice->id }}">
                        <div class="row">
                            <div class="mt-4  col-12 ">
                                <label for="vechile_price" class="form-label">سعر المركبة اليومى </label>
                                <input type="text" style="text-direction:rtl" value="{{ $vechilePrice->vechile_price }}"
                                    name="vechile_price" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('.discount-edit').on('click', function() {
                $('#adminsReceive').modal('show');
            });

            var listItem = $(".discount-edit");
            for (var i = 0; i < listItem.length; i++) {
                listItem[i].addEventListener('click', function(e) {
                    var id = $("." + e.target.id + " .discount_id").text();
                    var percentage_to = $("." + e.target.id + " .percentage_to").text();
                    var percentage = $("." + e.target.id + " .percentage").text();
                    $('#discount_id').val(id);
                    $('#trip_count').val(percentage_to);
                    $('#discount').val(percentage);
                });
            }
        });
    </script>


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
                    "sLengthMenu": "عـرض _MENU_ النسبة",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض النسبة من _START_ إلى _END_ من إجمالي _TOTAL_ من مستند",
                    "sInfoEmpty": "عرض النسبة من 0 إلى 0 من إجمالي 0 نسبة خصم",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من النسبة)",
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
