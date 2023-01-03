
@extends('index')
@section('title','المركبات')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">{{ $title }}</h5>
    <div class="float-end mt-3">
        @if(Auth::user()->isAbleTo('vechile_show'))   
        @if(Auth::user()->isAbleTo('vechiles_show_all'))         
        <a href="{{url('vechile/show')}}" class="btn {{$title == 'عرض بيانات المركبات' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >جميع المركبات</a>
        @endif
        @if(Auth::user()->isAbleTo('vechiles_show_excluded'))    
        <a href="{{url('vechile/show/blocked')}}" class="btn {{$title == 'عرض بيانات المركبات المستبعدة' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >المركبات المستبعده</a>
        @endif
        @if(Auth::user()->isAbleTo('vechiles_show_received'))    
        <a href="{{url('vechile/show/active')}}" class="btn {{$title == 'عرض بيانات المركبات المستلمة' ? 'btn-primary' : 'btn-light'}} btn-primary rounded-0 m-0" >المركبات المستلمة</a>
        @endif
        @if(Auth::user()->isAbleTo('vechiles_show_waiting'))    
        <a href="{{url('vechile/show/waiting')}}" class="btn {{$title == 'عرض بيانات المركبات المنتظرة' ? 'btn-primary' : 'btn-light'}} btn-primary rounded-0 m-0" >المركبات المنتظرة</a>
        @endif
        @if(Auth::user()->isAbleTo('vechile_add_new'))  
        <a href="{{url('vechile/add')}}" class="btn btn-success rounded-0 m-0" >أضـافـة مركبة جديدة</a>
        @endif
        @endif
        <a href="{{url('vechile/reports')}}" class="btn btn-success rounded-0 m-0" > تقارير المركبات </a>
       
    </div>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم </th>
                                    <th>النوع</th>
                                    <th>سنة الصنع</th>
                                    <th>رقم اللوحة</th>
                                    <th>السائق</th>
                                    <th>الهاتف</th>
                                    <th>اضيفة بواسطة</th>
                                    <th>تاريخ الاضافة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vechiles as $vechile)
                                <tr>
                                    <td>{{ $vechile->id }}</td>
                                    <td>{{ $vechile->vechile_type }}</td>
                                    <td>{{ $vechile->made_in }}</td>
                                    <td>{{ $vechile->plate_number }}</td>
                                    <td>{{ $vechile->name}}</td>
                                    <td>{{ $vechile->phone}}</td>
                                    <td>{{ $vechile->add_date}}</td>
                                    <td>{{ $vechile->admin_name}}</td>
                                    
                                    <td>
                                        @if(Auth::user()->isAbleTo('vechile_show_detials'))  
                                        <a href="{{ url('vechile/details/'.$vechile->id) }}" class="btn btn-primary">عرض</a>
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
                    "sLengthMenu": "عـرض _MENU_ المركبات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المركبات من _START_ إلى _END_ من إجمالي _TOTAL_ من مركبة",
                    "sInfoEmpty": "عرض المركبات من 0 إلى 0 من إجمالي 0 مركبة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المركبات)",
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