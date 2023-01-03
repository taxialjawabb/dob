@extends('index')
@section('title','إضافة دور')
@section('content')
<div class="container">
    <h3 class="m-1 mt-4">أضافة دور جديد </h3>
</div>
<form method="POST" action="{{ url('user/roles/update') }}">
    @csrf
    <input type="hidden" name="role_id" value="{{$role->id}}">
    <div class="container">
        <div class="row">

            <div class="mt-2  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="display_name" class="form-label">اسم الدور</label>
                <input type="text" value="{{ $role->display_name }}" name="display_name" class="form-control"
                    id="display_name" required>
            </div>

            <div class="row">
                <div class="mb-1 col-sm-12 col-lg-6">
                    <label for="description" class="col-form-label">الـوصــف:</label>
                    <textarea name="description" value="{{ $role->description }}" class="form-control" id="description"
                        required>{{ $role->description }}</textarea>
                </div>
            </div>
            <div class="container border border-primary border-1  rounded-3 mt-4 p-3">
                <div class="row">

                    @for($i=0;$i<count($permissions);$i++) @if ($permissions[$i]->id==1)
                        <br />
                        <h2>
                            العملاء
                            @php
                            $class = 'client'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="{{ $class }}"
                                id="client">
                        </h2>
                        @elseif ($permissions[$i]->id==100)
                        <br /><br /><br />
                        <hr>
                        <h2>
                            السائقين
                            @php
                            $class = 'driver'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="driver">
                        </h2>
                        @elseif ($permissions[$i]->id==200)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            المركبات
                            @php
                            $class = 'vechile'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="vechile">
                        </h2> <br />
                        @elseif ($permissions[$i]->id==250)
                        <br /> <br /> <br /><hr>
                            <h2>
                            تصنيف المركبات
                            @php
                            $class = 'cat-vechile'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="cat-vechile">
                        </h2>
                        <br />

                        @elseif ($permissions[$i]->id==300)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            الطـلـبـات
                            @php
                            $class = 'request'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="request">
                        </h2> <br />
                        @elseif ($permissions[$i]->id==400)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            الفواتيــر
                            @php
                            $class = 'bills'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="bills">
                        </h2> <br />

                        @elseif ($permissions[$i]->id==500)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            التحويلات البنكيه
                            @php
                            $class = 'bank-transfer'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value=""
                                id="bank-transfer">
                        </h2> <br />
                        @elseif ($permissions[$i]->id==600)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            المهام
                            @php
                            $class = 'tasks'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="tasks">

                        </h2> <br />
                        @elseif ($permissions[$i]->id==700)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            المستخدمين
                            @php
                            $class = 'users'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="users">
                        </h2> <br />
                        @elseif ($permissions[$i]->id==1600)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            العهد
                            @php
                            $class = 'covenant'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="covenant">
                        </h2> <br />
                        @elseif($permissions[$i]->id==800)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            الصادر والوارد
                            @php
                            $class = 'import-export'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value=""
                                id="import-export">
                        </h2> <br />
                        @elseif($permissions[$i]->id==900)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            التنبهات
                            @php
                            $class = 'alerts'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="alerts">
                        </h2> <br />

                        @elseif($permissions[$i]->id==1000)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            الجهات
                            @php
                            $class = 'stakeholders'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value=""
                                id="stakeholders">
                        </h2> <br />
                        @elseif($permissions[$i]->id==1100)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            مركز الصيانه
                            @php
                            $class = 'maintanence'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="maintanence">
                        </h2> <br />
                        @elseif($permissions[$i]->id==1200)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            الاشتركات
                            @php
                            $class = 'booking'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="booking">
                        </h2> <br />
                        @elseif($permissions[$i]->id==1300)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            المجموعات
                            @php
                            $class = 'groups'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="groups">
                        </h2> <br />
                        @elseif($permissions[$i]->id==1400)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            الدعايه والتسويق
                            @php
                            $class = 'marketing'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="marketing">

                        </h2> <br />
                        @elseif($permissions[$i]->id==1500)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                            الرسائل
                            @php
                            $class = 'massages'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="massages">

                        </h2> <br />


                        @elseif($permissions[$i]->id==1800)
                        <br /> <br /> <br />
                        <hr>
                        <h2>
                        الصلاحيات العامة للوحة التحكم
                            @php
                            $class = 'general'
                            @endphp
                            <input class="form-check-input main-role  {{ $class  }}" name="" type="checkbox" value="" id="general">

                        </h2> <br />

                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-check mt-2">
                                <input name="id[]" type="checkbox"
                                    class="form-check-input {{ $class  }}  checkbox{{$permissions[$i]->id}}"
                                    value="{{$permissions[$i]->id}}" id="{{$permissions[$i]->name}}" {{
                                    $role->hasPermission($permissions[$i]['name']) ? 'checked' : ''}}>
                                <label class="form-check-label text-dark" for="{{$permissions[$i]->name}}">
                                    {{$permissions[$i]->display_name}}
                                </label>
                            </div>
                        </div>
                        @endfor

                </div>
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
    <button type="submit" class="btn btn-primary m-4 ">حفظ الدور</button>
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
    var listItem = $(".main-role");
            for (var i = 0; i < listItem.length; i++) {
                listItem[i].addEventListener('click', function(e) {
                    if($("." +e.target.id).prop('checked')){
                        $("." +e.target.id).prop('checked', true);
                    }
                    else{
                        $("." +e.target.id).prop('checked', false);
                    }
                });
            }
});
</script>

@endsection
