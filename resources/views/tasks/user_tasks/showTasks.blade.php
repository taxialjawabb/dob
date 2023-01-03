
@extends('index')
@section('title','المهام')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start"> 
        مهام قسم
    @switch(Auth::user()->department)
        @case('management')
            الفسم الإدارى
            @break
        @case('technical')
            القسم التقنى
            @break
        @default
    @endswitch
</h5>
    <div class="float-end mt-3">
    <a href="{{ url('tasks/user/show/unseen') }}" class="btn {{$state === 'unseen'? 'btn-primary': ''}} rounded-0 m-0" >غير مقروءة</a>
        <a href="{{ url('tasks/user/show/seen') }}" class="btn {{$state === 'seen'? 'btn-primary': ''}} rounded-0 m-0" >مقروءة</a>        
        <a href="{{ url('tasks/user/show/uncomplete') }}" class="btn {{$state === 'uncomplete'? 'btn-primary': ''}} rounded-0 m-0" >غير مكتملة</a>
        @if(Auth::user()->isAbleTo('complete_task'))
        <a href="{{ url('tasks/user/show/complete/complete') }}" class="btn {{$state === 'complete'? 'btn-primary': ''}} rounded-0 m-0" >مكتملة</a>        
        @endif
        @if(Auth::user()->isAbleTo('task_add_new'))
        <a href="{{url('tasks/add')}}" class="btn btn-success rounded-0 m-0" >أضـافـة مهمة</a>
        @endif
    </div>
</div>
<div class="clearfix "></div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم المهمة</th>
                                    <th>الموضوع</th>
                                    <th>الوصف</th>
                                    <th>الحالة</th>
                                    <th>مشاهدة بواسطة</th>
                                    <th>تاريخ الأضافة</th>
                                    <th>اخر تحديث</th>
                                    <th>تاريخ الأنتهاء</th>
                                    <th>أضيف بواسطة</th>
                                    <th>
                                        عرض
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr class=" {{ $task->type ==='rider'? 'table-dark' :'' }}">
                                    <td>{{ $task->id }}</td>
                                    <td>{{ $task->subject }}</td>
                                    <td>{{ $task->content }}</td>
                                    <td>
                                    @switch($task->state)
                                        @case('unseen')
                                            غير مقروء
                                            @break
                                        @case('seen')
                                            مقروء
                                            @break
                                        @case('uncomplete')
                                            غير مكتمل
                                            @break
                                        @case('complete')
                                            مكتمل
                                            @break
                                        @default
                                    @endswitch
                                    </td>
                                    <td>{{ $task->readed_admin }}</td>                                    
                                    <td>{{ $task->created_at }}</td>
                                    <td>{{ $task->created_at == $task->updated_at? '':$task->updated_at }}</td>
                                    <td>{{ $task->finish_date }}</td>
                                    <td>
                                        {{ $task->add_admin  }}
                                        {{ $task->type ==='rider'? '(عميل) ' :'' }}
                                    </td>
                                    <td>
                                        
                                        <a href="{{ url('tasks/detials/'.$task->id.'/'.$task->type) }}" class="btn btn-primary m-1">عرض</a>
                                       
                                        @if($state !== 'complete')
                                        <a href="{{ url('tasks/user/add/'.$task->id.'/'.$task->type) }}" class="btn btn-danger m-1">تحديث</a>
                                        @endif
                                        @if($state === 'unseen')
                                        <a href="{{ url('tasks/recived/'.$task->id.'/'.$task->type) }}" class="btn btn-danger m-1">استلام</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    "sLengthMenu": "عـرض _MENU_ المهام",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المهام من _START_ إلى _END_ من إجمالي _TOTAL_ من مهمة",
                    "sInfoEmpty": "عرض المهام من 0 إلى 0 من إجمالي 0 مهمة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المهام)",
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