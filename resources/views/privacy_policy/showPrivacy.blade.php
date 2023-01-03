@extends('index')
@section('title', $belong == "policy" ? "سياسة الخصوصية": "الشروط و الأحكام")
@section('content')
<div class="container clearfix ">
    <div class="float-start mt-4">
        <h3>
            @if ($belong == 'policy')
            عرض سياسة الخصوصية
            @else
            عرض الشروط و الأحكام
            @endif
        </h3>
    </div>
    <div class="float-end mt-3">
        <a href="{{url('privacy/policy/show/add')}}" class="btn btn-success rounded-0 ms-1">أضافة خصوصية و شروط</a>
        <div class="dropdown float-start ms-1">
            <button class="btn btn-primary dropdown-toggle rounded-0" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
               عـرض الخصوصية والشروط
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" href="{{url('privacy/policy/driver/ar')}}" target="_blank">سياسة الخصوصية
                        للسائق</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{url('privacy/policy/rider/ar')}}" target="_blank">سياسة الخصوصية
                        للعميل</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{url('terms/conditions/driver/ar')}}" target="_blank">الشروط والأحكام
                        للسائق</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{url('terms/conditions/rider/ar')}}" target="_blank">الشروط ولأحكام
                        للعميل</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>موجه الى</th>
                    <th>العنوان</th>
                    <th>محتوى السياسة</th>
                    <th>تاريخ الأضافة</th>
                    <th>اضيف بواسطة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $policy)
                <tr>
                    <td>{{ $policy->id }}</td>
                    <td>
                        @switch($policy->type)
                        @case('driver')
                        السائق
                        @break
                        @case('rider')
                        العميل
                        @break
                        @case('all')
                        الجميع
                        @break
                        @default

                        @endswitch
                    </td>
                    <td>{{ $policy->ar_title }}</td>
                    <td>{{ $policy->ar_content }}</td>
                    <td>{{ \Carbon\Carbon::parse($policy->add_date) }}</td>
                    <td>{{ $policy->add_by->name }}</td>
                    <td>
                        <a href="{{ url('privacy/policy/show/details/'.$policy->id) }}"
                            class="btn btn-primary m-1">عـرض</a>
                        <a href="{{ url('privacy/policy/show/update/'.$policy->id) }}"
                            class="btn btn-danger m-1">تعديل</a>
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
            var belong = @json($belong);
            var title = '';
            if(belong == 'policy')
            {
                title = 'سياسة الخصوصية'
            }
            else{
                title = 'الشروط و الأحكام'
            }
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
                    "sLengthMenu": "عـرض _MENU_ "+title+"",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض "+title+" من _START_ إلى _END_ من إجمالي _TOTAL_ من "+title,
                    "sInfoEmpty": "عرض "+title+" من 0 إلى 0 من إجمالي 0 "+title,
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من "+title+")",
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
