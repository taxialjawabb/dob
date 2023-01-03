@extends('index')
@section('title', 'أضافة سند')
@section('content')

    <h5 class="mt-4">أضافة سند نقاط بيع</h5>
    <div id="alert">

    </div>
    <form method="POST" action="{{ route('general.add.bond.selling.point') }}" enctype="multipart/form-data">
        @csrf
        <div class="row" id="belongs_to_row">
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="device" class="form-label">جهاز نقاط البيع</label>
                <select name="device" id="device" class="form-select" id="device" required>
                    <option disabled value="" selected>حدد جهاز نقاط البيع</option>
                    @foreach ($covenantItems as $item)
                        <option value="{{ $item->id }}">جهاز رقم:{{ $item->id }} رقم تسلسلى:
                            {{ $item->serial_number }}</option>
                    @endforeach

                </select>
            </div>
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="user" class="form-label">السائق الموجه له السند</label>
                <select name="user" id="user" class="form-select" id="user" readonly required>
                    <option readonly value="" selected> بيانات السائق</option>
                </select>

            </div>

        </div>
        <div class="row" id="printable">
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="bond_type" class="form-label">نوع السند</label>
                <select value="{{ old('bond_type') }}" name="bond_type" id="bond_type" class="form-select"
                    aria-label="Default select example" id="bond_type" required>
                    <option value="take">قـبـض</option>
                    <option value="spend">صــرف</option>
                </select>
            </div>


            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="money" class="form-label">المبلغ</label>
                <input type="text" value="{{ old('money') }}" name="money" class="form-control" id="money"
                    required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="tax" class="form-label">الضرائب</label>
                <input type="text" value="{{ old('tax') ?? 0 }}" name="tax" class="form-control" id="tax"
                    required>
            </div>

            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="total_money" class="form-label">المبلغ الكلى</label>
                <input type="text" value="{{ old('total_money') }}" name="total_money" class="form-control"
                    id="total_money" disabled>
            </div>

            <div class="row">
                <div class="mb-2 col-sm-12 col-lg-6">
                    <label for="message-text" class="col-form-label">الـوصــف:</label>
                    <textarea name="descrpition" value="{{ old('descrpition') }}" class="form-control" id="descrpition" required>{{ old('descrpition') }}</textarea>
                </div>
            </div>
            <div id="spend_bond">
                <div class="row" style="display: none">
                    <div class="mb-3 mt-4 ">
                        <label for="formFile" class="form-label">صورة فاتور الصرف</label>
                        <input class="form-control" type="file" name="image" id="file">
                    </div>
                    <div class="text-center image">
                        <img src="{{ asset('assets/images/pleaceholder/image.png') }}" style="width: 200px; height: 200px"
                            id="profile-img-tag" alt="صورة السائق">
                    </div>
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">حفظ السند</button>
    </form>
    <!-- <button id="print">print</button> -->
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

    <script src="{{ asset('assets/js/addimg.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on("change", '#device', function() {
                var itemId = $(this).val();
                $.ajax({
                    type: 'post',
                    url: '{!! route('selling.point.device.owner') !!}',
                    data: {
                        'item': itemId,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success) {
                            $("#alert").html("");
                            $("#user option:selected").val(data.driver.id);
                            $("#user option:selected").text(data.driver.name);
                            var device = $("#device option:selected").text();


                            $("#descrpition").val("سند قبض من : " + device);
                        } else {
                            $("#alert").html('<div class="alert alert-danger">' + data.message +
                                '</div>')
                        }

                    },
                    error: function(e) {
                        console.log('error');
                        console.log(e);
                    }
                });

            });

            $("#tax").focus(function() {
                $(this).val('');
            });
            $("#tax ,#money").on('input', function() {
                var money = new Number($('#money').val());
                var percentage = new Number($("#tax").val() / 100);
                var tax = percentage * money;
                var total_money = money + tax;
                $('#total_money').val(total_money);
            });
        });
    </script>
@endsection
