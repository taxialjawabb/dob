@extends('index')
@section('title', 'العهد')
@section('content')
<div class="container clearfix">
    <h3 class="m-2 mt-4 float-start">تسليم العهد</h3>

</div>
<form id="form"  method="POST">
    @csrf
    <div class="mt-4   ">
        <label for="user_id" class="form-label">الشخص او الجهة المستهدفة</label>
        <select value="{{ old('user_id') }}" name="user_id" id="user_id" class="form-select"
            aria-label="Default select example" id="user_id" required>
            <option value="" selected disabled>حدد الشخص المستهدف</option>
            @foreach (\App\Models\Admin::where('state','active')->where('department', 'management')->get() as $user )
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-4">
        <input type="submit" value=" تسليم العهد لمستخدم" id="confirmButton" class="btn btn-primary rounded-0 m-0">
    </div>

    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th># </th>
                        <th> اسم العهدة</th>
                        <th> العدد</th>
                        <th>
                            <button id="confirm-all" class="btn btn-light m-0 p-0">تحديد الجميع</button>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($covenants as $covenant)
                    <tr class="covenat{{ $covenant->id }}">
                        <td class="id">{{ $covenant->id }}</td>
                        <td class="name">{{ $covenant->covenant_name }}</td>
                        <td>{{ $covenant->counts }}</td>
                        <td>
                            <input type="checkbox" name="covenant[]" class="myCheckBox"
                                value="{{$covenant->covenant_name}}">
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</form>

    <!-- Modal -->
    <div class="modal fade" id="verification_code_div" tabindex="-1" role="dialog"
        aria-labelledby="verification_code_divLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verification_code_divLabel">أرسال كود تحقيق للمستخدم لتسليم العهد </h5>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="mt-2 mb-3 col-12 ">
                            <label for="verification_code" class="col-md-4 col-form-label text-md-right">كود التحقيق</label>

                            <div class="col-md-6">
                                <input id="verification_code_inp" type="verification_code"
                                    class="form-control{{ $errors->has('verification_code') ? ' is-invalid' : '' }}"
                                    name="verification_code" value="{{ old('verification_code') }}">

                                @if ($errors->has('verification_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('verification_code') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="alert text-danger m-1" id="alert-confirm">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success " id="verification_code">
                           تأكيد
                        </button>
                        <a class="btn btn-secondary close-modal" data-dismiss="modal">إلغاء</a>
                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var userCode;
        $('#form').on('submit', function(e){
            e.preventDefault();
            $('#verification_code_div').modal('show');
            var formData = $(this).serializeArray();
            // console.log(data);
            $.ajax({
                type: 'post',
                url: '{!!url("covenant/delivering/send/code")!!}',
                data: formData,
                success: function(data){
                     console.log(data);
                    if(data.success === true){
                        userCode = data.code;
                    }
                    else{
                        window.location.href = '{!!URL::to("covenant/delivering")!!}';
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        });
        $("#verification_code").on('click', function (){
            var formData = $("#form").serializeArray();
            let code = $('#verification_code_inp').val();
            if(userCode == code){
                $.ajax({
                type: 'post',
                url: '{!!url("covenant/delivering/save")!!}',
                data: formData,
                success: function(data){
                    if(data.success === true){
                        window.location.href = '{!!URL::to("covenant/show")!!}';
                    }
                    else{
                        window.location.href = '{!!URL::to("covenant/delivering")!!}';
                    }

                },
                error:function(error){
                    console.log(error);
                }
            });
            }
            else if(code.length == 0){
                $("#alert-confirm").show();
                $("#alert-confirm").text("الرجاء أدخال كود التحقق لتسليم العهد");
            }
            else{
                $("#alert-confirm").show();
                $("#alert-confirm").text("الرجاء التحقق من رقم التأكيد");
            }
        });


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
            $(".mycontainer").append( '<div class="mt-3"><input type="text" name="serial[]" class="form-control"  ></div>' ); }
            } }); var listItem=$(".covenant"); for (var i=0; i < listItem.length; i++) { listItem[i].addEventListener('click',
            function(e) { var id=$("." + e.target.id + " .id" ).text(); var name=$("." + e.target.id + " .name" ).text();
            $("#covenant-name").text(name); $(".covenant_name").val(name); }); }
        });
</script>
    <script>
        var boxes = $('.myCheckBox');

       boxes.on('change', function() {
        $('#confirmButton').prop('disabled', !boxes.filter(':checked').length);
       }).trigger('change');
        $(document).ready(function() {
            $('#datatable').DataTable({
                lengthMenu:[[-1],['الجميع']],
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
        $(document).ready(function() {
        var selectAll = false;
        $("#confirm-all").click(function(e) {


            e.preventDefault();

            if (selectAll == false) {

                selectAll = true;
                $(this).text('إلغاء التحديد للجميع');
                $("#datatable input").attr('checked', 'checked');
                $('#confirmButton').prop('disabled', false);
            } else {
                $(this).html('تحديد الجميع');
                selectAll = false;
                $("#datatable input").removeAttr('checked');
                $('#confirmButton').prop('disabled', true);

            }
        });
    });
    </script>
    @endsection
