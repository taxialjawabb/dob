@extends('index')
@section('title', 'الملاحظات')
@section('content')
<h5 class="mt-4">أضافة ملاحظة </h5>

<form method="POST" action="{{ url('general/save/note') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="stakeholder" class="form-label">الجهة المستهدفة</label>
            <select value="{{ old('stakeholder') }}" name="stakeholder" id="stakeholder" class="form-select"
                aria-label="Default select example" id="stakeholder">
                <option value="" selected disabled>حدد الجهة المستهدفة</option>
                <option value="driver">السائقين</option>
                <option value="vechile">المركبات</option>
                <option value="rider">العملاء</option>
                <option value="user">المستخدمين</option>
                <option value="stakeholder">الجهات</option>
            </select>
        </div>
        <div class="mt-2 mb-3 col-sm-12 col-lg-6 ">
            <label for="user" class="form-label">الشخص او الجهة المستهدفة</label>
            <select value="{{ old('user') }}" name="user" id="user" class="form-select"
                aria-label="Default select example" id="user">
                <option value="" selected disabled>حدد الشخص المستهدف</option>
            </select>
        </div>
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="notes_type" class="form-label">نــوع الملاحظة</label>
            <input type="text" value="{{ old('notes_type') }}" name="notes_type" class="form-control" id="notes_type"
                required>
        </div>
        <div class="mb-2 col-sm-12 col-lg-6">
            <label for="message-text" class="col-form-label">الـوصــف:</label>
            <textarea name="content" value="{{ old('content') }}" class="form-control" id="message-text"
                required></textarea>
        </div>

    </div>

    <div class="mb-2 mt-1 ">
        <label for="formFile" class="form-label">المرفق</label>
        <input class="form-control" type="file" name="image" value="{{old('image')}}" id="file">

        <div class="text-center image m-2">
            <img src="{{ asset('assets/images/pleaceholder/image.png')}}" style="width: 200px; height: 200px"
                id="profile-img-tag" alt="المرفق">
        </div>

        <button type="submit" class="btn btn-primary">حفظ </button>
</form>
@if ($errors->any())
<div class="alert alert-danger m-3 mt-4">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif



@endsection

@section('scripts')
<script src="{{ asset('assets/js/addimg.js') }}" ></script>
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
        $(document).on("change", '#stakeholder', function() {
                var stakeholder = $(this).val();
                var stakeholder_id = $("#stakeholder_id").val();
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('general/show') !!}',
                    data: {
                        'to': stakeholder
                    },
                    success: function(data) {
                        op += '<option value="" selected disabled>حدد الشخص المستهدف</option>';
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].id + '">' + data[i].name +
                                '</option>';
                        }
                        $("#user").html(op);
                    },
                    error: function(e) {
                        console.log('error');
                        console.log(e);
                    }
                });
            });



</script>
@endsection
