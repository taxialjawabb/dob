<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta HTTP-EQUIV="Content-language" CONTENT="ar">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous"> -->

    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/kt-2.6.4/r-2.2.9/datatables.min.css"/> -->

    <link href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sidebars.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col col-md-4 col-sm-5 col-xs-6 no-print">
                <x-navbar></x-navbar>
            </div>
            <div class="col-xxl-10 col-xl-9 col-md-8 col-sm-7 col-xs-6">
                @if (Session::has('status'))
                    <div class="alert alert-success m-3" role="alert">
                        {{ Session::get('status') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger m-3">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/kt-2.6.4/r-2.2.9/datatables.min.js">
    </script> -->
    <script src="{{ asset('assets/js/bootstrap-hijri-datetimepicker.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('assets/js/sidebars.js') }}"></script>
</body>

</html>
