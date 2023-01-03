<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *               php artisan db:seed --class=PermissionSeeder
     *
     *
     * @return void
     */
    public function run()
    {


        //العملاء 0--8--
        $editUser = Permission::create([
             'id' =>1,
            'name' => 'rider_data',
            'display_name' => 'العملاء', // optional
            'description' => 'يستطيع المستخدم الوصول لبيانات الركاب سواء عرض او تعديل حالة الراكب ', // optional

        ]);

        $editUser3 = Permission::create([  'id' =>2,
        'name' => 'rider_details',
        'display_name' => 'عرض بيانات العميل', // optional
        'description' =>  'يستطيع المستخدم  يمكن عرض بيانات العميل', // optional
    ]);
        $editUser = Permission::create([
            'id' =>3,
            'name' => 'rider_document_notes',
            'display_name' => 'المستندات و الملاحظات للعميل', // optional
            'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات للراكب سواء عرض او أضافة',
        ]);
        $editUser3 = Permission::create([  'id' =>4,
        'name' => 'rider_note_docs_add_new',
        'display_name' => ' اضافه ملاحظه او مستند للعميل', // optional
        'description' =>  'يستطيع المستخدم  يمكن  اضافه ملاحظه العميل', // optional
        ]);
        $editUser = Permission::create([
            'id' =>5,
            'name' => 'rider_box',
            'display_name' => 'صندوق العميل', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق الراكب سواء عرض او اضافة سند', // optional
        ]);


        $editUser3 = Permission::create([  'id' =>6,
            'name' => 'rider_box_add_new',
            'display_name' => 'اضافة صندوق العميل', // optional
            'description' =>  'يستطيع المستخدم  يمكن اضافة صندوق العميل', // optional
        ]);


        $editUser3 = Permission::create([  'id' =>7,
            'name' => 'rider_update',
            'display_name' => 'تعديل بيانات العميل', // optional
            'description' =>  'يستطيع المستخدم  يمكن تعديل بيانات العميل', // optional
        ]);
        $editUser3 = Permission::create([  'id' =>8,
            'name' => 'rider_trip',
            'display_name' => 'عرض بيانات رحلات العميل', // optional
            'description' =>  'يستطيع المستخدم  يمكن عرض بيانات  رحلات العميل', // optional
        ]);


        //السائقين   ////////////////////////////////////////////////////////////////////////
        $editUser = Permission::create([
            'id'=>100,
            'name' => 'driver_data',
            'display_name' => ' بيانات السائقين', // optional
            'description' => 'يستطيع المستخدم الوصول لبيانات المستخدم سواء عرض او أضافة او تعديل عرض المركبات المستلمة تحويل حالة السائق', // optional
        ]);


        $editUser3 = Permission::create([ 'id'=>101,
        'name' => 'driver_show_active',
        'display_name' => 'السائقين المستلمين', // optional
        'description' => 'يستطيع المستخدم عرض السائقين النشط ', // optional
    ]);

        $editUser3 = Permission::create([ 'id'=>102,
        'name' => 'driver_show_watting',
        'display_name' => 'انتظار السائقين ', // optional
        'description' => 'يستطيع المستخدم عرض السائقين ف حاله الانتظار ', // optional
    ]);


      $editUser3 = Permission::create([ 'id'=>103,
      'name' => 'driver_show_blocked',
      'display_name' => 'السائقين المستبعدين ', // optional
      'description' => 'يستطيع المستخدم عرض السائقين المحظورين ', // optional
  ]);
    $editUser = Permission::create([ 'id'=>104,
        'name' => 'recently_driver',
        'display_name' => '  السائقين  بأنتظار الموافقة', // optional
        'description' => 'يستطيع المستخدم من خلالها عرض السائقين المسجلين حديثا', // optional
    ]);

        $editUser = Permission::create([ 'id'=>105,
        'name' => 'contract_manage',
        'display_name' => ' عقود التأجير', // optional
        'description' => 'يستطيع المستخدم ادراة العقود  انشاء عقد جديد او تمديد عقد او انهاء عقد او عرض بيانات العقد', // optional
    ]);

    $editUser = Permission::create([ 'id'=>106,
        'name' => 'driver_counts',
        'display_name' => 'احصائية السائقين العملاء', // optional
        'description' => 'يستطيع المستخدم من خلالها عرض تقرير أعداد العملاء و السائقين', // optional
    ]);
    $editUser3 = Permission::create([ 'id'=>107,
    'name' => 'driver_show_notes',
    'display_name' => '   ملاحظات السائقين ', // optional
    'description' => 'يستطيع المستخدم عرض  ملاحظات السائقين  ', // optional
]);
    $editUser = Permission::create([ 'id'=>108,
    'name' => 'driver_reports',
    'display_name' => 'تقرير قبض السائقين  ', // optional
    'description' => 'يستطيع المستخدم من خلالها عرض اجمالى القبض للسائق خلال فترة معينة', // optional
]);
    $editUser = Permission::create([ 'id'=>109,
    'name' => 'driver_debits',
    'display_name' => 'السائقين المتعثرين', // optional
    'description' => 'يستطيع المستخدم من خلالها عرض السائقين المتعثرين والمتخالفين عن دفع مبلغ معين ', // optional
]);


$editUser3 = Permission::create([ 'id'=>110,
    'name' => 'driver_show_available',
    'display_name' => ' السائقين المتاحين', // optional
    'description' =>  '   يستطيع المستخدم عرض السائقين المتاحين ', // optional
      ]);

      $editUser3 = Permission::create([ 'id'=>111,
      'name' => 'driver_add_new_driver',
      'display_name' => 'اضافه سائق جديد', // optional
      'description' =>  'يستطيع المستخدم اضافه سائق جديد', // optional
  ]);







        $editUser1 = Permission::create([ 'id'=>112,
            'name' => 'driver_data_show',
            'display_name' => 'عرض  تفاصيل بيانات السائق', // optional
            'description' => 'يستطيع المستخدم عرض جميع بيانات السائق', // optional
        ]);

        $editUser = Permission::create([ 'id'=>113,
            'name' => 'driver_document_notes',
            'display_name' => 'المستندات و الملاحظات للسائقين', // optional
            'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات للسائق سواء عرض او أضافة', // optional
        ]);

        $editUser3 = Permission::create([ 'id'=>114,
            'name' => 'driver_add_note_docs',
            'display_name' => 'اضافه ملاحظه او مستند لسائق', // optional
            'description' =>  'يستطيع المستخدم اضافه ملاحظه  او مستند لسائق', // optional
        ]);

        $editUser = Permission::create([ 'id'=>115,
            'name' => 'driver_box',
            'display_name' => 'صندوق السائقين', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق السائق سواء عرض او أضافة سند', // optional
        ]);

        $editUser3 = Permission::create([ 'id'=>116,
            'name' => 'driver_add_box',
            'display_name' => 'اضافه صندوق لسائق', // optional
            'description' =>  'يستطيع المستخدم  اضافه سند  السائق', // optional
        ]);

        $editUser3 = Permission::create([ 'id'=>117,
            'name' => 'driver_print_box',
            'display_name' => ' طباعه صندوق سائق', // optional
            'description' =>  'يستطيع المستخدم  طباعه صندوق  السائق', // optional
        ]);

        $editUser = Permission::create([ 'id'=>118,
        'name' => 'driver_take_vechile',
        'display_name' => 'تسليم مركبة للسائق', // optional
        'description' => 'يستطيع المستخدم من خلالها', // optional
        ]);

        $editUser3 = Permission::create([ 'id'=>119,
            'name' => 'driver_convert_status',
            'display_name' => 'تحويل حاله السائق', // optional
            'description' =>  '  يستطيع المستخدم تحويل حاله السائق الي مستبعد او انتظار', // optional
        ]);

        $editUser3 = Permission::create([ 'id'=>120,
        'name' => 'driver_vechial_delivered',
        'display_name' => '  المركبات المستلمه لسائق', // optional
        'description' =>  '  يستطيع المستخدم عرض المركبات المستلمه لسائق', // optional
        ]);
     $editUser3 = Permission::create([ 'id'=>121,
            'name' => 'driver_covenant_delivered',
            'display_name' => 'عرض العهد المستلمة', // optional
            'description' =>  '  يستطيع المستخدم عرض العهد المستلمه لسائق', // optional
        ]);
        $editUser3 = Permission::create([ 'id'=>122,
        'name' => 'driver_update_data',
        'display_name' => 'تعديل بيانات السائق', // optional
        'description' =>  'يستطيع المستخدم  تعديل بيانات السائق', // optional
        ]);

        $editUser3 = Permission::create([ 'id'=>123,
        'name' => 'driver_add_convenant',
        'display_name' => 'اضافه عهد لسائق', // optional
        'description' =>  'يستطيع المستخدم اضافه عهد لسائق', // optional
    ]);

    $editUser3 = Permission::create([ 'id'=>124,
        'name' => 'driver_add_note_convenant',
        'display_name' => 'اضافه ملاحظه لعهده السائق', // optional
        'description' =>  'يستطيع المستخدم اضافه  ملاحظه لعهده السائق', // optional
    ]);
    $editUser3 = Permission::create([ 'id'=>125,
        'name' => 'driver_show_convenant_note',
        'display_name' => 'عرض ملاحظات عهد السائق', // optional
        'description' =>  'يستطيع المستخدم يعرض ملاحظات التي تمت اضاتفتها للعهد السائق', // optional
    ]);


        $editUser = Permission::create([ 'id'=>127,
            'name' => 'maintenance_outdoor',
            'display_name' =>  'عرض الصيانات المدخلة من خلال التطبيق', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض الصيانات الخارجية للسائق', // optional
        ]);

        $editUser2 = Permission::create([ 'id'=>128,
            'name' => 'driver_maintain_show',
            'display_name' => 'صيانات السائق الخاص بمركز الصيانة', // optional
            'description' => ' يستطيع المستخدم عرض جميع الصيانات الخاص بالسائق ', // optional
        ]);
        $editUser3 = Permission::create([ 'id'=>129,
            'name' => 'driver_maintain_add',
            'display_name' => 'اضافه صيانه لسائق ', // optional
            'description' => 'يستطيع المستخدم اضافه صيانه لسائق خاص بمركز الصيانه ', // optional
        ]);

        $editUser3 = Permission::create([ 'id'=>130,
        'name' => 'driver_sample_data',
        'display_name' => 'طباعة نموذج لسائق', // optional
        'description' => 'يستطيع المستخدم طباعة نموذج لسائق ', // optional
        ]);
        $editUser3 = Permission::create([ 'id'=>131,
        'name' => 'driver_delegate_data',
        'display_name' => 'طباعة تفويض لسائق', // optional
        'description' => 'يستطيع المستخدم طباعة تفويض لسائق', // optional
        ]);


        //المركبات

        $editUser = Permission::create([
            'id'=>200,
            'name' => 'vechile_data',
            'display_name' => 'بيانات المركبات', // optional
            'description' => 'يستطيع المستخدم الوصول لبيانات التصنيفات و المدن سواء عرض او أضافة او تعديل', // optional
        ]);

        $editUser3 = Permission::create(['id'=>201,
            'name' => 'vechile_show',
            'display_name' => 'عرض المركبات', // optional
            'description' =>  'يستطيع المستخدم يعرض المركبات بجميع انواعها', // optional
        ]);

        $editUser3 = Permission::create(['id'=>202,
        'name' => 'vechile_show_detials',
        'display_name' => 'عرض بيانات المركبه', // optional
        'description' =>  'يستطيع المستخدم عرض بيانات المركبه', // optional
        ]);
        $editUser3 = Permission::create(['id'=>203,
        'name' => 'vechile_add_new',
        'display_name' => 'اضافه مركبه جديده', // optional
        'description' =>  'يستطيع المستخدم    اضافه مركبه جديه', // optional
         ]);


        $editUser = Permission::create(['id'=>204,
            'name' => 'vechile_document_notes',
            'display_name' => 'المستندات و الملاحظات للمركبات', // optional
            'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات سواء عرض او أضافة او تعديل', // optional
        ]);
        $editUser3 = Permission::create(['id'=>205,
            'name' => 'vechile_add_notes_docs',
            'display_name' => 'اضافه ملاحظه او مستند للمركبه', // optional
            'description' =>  '  يستطيع المستخدم اضافه ملاحظه المركبه  ', // optional
        ]);

        $editUser = Permission::create(['id'=>206,
            'name' => 'vechile_box',
            'display_name' => 'صندوق المركبات', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق المركبة و عرض و أضافة سند', // optional
        ]);

        $editUser3 = Permission::create(['id'=>207,
        'name' => 'vechile_add_new_box',
        'display_name' => 'اضافه سند جديد لصندوق المركبه ', // optional
        'description' =>  '  يستطيع المستخدم اضافه سند جديد لصندوق المركبه  ', // optional
                     ]);

            $editUser3 = Permission::create(['id'=>208,
            'name' => 'vechile_print_box',
            'display_name' => 'طباعه سند من صندوق المركبه', // optional
            'description' =>  '  يستطيع المستخدم طباعه سند من صندوق المركبه  ', // optional
        ]);

        $editUser3 = Permission::create(['id'=>209,
            'name' => 'vechile_convert_status',
            'display_name' => '  تحويل حاله السياره', // optional
            'description' =>  'يستطيع المستخدم تحويل حاله السياره', // optional
        ]);
        $editUser3 = Permission::create(['id'=>210,
            'name' => 'vechile_show_maintain',
            'display_name' => 'عرض صيانه المركبه', // optional
            'description' =>  'يستطيع المستخدم عرض بيانات صيانه لهذه المركبه', // optional
        ]);
        $editUser3 = Permission::create(['id'=>211,
            'name' => 'vechile_show_driver_delivered',
            'display_name' => 'عرض سائقين مستلمين لهذه المركبه', // optional
            'description' =>  'يستطيع المستخدم عرض المستلمين لهذه المركبه', // optional
        ]);
        $editUser3 = Permission::create(['id'=>212,
            'name' => 'vechile_update',
            'display_name' => 'تعديل بيانات المركبه', // optional
            'description' =>  'يستطيع المستخدم تعديل بيانات المركبه', // optional
        ]);

        $editUser3 = Permission::create(['id'=>213,
            'name' => 'vechiles_show_all',
            'display_name' => 'عرض جميع  المركبات', // optional
            'description' =>  'يستطيع المستخدم عرض جميع  المركبات', // optional
        ]);
        $editUser3 = Permission::create(['id'=>214,
            'name' => 'vechiles_show_excluded',
            'display_name' => '  عرض المركبات المستبعده', // optional
            'description' =>  'يستطيع المستخدم عرض المركبات  المستبعده', // optional
        ]);
        $editUser3 = Permission::create(['id'=>215,
        'name' => 'vechiles_show_received',
        'display_name' => '  عرض المركبات المستلمه', // optional
        'description' =>  'يستطيع المستخدم عرض المركبات  المستلمه', // optional
         ]);
        $editUser3 = Permission::create(['id'=>216,
        'name' => 'vechiles_show_waiting',
        'display_name' => '  عرض المركبات المنتظره', // optional
        'description' =>  'يستطيع المستخدم عرض المركبات  المنتظره', // optional
         ]);



        $createPost = Permission::create(['id'=>250,
        'name' => 'category_city',
        'display_name' => 'التصنيفات و المدن', // optional
        'description' => 'يستطيع المستخدم الوصول لبيانات التصنيفات و المدن سواء عرض اوأضافة او تعديل عرض السائقين المستلمين تحويل حالة المركبة', // optional
    ]);
        $editUser3 = Permission::create(['id'=>251,
            'name' => 'vechile_add_new_category',
            'display_name' => 'اضافه تصنيف جديد للمركبات', // optional
            'description' =>  '  يستطيع المستخدم اضافه  تصنيف للمركبات جديد  ', // optional
        ]);
        $editUser3 = Permission::create(['id'=>252,
            'name' => 'vechile_add_new_sub_category',
            'display_name' => 'اضافه تصنيف  فرعي جديد للمركبات', // optional
            'description' =>  '  يستطيع المستخدم اضافه  تصنيف فرعي للمركبات جديد  ', // optional
        ]);



        $editUser3 = Permission::create(['id'=>253,
            'name' => 'vechile_show_category_detail',
            'display_name' => 'عرض بيانات التصنيف الرئيسي', // optional
            'description' =>  '  يستطيع المستخدم عرض بيانات التصنيف الرئيسي ', // optional
        ]);
        $editUser3 = Permission::create(['id'=>254,
            'name' => 'vechile_update_category',
            'display_name' => 'تعديل التصنيف الرئيسي', // optional
            'description' =>  '   يستطيع المستخدم تعديل التصنيف الرئيسي ', // optional
        ]);
        $editUser3 = Permission::create(['id'=>255,
            'name' => 'vechile_show_city_in_category',
            'display_name' => 'عرض المدن التي داخل تصنيف', // optional
            'description' =>  '  يستطيع المستخدم عرض المدن داخل التصنيف   ', // optional
        ]);


        $editUser3 = Permission::create(['id'=>256,
            'name' => 'vechile_sub_category_update',
            'display_name' => 'تعديل التصنيف الفرعي للمركبه', // optional
            'description' =>  '  يستطيع المستخدم تعديل التصنيف الفرعي للمركبه    ', // optional
        ]);

        $editUser3 = Permission::create(['id'=>257,
            'name' => 'vechile_add_new_city_to_category',
            'display_name' => 'اضافه مدينه جديده لتصنيف', // optional
            'description' =>  'يستطيع المستخدم اضافه مدينه جديد لتصنيف  ', // optional
        ]);




        //الطلبات
        $editUser = Permission::create([
            'id' =>300,
            'name' => 'requests',
            'display_name' => 'الطلبات', // optional
            'description' => 'يستطيع المستخدم رية الطلبات للرحلات بجيميع حالتها', // optional
        ]);

        //الفواتير

        $editUser = Permission::create([
            'id' =>400,
            'name' => 'waiting_confirm',
            'display_name' => 'فواتير بإنتظار  التأكيد', // optional
            'description' => 'يستطيع الوصول للفواتير بأنتظار التأكيد و عمل تأكيد على الفواتير', // optional
        ]);
        $editUser3 = Permission::create(['id' =>401,
        'name' => 'bill_confirm',
        'display_name' => 'تاكيد الفواتير', // optional
        'description' =>  ' يستطيع المستخدم تاكيد الفواتير   ', // optional
    ]);
    $editUser3 = Permission::create(['id' =>402,
        'name' => 'bill_confirm_show',
        'display_name' => 'عرض بيانات فواتير قيد التاكيد', // optional
        'description' =>  ' يستطيع المستخدم عرض بيانات فواتير قيد التاكيد', // optional
    ]);


        $editUser = Permission::create(['id' =>403,
            'name' => 'waiting_trustworthy',
            'display_name' => 'فواتير بإنتظار الأعتماد', // optional
            'description' => 'يستطيع المستخدم الوصول للفواتير بإنتظار الأعتماد', // optional
        ]);
        $editUser3 = Permission::create(['id' =>404,
        'name' => 'bill_trustworthy',
        'display_name' => 'اعتماد الفواتير', // optional
        'description' =>  ' يستطيع المستخدم اعتماد الفواتير   ', // optional
          ]);
        $editUser3 = Permission::create(['id' =>405,
            'name' => 'bill_trustworthy_show',
            'display_name' => 'عرض بيانات فواتير قيد الاعتماد', // optional
            'description' =>  ' يستطيع المستخدم عرض بيانات فواتير قيد الاعتماد', // optional
        ]);
        $editUser = Permission::create(['id' =>406,
            'name' => 'waiting_deposit',
            'display_name' => 'مبالغ بإنتظار الإيداع', // optional
            'description' => 'يستطيع المستخدم الوصول الى المبالغ والفواتير بإنتظار الإيداع وعمل ايداع', // optional
        ]);
        $editUser3 = Permission::create(['id' =>407,
        'name' => 'bill_deposit',
        'display_name' => 'ايداع مبلغ', // optional
        'description' =>  ' يستطيع المستخدم ايداع مبالغ ف خزنة', // optional
    ]);
    $editUser3 = Permission::create(['id' =>408,
        'name' => 'bill_deposit_show',
        'display_name' => 'عرض بيانات مبالغ قيد ايداع', // optional
        'description' =>  ' يستطيع المستخدم عرض بيانات مبالغ قيد ايداع', // optional
    ]);
        $editUser = Permission::create(['id' =>409,
            'name' => 'general_box',
            'display_name' => 'الصندوق العام', // optional
            'description' => 'يستطيع المستخدم الوصول الى الصندوق العام ', // optional
        ]);

        $editUser3 = Permission::create(['id' =>410,
            'name' => 'box_general_show',
            'display_name' => 'عرض مبالغ المودعة ف صندوق العام', // optional
            'description' =>  ' يستطيع المستخدم  عرض مبالغ المودعة ف صندوق العام', // optional
        ]);

        $editUser3 = Permission::create([ 'id' =>411,
            'name' => 'bank_transfer_driver',
            'display_name' => 'التحويلات البنكيه لسائقين', // optional
            'description' =>  'يستطيع المستخدم الدخول علي التحويلات البنكيه لسائقين', // optional
        ]);
        $editUser3 = Permission::create([ 'id' =>412,
            'name' => 'bank_transfer_rider',
            'display_name' => 'التحويلات البنكيه للعملاء', // optional
            'description' =>  'يستطيع المستخدم الدخول علي التحويلات البنكية لعملاء', // optional
        ]);

        $editUser3 = Permission::create([ 'id' =>413,
        'name' => 'tax_bill',
        'display_name' => 'ضربية القيمة المضافة', // optional
        'description' =>  'يستطيع المستخدم الدخول علي ضربية  القيمة المضافة', // optional
    ]);









        //   المهام
        $editUser = Permission::create([
            'id' =>600,
            'name' => 'manage_tasks',
            'display_name' => 'أدارة المهام', // optional
            'description' => 'يستطيع المستخدم من أدارة المهام للمستخدمين وأضافة مهام وعرضها', // optional
        ]);

        $editUser = Permission::create([   'id' =>601,
        'name' => 'user_own_tasks',
        'display_name' => 'مهامي الخاصه(الموظفين)', // optional
        'description' => 'يستطيع المستخدم من الوصول الى المهام الخاصة بيها و اضافة تحديثات لها', // optional
         ]);
         $editUser3 = Permission::create([   'id' =>602,
         'name' => 'task_add_new',
         'display_name' => 'اضافه مهمة جديدة', // optional
         'description' =>  'يستطيع المستخدم اضافه مهمة جديدة', // optional
     ]);
        $editUser = Permission::create([   'id' =>603,
            'name' => 'complete_task',
            'display_name' => 'المهام المكتملة', // optional
            'description' => 'يستطيع المستخدم من روئية المهام المكتملة', // optional
        ]);

        $editUser = Permission::create([   'id' =>604,
            'name' => 'direct_task',
            'display_name' => 'توجيه المهام', // optional
            'description' => 'يستطيع المستخدم من خلالها توجيه المهمه الى مستخدم محدد او تغير الشخص المسؤال عن المهمة', // optional
        ]);

        //المستخدمين

        $editUser = Permission::create([
            'id' =>700,
            'name' => 'user_manage',
            'display_name' => 'أدارة المستخدمين', // optional
            'description' => 'يستطيع المستخدم الوصول للمستخدمين و أضافة ادوار و تعديل صلاحيات المستخدمين', // optional
        ]);

        $editUser = Permission::create([   'id' =>702,
            'name' => 'show_ations_on_system',
            'display_name' => 'الأحداث', // optional
            'description' => 'تمكن المستخدم من روئية الأحداث التى وقعت داخل النظام من عمليات الدخول والاضافة والتعديل', // optional
        ]);
        $editUser = Permission::create([   'id' =>703,
            'name' => 'user_show',
            'display_name' => 'عرض المستخدمين', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض المستخدمين للنظام', // optional
        ]);
        $editUser = Permission::create([   'id' =>704,
            'name' => 'user_add',
            'display_name' => 'أضافة مستخدم', // optional
            'description' => 'يستطيع المستخدم من خلالها أضافة مستخدم جديد', // optional
        ]);
        $editUser = Permission::create([   'id' =>705,
            'name' => 'user_box',
            'display_name' => 'صندوق المستخدم', // optional
            'description' => 'يستطيع المستخدم من خلالها روئية الصندوق الخاص بالمستخدم', // optional
        ]);
        $editUser = Permission::create([   'id' =>706,
            'name' => 'user_note',
            'display_name' => 'ملاحظات المستخدم', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض المستندات الخاصة بالمستخدم ', // optional
        ]);
        $editUser = Permission::create([   'id' =>707,
            'name' => 'user_document',
            'display_name' => 'مستندات المستخدم', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض المستندات الخاصة بالمستخدم', // optional
        ]);
        $editUser = Permission::create([   'id' =>708,
            'name' => 'user_state',
            'display_name' => 'استبعاد المستخدم', // optional
            'description' => 'يستطيع المستخدم من خلالها أضافة صلاحية لمستخدم', // optional
        ]);
        $editUser = Permission::create([   'id' =>709,
            'name' => 'user_role',
            'display_name' => 'أضافة دور للمستخدم', // optional
            'description' => 'يستطيع المستخدم من خلالها أضافة دور للمستخدم', // optional
        ]);
        $editUser = Permission::create([   'id' =>710,
            'name' => 'role_add',
            'display_name' => 'أضافة دور', // optional
            'description' => 'يستطيع المستخدم من خلالها', // optional
        ]);
        $editUser = Permission::create([   'id' =>711,
            'name' => 'role_update',
            'display_name' => 'تعديل دور', // optional
            'description' => 'يستطيع المستخدم من خلالها', // optional
        ]);


        //الصادر والوراد
        $editUser = Permission::create([
            'id' =>800,
            'name' => 'import_export',
            'display_name' => ' عرض الصادر و الوارد ', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض الصادر والوارد و اضافة جديده للصادر والوارد', // optional
        ]);
        $editUser3 = Permission::create([  'id' =>801,
            'name' => 'add_import_export',
            'display_name' => 'اضاف صادر او وارد', // optional
            'description' =>  'يستطيع المستخدم   اضافه عنصرالي الصادر او الوارد', // optional
        ]);

        //التنبهات

        $editUser = Permission::create([
            'id' =>900,
            'name' => 'warning_driver',
            'display_name' => 'تنبيهات السائقين ', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض تنبيهات للسائقين عن تاريخ انتهاء الهوية و انتهاء الرخصةو انتهاء عقد العمل و المخالصة النهائية', // optional
        ]);
        $editUser = Permission::create([  'id' =>901,
            'name' => 'warning_vechile',
            'display_name' => 'تنبيهات المركبات', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض تنبيهات المركبات عن انتهاء رخصة السير و انتهاء الفحص الدورى و انتهاء التأمين و انتهاء بطاقة التشغيل ', // optional
        ]);
        $editUser = Permission::create([  'id' =>902,
            'name' => 'warning_user',
            'display_name' => 'تنبيهات المستخدمين ', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض تنبيهات المستخدمين عن انتهاء عقد العمل و تاريخ المخالصة النهائية', // optional
        ]);

        //الجهات

        $editUser = Permission::create([
            'id' =>1000,
            'name' => 'stakeholders',
            'display_name' => 'الجهات', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض الجهات وأضافة جهة جديدة ', // optional
        ]);
        $editUser3 = Permission::create([
            'id' =>1001,
            'name' => 'stackholder_add_new',
            'display_name' => 'اضافه جهة جديده', // optional
            'description' =>  'يستطيع المستخدم اضافه مدينه جديد لتصنيف  ', // optional
        ]);

         $editUser = Permission::create([   'id' =>1002,
            'name' => 'nathiraat_box',
            'display_name' => 'الـنـثـريـات', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق النثريات سواء عرض او أضافة سند', // optional
        ]);
        $editUser3 = Permission::create([   'id' =>1003,
        'name' => 'stackHolder_print_nathiraat',
        'display_name' => 'طباعه النثريات', // optional
        'description' =>  'يستطيع المستخدم طباعه فواتير النثريات', // optional
            ]);

        $editUser3 = Permission::create([   'id' =>1004,
        'name' => 'stackholder_detials',
        'display_name' => 'عرض الجهة', // optional
        'description' =>  'يستطيع المستخدم يستطيع المستخدم اضافه مستند لجهة معينه', // optional
        ]);


        $editUser3 = Permission::create([   'id' =>1005,
        'name' => 'stackholder_update',
        'display_name' => 'تعديل بيانات الجهة', // optional
        'description' =>  'يستطيع المستخدم تعديل بيانات الجهه ', // optional
       ]);

        $editUser3 = Permission::create([   'id' =>1006,
            'name' => 'stackHolder_box_show',
            'display_name' => 'عرض صندوق الجهة', // optional
            'description' =>  'يستطيع المستخدم عرض بيانات الصندوق الخاص ب جهة معينه', // optional
        ]);
        $editUser3 = Permission::create([   'id' =>1007,
            'name' => 'stackHolder_box_add',
            'display_name' => 'اضافه صندوق لجهة', // optional
            'description' =>  'يستطيع المستخدم يستطيع المستخدم اضافه صندوق لجهة معينه', // optional
        ]);


        $editUser3 = Permission::create([   'id' =>1008,
            'name' => 'stackHolder_notes_show',
            'display_name' => 'عرض ملاحظات الجهة', // optional
            'description' =>  'يستطيع المستخدم عرض بيانات ملاحظات الخاص ب جهة معينه', // optional
        ]);
        $editUser3 = Permission::create([   'id' =>1009,
            'name' => 'stackHolder_notes_add',
            'display_name' => 'اضافه ملاحظه لجهة', // optional
            'description' =>  'يستطيع المستخدم يستطيع المستخدم اضافه ملاحظه لجهة معينه', // optional
        ]);
        $editUser3 = Permission::create([   'id' =>1010,
            'name' => 'stackHolder_document_show',
            'display_name' => 'عرض مستندات الجهة', // optional
            'description' =>  'يستطيع المستخدم عرض بيانات مستندات الخاص ب جهة معينه', // optional
        ]);
        $editUser3 = Permission::create([   'id' =>1011,
            'name' => 'stackHolder_document_add',
            'display_name' => 'اضافه مستند لجهة', // optional
            'description' =>  'يستطيع المستخدم يستطيع المستخدم اضافه مستند لجهة معينه', // optional
        ]);




        //مركز الصيانه
        $editUser = Permission::create([
            'id' =>1100,
            'name' => 'maintenance_center',
            'display_name' => 'مركز الصيانة', // optional
            'description' => 'يستطيع المستخدم من خلالها متابعة بيانات مركز الصيانة واضافة منتاجة و صيانة للسائقين', // optional
        ]);

        $editUser3 = Permission::create([
            'id' =>1101,
            'name' => 'maintain_add_new_category',
            'display_name' => 'اضافه صنف جديد  لمركز صيانه', // optional
            'description' =>  'يستطيع المستخدم   اضافه عنصرالي مركز الصيانه من الاصناف', // optional
        ]);
            $editUser3 = Permission::create([
                'id' =>1102,
                'name' => 'maintain_update_category',
                'display_name' => 'تعديل  بيانات صنف   لمركز صيانه', // optional
                'description' =>  'يستطيع المستخدم   اضافه عنصرالي مركز الصيانه من الاصناف', // optional
            ]);

        $editUser3 = Permission::create([
            'id' =>1103,
            'name' => 'maintain_add_new_amount',
            'display_name' => 'اضافه كميه جديده لصنف لمركز صيانه', // optional
            'description' =>  'يستطيع المستخدم   اضافه عنصرالي مركز الصيانه من الاصناف', // optional
        ]);


        //الاستراكات


        $editUser = Permission::create([
            'id' =>1200,
            'name' => 'show_booking',
            'display_name' => 'أدارة الإشتركات', // optional
            'description' => 'يستطيع المستخدم من خلالها أدارة الإشتركات', // optional
        ]);
        $editUser3 = Permission::create([
            'id' =>1201,
            'name' => 'booking_add_precentage',
            'display_name' => 'اضافه نسب خصم  ف الاشتراكات الشهريه', // optional
            'description' =>  'يستطيع المستخدم اضافه نسب الخصم ف الاشتراكات الشهريه', // optional
        ]);
        $editUser3 = Permission::create([
            'id' =>1202,
            'name' => 'booking_show_precentage',
            'display_name' => 'عرض نسب الخصم ف الاشتراكات الشهرية', // optional
            'description' =>  'يستطيع المستخدم عرض نسب الخصم ف الاشتراكات الشهريه', // optional
        ]);
        $editUser3 = Permission::create([
            'id' =>1203,
            'name' => 'booking_update_precentage',
            'display_name' => 'تعديل نسب الخصم ف الاشتراكات الشهرية', // optional
            'description' =>  'يستطيع المستخدم تعديل نسب الخصم ف الاشتراكات الشهريه', // optional
        ]);

        //المجموعات
        $editUser = Permission::create([
            'id' =>1300,
            'name' => 'manage_group',
            'display_name' => 'أدارة جميع المجموعات', // optional
            'description' => 'يستطيع المستخدم من خلالها أدارة جميع المجموعات', // optional
        ]);
        $editUser = Permission::create([
            'id' =>1301,
            'name' => 'user_group',
            'display_name' => 'مستخدم يدير مجموعة او اكثر', // optional
            'description' => 'يستطيع المستخدم من خلالها أدارة مجموعة او أكثر', // optional
        ]);

        $editUser3 = Permission::create([
            'id' =>1302,
            'name' => 'group_add_new',
            'display_name' => 'اضافه مجموعه جديدة', // optional
            'description' =>  'يستطيع المستخدم اضافه مجموعه جديدة', // optional
        ]);

        $editUser3 = Permission::create([
            'id' =>1303,
            'name' => 'group_update_price_vechile',
            'display_name' => 'تعديل سعر المركبه ف المجموعات', // optional
            'description' =>  'يستطيع المستخدم تعديل سعر المركبه ف المجموعات', // optional
        ]);

        //الدعايه والتسويق
        $editUser = Permission::create([
            'id' =>1400,
            'name' => 'marketing',
            'display_name' => 'دعاية وتسويق', // optional
            'description' => 'يستطيع المستخدم من خلالها عرض جهة ادارة الدعاية والتسويق', // optional
        ]);


        //ارسال الرسائل


        $editUser3 = Permission::create([
            'id' =>1500,
            'name' => 'sms_send_driver',
            'display_name' => 'ارسال الي سائقين', // optional
            'description' =>  'يستطيع المستخدم  يمكن ارسال رساله الي سائقين', // optional
        ]);
        $editUser3 = Permission::create([
            'id' =>1501,
            'name' => 'sms_send_rider',
            'display_name' => 'ارسال الي عملاء', // optional
            'description' =>  'يستطيع المستخدم  يمكن ارسال رساله الي عملاء', // optional
         /// optional
        ]);

             //العهد


             $editUser = Permission::create([
                'id' =>1600,
                'name' => 'manage_covenant_system',
                'display_name' => '   عرض جميع العهد', // optional
                'description' => ' يستطيع المستخدم من خلالها أدارة  جميع العهد ' , // optional
            ]);


                $editUser3 = Permission::create(['id' =>1601,
                'name' => 'covenant_add_new',
                'display_name' => 'اضافه عهدة جديده', // optional
                'description' =>  'يستطيع المستخدم اضافه عهدة جديده', // optional
            ]);
                $editUser3 = Permission::create(['id' =>1602,
                'name' => 'covenant_deliver_to',
                'display_name' => ' تسليم العهد للموظف', // optional
                'description' =>  'يستطيع المستخدم ان يسلم عهدة الي موظف معين', // optional
            ]);

                $editUser3 = Permission::create(['id' =>1603,
                'name' => 'covenant_add_element',
                'display_name' => 'اضافة عنصر الي العهدة', // optional
                'description' =>  'يستطيع المستخدم   اضافه عنصر من نوع عهده معينه', // optional
                ]);

                $editUser3 = Permission::create(['id' =>1604,
                'name' => 'covenant_show',
                'display_name' => 'عرض العهدة', // optional
                'description' =>  'يستطيع المستخدم عرض عهده معينه', // optional
                ]);

            //العهد للموظفين
             $editUser = Permission::create([
                    'id' =>1700,
                    'name' => 'manage_covenant',
                    'display_name' => '  أدارة العهد الخاصة بالموظف', // optional
                    'description' => ' يستطيع المستخدم من خلالها أدارة العهد الخاصة' , // optional
                ]);
              // الملاحظات والمستندات
              $editUser = Permission::create([
                'id' =>1800,
                'name' => 'manage_all_notes_documents',
                'display_name' => '  أدارة جميع الملاحظات والمستندات  ', // optional
                'description' => 'أدارة جميع الملاحظات والمستندات لنظام' , // optional
            ]);
              // سياسة الخصوصية
              $editUser = Permission::create([
                'id' =>1801,
                'name' => 'policy_terms',
                'display_name' => 'سياسة الخصوصية', // optional
                'description' => 'أدارة سياسة الخصوصية' , // optional
            ]);
              // الشروط و الاحكام
              $editUser = Permission::create([
                'id' =>1802,
                'name' => 'terms_conditions',
                'display_name' => 'الشروط و الاحكام', // optional
                'description' => 'أدارة الشروط والاحكام' , // optional
            ]);
           
            $editUser = Permission::create([
                'id' =>1803,
                'name' => 'add_notes_to_all',
                'display_name' => 'اضافة ملاحظه ', // optional
                'description' => 'اضافة ملاحظه لاي جهه' ,// optional
            ]);
            $editUser = Permission::create([
                'id' =>1804,
                'name' => 'add_document_to_all',
                'display_name' => 'اضافة سند ', // optional
                'description' => 'اضافة سند لاي جهه' ,// optional
            ]);
            $editUser = Permission::create([
                'id' =>1805,
                'name' => 'add_bond_to_all',
                'display_name' => 'اضافة صندوق ', // optional
                'description' => 'اضافة صندوق لاي جهه' , // optional
            ]);








    }
}
