@extends('index')
@section('title','النسبة')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">عرض نسبة الخصم لإشتراكات</h5>
    <h5 class=" mt-4 float-start">الإشتركات الشهرية</h5>
    <div class="float-end mt-3">
        @if(Auth::user()->isAbleTo('booking_add_precentage'))
        <a href="#" class="btn btn-success rounded-0 m-0" id="booking-discount" data-bs-toggle="modal"
            data-bs-target="#exampleModal">أضـافـة نسبة للإشتراك</a>
        @endif    
    </div>
</div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>عدد الرحلات</th>
                    <th>نسبة الخصم من مائة</th>
                    <th>تعديل</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr class="discount{{ $d->id }}">
                    <td class="discount_id">{{ $d->id }}</td>
                    <td class="percentage_to">{{ $d->percentage_to }}</td>
                    <td class="percentage">{{ $d->percentage }}</td>
                    <td>
                        @if(Auth::user()->isAbleTo('booking_update_precentage'))
                        <button class="btn btn-danger discount-edit" id="discount{{ $d->id }}">تعديل </button>
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
                <p class="mb-1 mt-3 pt-1 text-center " style="color: black; font-size: 16px;">أضافة نسبة خصم للإشتراك
                </p>
                <form method="POST" action="{{ url('bookings/discount') }}" id='form'>
                    @csrf
                    <div class="row">
                        <div class="mt-4  col-12 ">
                            <label for="trip_count" class="form-label">عدد الرحلات</label>
                            <input type="text" style="text-direction:rtl" value="{{ old('trip_count') }}"
                                name="trip_count" class="form-control" required>
                        </div>

                        <div class="mt-4  col-12 ">
                            <label for="discount" class="form-label">نسبة الخصم</label>
                            <input type="text" style="text-direction:rtl" value="{{ old('discount') }}" name="discount"
                                class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="adminsReceive" tabindex="-1" aria-labelledby="adminsReceiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="container-fluid mt-1 element-center" id="printable">
                <p class="mb-1 mt-3 pt-1 text-center " style="color: black; font-size: 16px;">تسليم العهد لمستخدم</p>
                <form method="POST" action="{{ url('bookings/discount/update') }}" id='form'>
                    <input type="hidden" name="discount_id" value="" id="discount_id">
                    @csrf
                    <div class="row">
                        <div class="mt-4  col-12 ">
                            <label for="trip_count" class="form-label">عدد الرحلات</label>
                            <input type="text" style="text-direction:rtl" value=""
                                name="trip_count" class="form-control" id="trip_count" required>
                        </div>

                        <div class="mt-4  col-12 ">
                            <label for="discount" class="form-label">نسبة الخصم</label>
                            <input type="text" style="text-direction:rtl" value="" name="discount"
                                class="form-control" id="discount" required>
                        </div>
                    </div>
                    <button type="submit" id="save-form" class="btn btn-primary mt-3 mb-3 ">تعديل </button>
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