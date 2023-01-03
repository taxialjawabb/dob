
@extends('index')
@section('title','إضافة مهمة')
@section('content')
<div class="container">
    <h3 class="m-2 mt-4">أضافة مهمة جديد</h3>
</div>
<form method="POST" action="{{ url('tasks/add') }}">
@csrf
<div class="container">
    <div class="row">

    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="department" class="form-label">القسم الموجه له المهمة</label>
            <select value="{{ old('department') }}" name="department" id="department" class="form-select" aria-label="Default select example" id="department" required>
                <option selected disabled>حدد القسم</option>
                <option value="management">القسم الإدارى</option>
                <option value="technical">القسم التقني</option>
            </select>
    </div>
    
    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="user" class="form-label">موجهة الي</label>
            <select value="{{ old('user_id') }}" name="user_id" id="user" class="form-select" aria-label="Default select example" id="user" required></select>
    </div>


    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="subject" class="form-label">الموضوع المهمة</label>
        <input type="text" value="{{ old('subject') }}" name="subject" class="form-control" id="subject"  required>
    </div>

    <div class="mb-1 col-sm-12 col-lg-6"></div>

    <div class="mb-1 col-sm-12 col-lg-6">
        <label for="description" class="col-form-label">الـوصــف:</label>
        <textarea name="description"  value="{{ old('description') }}"  class="form-control" id="description" required></textarea>
    </div>

    </div>
</div>
@if ($errors->any())
<div class="alert alert-danger m-3 mt-4">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<button type="submit" class="btn btn-primary m-4 ">حفظ </button>
</form>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $(document).on("change", '#department', function(){
        var department = $(this).val();
        var op = " ";
        $.ajax({
          type: 'get',
          url: '{!!URL::to("tasks/user/department")!!}',
          data: {'department':department},
          success: function(data){

            // op += '<option value="0" selected disabled> اختر التصنيف الفرعي</option>';
            for(var i =0 ; i < data.length; i++){
              op += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#user").html(op);
          },
          error:function(e){
            console.log('error');
            console.log(e);
          }
        });
      });
    });
  </script>
@endsection