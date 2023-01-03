
@extends('index')
@section('title','التصنيفات')
@section('content')
<div class="container clearfix">
    <h3 class="m-2 mt-4 float-start">عرض التصنيفات</h3>
    <div class="float-end mt-4">
        @if(Auth::user()->isAbleTo('vechile_add_new_category'))
    <a href="{{url('vechile/add/cagegory')}}" class="btn btn-success rounded-0 m-0" >أضـافـة تصنيف جديد</a>
        @endif 
</div>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم </th>
                                    <th> اسم </th>
                                    <th>السعر الاساسي</th>
                                    <th>تكلفة كم</th>
                                    <th>تكلفة الرفض</th>
                                    <th>تكلفة الإلغاء</th>
                                    <th>التقيم</th>
                                    <th>تم الاضافة بواسطة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cats as $cat)
                                <tr>
                                    <td>{{ $cat->id }}</td>
                                    <td>{{ $cat->category_name }}</td>
                                    <td>{{ $cat->basic_price }}</td>
                                    <td>{{ $cat->km_cost }}</td>
                                    <td>{{ $cat->reject_cost }}</td>
                                    <td>{{ $cat->cancel_cost }}</td>
                                    <td>{{ $cat->rate }}</td>
                                    <td>{{ $cat->admin_name}}</td>
                                    <td>
                                        @if(Auth::user()->isAbleTo('vechile_show_category_detail'))
                                        <a href="{{ url('vechile/detials/cagegory/'.$cat->id) }}" class="btn btn-primary">عرض</a>
                                        @endif
                                        @if(Auth::user()->isAbleTo('vechile_show_city_in_category'))
                                        <a href="{{ url('vechile/show/city/'.$cat->id) }}" class="btn btn-success">المدن</a>
                                        @endif
                                        @if(Auth::user()->isAbleTo('vechile_update_category'))
                                        <a href="{{ url('vechile/update/cagegory/'.$cat->id) }}" class="btn btn-danger">تعديل</a>
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
                    "sLengthMenu": "عـرض _MENU_ التصنيفات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض التصنيفات من _START_ إلى _END_ من إجمالي _TOTAL_ من تصنيف",
                    "sInfoEmpty": "عرض التصنيفات من 0 إلى 0 من إجمالي 0 تصنيف",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من التصنيفات)",
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