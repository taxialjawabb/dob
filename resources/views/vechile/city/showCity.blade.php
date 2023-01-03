
@extends('index')
@section('title','عرض المدن')
@section('content')
                <div class="container">
                    <h3 class="m-2 mt-4 ">بيان مفصل للتصنيف و المدن</h3>
                    <div class="clearfix">
                        <p class="h5 float-start">
                        اسم التصنيف : {{$cat->category_name}}
                        </p >
                        <div class="float-end ">
                            
                            @if(Auth::user()->isAbleTo('vechile_add_new_city_to_category'))
                            <a href="{{ url('vechile/add/city/'.$cat->id) }}" class="btn btn-primary p-2 pl-6 pr-6">أضافة مدينة للتصنيف</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>المدينة</th>
                                    <th>ذهاب</th>
                                    <th>ذهاب و عودة</th>
                                    <th>إلغاء</th>
                                    <th>رفض</th>
                                    <th>نوع النسبة</th>
                                    <th>النسبة</th>
                                    <th>إضيفت بواسطة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($city as $cit)
                                <tr>
                                    <td>{{ $cit->city }}</td>
                                    <td>{{ $cit->going_cost }}</td>
                                    <td>{{ $cit->going_back_cost }}</td>
                                    <td>{{ $cit->city_cancel_cost }}</td>
                                    <td>{{ $cit->city_regect_cost }}</td>
                                    <td>{{$cit->percentage_type == 'fixed'? 'النسبة ثابتة':'النسبة مئوية'}}</td>
                                    <td>{{ $cit->city_percent }}</td>
                                    <td>{{ $cit->admin_name }}</td>
                                    <td>
                                    <a href="{{ url('vechile/update/city/'.$cat->id.'/'.$cit->id) }}" class="btn btn-danger">تعديل</a>
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
                    "sLengthMenu": "عـرض _MENU_ المدن",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المدن من _START_ إلى _END_ من إجمالي _TOTAL_ من مدن",
                    "sInfoEmpty": "عرض المدن من 0 إلى 0 من إجمالي 0 مدن",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المدن)",
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