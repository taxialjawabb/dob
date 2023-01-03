<?php

use App\Http\Controllers\Admin\RequestsController;
use App\Http\Controllers\Admin\Rider\RiderController;
use Illuminate\Support\Facades\Route;

// login page to admin
Route::group([
    'middleware' => ['guest'],
], function () {
    Route::get('control/panel/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('control/panel/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login_admin'])->name('login');
    Route::post('/user/send/code', [App\Http\Controllers\Admin\Auth\LoginController::class, 'send_code_user']);

});

//all linkks that admin can access
Route::group([
    'middleware' => ['auth:admin'],
], function () {

    Route::group([
        'prefix' => 'stakeholders',
        // 'middleware' => ['permission:rider_box|driver_box|vechile_box|user_manage|stakeholders']
    ], function () {
        Route::get('/show', [App\Http\Controllers\Admin\InternalTransfer\InternalTransferController::class, 'get_stakeholders']);

        // Route::post('/delivery/add', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'save_add']);
    });

    // all file pdf and images
    Route::get('show/pdf', [App\Http\Controllers\Controller::class, 'show_pdf']);

    //logout from control panel
    Route::get('logout', [App\Http\Controllers\Admin\Auth\homeController::class, 'logout']);

    // home page is the first page user see after login
    Route::get('/home', [App\Http\Controllers\Admin\Auth\homeController::class, 'home']);

    Route::get('system/notes', [App\Http\Controllers\Admin\DocumentAndNotes\DocumentNotesController::class, 'getNotes'])->middleware(['permission:manage_all_notes_documents']);
    Route::get('system/document', [App\Http\Controllers\Admin\DocumentAndNotes\DocumentNotesController::class, 'getDocuments'])->middleware(['permission:manage_all_notes_documents']);

    // user manage roles and permission
    Route::group([
        'prefix' => 'user',
        'middleware' => ['permission:user_manage'],
    ], function () {
        Route::get('activity/log', [App\Http\Controllers\Admin\Users\UsersController::class, 'activity_log']);
        Route::get('show/{type}', [App\Http\Controllers\Admin\Users\UsersController::class, 'show_users']);
        Route::get('add', [App\Http\Controllers\Admin\Users\UsersController::class, 'add_show']);
        Route::post('add', [App\Http\Controllers\Admin\Users\UsersController::class, 'add_save']);
        Route::get('update/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'update_show']);
        Route::post('update', [App\Http\Controllers\Admin\Users\UsersController::class, 'update_save']);
        Route::get('detials/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'detials']);
        Route::get('roles/show', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'show_roles']);
        Route::get('roles/add', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'show_add']);
        Route::post('roles/add', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'save_role']);
        Route::get('roles/update/{id}', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'update_show']);
        Route::post('roles/update', [App\Http\Controllers\Admin\Users\Roles\RolesController::class, 'update_save']);

        Route::post('attendance/add', [App\Http\Controllers\Admin\Users\UsersAttendanceController::class, 'add_attendance']);
        Route::get('attendance/show', [App\Http\Controllers\Admin\Users\UsersAttendanceController::class, 'show_attendance']);
        Route::get('attendance/show/reports/{type}/{date?}', [App\Http\Controllers\Admin\Users\UsersAttendanceController::class, 'report_salary_counted']);
        Route::get('attendance/show/report/{type}', [App\Http\Controllers\Admin\Users\UsersAttendanceController::class, 'report_salary_driver_user']);
        Route::post('attendance/confirm/reports/{date?}', [App\Http\Controllers\Admin\Users\UsersAttendanceController::class, 'report_confirm']);
        Route::get('/reports', [App\Http\Controllers\Admin\Users\UsersController::class, 'show_users_report']);

        Route::group([
            'prefix' => 'driver',
            'middleware' => ['permission:user_manage'],
        ], function () {
            Route::get('/employee/show/{type}', [App\Http\Controllers\Admin\Users\DriversAttendanceController::class, 'show_driver_employee']);
            Route::get('/attendance/show', [App\Http\Controllers\Admin\Users\DriversAttendanceController::class, 'show_attendance']);
            Route::post('/attendance/add', [App\Http\Controllers\Admin\Users\DriversAttendanceController::class, 'add_attendance']);

        });
    });

    Route::group([
        'prefix' => 'rider',
        'middleware' => ['permission:rider_data'],
    ], function () {
        Route::get('show', [RiderController::class, 'index']);
        Route::get('detials/{id}', [RiderController::class, 'detials'])->middleware(['permission:rider_details']);
        Route::get('trips/{id}', [RiderController::class, 'show'])->middleware(['permission:rider_trip']);
        Route::get('edit/{id}', [RiderController::class, 'edit'])->middleware(['permission:rider_update']);
        Route::get('edit/state/{id}', [RiderController::class, 'change_state']);
        Route::post('edit/address/{rider}', [RiderController::class, 'save_edit'])->name('update.rder.city');
    });

    //user accest to all trips and request in any state
    Route::group([
        'prefix' => 'requests',
        'middleware' => ['permission:requests'],
    ], function () {
        Route::get('/{request_state}', [RequestsController::class, 'requests']);
    });

    //Category and Ctiy manage
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:category_city'],
    ], function () {
        Route::get('/show/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'show_category']);
        Route::get('/detials/cagegory/{id}', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'detials_show'])->middleware(['permission:vechile_show_category_detail']);
        Route::get('/add/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'show_add'])->middleware(['permission:vechile_add_new_category']);
        Route::post('/add/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'add_category']);
        Route::get('/update/cagegory/{id}', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'update_show'])->middleware(['permission:vechile_update_category']);
        Route::post('/update/cagegory', [App\Http\Controllers\Admin\Vechile\CategoryController::class, 'update_category']);

        Route::get('/add/cagegory/secondary/{id}', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'show_add'])->middleware(['permission:vechile_add_new_sub_category']);
        Route::post('/add/cagegory/secondary', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'add_category']);
        Route::get('/update/secondary/cagegory/{id}', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'update_show'])->middleware(['permission:vechile_sub_category_update']);
        Route::post('/update/secondary/cagegory', [App\Http\Controllers\Admin\Vechile\CategorySecondaryController::class, 'update_category']);

        Route::get('/show/city/{id}', [App\Http\Controllers\Admin\Vechile\CityController::class, 'show_city'])->middleware(['permission:vechile_show_city_in_category']);
        Route::get('/add/city/{id}', [App\Http\Controllers\Admin\Vechile\CityController::class, 'show_add'])->middleware(['permission:vechile_add_new_city_to_category']);
        Route::post('/add/city', [App\Http\Controllers\Admin\Vechile\CityController::class, 'add_city']);
        Route::get('/update/city/{catid}/{citid}', [App\Http\Controllers\Admin\Vechile\CityController::class, 'show_update']);
        Route::post('/update/city', [App\Http\Controllers\Admin\Vechile\CityController::class, 'update_city']);

    });

    //vechile data show all vechiles and add new vechile, change state to vechile
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:vechile_data'],
    ], function () {
        Route::get('/add', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'show_add'])->middleware(['permission:vechile_add_new']);;
        Route::post('/add', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'add_vechile']);
        Route::get('/show/{state?}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'show_vechile'])->middleware(['permission:vechile_show']);
        Route::get('/update/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_show'])->middleware(['permission:vechile_update']);
        Route::post('/update', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_vechile']);
        Route::get('/details/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'detials'])->middleware(['permission:vechile_show_detials']);
        Route::get('/reports', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'show_reports']);
        // Ajax get secondary Category
        Route::get('/secondary/category', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'secondary_category']);

        Route::get('/drivers/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'drivers'])->middleware(['permission:vechile_show_driver_delivered']);

        Route::get('/state/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'show_state']);
        Route::post('/state', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'save_state']);

        Route::get('/maintenance/{id}', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'vechile_show_maintenance'])->middleware(['permission:vechile_show_maintain']);

    });

    Route::group([
        'prefix' => 'driver',
        'middleware' => ['permission:driver_data|recently_driver|user_group|manage_group'],
    ], function () {

        Route::group([

            'middleware' => ['permission:contract_manage|user_group|manage_group'],
        ], function () {
            Route::post('/contract/send/code', [App\Http\Controllers\Admin\Driver\Contract\ConfirmContractController::class, 'send_code_driver']);
            Route::post('/user/contract/send/code', [App\Http\Controllers\Admin\Driver\Contract\ConfirmContractController::class, 'send_code_user']);
            Route::post('/contract/adddata', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'save_data']);
            Route::post('/contract/extension', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'extension_contract']);
            Route::post('/contract/end/endview', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'end_contract_view']);
            Route::post('/contract/end/save', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'end_contract']);
            Route::get('/contract/{id?}', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'show_adding']);
            Route::get('/show/contracts/{state}', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'show_contracts'])->name('driver.show.contracts');
            Route::get('/contract/show/details/{id}', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'show_contract_details']);
            Route::get('/contract/end/{id}', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'end_contract_show']);

            Route::post('/contract/views', [App\Http\Controllers\Admin\Driver\Contract\ContractController::class, 'view_contract']);

        });

        Route::get('/show/{state?}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_driver']);
        Route::get('/add', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_add'])->middleware(['permission:driver_add_new_driver']);
        Route::post('/add', [App\Http\Controllers\Admin\Driver\DriverController::class, 'add_driver']);
        Route::get('/details/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'detials'])->middleware(['permission:driver_data_show']);
        Route::get('/update/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'update_show'])->middleware(['permission:driver_update_data|user_group|manage_group']);;
        Route::post('/update', [App\Http\Controllers\Admin\Driver\DriverController::class, 'update_driver'])->middleware(['permission:driver_update_data|user_group|manage_group']);
        Route::get('/availables', [App\Http\Controllers\Admin\Driver\DriverController::class, 'availables'])->middleware(['permission:driver_show_available']);

        Route::get('/vechile/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'vechiles'])->middleware(['permission:driver_vechial_delivered|user_group|manage_group']);

        Route::get('/state/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_state']);
        Route::post('/state', [App\Http\Controllers\Admin\Driver\DriverController::class, 'save_state'])->middleware(['permission:driver_convert_status|user_group|manage_group']);
        Route::get('/take/vechile/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_take'])->middleware(['permission:driver_take_vechile']);
        Route::post('/take/vechile', [App\Http\Controllers\Admin\Driver\DriverController::class, 'save_take']);

        Route::get('/records/notes', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'show']);
        Route::get('/vechile/maintenance/{id}', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'current_maintenance']);

        Route::get('/pending/active/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'driver_active']);

        Route::get('/reports/show', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_report'])->middleware(['permission:driver_reports']);
        Route::get('/debits', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_debits'])->middleware(['permission:driver_debits']);
        Route::get('/count/users', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'show_count'])->middleware(['permission:driver_counts']);
        Route::get('/sample/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'driver_sample_show'])->middleware(['permission:driver_sample_data']);
        Route::get('/delegate/{id}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'driver_delegate_show'])->middleware(['permission:driver_delegate_data']);
        Route::get('/receive/covenant/{driver}/{vechile?}', [App\Http\Controllers\Admin\Driver\DriverController::class, 'driver_receive_show'])->name('driver.receive.covenant');
        Route::get('/reports/status/show', [App\Http\Controllers\Admin\Driver\DriverController::class, 'show_report_status'])->middleware(['permission:driver_reports']);

        Route::get('/center/bill/{id}', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'show_bills']);
        Route::get('/center/add/bill/{id}', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'show_add']);
        Route::post('/center/item', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'confirm_item']);
        Route::post('/center/item/save', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'save_item'])->name('items');
    });

    // Documents and Notes for vechile
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:vechile_document_notes|user_group|manage_group'],
    ], function () {
        Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Vechile\Documents\DocumentVechileController::class, 'show_document']);
        Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Vechile\Documents\DocumentVechileController::class, 'show_add'])->middleware(['permission:vechile_add_notes_docs|user_group|manage_group']);
        Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Vechile\Documents\DocumentVechileController::class, 'add_document']);

        Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Vechile\Notes\NotesVechileController::class, 'show_note']);
        Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Vechile\Notes\NotesVechileController::class, 'show_add'])->middleware(['permission:vechile_add_notes_docs|user_group|manage_group']);
        Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Vechile\Notes\NotesVechileController::class, 'add_note']);
    });

    // Documents and Notes for Driver
    Route::group([
        'prefix' => 'driver',
        'middleware' => ['permission:driver_document_notes|user_group|manage_group'],
    ], function () {
        Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Driver\Documents\DocumentDriverController::class, 'show_document']);
        Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Driver\Documents\DocumentDriverController::class, 'show_add'])->middleware(['permission:driver_add_note_docs|user_group|manage_group']);
        Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Driver\Documents\DocumentDriverController::class, 'add_document']);

        Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Driver\Notes\NotesDriverController::class, 'show_note']);
        Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Driver\Notes\NotesDriverController::class, 'show_add'])->middleware(['permission:driver_add_note_docs|user_group|manage_group']);
        Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Driver\Notes\NotesDriverController::class, 'add_note']);
    });

    // Documents and Notes for rider
    Route::group([
        'prefix' => 'rider',
        'middleware' => ['permission:rider_document_notes'],
    ], function () {
        Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Rider\Documents\DocumentRiderController::class, 'show_document']);
        Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Rider\Documents\DocumentRiderController::class, 'show_add'])->middleware(['permission:rider_note_docs_add_new']);
        Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Rider\Documents\DocumentRiderController::class, 'add_document']);

        Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Rider\Notes\NotesRiderController::class, 'show_note']);
        Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Rider\Notes\NotesRiderController::class, 'show_add'])->middleware(['permission:rider_note_docs_add_new']);
        Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Rider\Notes\NotesRiderController::class, 'add_note']);
    });

    // Documents and Notes for Driver
    Route::group([
        'prefix' => 'user',
        //'middleware' => ['permission:driver_document_notes']
    ], function () {
        Route::get('/documents/show/{id}', [App\Http\Controllers\Admin\Users\Documents\DocumentUserController::class, 'show_document']);
        Route::get('/documents/add/{id}', [App\Http\Controllers\Admin\Users\Documents\DocumentUserController::class, 'show_add']);
        Route::post('/documents/add/{id}', [App\Http\Controllers\Admin\Users\Documents\DocumentUserController::class, 'add_document']);

        Route::get('/notes/show/{id}', [App\Http\Controllers\Admin\Users\Notes\NotesUserController::class, 'show_note']);
        Route::get('/notes/add/{id}', [App\Http\Controllers\Admin\Users\Notes\NotesUserController::class, 'show_add']);
        Route::post('/notes/add/{id}', [App\Http\Controllers\Admin\Users\Notes\NotesUserController::class, 'add_note']);

        Route::get('/block/{id}', [App\Http\Controllers\Admin\Users\UserController::class, 'user_block']);
        Route::get('/block/confirm/{id}', [App\Http\Controllers\Admin\Users\UserController::class, 'confirm_block']);
    });

    // Box for driver
    Route::group([
        'prefix' => 'driver',
        'middleware' => ['permission:driver_box'],
    ], function () {
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Driver\Box\BoxDriverController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Driver\Box\BoxDriverController::class, 'show_add'])->middleware(['permission:driver_add_box']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Driver\Box\BoxDriverController::class, 'add_box']);

        Route::get('/delayed/weekly/payment/{driver}', [App\Http\Controllers\Admin\Driver\Box\BoxDriverController::class, 'weekly_delayed'])->name('driver.delayed.weekly.payment');

    });

    // Box for user
    Route::group([
        'prefix' => 'user',
        'middleware' => ['permission:user_manage'],
    ], function () {
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Users\Box\BoxUserController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Users\Box\BoxUserController::class, 'show_add']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Users\Box\BoxUserController::class, 'add_box']);
    });

    // Box for vechile
    Route::group([
        'prefix' => 'vechile',
        'middleware' => ['permission:vechile_box'],
    ], function () {
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Vechile\Box\BoxVechileController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Vechile\Box\BoxVechileController::class, 'show_add'])->middleware(['permission:vechile_add_new_box']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Vechile\Box\BoxVechileController::class, 'add_box']);
    });

    // Box for rider
    Route::group([
        'prefix' => 'rider',
        'middleware' => ['permission:rider_box'],
    ], function () {
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Rider\Box\BoxRiderController::class, 'show_box']);
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Rider\Box\BoxRiderController::class, 'show_add'])->middleware(['permission:rider_box_add_new']);
        Route::post('/box/add/{id}', [App\Http\Controllers\Admin\Rider\Box\BoxRiderController::class, 'add_box']);
    });

    // Box for nathiraat
    Route::get('nathiraat/box/show/{type}', [App\Http\Controllers\Admin\Nathiraat\BoxNathiraatController::class, 'show_box'])->middleware(['permission:nathiraat_box']);
    Route::group([
        'prefix' => 'nathiraat',
        'middleware' => ['permission:stakeholders|marketing'],
    ], function () {

        Route::get('/stakeholders/box/show/{type}/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box\BoxStakeholdersController::class, 'show_box'])->middleware(['permission:stackHolder_box_show|marketing']);
        Route::get('/stakeholders/box/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box\BoxStakeholdersController::class, 'show_add'])->middleware(['permission:stackHolder_box_add|marketing']);
        Route::post('/stakeholders/box/add', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box\BoxStakeholdersController::class, 'add_box']);

        Route::get('/stakeholders/show', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'show_stakeholders']);
        Route::get('/stakeholders/add', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'add_show'])->middleware(['permission:stackholder_add_new']);
        Route::post('/stakeholders/add', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'add_save']);

        Route::get('/stakeholders/update/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'update_show_stackhoder'])->middleware(['permission:stackholder_update']);
        Route::post('/stakeholders/update', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'update_save_stackhoder']);

        Route::get('/stakeholders/detials/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\StakeholdersController::class, 'detials'])->middleware(['permission:stackholder_detials|marketing']);

        Route::get('stakeholders/documents/show/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Documents\DocumentStakeholdersController::class, 'show_document'])->middleware(['permission:stackHolder_document_show|marketing']);
        Route::get('stakeholders/documents/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Documents\DocumentStakeholdersController::class, 'show_add'])->middleware(['permission:stackHolder_document_add|marketing']);
        Route::post('stakeholders/documents/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Documents\DocumentStakeholdersController::class, 'add_document']);

        Route::get('stakeholders/notes/show/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Notes\NotesStakeholdersController::class, 'show_note'])->middleware(['permission:stackHolder_notes_show|marketing']);
        Route::get('stakeholders/notes/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Notes\NotesStakeholdersController::class, 'show_add'])->middleware(['permission:stackHolder_notes_add|marketing']);
        Route::post('stakeholders/notes/add/{id}', [App\Http\Controllers\Admin\Nathiraat\Stakeholders\Notes\NotesStakeholdersController::class, 'add_note']);
    });

    // Confirm bills
    Route::group([
        'prefix' => 'bills/waiting/confrim',
        'middleware' => ['permission:waiting_confirm'],
    ], function () {
        Route::get('/{type}', [App\Http\Controllers\Admin\Bills\ConfirmBillsController::class, 'show_bills']);
        Route::post('/', [App\Http\Controllers\Admin\Bills\ConfirmBillsController::class, 'confirm_bills'])->middleware(['permission:bill_confirm']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\ConfirmBillsController::class, 'show'])->middleware(['permission:bill_confirm_show']);
    });

    // Trusthworthy bill
    Route::group([
        'prefix' => 'bills/waiting/trustworthy',
        'middleware' => ['permission:waiting_trustworthy'],
    ], function () {
        Route::get('/{type}', [App\Http\Controllers\Admin\Bills\TrutworthyBillsController::class, 'show_bills']);
        Route::post('/', [App\Http\Controllers\Admin\Bills\TrutworthyBillsController::class, 'trustworthy_bills'])->middleware(['permission:bill_trustworthy']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\TrutworthyBillsController::class, 'show'])->middleware(['permission:bill_trustworthy_show']);
    });

    // Deposit money
    Route::group([
        'prefix' => 'bills/waiting/deposit',
        'middleware' => ['permission:waiting_deposit'],
    ], function () {
        Route::get('/{type}', [App\Http\Controllers\Admin\Bills\DepositBillsController::class, 'show_bills']);
        Route::post('/', [App\Http\Controllers\Admin\Bills\DepositBillsController::class, 'deposit_bills'])->middleware(['permission:bill_deposit']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\DepositBillsController::class, 'show'])->middleware(['permission:bill_deposit_show']);
    });

    // General box
    Route::group([
        'prefix' => 'general/box',
        'middleware' => ['permission:general_box'],
    ], function () {
        Route::get('/', [App\Http\Controllers\Admin\Bills\GeneralBoxController::class, 'show_general_box']);
        Route::post('/show', [App\Http\Controllers\Admin\Bills\GeneralBoxController::class, 'show'])->middleware(['permission:box_general_show']);
        // Route::post('/search', [App\Http\Controllers\Admin\Bills\GeneralBoxController::class, 'search']);
    });

    Route::group([
        'prefix' => 'tasks',
        'middleware' => ['permission:manage_tasks|user_own_tasks|task_add_new'],
    ], function () {
        Route::get('/add', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'add_show'])->middleware(['permission:task_add_new']);
        Route::post('/add', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'add_task']);
        Route::get('/user/department', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'user_department']);
    });

    Route::group([
        'prefix' => 'tasks',
        'middleware' => ['permission:manage_tasks'],
    ], function () {
        Route::get('/show/{state}', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'show_tasks']);
        Route::get('/show/complete/{state}', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'show_complete_tasks'])->middleware(['permission:complete_task']);
        Route::get('/make/uncomplete/{id}/{type}', [App\Http\Controllers\Admin\Tasks\ManageTaskController::class, 'make_uncomplate'])->middleware(['permission:complete_task']);
    });

    Route::group([
        'prefix' => 'tasks/user',
        'middleware' => ['permission:user_own_tasks'],
    ], function () {
        Route::get('/show/{state}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'show_tasks']);
        Route::get('/show/complete/{state}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'show_complete_tasks'])->middleware(['permission:complete_task']);
        Route::get('/add/{id}/{type}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'show_add']);
        Route::post('/add', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'save_tasks_result']);
    });

    Route::group([
        'prefix' => 'tasks',
        'middleware' => ['permission:user_manage|user_own_tasks'],
    ], function () {
        Route::get('/detials/{id}/{type}', [App\Http\Controllers\Admin\Tasks\ShowTaskController::class, 'show']);
        Route::get('/direct/{id}/{type}', [App\Http\Controllers\Admin\Tasks\ShowTaskController::class, 'direct'])->middleware(['permission:direct_task']);
        Route::post('/direct', [App\Http\Controllers\Admin\Tasks\ShowTaskController::class, 'direct_save']);
        Route::get('recived/{id}/{type}', [App\Http\Controllers\Admin\Tasks\UserTaskController::class, 'recieved_task']);
    });

    Route::group([
        'prefix' => 'import/export',
        'middleware' => ['permission:import_export'],
    ], function () {
        Route::get('/show/{type}', [App\Http\Controllers\Admin\ImportsAndExport\ImportsAndExportController::class, 'show']);
        Route::get('/add', [App\Http\Controllers\Admin\ImportsAndExport\ImportsAndExportController::class, 'add'])->middleware(['permission:add_import_export']);
        Route::post('/add', [App\Http\Controllers\Admin\ImportsAndExport\ImportsAndExportController::class, 'add_save']);

    });

    Route::group([
        'prefix' => 'covenant',

    ], function () {
        Route::get('/delivering', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'show_deliver'])->middleware(['permission:covenant_deliver_to']);
        Route::post('/delivering/send/code', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'send_code_user']);
        Route::post('/delivering/save', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'save_deliver']);

        Route::get('/show/user', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'show_user'])->middleware(['permission:manage_covenant']);
        Route::get('/show', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'show'])->middleware(['permission:manage_covenant_system']);
        Route::get('/add', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'show_add'])->middleware(['permission:covenant_add_new']);
        Route::post('/add', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'save_add']);

        Route::get('/delivery/{id}', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'delivery_covenant']);
        Route::get('/delivery/add/{id}', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'show_add'])->middleware(['permission:driver_add_convenant']);
        Route::get('/select/item', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'show_item']);
        Route::post('/delivery/add', [App\Http\Controllers\Admin\Driver\Covenant\CovenantDriverController::class, 'save_add']);

        Route::post('/delivery/user', [App\Http\Controllers\Admin\Covenant\CovenantManageController::class, 'receive_to_user']);
        Route::get('/show/note/{id}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'show_note']);
        Route::get('/add/note/{id}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'add_note']);
        Route::post('/add/note', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'save_note']);
        Route::get('/show/record/{id}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'show_record']);

        Route::group([
            'prefix' => 'item',
            // 'middleware' => ['permission:user_manage|user_own_tasks']
        ], function () {
            Route::get('/show/{covenant}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'show'])->middleware(['permission:covenant_show']);
            Route::get('/add/{id}', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'show_add']);
            Route::post('/delivery/add', [App\Http\Controllers\Admin\Covenant\CovenantItemManageController::class, 'save_add']);
        });
    }); // end covenant

    Route::group([
        'prefix' => 'warning',
        'middleware' => ['permission:warning_driver|warning_vechile|warning_user'],
    ], function () {
        Route::get('/driver/{type}', [App\Http\Controllers\Admin\Warning\DriverWarningController::class, 'show'])->middleware(['permission:warning_driver']);
        Route::post('/driver/update', [App\Http\Controllers\Admin\Warning\DriverWarningController::class, 'update_date'])->middleware(['permission:warning_driver']);
        Route::get('/vechile/{type}', [App\Http\Controllers\Admin\Warning\VechileWarningController::class, 'show'])->middleware(['permission:warning_vechile']);
        Route::post('/vechile/update', [App\Http\Controllers\Admin\Warning\VechileWarningController::class, 'update_date'])->middleware(['permission:warning_vechile']);
        Route::get('/user/{type}', [App\Http\Controllers\Admin\Warning\UserWarningController::class, 'show'])->middleware(['permission:warning_user']);
        Route::post('/user/update', [App\Http\Controllers\Admin\Warning\UserWarningController::class, 'update_date'])->middleware(['permission:warning_user']);
        Route::get('/driver/charts/show', [App\Http\Controllers\Admin\Warning\ChartsWarningController::class, 'show'])->middleware(['permission:warning_user']);
        Route::get('/contract', [App\Http\Controllers\Admin\Warning\ContractController::class, 'show_contract'])->middleware(['permission:warning_user']);
    });
    Route::group([
        'prefix' => 'maintenance',
        'middleware' => ['permission:maintenance_center'],
    ], function () {
        Route::get('/center/manage', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'show_products']);
        Route::get('/center/add', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'show_add'])->middleware(['permission:maintain_add_new_category']);
        Route::post('/center/add', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'save_add']);
        Route::post('/center/quantity', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'save_quantity']);
        Route::get('/center/update/{id}', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'show_update'])->middleware(['permission:maintain_update_category']);
        Route::post('/center/update', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'save_update']);
        Route::get('/center/show/{id}', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'show_details']);
        Route::get('/center/bill/{id}', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'show_bills']);
        Route::get('/center/show/detials/{id}', [App\Http\Controllers\Admin\Maintenance\MaintenanceController::class, 'show_details_quantity']);
        Route::get('/center/add/bill/{id}', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'show_add']);
        // Route::get('/center/item', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'show_item']);
        Route::post('/center/item', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'confirm_item']);
        Route::post('/center/item/save', [App\Http\Controllers\Admin\Maintenance\MaintenaceCenterController::class, 'save_item'])->name('items');
    });

    Route::group([
        'prefix' => 'bookings',

    ], function () {
        Route::get('/{request_state}', [\App\Http\Controllers\Admin\Booking\BookingController::class, 'requestsBooking']);
        Route::get('/discount/show', [\App\Http\Controllers\Admin\Booking\BookingController::class, 'show_discount'])->middleware(['permission:booking_show_precentage']);
        Route::post('/discount', [\App\Http\Controllers\Admin\Booking\BookingController::class, 'save_discount'])->middleware(['permission:booking_add_precentage']);
        Route::post('/discount/update', [\App\Http\Controllers\Admin\Booking\BookingController::class, 'save_update'])->middleware(['permission:booking_update_precentage']);
    });

    Route::group([
        'prefix' => 'bank/transfer',

    ], function () {
        Route::group([
            'prefix' => '/driver',

        ], function () {
            Route::get('/show', [\App\Http\Controllers\Admin\BankTransfer\BankTransferDriverController::class, 'show_request'])->middleware(['permission:bank_transfer_driver']);
            Route::get('/show/state/{type}', [\App\Http\Controllers\Admin\BankTransfer\BankTransferDriverController::class, 'show_state']);
            Route::get('/refused/{id}', [\App\Http\Controllers\Admin\BankTransfer\BankTransferDriverController::class, 'refused_request']);
            Route::get('/accept', [\App\Http\Controllers\Admin\BankTransfer\BankTransferDriverController::class, 'accept_request'])->name('accept.driver.transfer');
            Route::get('/add', [\App\Http\Controllers\Admin\BankTransfer\BankTransferDriverController::class, 'accept_request']);
            Route::post('/add', [\App\Http\Controllers\Admin\BankTransfer\BankTransferDriverController::class, 'accept_save']);
        });
        Route::group([
            'prefix' => '/rider',

        ], function () {
            Route::get('/show', [\App\Http\Controllers\Admin\BankTransfer\BankTransferClientController::class, 'show_request'])->middleware(['permission:bank_transfer_rider']);
            Route::get('/show/state/{type}', [\App\Http\Controllers\Admin\BankTransfer\BankTransferClientController::class, 'show_state']);
            Route::get('/refused/{id}', [\App\Http\Controllers\Admin\BankTransfer\BankTransferClientController::class, 'refused_request']);
            Route::get('/accept', [\App\Http\Controllers\Admin\BankTransfer\BankTransferClientController::class, 'accept_request'])->name('accept.rider.transfer');
            Route::get('/add', [\App\Http\Controllers\Admin\BankTransfer\BankTransferClientController::class, 'accept_request']);
            Route::post('/add', [\App\Http\Controllers\Admin\BankTransfer\BankTransferClientController::class, 'accept_save']);
        });
    });

    Route::group([
        'prefix' => 'groups',
        'middleware' => ['permission:manage_group|user_group'],
    ], function () {

        Route::get('/driver/warning/{type}/{id}', [App\Http\Controllers\Admin\Groups\GroupWarningController::class, 'show']);
        Route::get('/vechile/warning/{type}/{id}', [App\Http\Controllers\Admin\Groups\GroupWarningController::class, 'show_vechile']);
        Route::get('/show/drivers/{id}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'show_driver']);
        Route::get('/add/driver/{id}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'add_driver']);
        Route::get('/add/user/{id}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'add_user']);
        Route::get('/add/vechile/{id}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'add_vechile']);

        Route::post('/save/drivers', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'save_driver']);
        Route::post('/save/user', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'save_user']);
        Route::post('/save/vechile', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'save_vechile']);

        Route::get('/show/vechiles/{id}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'show_vechile']);
        Route::get('/show/users/{id}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'show_user']);
        Route::get('/user/state/{id}/{user_id}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'change_state']);

        Route::get('/secondary/category', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'secondary_category']);

        Route::group([
            'middleware' => ['permission:manage_group'],
        ], function () {
            Route::get('/show', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'show']);
            Route::post('/daily/price', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'update_vechile_price'])->middleware(['permission:group_update_price_vechile']);
            Route::get('/add', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'add_show'])->middleware(['permission:group_add_new']);
            Route::post('/add', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'save_add']);
            Route::get('/show/details/{group}', [App\Http\Controllers\Admin\Groups\GroupsController::class, 'show_details'])->name('groups.show.details');


        });
        Route::group([
            'middleware' => ['permission:user_group|manage_group'],
        ], function () {

            Route::get('/user/{id}', [App\Http\Controllers\Admin\Groups\GroupsUserController::class, 'show']);
            Route::get('/driver/detials/{id}/{groupid?}', [App\Http\Controllers\Admin\Groups\GroupsUserController::class, 'driver_show']);
            Route::get('/vechile/detials/{id}/{groupid?}', [App\Http\Controllers\Admin\Groups\GroupsUserController::class, 'vechile_show']);
            Route::get('/maintenance/{id}', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'vechile_show_maintenance']);

            Route::get('/user/detials/{id}/{groupid}', [App\Http\Controllers\Admin\Groups\GroupsUserController::class, 'user_show']);
            Route::get('/driver/box/show/{type}/{id}', [App\Http\Controllers\Admin\Groups\GroupsControllerBox::class, 'show_box']);
            Route::get('/driver/box/add/{id}', [App\Http\Controllers\Admin\Groups\GroupsControllerBox::class, 'show_add']);
            Route::post('/driver/box/save/{id}', [App\Http\Controllers\Admin\Groups\GroupsControllerBox::class, 'save_add']);

            Route::get('vechile/drivers/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'drivers']);
            Route::get('vechile/update/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_show']);
            Route::post('vechile/update', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_vechile']);
        });
    });

    Route::group([
        'prefix' => 'send/message',
        // 'middleware' => ['permission:warning_driver|warning_vechile|warning_user']
    ], function () {
        Route::group([
            'prefix' => 'driver',
            // 'middleware' => ['permission:warning_driver|warning_vechile|warning_user']
        ], function () {
            Route::get('/show/{type}', [App\Http\Controllers\Admin\SendMessage\SendMessageDriverController::class, 'show']);
            Route::post('/', [App\Http\Controllers\Admin\SendMessage\SendMessageDriverController::class, 'send_message'])->middleware(['permission:sms_send_driver']);
        });
        Route::group([
            'prefix' => 'rider',
            // 'middleware' => ['permission:warning_driver|warning_vechile|warning_user']
        ], function () {
            Route::get('/show/{type}', [App\Http\Controllers\Admin\SendMessage\SendMessageRiderController::class, 'show']);
            Route::post('/', [App\Http\Controllers\Admin\SendMessage\SendMessageRiderController::class, 'send_message'])->middleware(['permission:sms_send_rider']);
        });
    });
    Route::group([
        'prefix' => 'privacy/policy',
        // 'middleware' => ['permission:warning_driver|warning_vechile|warning_user']
    ], function () {
        Route::get('/manage/show/{belong}', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'show_privacy_policy']);
        Route::get('/show/add', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'add_privacy_policy']);
        Route::post('/show/add', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'save_privacy_policy']);
        Route::get('/show/update/{id}', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'update_privacy_policy']);
        Route::post('/show/update', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'update_privacy_policy_save']);
        Route::get('/show/details/{id}', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'details']);
    });

    Route::group([
        'prefix' => 'general',

    ], function () {
        Route::get('add/bond', [App\Http\Controllers\Admin\General\BondController::class, 'show_add']);
        Route::post('device/owner', [App\Http\Controllers\Admin\General\BondController::class, 'device_owner'])->name('selling.point.device.owner');
        Route::get('add/bond/selling/point', [App\Http\Controllers\Admin\General\BondController::class, 'show_selling_point'])->name('general.add.bond.selling.point.show');
        Route::post('save/bond/selling/point', [App\Http\Controllers\Admin\General\BondController::class, 'save_selling_point'])->name('general.add.bond.selling.point');


        Route::post('add/bond', [App\Http\Controllers\Admin\General\BondController::class, 'save_add']);
        Route::get('show/add/note', [App\Http\Controllers\Admin\General\NotesController::class, 'show_add_note']);
        Route::post('save/note', [App\Http\Controllers\Admin\General\NotesController::class, 'save_note']);
        Route::get('show/add/document', [App\Http\Controllers\Admin\General\DocumentsController::class, 'show_add_document']);
        Route::post('save/document', [App\Http\Controllers\Admin\General\DocumentsController::class, 'save_document']);
        Route::get('/show', [App\Http\Controllers\Admin\General\GeneralController::class, 'get_stakeholders']);
    });

    Route::group([
        'prefix' => 'manage/groups',
        'middleware' => ['permission:manage_group'],
    ], function () {
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Groups\GroupDriver\GroupDriverBalanceController::class, 'show_box'])->name('manage.groups.box.show');
        Route::get('/box/add/{id}', [App\Http\Controllers\Admin\Groups\GroupDriver\GroupDriverBalanceController::class, 'show_bond'])->name('manage.groups.box.add');
        Route::post('/box/add', [App\Http\Controllers\Admin\Groups\GroupDriver\GroupDriverBalanceController::class, 'add_box']);


        Route::get('/show', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'show_all_groups'])->name('manage.groups.show');
        Route::get('/add', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'add_show'])->name('manage.groups.add');
        Route::post('/add', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'save_add'])->name('manage.groups.add');
        Route::get('/update/{group}', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'update_show'])->name('manage.groups.update');
        Route::post('/update/{group}', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'update_save'])->name('manage.groups.update');


        Route::get('license/show/{type}', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'license_show'])->name('manage.groups.license.show');
        Route::get('license/change/{type}/{id}', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'license_change'])->name('manage.groups.license.change');


        Route::get('/change/state/{group}', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'state_show'])->name('manage.groups.state');
        Route::post('/change/state/{group}', [App\Http\Controllers\Admin\Groups\ManageGroups\ManageGroupsController::class, 'state_save'])->name('manage.groups.state');

    });
    Route::group([
        'prefix' => 'my/groups',
        'middleware' => ['permission:user_group'],
    ], function () {

        Route::get('/covenant/notes/show/{group}/{id}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'show_covanent_notes'])->name('my.groups.covenant.show.notes');
        Route::get('/covenant/notes/add/{group}/{id}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'show_covanent_note_add'])->name('my.groups.covenant.add.notes');
        Route::post('/covenant/notes/save/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'save_covanent_note'])->name('my.groups.covenant.save.notes');

        Route::get('/covenant/show/history/{group}/{id}', [App\Http\Controllers\Admin\Groups\MyGroups\GroupCovanentRecord::class, 'show_history'])->name('my.groups.covenant.show.history');

        Route::get('/covenant/show/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'show'])->name('my.groups.covenant.show');
        Route::get('/covenant/add/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'show_add'])->name('my.groups.covenant.add');
        Route::post('/covenant/save/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'save_add'])->name('my.groups.covenant.save');
        Route::get('/covenant/delivering/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'show_delivering'])->name('my.groups.covenant.delivering');
        Route::post('/covenant/delivering/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'save_delivering'])->name('my.groups.covenant.delivering');

        Route::get('/covenant/delivering/driver/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'show_delivering_driver'])->name('my.groups.covenant.delivering.driver');
        Route::post('/covenant/delivering/driver/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\CovenantGroupController::class, 'save_delivering_driver'])->name('my.groups.covenant.delivering.driver');

        Route::get('/show', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'show_my_group']);

        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'show_box']);


        Route::get('/add/renew/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'renew_show'])->name('my.groups.renew');
        Route::post('/add/renew/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'renew_save'])->name('my.groups.renew');

        Route::get('/add/license/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'license_show'])->name('my.groups.license');
        Route::post('/add/license/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'license_save'])->name('my.groups.license');


        Route::get('/show', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'show_my_group']);
        Route::get('/details/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'show_my_group_details'])->name('my.groups.details');
        Route::get('/box/show/{type}/{id}', [App\Http\Controllers\Admin\Groups\MyGroups\MyGroupsController::class, 'show_box']);
    });
    Route::group([
        'prefix' => 'shared/groups',
        'middleware' => ['permission:manage_group|user_group'],
    ], function () {
        Route::get('/general/box/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'general_box'])->name('shared.groups.general.box');
        Route::get('/show/tax/{group}/{year?}', [App\Http\Controllers\Admin\Groups\SharedGroups\TaxController::class, 'show_tax'])->name('shared.groups.show.tax');
        Route::post('/show/tax/spend/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\TaxController::class, 'spend_tax'])->name('shared.groups.show.tax.spend');

        Route::get('/show/contracts/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'show_contracts']);
        Route::post('/contract/send/code', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractConfirmController::class, 'send_code_driver']);
        Route::post('/user/contract/send/code', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractConfirmController::class, 'send_code_user']);
        Route::post('/contract/adddata', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'save_data']);
        Route::post('/contract/extension', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'extension_contract']);
        Route::post('/contract/end/endview', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'end_contract_view']);
        Route::post('/contract/end/save', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'end_contract']);
        Route::get('/contract/{id?}', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'show_adding']);
        Route::get('/contract/show/details/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'show_contract_details']);
        Route::get('/contract/end/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'end_contract_show']);
        Route::post('/contract/views', [App\Http\Controllers\Admin\Groups\SharedGroups\contract\ContractGroupController::class, 'view_contract']);

        Route::get('/renew/{group}', [App\Http\Controllers\Admin\Groups\MyGroups\renewGroupController::class, 'renew_save'])->name('shared.groups.renew');

        Route::get('/importandexport/show/{type}/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\ImportsAndExport\ImportAndExportGroupController::class, 'show']);
        Route::get('/importandexport/add/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\ImportsAndExport\ImportAndExportGroupController::class, 'add']);
        Route::post('/importandexport/add', [App\Http\Controllers\Admin\Groups\SharedGroups\ImportsAndExport\ImportAndExportGroupController::class, 'add_save']);

        Route::get('/driver/state/{group}/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'change_driver_state']);
        Route::get('/driver/update/{id}/{groupid}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'update_driver_show']);
        Route::post('/driver/update/save', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'update_driver_save']);
        Route::get('/vechile/state/{group}/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'change_vechile_state']);
        Route::get('/details/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'group_details'])->name('shared.groups.details');
        Route::get('/show/contracts/{id}/{state}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'show_contracts']);
        Route::get('/show/vechiles/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'show_vechile'])->name('shared.groups.vechiles.show');


        Route::get('/show/users/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'show_user']);
        Route::get('/user/detials/{id}/{groupid}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'user_show']);
        Route::get('/add/user/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'add_user']);
        Route::post('/save/user',[ App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'save_user']);
        Route::get('/user/state/{id}/{user_id}', [ App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'change_state']);

        Route::get('/show/drivers/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'show_driver']);
        Route::get('/driver/detials/{id}/{groupid?}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'driver_show']);

         Route::get('/add/vechile/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'add_vechile'])->name('shared.groups.vechile.add');;
         Route::post('/save/vechile', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'save_vechile']);


         Route::get('/driver/box/show/{driver}/{group}/{type}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'show_box_driver'])->name('shared.groups.driver.box.show');
         Route::get('/driver/box/add/{driver}/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'show_add_driver'])->name('shared.groups.driver.box.add');
         Route::post('/driver/box/save/{driver}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'save_add_driver'])->name('shared.groups.driver.box.save');

         Route::get('/vechile/box/show/{vechile}/{group}/{type}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'show_box_vechile'])->name('shared.groups.vechile.box.show');
         Route::get('/vechile/box/add/{vechile}/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'show_add_vechile'])->name('shared.groups.vechile.box.add');
         Route::post('/vechile/box/save/{vechile}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'save_add_vechile'])->name('shared.groups.vechile.box.save');

         Route::get('/user/box/show/{user}/{group}/{type}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'show_box_user'])->name('shared.groups.user.box.show');
         Route::get('/user/box/add/{user}/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'show_add_user'])->name('shared.groups.user.box.add');
         Route::post('/user/box/save/{user}/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'save_add_user'])->name('shared.groups.user.box.save');

         Route::post('general/box/search/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\InternalBoxController::class, 'general_box_bonds'])->name('shared.groups.general.box.search');

         Route::get('/add/driver/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'add_driver']);
         Route::post('/save/drivers', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'save_driver']);

         Route::get('/driver/warning/{type}/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\WariningGroupsController::class, 'show_driver_warning']);
         Route::get('/vechile/warning/{type}/{id}', [App\Http\Controllers\Admin\Groups\SharedGroups\WariningGroupsController::class, 'show_vechile_warning']);


         Route::get('/vechile/detials/{id}/{groupid?}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'vechile_show']);
         Route::get('vechile/drivers/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'drivers']);
         Route::get('vechile/update/{id}', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_show']);
         Route::post('vechile/update', [App\Http\Controllers\Admin\Vechile\VechileController::class, 'update_vechile']);
         Route::get('/maintenance/{id}', [App\Http\Controllers\Admin\Driver\Maintenance\MaintenanceController::class, 'vechile_show_maintenance']);

        /*******************************************/

        Route::get('/show/document/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\Documents\DocumentsControllers::class, 'document_all_show'])->name('shared.groups.document.show');

        Route::get('/add/document/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\Documents\DocumentsControllers::class, 'document_show'])->name('shared.groups.document');
        Route::post('/add/document/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\Documents\DocumentsControllers::class, 'document_save'])->name('shared.groups.document');

        Route::get('/show/note/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\Notes\NotesControllers::class, 'note_all_show'])->name('shared.groups.note.show');

        Route::get('/add/note/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\Notes\NotesControllers::class, 'note_show'])->name('shared.groups.note');
        Route::post('/add/note/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\Notes\NotesControllers::class, 'note_save'])->name('shared.groups.note');

        Route::get('/license/show/{group}', [App\Http\Controllers\Admin\Groups\SharedGroups\SharedGroupsController::class, 'license_show'])->name('shared.groups.license.show');
    });

    Route::group([
        'prefix' => 'tax',
        'middleware' => ['permission:tax_bill'],
    ], function () {
        Route::get('/show/{year?}', [App\Http\Controllers\Admin\Bills\TaxController::class, 'show'])->name('tax.show');
        Route::post('company/show/spend', [App\Http\Controllers\Admin\Bills\TaxController::class, 'spend_tax'])->name('company.show.tax.spend');
    });

}); //end middleware auth:admin all

Route::get('data', [App\Http\Controllers\AuthController::class, 'data']);
Route::get('about/us', [App\Http\Controllers\AuthController::class, 'about_us']);
Route::get('privacy/policy/{type}/{lang?}', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'privacy_policy']);
Route::get('terms/conditions/{type}/{lang?}', [App\Http\Controllers\Admin\DriverRider\DriverRiderController::class, 'terms_conditions']);

Route::get('/ios/client', function () {
    return redirect('https://apps.apple.com/sa/app/%D8%AA%D8%A7%D9%83%D8%B3%D9%8A-%D8%A7%D9%84%D8%AC%D9%88%D8%A7%D8%A8-%D8%AA%D8%B7%D8%A8%D9%8A%D9%82-%D8%A7%D9%84%D8%B9%D9%85%D9%8A%D9%84/id1626082288?l=ar');
});
Route::get('/ios/driver', function () {
    return redirect('https://apps.apple.com/sa/app/%D9%83%D8%A7%D8%A8%D8%AA%D9%86-%D8%A7%D9%84%D8%AC%D9%88%D8%A7%D8%A8/id1626634706?l=ar');
});
Route::get('/android/client', function () {
    return redirect('https://play.google.com/store/apps/details?id=com.taxialjawabb.aljwab_cleint.aljwab_cleint');
});
Route::get('/android/driver', function () {
    return redirect('https://play.google.com/store/apps/details?id=com.taxialjawabb.aljwab_driver.aljwab_driver');
});
