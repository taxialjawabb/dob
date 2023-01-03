
@extends('index')
@section('title','سجل الدخول')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">عرض سجل الإحداث لتسجيل دخول الموظفيين</h5>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الموظف</th>
                                    <th>الحالة</th>
                                    <th>الوقت</th>
                                    <th>IP address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index=>$log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->name }}</td>
                                    <td>
                                    @switch($log->log_type)
                                        @case('code')
                                                ارسال الكود
                                            @break
                                        @case('success')
                                                تسجيل دخول
                                            @break
                                        @case('logout')
                                                تسجيل خروج
                                            @break
                                        @case('faild')
                                                فشل الدخول
                                            @break
                                        @default
                                    @endswitch
                                    </td>
                                    {{-- <td>{{ $log->created_at }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('y-m-d h:m:s A') }}</td>
                                    <td>{{ $log->ip }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" alt="المرفق" id="document" style="width:100%; height:380px" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "order":  [[0, 'desc']],
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ المستندات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المستندات من _START_ إلى _END_ من إجمالي _TOTAL_ من مستند",
                    "sInfoEmpty": "عرض المستندات من 0 إلى 0 من إجمالي 0 مستند",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المستندات)",
                    "sInfoPostFix": "",
                    "sSearch": "بـحــث:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "التحميل...",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sLast": "الأخير",
                        "sNext": "التالى",
                        "sPrevious": "المستخدم"
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
        <script src="{{ asset('js/imgmodel.js') }}" ></script>
@endsection
