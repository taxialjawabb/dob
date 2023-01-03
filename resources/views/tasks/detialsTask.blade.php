
@extends('index')
@section('title','بيانات مهمة')
@section('content')
<div class="mt-3 mb-3 container clearfix">
  <h4 class=" float-start">بيانات المهمة</h4>
</div>

<div class="clearfix"></div>

<div class="container">
    <div class="row">
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">الموضوع</label>
        <p class="alert alert-secondary p-1">{{$task->subject}}</p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">الموضوع</label>
        <p class="alert alert-secondary p-1">{{$task->content}}</p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">تاريخ القراءة</label>
        <p class="alert alert-secondary p-1">{{$task->readed_date??'غير مقروءة'}}</p>
      </div>
      @if($task->finish_date !== null)
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">تاريخ الأنهاء</label>
        <p class="alert alert-secondary p-1">{{$task->finish_date}}</p>
      </div>
      @endif
    </div>

@if(count($results) > 0)
    <h5 class="mt-2">نتائج المهمة</h5>
<div>
    <div class="row">
        
        <div class="panel panel-default mt-2">
          <div class="table-responsive">
              <table class="table " id="datatable">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>أضيف بواسطة</th>
                          <th>المحتوى</th>
                          <th>تاريخ الأضافة</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($results as $index=>$result)
                      <tr class=" {{ $result->type ==='rider'? 'table-dark' :'' }}">
                          <td>{{ ++$index}}</td>
                          <td>
                            {{ $result->name }}
                            {{ $result->type ==='rider'? '(عميل) ' :'' }}
                          </td>                                    
                          <td>{{ $result->content }}</td>
                          <td>{{ $result->addDateIn }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
@endif


  </div>


@endsection

@section('scripts')

@endsection