<div class="container-fluid">
    <div class="row">
        <div class="col col-xs-12 col-sm-4 col-md-3 col-lg-2">
            حالة المركبة
            <span class="bg-danger">
            @switch($vechiles->state)
                @case('active')
                    مركبة مستلم
                    @break
                @case('waiting')
                    مركبة انتظار
                    @break
                @case('blocked')
                    مركبة مستبعده
                    @break
                @default
                    Default case...
            @endswitch
            </span>
        </div>
        <div class="col col-xs-12 col-sm-4 col-md-3 col-lg-2">
            نوع التصنيف
            <span>
                {{$vechiles->category_name ?? null}}
            </span>
        </div>
        <div class="col col-xs-12 col-sm-4 col-md-3 col-lg-2">
            نوع المركبة
            <span>
                {{$vechiles->vechile_type ?? null}}
            </span>
        </div>
        <div class="col col-xs-12 col-sm-4 col-md-3 col-lg-2">
            سنة الصنع
            <span>
                {{$vechiles->made_in ?? null}}
            </span>
        </div>
    </div>
</div>