
@extends('index')
@section('title','صادر و وارد')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">عرض  {{ $type === 'import' ? "وارد" : "صادر"}}</h5>
    <div class="float-end mt-3">        
        <a href="{{ url('import/export/show/export') }}" class="btn {{$type === 'export'? 'btn-primary': ''}} rounded-0 m-0" >صادر</a>
        <a href="{{ url('import/export/show/import') }}" class="btn {{$type === 'import'? 'btn-primary': ''}} rounded-0 m-0" >وارد</a>
        @if(Auth::user()->isAbleTo('add_import_export'))
        <a href="{{url('import/export/add')}}" class="btn btn-success rounded-0 m-0" >أضـافـة صادر و وارد </a>
        @endif
    </div>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم</th>
                                    <th>العنوان</th>
                                    <th>الموضوع</th>
                                    <th>المرفق</th>
                                    <th>الجهة</th>
                                    <th>تاريخ الاضافة</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->title }}</td>
                                    <td>{{ $d->content }}</td>
                                    <td>
                                        @if($d->attached !== null)
                                        <form  method="GET" action="{{ url('show/pdf') }}">
                                            @csrf
                                            <input type="hidden" name="url" value="{{'assets/images/importsAndExport/'.$d->attached}}">
                                            <button type="submit" class="btn btn-light" >عرض المرفق</button>
                                        </form>
                                        @endif
                                    </td>
                                    <td>{{ $d->stakeholder->name  }}</td>
                                    <!-- <td>{{ \Carbon\Carbon::parse($d->add_date)->format('d/m/Y') }}</td> -->
                                    <td>{{ $d->add_date }}</td>
                                    
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
        <img src="" alt="المرفق" id="note" style="width:100%; height:380px" >
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
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ خطابات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض خطابات من _START_ إلى _END_ من إجمالي _TOTAL_ من خطاب",
                    "sInfoEmpty": "عرض خطابات من 0 إلى 0 من إجمالي 0 خطاب",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من خطابات)",
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
        <script src="{{ asset('js/imgmodel.js') }}" ></script>   
@endsection