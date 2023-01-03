<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>About</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta property="og:image" content="{{ asset('assets/images/pleaceholder/taxi2.jpg') }}">
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="title" content="الجواب للنقل البري">
    <meta name="description" content="شركة الجواب للنقل البري هى شركة واحدة من اكبر الشركات للنقل البرى داخل المدينة المنورة تستطيع من خلالها عمل رحلات داخلية داخل المدينة المنورة او رحلات بين المدن او القيام بأشتراك شهرى بيها العديد من المميزات الامان والكفاءة والسرعة فى تنفيذ الطلبات مع باقات واسعار منخفضة  خدمة متوفرة على مدار 24 ساعة." >
    <meta name="keywords" content="نقل, تاكسي, تاكسى, اجرة, أجرة">
    <meta name="author" content="Ahmed Marey">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/about.css') }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'noto';
            src: asset('assets/fonts/NotoNaskhArabic-VariableFont_wght.ttf');
        }

        * {
            font-family: 'noto';
        }
    </style>
</head>

<body class="" id="top">
    <div class="ps-4 pt-2 pb-2 bg-green">
        <p class=" text-light h2">الجواب للنقل البري</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                <img src="{{ asset('assets/images/pleaceholder/taxi1.jpg') }}" class="img-fluid" alt="تاكسى الجواب">
            </div>
            <div class="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-xs-12 align-self-center">
                <h1 class="text-center text-oringe">تطبيقاتنا</h1>
                <div class="clearfix">
                    <div class="float-start mx-auto">
                        <a href="{{ url('/android/client') }}" class="btn p-0">
                            <img src="{{ asset('assets/images/pleaceholder/googleplay.png') }}" class="img-fluid"
                                alt="تاكسى الجواب" style="width: 260px; height: 80px;">
                        </a>
                    </div>
                    <div class="float-start">
                        <a href="{{ url('/ios/client') }}" class="btn p-0">
                            <img src="{{ asset('assets/images/pleaceholder/apps.png') }}" class="img-fluid"
                                alt="تاكسى الجواب" style="width: 260px; height: 80px;">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                <h2 class="text-oringe">من نحن</h2>
                <p class="h5">
                    شركة الجواب للنقل البرى هى واحده من اكبر الشركات للنقل البرى داخل المدينة المنورة، 
                    توفر لك شركة الجواب العديد من المميزات من خلالها تسطيع القيام برحلات داخل المدينة المنورة بأسعار منخفضة وتحديد نوع المركبة التريد تريد الذهاب بها مع سرعة فى استجابة الطلب وسائقين ذات كفاءة عالية و مركبات بها جميع  الرفيهات معها اجهزة تتبع و كاميرات مراقبة رحلتك دائما فى امان، 
                    ليس هذا فقط ما نقدمة بل يمكنك طلب رحلة للذهاب الى مدينة اخرى (رحلات بين المدن) مع تحديد فئة المركبة وموعد الذهاب والحجز ايضا يشمل اذا كان الرحلة ذهاب فقط او ذهاب وعودة،
                    لا تتوقف شركة الجواب عند هذا الحد من خدمة عملائها حيث تم توفير نظام الاشتراك الشهرى او عدد ايام معين يستطيع العميل من خلاله تحديد ايام الاشتراك و تحديد فئة المركبة  تحديد وقت الاشتراك أذا كان ذهاب فقط او ذهاب وعودة مع توفير الامكانات لخدمة العميل على اكمل وجه.
                </p>
            </div>

            <div class="col-xxl-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                <img src="{{ asset('assets/images/pleaceholder/taxi2.jpg') }}" class="img-fluid" alt="تاكسى الجواب">
            </div>
        </div>
    </div>

    {{-- our service we provide --}}
    <section class=" bg-green" id="services">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="text-center services-card">
                        <h3 class="text-light">ألامــــان</h3>
                        <div class="icon">
                            <i class="fa fa-shield"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="text-center services-card">
                        <h3 class="text-light">اسعار منخفضة</h3>
                        <div class="icon">
                            <i class="fa fa-usd" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="text-center services-card">
                        <h3 class="text-light">سرعة الاستجابة</h3>
                        <div class="icon">
                            <i class="fa fa-bolt" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="text-center services-card">
                        <h3 class="text-light">خدمة 24 ساعة</h3>
                        <div class="icon">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="list-services">
        <div class="container">
            <h2 class="text-oringe">خدماتنا</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    <p>
                        <button id="internal-trip" class="btn text-oringe btn-custom" type="button" data-bs-toggle="collapse" data-bs-target="#internal" aria-expanded="true" aria-controls="internal">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                            رحلات داخل المدينة المنورة
                        </button>
                    </p>
                    <div class="collapse show" id="internal">
                        <div class="card card-body">
                            أذا كنت من سكان المدنية المنورة يمكن عمل رحلات داخل المدينة المنورة بسرعة فى الاستجابة لطلبك بتكلفة منخفضة و تحديد نوع السياة التى تريد ان تقوم بيها وتحديد تصنيف السيارة الأقتصادية او عائلية او Vip.
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <p>
                        <button id="city-trip" class="btn text-oringe btn-custom" type="button" data-bs-toggle="collapse" data-bs-target="#city" aria-expanded="true" aria-controls="city">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                            رحلات بين المدن
                        </button>
                    </p>
                    <div class="collapse show" id="city">
                        <div class="card card-body">
                            أذا كنت داخل المدينة المنورة و وتريد بعمل رحلة إلى مدينة اخرى فى المملكة العربية السعودية يمكن حجز رحلة بين المدن و أيضا تحديد أذا كانت الرحلة ذهاب او ذهاب و عودة مع تحديد تاريخ الذهاب والعودة بتكلفة منخفضة و تحديد نوع السياة التى تريد ان تقوم بيها وتحديد تصنيف السيارة الأقتصادية او عائلية او Vip.
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <p>
                        <button id="booking-trip" class="btn text-oringe btn-custom" type="button" data-bs-toggle="collapse" data-bs-target="#booking" aria-expanded="true" aria-controls="booking">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                            حجز أشتراكات للرحلات
                        </button>
                    </p>
                    <div class="collapse show" id="booking">
                        <div class="card card-body">
                            تريد الذهاب للعمل بشكل يوم وتقليل تكلفة الرحلات شركة الجواب وفرت لك ميزة جديدة وهى الاشتراك فى فترة دروية مع تحديد نوع الاشتراك ذهاب او ذهاب وعودة مع متحديد تصنيف السيارة 
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <footer>
        <div class="footer">
            <div class="icon">
                <i class="fa fa-snapchat"></i>
            </div>
            <div class="icon">
                <i class="fa fa-facebook" aria-hidden="true"></i>
            </div>
            <div class="icon">
                <i class="fa fa-google"></i>
            </div>
            <div class="icon">
                <i class="fa fa-twitter"></i>
            </div>

            <p class="pt-3 m-0">حقوق الطباعة والنشر محفوظ لشركة الجواب للنقل البرى</p>
            <span>Copyright &copy; TaxiAljwab Team.</span>

        </div>
    </footer>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/about.js') }}"></script>
</body>

</html>