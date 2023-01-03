@extends('index')
@section('title','المجموعات')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">عرض المجموعات</h5>
    <div class="float-end mt-3">
        @if(Auth::user()->isAbleTo('group_update_price_vechile'))
        <a href="#" class="btn btn-success rounded-0 m-0" id="booking-discount" data-bs-toggle="modal"
            data-bs-target="#exampleModal">تعديل سعر المركبة</a>
        @endif
        @if(Auth::user()->isAbleTo('group_add_new'))
        <a href="{{ route('manage.groups.add') }}" class="btn btn-primary rounded-0 m-0">أضافة مجموعة</a>
        @endif
        <a href="{{ route('manage.groups.license.show', 'pending') }}" class="btn btn-primary rounded-0 m-0">طلبات تحديث الترخيص</a>
    </div>
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
                <tr>
                    <td></td>
                    <td>الجواب للنقل البرى</td>
                    <td>{{ \App\Models\Vechile::count() }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>

                        {{-- <a href="{{ url('groups/show/drivers/aljwab') }}" class="btn btn-primary m-1">السائقين</a>
                        <a href="{{ url('groups/show/vechiles/aljwab') }}" class="btn btn-primary m-1">المركبات</a> --}}
                    </td>
                </tr>
                @foreach($groups as $group)
                <tr>
                    <td>{{ $group->id }}</td>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->city }}</td>
                    <td>{{ $group->add_date }}</td>
                    <td>{{ $group->renew_date }}</td>
                    <td>{{ $group->vechile_counter }}</td>
                    {{-- <td>{{ $group->manager->name ?? ''}}</td> --}}
                    @if($group->expired_date_transportation_license_number != null)
                    <td>{{ date($group->expired_date_transportation_license_number) >date('now') ? "سارى":"منتهى" }}
                    </td>
                    @else
                    <td></td>
                    @endif
                    <td>

                        <a href="{{ route('shared.groups.details', ['group' => $group]) }}"
                            class="btn btn-outline-primary m-1">دخول </a>

                       @if($group->id !== 1)
                       <a href="{{ route('manage.groups.box.show', ['type' => 'spend', 'id' => $group->id]) }}"
                        class="btn btn-outline-primary m-1">الصندوق </a>

                        <a href="{{ route('manage.groups.update', ['group' => $group]) }}"
                                class="btn btn-outline-success m-1">تعديل بيانات المجموعة </a>
                        @if ($group->state == 'active')
                            <a href="{{ route('manage.groups.state', ['group' => $group->id]) }}"
                                class="btn btn-outline-danger m-1">استبعاد </a>
                        @else
                            <a href="{{ route('manage.groups.state', ['group' => $group->id]) }}"
                                class="btn btn-outline-danger m-1">إلغاء استبعاد </a>
                        @endif
                        {{-- @else
                        <a href="{{ url('groups/show/drivers/1') }}" class="btn btn-primary m-1">السائقين</a>
                        <a href="{{ url('groups/show/vechiles/1') }}" class="btn btn-primary m-1">المركبات</a> --}}

                       @endif
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
        $('.discount-edit').on('click', function(){
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
