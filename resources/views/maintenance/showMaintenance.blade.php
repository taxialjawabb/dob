@extends('index')
@section('title', 'الصنف')
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
    <div class="container clearfix">
        <h3 class="m-2 mt-4 float-start">عرض الأصناف</h3>
        <div class="float-end mt-4">

            @if(Auth::user()->isAbleTo('maintain_add_new_category'))
            <a href="{{ url('maintenance/center/add') }}" class="btn btn-success rounded-0 m-0">أضـافـة صنف جديد</a>
           @endif
            {{-- <a href="#" id="receive-covenent" class="btn btn-primary rounded-0 m-0">
                تسليم الصنف لمستخدم
            </a> --}}
        </div>
    </div>
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th># </th>
                        <th>الصنف</th>
                        <th>العدد الكلى</th>
                        <th>المخزون</th>
                        <th>المستهلك</th>
                        <th>المرتجع</th>
                        <th>العدد المجانى</th>
                        <th>مدة التغير</th>
                        <th>سعر الأضافى</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product as $main)
                        <tr class="covenat{{ $main->id }}">
                            <td class="id">{{ $main->id }}</td>
                            <td class="name">{{ $main->name }}</td>
                            <td>{{ $main->total }}</td>
                            <td>{{ $main->stored }}</td>
                            <td>{{ $main->used }}</td>
                            <td>{{ $main->returned }}</td>
                            <td>{{ $main->free_count }}</td>
                            <td>
                                @switch($main->periodic_days)
                                    @case(7)
                                        اسبوعي
                                        @break
                                    @case(14)
                                        كل اسبوعين
                                        @break
                                    @case(30)
                                        شهرى
                                        @break
                                    @case(183)
                                        نصف سنوى
                                        @break
                                    @case(365)
                                        سنوى
                                        @break
                                    @default
                                        {{ $main->periodic_days }} أيام
                                @endswitch
                            </td>
                            <td>{{ $main->price }}</td>
                            <td>
                                <a href="{{ url('maintenance/center/show/' . $main->id) }}"
                                    class="btn btn-primary m-1">عرض</a>
                                @if(Auth::user()->isAbleTo('maintain_update_category'))        
                                <a href="{{ url('maintenance/center/update/' . $main->id) }}"
                                    class="btn btn-danger m-1">تعديل</a>
                                @endif  
                                @if(Auth::user()->isAbleTo('maintain_add_new_amount'))    
                               <a href="#" class="btn covenant btn-success m-1" id="covenat{{ $main->id }}"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">أضافة كمية</a>
                                @endif    
                                <a href="{{ url('maintenance/center/show/detials/' . $main->id) }}"
                                    class="btn btn-primary m-1">عرض صرف الكميات</a>
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
                    <p class="mb-1 mt-3 pt-1 text-center " style="color: black; font-size: 16px;">أضافة كمية من * <span
                            id="covenant-name"></span> * </p>
                    <form method="POST" action="{{ url('maintenance/center/quantity') }}" id='form'>
                        <input type="hidden" class="quantity_name" name="quantity_name" required>
                        <input type="hidden" id="id" name="id" required>
                        @csrf
                        <div class="row">

                            <div class="mt-4  col-12 ">
                                <label for="quantity" class="form-label">الكمية المراد إدخالها</label>
                                <input type="text" value="{{ old('quantity') }}" name="quantity" class="form-control" id="quantity"  required>
                            </div>
                            <div class="mt-4  col-12 ">
                                <label for="price" class="form-label">المبلغ المدفوع لشراء هذه الكمية(إختيارى)</label>
                                <input type="text" value="0" name="price" class="form-control" id="price"  >
                            </div>

                            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="payment_type" class="form-label">طريقة دفع الكمية(إختيارى)</label>
                                <select value="{{ old('payment_type') }}" name="payment_type" id="payment_type" class="form-select" aria-label="Default select example" id="payment_type" >
                                    <option value="" selected disabled>حدد طريقة دفع الكيمة</option>
                                    <option value="cash">كــاش</option>
                                    <option value="bank transfer">تحويل بنكى</option>
                                    <option value="internal transfer">تحويل داخلى</option>
                                    <option value="selling points">نقاط بيع</option>
                                    <option value="electronic payment">دفع إلكترونى</option>
                                </select>
                            </div>

                            <div class="mt-4  col-12 ">
                                <label for="type" class="form-label">حالة هذه الكمية</label>
                                <select value="{{ old('type') }}" name="type" id="type" class="form-select" aria-label="Default select example" id="type" required>
                                    <option value="" selected disabled>حدد المدة المجانية للتغير</option>
                                    <option value="stored">جديد(مخزن) </option>
                                    <option value="returned">مرتجع</option>
                                    <option value="used">مستهلك</option>

                                </select>
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

        var listItem = $(".covenant");
        for (var i = 0; i < listItem.length; i++) {
            listItem[i].addEventListener('click', function(e) {
                var id = $("." + e.target.id + " .id").text();
                var name = $("." + e.target.id + " .name").text();
                $("#covenant-name").text(name);
                $(".quantity_name").val(name);
                $("#id").val(id);
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
                    "sLengthMenu": "عـرض _MENU_ الصنف",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الصنف من _START_ إلى _END_ من إجمالي _TOTAL_ من صنف",
                    "sInfoEmpty": "عرض الصنف من 0 إلى 0 من إجمالي 0 صنف",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الصنف)",
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
