
@extends('index')
@section('title','عرض بيانات مستخدم')
@section('content')
  <div class="container clearfix">
    <h4 class=" float-start">بيانات المستخدم </h4>
    <div class="float-end mt-4">
      @if($user->state === "active")
        <a href="{{ url('user/block/'.$user->id) }}" class="btn btn-danger rounded-0 m-0">استبعاد</a>
      @else
        <a href="{{ url('user/block/'.$user->id) }}" class="btn btn-dark rounded-0 m-0">إلغاء الأستبعاد</a>
      @endif
      <a href="{{ url('user/box/show/take/'.$user->id) }}" class="btn btn-primary rounded-0 m-0">الصندوق</a>
      <a href="{{ url('user/notes/show/'.$user->id) }}" class="btn btn-primary rounded-0 m-0">الملاحظات</a>
      <a href="{{ url('user/documents/show/'.$user->id) }}" class="btn btn-primary rounded-0 m-0">المستندات</a>
      <!-- <a href="{{ url('user/documents/show/'.$user->id) }}" class="btn btn-primary rounded-0 m-0">عرض أيام الغياب</a>
      <a href="{{ url('user/documents/show/'.$user->id) }}" class="btn covenant btn-success" data-bs-toggle="modal" data-bs-target="#add-absence" id="add-absence">أضافة أيام غياب</a> -->
  </div>
</div>

<div class="container">
    <div class="row">

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">الاســم</label>
        <p class="alert alert-secondary p-1">{{$user->name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال</label>
        <p class="alert alert-secondary p-1">{{$user->phone}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="department" class="form-label">القسم</label>
        <p class="alert alert-secondary p-1">
            @switch($user->department)
                @case('management')
                القسم الإدارى
                    @break
                @case('developer')
                القسم التقني
                    @break
                @case('technical')
                القسم الفنى
                    @break
                @case('group_manager')
                أدارة مجموعة
                    @break
                @default

            @endswitch
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <p class="alert alert-secondary p-1">{{$user->ssd}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label"> الأدوار</label>
        <p class="alert alert-secondary p-1">
          @foreach($user->roles as $role)
          {{$role->display_name}}
          @endforeach
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label"> الـصـلاحـيـات</label>
        <p class="alert alert-secondary p-1">
          @foreach($user->allPermissions() as $index=>$p)
          {{$p->display_name}}
          {{  $index+1 < $user->allPermissions()->count() ? ' , ': ' '}}
          @endforeach
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <p class="alert alert-secondary p-1">{{$user->nationality}}</p>
      </div>


      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="working_hours" class="form-label">عدد ساعات العمل</label>
        <p class="alert alert-secondary p-1">{{$user->working_hours}}</p>
      </div>


      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="monthly_salary" class="form-label">الراتب الكلى</label>
        <p class="alert alert-secondary p-1">{{$user->monthly_salary}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="monthly_deduct" class="form-label">الراتب الاساسى</label>
        <p class="alert alert-secondary p-1">{{$user->monthly_salary - $user->monthly_deduct}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="monthly_deduct" class="form-label">الإستقطاع</label>
        <p class="alert alert-secondary p-1">{{$user->monthly_deduct}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="vacation_days" class="form-label">أيام الأجازة السنوية</label>
        <p class="alert alert-secondary p-1">{{$user->vacation_days}}</p>
      </div>
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="vacation_days_remains" class="form-label">أيام الأجازة السنوية المتبقى</label>
        <p class="alert alert-secondary p-1">{{$user->vacation_days_remains}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="date_join" class="form-label">تاريخ الإلتحاق</label>
        <p class="alert alert-secondary p-1">{{$user->date_join}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="Employment_contract_expiration_date" class="form-label">تاريخ انتهاء عقد العمل</label>
        <p class="alert alert-secondary p-1">{{$user->Employment_contract_expiration_date}}</p>
      </div>

      <!-- <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_exity_date" class="form-label">تاريخ انتهاء تصريح العمل</label>
        <p class="alert alert-secondary p-1">{{$user->final_clearance_exity_date}}</p>
      </div>


    </div>
  </div>
  <div class="container"> <h4 class=" float-start">بيانات المالية </h4> </div>
  <div class="panel panel-default mt-4">
    <div class="table-responsive">
      <div class="clearfix ">
        <div class="float-start">
            <h6 style="margin: 10px">
                إجمالي القبض :
            </h6>
            <div class="bg-warning m-2 text-center p-2 ">
                {{ $take ?? 0 }}
            </div>
        </div>
        <div class="float-start">
            <h6 style="margin: 10px">
                إجمالي الصرف :
            </h6>
            <div class="bg-warning m-2 text-center p-2 ">
                {{ $spend ?? 0 }}
            </div>
        </div>
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم السند</th>
                    <th>طريقة الدفع</th>
                    <th>المبلغ</th>
                    <th>الضريبة</th>
                    <th>اجمالى المبلغ</th>
                    <th>الوصف</th>
                    <th>تاريخ الأضافة</th>
                  
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($box as $bond)
                    <tr class="print{{ $bond->id }}">
                        <td class="bond-id">{{ $bond->id }}</td>
                        <td class="payment-type">
                            @switch($bond->payment_type)
                                @case('cash')
                                    كــاش
                                @break

                                @case('bank transfer')
                                    تحويل بنكى
                                @break

                                @case('internal transfer')
                                    تحويل داخلى
                                @break

                                @case('selling points')
                                    نقاط بيع
                                @break

                                @case('electronic payment')
                                    دفع إلكترونى
                                @break

                                @default
                                    Default case...
                            @endswitch
                        </td>
                        <td class="money">{{ $bond->money }}</td>
                        <td class="tax">{{ $bond->tax }}</td>
                        <td class="total-money">{{ $bond->total_money }}</td>
                        <td class="descrpition">{{ $bond->descrpition }}</td>
                        <td class="add-date">{{ $bond->add_date }}</td>
                       
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="container"><h4 class=" float-start">المستندات  </h4></div>
<div class="panel panel-default mt-4">
  <div class="table-responsive">
      <table class="table " id="datatable">
          <thead>
              <tr>
                  <th>نوع المستند</th>
                  <th>الموضوع</th>
                  <th>المرفق</th>
                 
                  <th>تاريخ الاضافة</th>                                   
              </tr>
          </thead>
          <tbody>
              @foreach($documents as $document)
              <tr>
                  <td>{{ $document->document_type }}</td>
                  <td>{{ $document->content }}</td>
                  <td>
                      <form  method="GET" action="{{ url('show/pdf') }}">
                              @csrf
                          <input type="hidden" name="url" value="{{'assets/images/users/documents/'.$document->attached}}">
                          <button type="submit" class="btn btn-light" >عرض المرفق</button>
                      </form>
                  </td>
                  
                  <!-- <td>{{ \Carbon\Carbon::parse($document->add_date)->format('d/m/Y') }}</td> -->
                  <td>{{ $document->add_date }}</td>
                  
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>
      <!-- Modal -->
      <div class="modal fade" id="absence-modal" tabindex="-1" aria-labelledby="absence-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container-fluid mt-1 element-center" id="printable">
                    <p class="mb-1 mt-3 pt-1 text-center " style="color: black; font-size: 16px;">أضافة أيام غياب </p>
                    <form method="POST" action="{{ url('covenant/item/delivery/add') }}" id='form'>
                        <input type="hidden" class="dayes_count" name="dayes_count" required>
                        @csrf
                        <p>أيام الغياب</p>
                        <div class="container mycontainer">

                        </div>
                        <div class="row">
                            <div class="mt-2  col" id="end">
                                <label for="number" class="form-label">عدد أيام الغياب</label>
                                <input type="text" name="counter" class="form-control" id="number" required>
                            </div>


                            <div class="mt-4  col">
                                <a type="button" id="add-col" href="#" class="btn mt-3 mb-3 btn-primary ">أضافة تاريخ لكل يوم غياب</a>
                            </div>
                        </div>
                        <button type="submit" id="save-form" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  @endsection

@section('scripts')
<script>
        $(function() {
            $('#add-absence').on('click', function(){
                $('#absence-modal').modal('show');
            });
            $("#save-form").hide();
            $('#add-col').on('click', function() {
                $("#save-form").show();
                var count = $("#end input").val();
                if (count != null) {
                    $(".mycontainer").html('');
                    for (let index = 0; index < count; index++) {
                        $(".mycontainer").append(
                            '<div class="mt-3"><input type="date" name="dates[]" class="form-control"  ></div>'
                            );

                    }
                }
            });

            var listItem = $(".covenant");
            for (var i = 0; i < listItem.length; i++) {
                listItem[i].addEventListener('click', function(e) {
                    var id = $("." + e.target.id + " .id").text();
                    var name = $("." + e.target.id + " .name").text();
                    $("#absence-content").text(name);
                    $(".dayes_count").val(name);
                });
            }
        });
    </script>
@endsection
