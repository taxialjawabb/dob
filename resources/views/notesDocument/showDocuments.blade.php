@extends('index')
@section('title','المستندات')
@section('content')
<div class="container clearfix mt-4">
    <h5 class=" mt-4 float-start">عرض المستندات</h5>
    <div class="float-end">
        <form action="{{ url('system/document') }}" method="GET">
            <div class="row">
                <div class="col-5">
                    <label for="from_date" class="form-label">من</label>
                    <input type="date" style="text-direction:rtl" value="{{ $from_date != null? \Carbon\Carbon::parse($from_date)->format('Y-m-d') : '' }}" name="from_date"
                        class="form-control" id="from_date" required>
                </div>
                <div class="col-5">
                    <label for="to_date" class="form-label">ألى</label>
                    <input type="date" style="text-direction:rtl" value="{{ $to_date != null? \Carbon\Carbon::parse($to_date)->format('Y-m-d') : '' }}" name="to_date"
                        class="form-control" id="to_date" required>
                </div>
                <div class="col-2 mt-2">
                    <button type="submit" class="btn btn-primary mt-4 ">بحث</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>نوع المستند</th>
                    <th>خاص ب </th>
                    <th> نوع </th>
                    <th>الموضوع</th>
                    <th>المرفق</th>
                    <th>اضيفة بواسطة</th>
                    <th>تاريخ الاضافة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $note)
                <tr>
                    <td>{{ $note->document_type }}</td>
                    <td>{{ $note->owner }}</td>
                    @if ($note->type=='drivers')
                    <td>سائق</td>
                    @elseif ($note->type=='users')
                    <td>مستخدم</td>
                    @elseif ($note->type=='nathriaat')
                    <td>جهة</td>
                    @else
                    <td>مركبة</td>

                    @endif

                    <td>{{ $note->content }}</td>
                    <td>

                        @if($note->attached !== null)
                        <form method="GET" action="{{ url('show/pdf') }}">
                            @csrf



                            <input type="hidden" name="url"
                                value="{{'assets/images/'.$note->type.'/documents/'.$note->attached}}">
                            <button type="submit" class="btn btn-light">عرض المرفق</button>
                        </form>
                        @endif
                    </td>
                    <td>{{ $note->admin_name }}</td>
                    <!-- <td>{{ \Carbon\Carbon::parse($note->add_date)->format('d/m/Y') }}</td> -->
                    <td>{{ $note->add_date }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>

@endsection

@section('scripts')
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
                    "sLengthMenu": "عـرض _MENU_ الملاحظات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الملاحظات من _START_ إلى _END_ من إجمالي _TOTAL_ من مستند",
                    "sInfoEmpty": "عرض الملاحظات من 0 إلى 0 من إجمالي 0 مستند",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الملاحظات)",
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
