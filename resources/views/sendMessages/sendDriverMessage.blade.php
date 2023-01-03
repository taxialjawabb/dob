@extends('index')
@section('title', 'ارسال رسائل')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">ارسال رسائل للسائقين</h5>
    <div class="float-end mt-3">
        <a href="{{url('send/message/driver/show/all')}}" class="btn {{$type === 'all' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0"> جميع السائقين</a>
        <a href="{{url('send/message/driver/show/active')}}" class="btn {{$type === 'active' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0">السائقين المستلمين</a>
        <a href="{{url('send/message/driver/show/waiting')}}" class="btn {{$type === 'waiting' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0">السائقين المنتظرين</a>
    </div>
</div>

<div class="clearfix "></div>
@if ($errors->any())
<div class="alert alert-danger m-3 mt-4">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form method="POST" action="{{ url('send/message/driver/') }}">
    @csrf
    <div class="container">
        <div class="clearfix">
            <div class="float-start">
                <label for="message-text" class="col-form-label">نص الرسالة:</label>
                <textarea name="content" style="width: 350px; height: 100px;" value="{{ old('content') }}" class="form-control" id="message-text" required>{{ old('content') }}</textarea>
                {{-- <span class="float-end" >0</span> --}}
                <div class="m-2">
                    @if(Auth::user()->isAbleTo('sms_send_driver'))

                    <button type="submint" class="btn btn-primary">أرسال </button>
                   @endif

                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="type" value="">
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم السائق</th>
                        <th>الجوال</th>
                        <th>
                            <button id="confirm-all" class="btn btn-light m-0 p-0">تحديد الجميع</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->id }}</td>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>
                            <input type="checkbox" name="phones[]" value="{{$driver->id}}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
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
                "sProcessing": "جاري التحميل..."
                , "sLengthMenu": "عـرض _MENU_ السائقين"
                , "sZeroRecords": "لم يتم العثور على نتائج"
                , "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول"
                , "sInfo": "عرض السائقين من _START_ إلى _END_ من إجمالي _TOTAL_ من سائق"
                , "sInfoEmpty": "عرض السائقين من 0 إلى 0 من إجمالي 0 سائق"
                , "sInfoFiltered": "(تصفية إجمالي _MAX_ من السائقين)"
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

    $(document).ready(function() {
        var selectAll = false;
        $("#confirm-all").click(function(e) {
            e.preventDefault();

            if (selectAll == false) {
                selectAll = true;
                $(this).text('إلغاء التحديد للجميع');
                $("#datatable input").attr('checked', 'checked');
            } else {
                $(this).html('تحديد الجميع');
                selectAll = false;
                $("#datatable input").removeAttr('checked');

            }
        });
    });

</script>
@endsection
