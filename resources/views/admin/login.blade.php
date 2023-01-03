<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>تسجيل الدخول</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">

</head>

<body>

    <div class="container" style="margin-top: 100px; margin-bottom: 30px; min-height: 400px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>تسجيل الدخول</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            @csrf
                            <div class="form-group row mt-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">رقم الهاتف</label>

                                <div class="col-md-6">
                                    <input id="phone" type="phone"
                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        name="phone" value="{{ old('phone') }}" required autofocus>

                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <label for="password" class="col-md-4 col-form-label text-md-right">كلمة المرور</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                    <div class="col-md-6 offset-md-4 ">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                            <div class="alert text-danger m-3" id="alert">

                            </div>
                            <div class="form-group row mb-0 mt-3">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success ">
                                        تسجيل الدخول
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="verification_code_div" tabindex="-1" role="dialog"
        aria-labelledby="verification_code_divLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verification_code_divLabel">رقم كود التحقيق </h5>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="mt-2 mb-3 col-12 ">
                            <label for="verification_code" class="col-md-4 col-form-label text-md-right">كود
                                التحقيق</label>

                            <div class="col-md-6">
                                <input id="verification_code_inp" type="verification_code"
                                    class="form-control{{ $errors->has('verification_code') ? ' is-invalid' : '' }}"
                                    name="verification_code" value="{{ old('verification_code') }}">

                                @if ($errors->has('verification_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('verification_code') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="alert text-danger m-1" id="alert-confirm">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success " id="verification_code">
                            تأكيد الدخول
                        </button>
                        <a class="btn btn-secondary close-modal" data-dismiss="modal">إلغاء</a>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#alert").hide();
            $("#alert-confirm").hide();

        var userCode;
        var count = 0;
        $('form').on('submit', function(e){
                e.preventDefault();
                var user = $(this).serializeArray();

            $.ajax({
                type: 'post',
                url: '{!!URL::to("/user/send/code")!!}',
                data: user,
                success: function(data){
                    // console.log(data);
                    if(data.success === true){
                        userCode = data.code;
                        $('#verification_code_div').modal('show');

                    }else{
                        if(data.errorNum == 'E100'){
                            userCode = data.message;
                            $('#verification_code_div').modal('show');
                            $("#alert-confirm").show();
                            $("#alert-confirm").text("لقد تم أرسال الكود من قبل يجب ان يمر 10 دقائق لأرسال كود اخر");

                        }
                        else{
                            $("#alert").show();
                            $("#alert").text(data.message);
                        }
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
            });
            $('#verification_code').on('click', function(){

                var user = $('form').serializeArray();
                var inp = $("#verification_code_inp").val();
               count++;
                if(inp == userCode){
                    $.ajax({
                        type: 'post',
                        url: '{!!route("login")!!}',
                        data: user,
                        success: function(data){
                            // console.log(data);
                            if(data.success === true){
                                if(data.page == 'home'){
                                    window.location.href = '{!!URL::to("/home")!!}';
                                }
                                else
                                {
                                    window.location.href = '{!!URL::to("groups/user/'+data.page+'")!!}';
                                }

                            }
                            else{
                                $("#alert-confirm").show();
                                $("#alert-confirm").text(data.message);
                            }
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });
                }
                else if (count > 5){
                    $("#alert-confirm").text("تم تجاوز الحد المسموح به للتحقيق");
                    setTimeout(() => {
                        window.location.href = '{!!URL::to("/control/panel/login")!!}';
                    }, 5000);
                }
                else{
                    $("#alert-confirm").show();
                    $("#alert-confirm").text("الرجاء التحقق من رقم التأكيد");
                }

            });
         });

    </script>
</body>

</html>
