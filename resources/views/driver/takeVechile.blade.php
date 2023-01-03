
@extends('index')
@section('title','المركبات')
@section('content')
            <div class="container">
                    <h3 class="m-2 mt-4 ">تسليم مركبة للسائق</h3>
                    <div class="clearfix">
                        <p class="h5 float-start">
                        اسم السائق : {{$driver->name}}
                        </p >
                        
                    </div>
                </div>
            <form method="POST" action="{{ url('driver/take/vechile') }}">
            @csrf
            
            <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                <div class="panel mycontainer panel-default row">
                    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                        <label for="main-category" class="form-label">نوع العهده</label>
                        <select name="vechile_id" id="vechile_id" class="form-select" required>
                            <option  disabled value="" selected hidden> رقم لوحة المركبة </option>
                            @foreach($waitingVechiles as $vechile)
                            <option value="{{$vechile->id}}">{{$vechile->plate_number}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="daily_revenue_cost" class="form-label">تكلفة العائد اليومي للمركبة</label>
                        <input type="text" value="{{ old('daily_revenue_cost') }}" name="daily_revenue_cost" class="form-control" id="daily_revenue_cost"  required>
                    </div>

                    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="maintenance_revenue_cost" class="form-label">تكلفة العائد اليومي للصيانة</label>
                        <input type="text" value="{{ old('maintenance_revenue_cost') }}" name="maintenance_revenue_cost" class="form-control" id="maintenance_revenue_cost"  required>
                    </div>
                    
                    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="identity_revenue_cost" class="form-label">تكلفة العائد اليومي للأقامة</label>
                        <input type="text" value="{{ old('identity_revenue_cost') }}" name="identity_revenue_cost" class="form-control" id="identity_revenue_cost"  required>
                    </div>

                    
                </div>
                <button type="submit" class="btn btn-primary p-2 pl-6 mt-4 pr-6">أضافة المركبة</button>
                <a href="#" type="submit" class="btn btn-dark p-2 pl-6 mt-4 pr-6" id="add-covenant">أضافة عهده</a>
                <a href="#" type="submit" class="btn btn-dark p-2 pl-6 mt-4 pr-6" id="remove-covenant">إزالة عهده</a>
            </form>
                

@endsection

@section('scripts')
<script>

    $(document).ready( function () {
        $(document).on("click",".tools", function (e) {
            $(document).on("change", '#'+e.target.id, function(){
                var covenant = $(this).val();
                var op = " ";
                $.ajax({
                type: 'get',
                url: '{!!URL::to("covenant/select/item")!!}',
                data: {'id':covenant},
                success: function(data){
                    // console.log(data);
                    // return 0;
                    op += '<option  disabled value="" selected hidden> حدد العهده المستلمة</option>';
                    for(var i =0 ; i < data.length; i++){
                        var serial = data[i].serial_number == null ? 'لا يوجد رقم تسلسلى': data[i].serial_number;
                        op += '<option value="'+data[i].id+'">'+data[i].id+' : '+serial+'</option>';
                    }
                    $("."+e.target.id).html(op);
                },
                error:function(e){
                    console.log('error');
                    console.log(e);
                }
                });
            });
        });
        
    });
</script>
<script>
    $(function() {
        var index = 0;
        $('#add-covenant').on('click', function(){
            
            $(".mycontainer").append(`
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="main-category" class="form-label">نوع العهده</label>
                <select name="covenant_name[]" id="covenant_name`+index+`"  required class="tools form-select  ">
                    <option    disabled value="" selected hidden> حدد نوع العهده </option>
                    @foreach($allCovenant as $c)
                    <option value="{{$c->covenant_name}}">{{$c->covenant_name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="secondary-category" class="form-label">العهد المستلمة</label>
                <select  name="covenant_item[]" class="form-select covenant_name`+index+`" required>
                    <option    disabled value="" selected hidden> حدد العهده المستلمة</option>
                </select>
            </div>
            `);
            index++;
        });
        $('#remove-covenant').on('click', function(){ 
            if(index  > 0){
                $(".mycontainer").children().last().remove();
                $(".mycontainer").children().last().remove();
                --index;
            }
        });

     
        
    
    });
</script>


@endsection