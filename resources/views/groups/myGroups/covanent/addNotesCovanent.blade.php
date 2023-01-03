
@extends('index')
@section('title','اضافه ملاحظه للعهدة')
@section('content')
<h5 class="mt-4">أضافة ملاحظة لعهدة</h5>

<form  method="POST" action="{{ route('my.groups.covenant.save.notes',['group'=>$group]) }}"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="groups_covenant_record_id" value="{{ $id }}">
    <div class="row">
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="state" class="form-label">حدد حالة العهد </label>
            <select value="{{ old('note_state') }}" name="note_state" id="state" class="form-select" aria-label="Default select example" id="stakeholder_id" required>
                <option  value="" disabled selected> حدد نوع الملاحظة  </option>
                <option value="waiting">قيد الانتظار</option>
                <option value="active">يعمل مع سائق</option>
                <option value="broken">معطل</option>
                <option value="damage">أتلاف</option>
                <option value="repair">أصلاح</option>
                <option value="theft">سرقة</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="mt-2 mb-3 col-sm-12 col-lg-6">
            <label for="subject" class="form-label">الموضوع</label>
            <input type="text" value="{{ old('subject') }}" name="subject" class="form-control" id="subject"  required>
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-12 col-lg-6">
            <label for="content" class="col-form-label">الـوصــف:</label>
            <textarea name="content"  value="{{ old('content') }}"  class="form-control" id="content" required></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">حفظ الملاحظة</button>
</form>
@if ($errors->any())
    <div class="alert alert-danger m-3 mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  
@endsection

@section('scripts')

@endsection