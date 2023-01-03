@extends('index')
@section('title', 'العهد')
@section('content')
    <div class="container clearfix">
        <h3 class="m-2 mt-4 float-start">عرض العهد</h3>

    </div>
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th># </th>
                        <th> اسم العهدة</th>
                        <th> العدد</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($covenants as $covenant)
                        <tr class="covenat{{ $covenant->id }}">
                            <td class="id">{{ $covenant->id }}</td>
                            <td class="name">{{ $covenant->covenant_name }}</td>
                            <td>{{ $covenant->items_count }}</td>


                            <td>
                                @if(Auth::user()->isAbleTo('covenant_show'))
                                <a href="{{ url('covenant/item/show/' . $covenant->covenant_name) }}"
                                    class="btn btn-primary  m-1">عرض</a>
                               @endif

                               @if(Auth::user()->isAbleTo('covenant_add_element'))
                                <a href="#" class="btn covenant btn-success  m-1" id="covenat{{ $covenant->id }}"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">أضافة عنصر</a>
                                @endif
                                    <!-- <a href="{{ url('vechile/update/cagegory/' . $covenant->id) }}" class="btn btn-danger">تعديل</a> -->
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
                    <p class="mb-1 mt-3 pt-1 text-center " style="color: black; font-size: 16px;">أضافة عهد * <span
                            id="covenant-name"></span> * </p>
                    <form method="POST" action="{{ url('covenant/item/delivery/add') }}" id='form'>
                        <input type="hidden" class="covenant_name" name="covenant_name" required>
                        @csrf
                        <p>الارقام التسلسلية</p>
                        <div class="container mycontainer">

                        </div>
                        <div class="row">
                            <div class="mt-2  col" id="end">
                                <label for="number" class="form-label">عدد العهد المراد ادخالها</label>
                                <input type="text" name="counter" class="form-control" id="number" required>
                            </div>


                            <div class="mt-4  col">
                                <a type="button" id="add-col" href="#" class="btn mt-3 mb-3 btn-primary ">اضافة ارقام تلسلية
                                    ليها</a>
                            </div>
                        </div>
                        <button type="submit" id="save-form" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
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
                    <form method="POST" action="{{ url('covenant/delivery/user') }}" id='form'>
                        <input type="hidden" class="covenant_name" name="covenant_name" required>
                        @csrf
                        <div class="row">
                            <div class="mt-4  col ">
                                <label for="user_id" class="form-label">الشخص او الجهة المستهدفة</label>
                                <select value="{{ old('user_id') }}" name="user_id" id="user_id" class="form-select"
                                    aria-label="Default select example" id="user_id">
                                    <option value="" selected disabled>حدد الشخص المستهدف</option>
                                    @foreach (\App\Models\Admin::where('state','active')->where('department', 'management')->get() as $user )
                                        <option value="{{ $user->id }}" >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" id="save-form" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(function() {
            $('#receive-covenent').on('click', function(){
                $('#adminsReceive').modal('show');
            });
            $("#save-form").hide();
            $('#add-col').on('click', function() {
                $("#save-form").show();
                var count = $("#end input").val();
                if (count != null) {
                    $(".mycontainer").html('');
                    for (let index = 0; index < count; index++) {
                        $(".mycontainer").append(
                            '<div class="mt-3"><input type="text" name="serial[]" class="form-control"  ></div>'
                            );

                    }
                }
            });

            var listItem = $(".covenant");
            for (var i = 0; i < listItem.length; i++) {
                listItem[i].addEventListener('click', function(e) {
                    var id = $("." + e.target.id + " .id").text();
                    var name = $("." + e.target.id + " .name").text();
                    $("#covenant-name").text(name);
                    $(".covenant_name").val(name);
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
                    "sLengthMenu": "عـرض _MENU_ العهد",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض العهد من _START_ إلى _END_ من إجمالي _TOTAL_ من عهده",
                    "sInfoEmpty": "عرض العهد من 0 إلى 0 من إجمالي 0 عهده",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من العهد)",
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
