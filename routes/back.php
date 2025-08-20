<?php

use App\Models\Back\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::fallback(function () {
    return view("back.404");
});

Route::get('403', function () {
    return view("back.403");
});

// Start Auth Route
Route::group(['namespace' => 'App\Http\Controllers\Back'], function(){
    Route::get('/login', function(){
        // $settings = Setting::first();
        return view('back.auth.login');
    });

    Route::post('login_post' , 'HomeController@login_post');
});


// Route::group(['prefix' => 'admin/forget_password'], function(){
//     Route::get('/', function(){
//         return view('back.auth.forget_password');
//     });
// });

// clear_cache
Route::get('clear_cache', function() {
    Artisan::call('cache:clear');
    return "cleared cache";
});






// , 'middleware' => 'checkLogin' , 'middleware' => 'throttle'
Route::group(['prefix' => '/', 'namespace' => 'App\Http\Controllers\Back', 'middleware' => 'checkLogin'], function(){



    Route::get('teacher_dash', function(){
        return 'teacher_dash Page';
    });

    Route::get('user_dash', function(){
        return 'user dash Pageeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
    });








    Route::get('/', 'HomeController@index');

    Route::get('logout' , 'HomeController@logout');



    ////////////////////////////////////////////////////////////////////////////////
    // Admin Home Page
    Route::get('/temp-dark', function(){
    return view('back.temp_dark.index');
    });
    

    // crm_columns_name Routes
    Route::group(['prefix' => 'crm/columns_name'] , function (){
        Route::get('/' , 'CrmColumnsNamesController@index');
        Route::get('/lastOrderNumber/{id}' , 'CrmColumnsNamesController@lastOrderNumber');
        Route::post('/store' , 'CrmColumnsNamesController@store');
        Route::get('/edit/{id}' , 'CrmColumnsNamesController@edit');
        Route::post('/update/{id}' , 'CrmColumnsNamesController@update');
        Route::get('/destroy/{id}' , 'CrmColumnsNamesController@destroy');

        Route::get('/datatable' , 'CrmColumnsNamesController@datatable');
    });


    // users Routes
    Route::group(['prefix' => 'users'] , function (){
        Route::get('/' , 'UsersController@index');
        Route::post('/store' , 'UsersController@store');
        Route::get('/edit/{id}' , 'UsersController@edit');
        Route::post('/update/{id}' , 'UsersController@update');
        Route::get('/destroy/{id}' , 'UsersController@destroy');
        
        Route::get('/changeAcademucYear/{id}' , 'UsersController@changeAcademucYear');

        Route::get('export' , 'UsersController@export');
        Route::get('datatable' , 'UsersController@datatable');
    });


    // teachers Routes
    Route::group(['prefix' => 'teachers'] , function (){
        Route::get('/' , 'TeachersController@index');
        Route::post('/store' , 'TeachersController@store');
        Route::get('/show/{id}' , 'TeachersController@show');
        Route::get('/edit/{id}' , 'TeachersController@edit');
        Route::post('/update/{id}' , 'TeachersController@update');
        Route::get('/destroy/{id}' , 'TeachersController@destroy');

        Route::get('datatable' , 'TeachersController@datatable');
        
        Route::get('/related-data' , 'TeachersController@related_data');
        
        // تقرير عن كشف التزام المدرسين  
        Route::group(['prefix' => 'report/commitment'] , function (){
            Route::get('/' , 'ReportsTeacherCommitmentController@index');
            Route::get('datatable' , 'ReportsTeacherCommitmentController@datatable');
            Route::get('/result/pdf' , 'ReportsTeacherCommitmentController@result_pdf');
        });

        // تقرير عن حصص الطلاب لمدرس  
        Route::group(['prefix' => 'report/students_classes'] , function (){
            Route::get('/' , 'ReportsTeacherStudentsClassesController@index');
            Route::get('/result/pdf' , 'ReportsTeacherStudentsClassesController@result_pdf');
        });
    });

    // teacher_subjects Routes    الصفوف والمواد الدراسية الخاصة بمدرس
    Route::group(['prefix' => 'teacher_subjects'] , function (){        
        Route::get('/{id}' , 'TeacherSubjectsController@index');
        Route::post('/store/{teacherId}/{matId}' , 'TeacherSubjectsController@store');
        Route::get('/show/{id}' , 'TeacherSubjectsController@show');
        Route::get('/edit/{id}' , 'TeacherSubjectsController@edit');
        Route::post('/update/{id}' , 'TeacherSubjectsController@update');
        Route::get('/destroy/{id}' , 'TeacherSubjectsController@destroy');
        
        Route::get('datatable/{id}' , 'TeacherSubjectsController@datatable');
    });


    // parents Routes
    Route::group(['prefix' => 'parents'] , function (){
        Route::get('/' , 'ParentController@index');
        Route::post('/store' , 'ParentController@store');
        Route::get('/show/{id}' , 'ParentController@show');
        Route::get('/edit/{id}' , 'ParentController@edit');
        Route::post('/update/{id}' , 'ParentController@update');
        Route::get('/destroy/{id}' , 'ParentController@destroy');
    
        Route::get('datatable' , 'ParentController@datatable');
    
        Route::get('/related-data' , 'ParentController@related_data');

        
        // تقرير عن كشف تفقد حضور وغياب الطلاب لولي امر  
        Route::group(['prefix' => 'report/attendance'] , function (){
            Route::get('/' , 'ReportsParentAttendanceController@index');
            Route::get('/result/pdf' , 'ReportsParentAttendanceController@result_pdf');
        });

        // crm routs
        Route::get('/crm_info/{id}' , 'ParentController@crm_info');
        Route::post('/crm_info_update/{id}' , 'ParentController@crm_info_update');
        Route::group(['prefix' => 'report'], function(){
            Route::get('/crm_pdf/{id}', 'ParentController@crm_pdf');
        });
    });
    
    // students Routes
    Route::group(['prefix' => 'students'] , function (){
        Route::get('/' , 'StudentsController@index');
        Route::post('/store' , 'StudentsController@store');
        Route::get('/show/{id}' , 'StudentsController@show');
        Route::get('/edit/{id}' , 'StudentsController@edit');
        Route::post('/update/{id}' , 'StudentsController@update');
        Route::get('/destroy/{id}' , 'StudentsController@destroy');
        
        Route::get('datatable' , 'StudentsController@datatable');
    });
    
    // students_wishlist Routes    موديول رغبات الطالب && موديول لائحة رغبات الطلاب
    Route::group(['prefix' => 'students_wishlist'] , function (){
        // start لائحة رغبات الطلاب
        Route::get('/' , 'StudentsWishlistController@index');
        Route::get('datatable' , 'StudentsWishlistController@datatable'); // Datatable لائحة رغبات الطلاب 
        // end لائحة رغبات الطلاب
        
        
        // start رغبات الطالب
        Route::get('/{id}' , 'StudentsWishlistController@index_student_wishlist');
        Route::post('/store/{studentId}/{matId}' , 'StudentsWishlistController@store');
        Route::get('/show/{id}' , 'StudentsWishlistController@show');
        Route::get('/edit/{id}' , 'StudentsWishlistController@edit');
        Route::post('/update/{id}' , 'StudentsWishlistController@update');
        Route::get('/destroy/{id}' , 'StudentsWishlistController@destroy');
        
        Route::get('datatable_student_wishlist/{id}' , 'StudentsWishlistController@datatable_student_wishlist'); // Datatable رغبات الطالب 
        // end رغبات الطالب
    });
   


    // partners Routes
    Route::group(['prefix' => 'partners'] , function (){
        Route::get('/' , 'PartnersController@index');
        Route::post('/store' , 'PartnersController@store');
        Route::get('/edit/{id}' , 'PartnersController@edit');
        Route::post('/update/{id}' , 'PartnersController@update');
        Route::get('/destroy/{id}' , 'PartnersController@destroy');
        
        Route::post('store_client_from_pos_page' , 'PartnersController@storeClientFromPosPage');
        Route::post('/import' , 'PartnersController@import');
        Route::get('datatable' , 'PartnersController@datatable');

        //تقرير عن حركة شريك
        Route::group(['prefix' => 'report'] , function (){
            Route::get('/' , 'ReportsPartnersController@index');
            Route::get('result' , 'ReportsPartnersController@result');
            Route::get('result/pdf' , 'ReportsPartnersController@result_pdf'); // خاص بتقرير عن حركة الجةة pdf
            Route::get('account_statement' , 'ReportsPartnersController@account_statement'); // خاص بكشف الحساب
            Route::get('account_statement/pdf' , 'ReportsPartnersController@account_statement_pdf'); // خاص بكشف الحساب pdf
        });
    });
    
    // partners_payments Routes
    Route::group(['prefix' => 'partners_payments'] , function (){
        Route::get('/' , 'PartnersPaymentsController@index');
        Route::post('/store' , 'PartnersPaymentsController@store');
        Route::get('/edit/{id}' , 'PartnersPaymentsController@edit');
        Route::post('/update/{id}' , 'PartnersPaymentsController@update');
        
        Route::get('datatable' , 'PartnersPaymentsController@datatable');
    });



    // times Routes
    Route::group(['prefix' => 'times'] , function (){
        Route::get('/' , 'TimesController@index');
        Route::post('/store' , 'TimesController@store');
        Route::get('/edit/{id}' , 'TimesController@edit');
        Route::post('/update/{id}' , 'TimesController@update');
        Route::get('/destroy/{id}' , 'TimesController@destroy');

        Route::get('datatable' , 'TimesController@datatable');
    });


    // time_table Routes
    Route::group(['prefix' => 'time_table'] , function (){
        Route::get('/' , 'TimeTableController@index');

        Route::get('/get_available_times_to_add_form' , 'TimeTableController@get_available_times_to_add_form');
        Route::get('/get_available_times_to_edit_form' , 'TimeTableController@get_available_times_to_edit_form');

        Route::get('/remove_recorded_times' , 'TimeTableController@remove_recorded_times');

        Route::post('/store' , 'TimeTableController@store');

        Route::get('/edit/{group_id}/{group_to_colspan}' , 'TimeTableController@edit');

        Route::get('/update/{id}' , 'TimeTableController@update');
        Route::get('/destroy/{id}' , 'TimeTableController@destroy');

        Route::get('datatable' , 'TimeTableController@datatable');

        // navbar search to get groups or classes
        Route::get('navbar_search_in_time_table' , 'TimeTableController@navbar_search_in_time_table');


        // teacher_report
        Route::get('teacher_report' , 'TimeTableReportsController@teacher_report_get');
        Route::post('teacher_pdf' , 'TimeTableReportsController@teacher_pdf');

        // groups_report
        Route::get('groups_report' , 'TimeTableReportsController@groups_report_get');
        Route::get('groups_report/get_groups/{id}' , 'TimeTableReportsController@get_groups');
        Route::post('groups_pdf' , 'TimeTableReportsController@groups_pdf');
    });

    // time_table_history Routes
    Route::group(['prefix' => 'time_table_history'] , function (){
        Route::get('/' , 'TimeTableHistoryController@index');
        Route::post('/store' , 'TimeTableHistoryController@store');
        Route::get('/edit/{id}' , 'TimeTableHistoryController@edit');
        Route::post('/update/{id}' , 'TimeTableHistoryController@update');
        Route::get('/destroy/{id}' , 'TimeTableHistoryController@destroy');

        Route::get('datatable' , 'TimeTableHistoryController@datatable');
    });


    /* -------------------------------------------------------------------------- */
    /*               Start time_table_ramadan_month  شهر رمضان                   */
    /* -------------------------------------------------------------------------- */

        // time_table_ramadan_month Routes
        Route::group(['prefix' => 'time_table_ramadan_month'] , function (){
            Route::get('/' , 'TimeTableRamadanMonthController@index');

            Route::get('/get_available_times_to_add_form' , 'TimeTableRamadanMonthController@get_available_times_to_add_form');
            Route::get('/get_available_times_to_edit_form' , 'TimeTableRamadanMonthController@get_available_times_to_edit_form');

            Route::get('/remove_recorded_times' , 'TimeTableRamadanMonthController@remove_recorded_times');

            Route::post('/store' , 'TimeTableRamadanMonthController@store');

            Route::get('/edit/{group_id}/{group_to_colspan}' , 'TimeTableRamadanMonthController@edit');

            Route::get('/update/{id}' , 'TimeTableRamadanMonthController@update');
            Route::get('/destroy/{id}' , 'TimeTableRamadanMonthController@destroy');

            Route::get('datatable' , 'TimeTableRamadanMonthController@datatable');

            // teacher_report
            Route::get('teacher_report' , 'TimeTableRamadanMonthReportsController@teacher_report_get');
            Route::post('teacher_pdf' , 'TimeTableRamadanMonthReportsController@teacher_pdf');

            // groups_report
            Route::get('groups_report' , 'TimeTableRamadanMonthReportsController@groups_report_get');
            Route::get('groups_report/get_groups/{id}' , 'TimeTableRamadanMonthReportsController@get_groups');
            Route::post('groups_pdf' , 'TimeTableRamadanMonthReportsController@groups_pdf');
        });



        // time_table_ramadan_month_history Routes
        Route::group(['prefix' => 'time_table_ramadan_month_history'] , function (){
            Route::get('/' , 'TimeTableRamadanMonthHistoryController@index');
            Route::post('/store' , 'TimeTableRamadanMonthHistoryController@store');
            Route::get('/edit/{id}' , 'TimeTableRamadanMonthHistoryController@edit');
            Route::post('/update/{id}' , 'TimeTableRamadanMonthHistoryController@update');
            Route::get('/destroy/{id}' , 'TimeTableRamadanMonthHistoryController@destroy');

            Route::get('datatable' , 'TimeTableRamadanMonthHistoryController@datatable');
        });
        
    /* -------------------------------------------------------------------------- */
    /*                End time_table_ramadan_month  شهر رمضان                   */
    /* -------------------------------------------------------------------------- */



    // students_estimates Routes
    Route::group(['prefix' => 'students_estimates',  'middleware' => 'checkRole:1,2,4'] , function (){

        Route::get('/' , 'StudentsRatesController@index');

        Route::get('/getStudentsToEstimate/{groupId}' , 'StudentsRatesController@getStudentsToEstimate');


        Route::get('/get_groups_by_teacher_date/{fromtDate}/{toDate}/{teacher}' , 'StudentsRatesController@get_groups_by_teacher_date');

        Route::post('/store' , 'StudentsRatesController@store');

        Route::get('/show/{group}/{month}' , 'StudentsRatesController@show');

        Route::get('/edit/{group}/{month}' , 'StudentsRatesController@edit');

        Route::post('/update/{group}/{month}' , 'StudentsRatesController@update');
        Route::get('/destroy/{group}/{month}' , 'StudentsRatesController@destroy');

        Route::get('datatable' , 'StudentsRatesController@datatable');


        // groups_report
        Route::get('groups_report' , 'StudentsRatesReportsController@groups_report_get')->middleware('checkRole:1,2');
        Route::post('groups_pdf' , 'StudentsRatesReportsController@groups_pdf')->middleware('checkRole:1,2');


        // groups_rated_report
        Route::get('groups_rated_report' , 'StudentsRatesReportsController@groups_rated_report_get');
        Route::post('groups_rated_pdf' , 'StudentsRatesReportsController@groups_rated_pdf');


        // groups_not_rated_report
        Route::get('groups_not_rated_report' , 'StudentsRatesReportsController@groups_not_rated_report_get');
        Route::post('groups_not_rated_pdf' , 'StudentsRatesReportsController@groups_not_rated_pdf');


        // student_report
        Route::get('student_report' , 'StudentsRatesReportsController@student_report_get')->middleware('checkRole:1,2');
        Route::post('student_pdf' , 'StudentsRatesReportsController@student_pdf')->middleware('checkRole:1,2');
    });



    // academic_years Routes   سنوات الأكاديمية
    Route::group(['prefix' => 'academic_years'] , function (){
        Route::get('/' , 'AcademicYearsController@index');
        Route::post('/store' , 'AcademicYearsController@store');
        Route::get('/edit/{id}' , 'AcademicYearsController@edit');
        Route::post('/update/{id}' , 'AcademicYearsController@update');
        Route::get('/destroy/{id}' , 'AcademicYearsController@destroy');
        
        Route::get('datatable' , 'AcademicYearsController@datatable');
    });
    
    
    // rooms Routes   الغرف الدراسية
    Route::group(['prefix' => 'rooms'] , function (){
        Route::get('/' , 'RoomsController@index');
        Route::post('/store' , 'RoomsController@store');
        Route::get('/edit/{id}' , 'RoomsController@edit');
        Route::post('/update/{id}' , 'RoomsController@update');

        Route::get('datatable' , 'RoomsController@datatable');
    });
    
    // wallets Routes   المحافظ
    Route::group(['prefix' => 'wallets'] , function (){
        Route::get('/' , 'WalletsController@index');
        Route::post('/store' , 'WalletsController@store');
        Route::get('/edit/{id}' , 'WalletsController@edit');
        Route::post('/update/{id}' , 'WalletsController@update');

        Route::get('datatable' , 'WalletsController@datatable');
    });
    
    // financial_categories Routes   تصنيفات العمليات المالية
    Route::group(['prefix' => 'financial_categories'] , function (){
        Route::get('/' , 'FinancialCategoriesController@index');
        Route::post('/store' , 'FinancialCategoriesController@store');
        Route::get('/edit/{id}' , 'FinancialCategoriesController@edit');
        Route::post('/update/{id}' , 'FinancialCategoriesController@update');

        Route::get('datatable' , 'FinancialCategoriesController@datatable');
    });
    
    // price_list Routes   جدول الاسعار
    Route::group(['prefix' => 'price_list'] , function (){
        Route::get('/' , 'PriceListController@index');
        Route::post('/store' , 'PriceListController@store');
        Route::get('/edit/{id}' , 'PriceListController@edit');
        Route::post('/update/{id}' , 'PriceListController@update');

        Route::get('datatable' , 'PriceListController@datatable');
    });


    // types_of_education Routes   انواع التعليم
    Route::group(['prefix' => 'types_of_education'] , function (){
        Route::get('/' , 'TypesOfEducationController@index');
        Route::post('/store' , 'TypesOfEducationController@store');
        Route::get('/edit/{id}' , 'TypesOfEducationController@edit');
        Route::post('/update/{id}' , 'TypesOfEducationController@update');

        Route::get('datatable' , 'TypesOfEducationController@datatable');
    });

    // nationalities Routes   الجنسيات
    Route::group(['prefix' => 'nationalities'] , function (){
        Route::get('/' , 'NationalitiesController@index');
        Route::post('/store' , 'NationalitiesController@store');
        Route::get('/edit/{id}' , 'NationalitiesController@edit');
        Route::post('/update/{id}' , 'NationalitiesController@update');

        Route::get('datatable' , 'NationalitiesController@datatable');
    });

    // places_of_stay Routes  اماكن الاقامة
    Route::group(['prefix' => 'places_of_stay'] , function (){
        Route::get('/' , 'PlacesOfStayController@index');
        Route::post('/store' , 'PlacesOfStayController@store');
        Route::get('/edit/{id}' , 'PlacesOfStayController@edit');
        Route::post('/update/{id}' , 'PlacesOfStayController@update');

        Route::get('datatable' , 'PlacesOfStayController@datatable');
    });
    
    
    // teacher_accounting_type Routes  طريقة حساب المدرس
    Route::group(['prefix' => 'teacher_accounting_type'] , function (){
        Route::get('/' , 'TeacherAccountingTypeController@index');
        Route::post('/store' , 'TeacherAccountingTypeController@store');
        Route::get('/edit/{id}' , 'TeacherAccountingTypeController@edit');
        Route::post('/update/{id}' , 'TeacherAccountingTypeController@update');

        Route::get('datatable' , 'TeacherAccountingTypeController@datatable');
    });

    // subjects Routes   المواد الدراسية
    Route::group(['prefix' => 'subjects'] , function (){
        Route::get('/' , 'SubjectsController@index');
        Route::post('/store' , 'SubjectsController@store');
        Route::get('/edit/{id}' , 'SubjectsController@edit');
        Route::post('/update/{id}' , 'SubjectsController@update');

        Route::get('datatable' , 'SubjectsController@datatable');
    });
    
    // groups Routes   المجموعات التعليمية
    Route::group(['prefix' => 'groups'] , function (){
        Route::get('/' , 'GroupsController@index');
        Route::post('/store' , 'GroupsController@store');
        Route::post('/store_students_to_group' , 'GroupsController@store_students_to_group');
        
        Route::get('/edit/{id}' , 'GroupsController@edit');
        Route::post('/update/{id}' , 'GroupsController@update');

        Route::get('/show_students/{id}/{group}' , 'GroupsController@show_students');
        Route::get('/destroy/{id}' , 'GroupsController@destroy');
        Route::post('/close_group/{id}' , 'GroupsController@close_group');

        Route::post('/remove_all_students_by_group/{group}' , 'GroupsController@remove_all_students_by_group');
        Route::post('/remove_one_student/{group}/{student_id}' , 'GroupsController@remove_one_student');

        Route::get('datatable' , 'GroupsController@datatable');
    });
    
    // parent-payments Routes   متحصلات من أولياء الأمور
    Route::group(['prefix' => 'parent-payments'] , function (){
        Route::get('/' , 'ParentsPaymentsController@index');
        Route::post('/store' , 'ParentsPaymentsController@store');
        Route::get('/edit/{id}' , 'ParentsPaymentsController@edit');
        Route::post('/update/{id}' , 'ParentsPaymentsController@update');
        Route::get('/destroy/{id}' , 'ParentsPaymentsController@destroy');

        Route::get('datatable' , 'ParentsPaymentsController@datatable');

        // تقرير عن كشف مدفوعات ولي أمر  
        Route::group(['prefix' => 'report'] , function (){
            Route::get('/' , 'ReportsParentPaymentsController@index');
            Route::get('result/pdf' , 'ReportsParentPaymentsController@result_pdf');
        });
    });
    
    // teacher-salaries Routes   أجور المدرسين
    Route::group(['prefix' => 'teacher-salaries'] , function (){
        Route::get('/' , 'TeacherSalaryController@index');
        Route::post('/store' , 'TeacherSalaryController@store');        
        Route::get('/edit/{id}' , 'TeacherSalaryController@edit');
        Route::post('/update/{id}' , 'TeacherSalaryController@update');
        Route::get('/destroy/{id}' , 'TeacherSalaryController@destroy');
        Route::get('datatable' , 'TeacherSalaryController@datatable');

        // تقرير عن كشف مدفوعات المدرسين  
        Route::group(['prefix' => 'report'] , function (){
            Route::get('/' , 'ReportsTeacherSalaryController@index');
            Route::get('result' , 'ReportsTeacherSalaryController@result');
            Route::get('result/pdf' , 'ReportsTeacherSalaryController@result_pdf');
        });
    });
   
    // groups-sessions Routes   حصص المجموعات التعليمية
    Route::group(['prefix' => 'groups-sessions'] , function (){
        Route::get('/{id}' , 'GroupSessionsController@index');
        Route::post('/store' , 'GroupSessionsController@store');

        Route::get('/take_attendance/{group}' , 'GroupsController@take_attendance');

        Route::get('/edit/{id}' , 'GroupSessionsController@edit');
        Route::post('/update/{id}' , 'GroupSessionsController@update');
        Route::get('/destroy/{id}' , 'GroupSessionsController@destroy');
        Route::get('datatable/{id}' , 'GroupSessionsController@datatable');
    });
    
    // groups-sessions/attendance Routes   تفقد الحضور والغياب للطلاب 🎓📋
    Route::group(['prefix' => 'groups-sessions/attendance'] , function (){
        Route::get('/{groupId}/{sessionId}' , 'GroupSessionsAttendanceController@index');

        Route::post('/store/{group_id}/{session_id}' , 'GroupSessionsAttendanceController@store');

        Route::post('/close_open_session/{sessionId}' , 'GroupSessionsAttendanceController@close_open_session');


        Route::get('/edit/{id}' , 'GroupSessionsAttendanceController@edit');
        Route::post('/update/{id}' , 'GroupSessionsAttendanceController@update');
        Route::get('/destroy/{id}' , 'GroupSessionsAttendanceController@destroy');
        Route::get('datatable/{groupId}/{sessionId}' , 'GroupSessionsAttendanceController@datatable');
    });

    // general_settings Routes  الاعدادات العامة
    Route::group(['prefix' => 'general_settings'] , function (){
        Route::get('/' , 'SettingController@index');
        Route::post('/update' , 'SettingController@update');

        Route::get('datatable' , 'SettingController@datatable');
    });

    // roles_permissions Routes
    Route::group(['prefix' => 'roles_permissions'] , function (){
        Route::get('/' , 'RolesPermissionsController@index');
        Route::get('create' , 'RolesPermissionsController@create');
        Route::post('/store' , 'RolesPermissionsController@store');
        Route::get('/edit/{id}' , 'RolesPermissionsController@edit');
        Route::post('/update/{id}' , 'RolesPermissionsController@update');

        Route::get('datatable' , 'RolesPermissionsController@datatable');
    });


    // تقرير عن الكشف المالي العام  
    Route::group(['prefix' => 'report/general-financial'] , function (){
        Route::get('/' , 'ReportsGeneralFinancialController@index');
        Route::get('result/pdf' , 'ReportsGeneralFinancialController@result_pdf');
    });

    
    
    // getByAjax Routes   
    Route::group(['prefix' => 'getByAjax'] , function (){
        Route::get('get_teachers_by_years_mat/{id}' , 'getByAjaxController@get_teachers_by_years_mat'); // get all teachers by years_mat
        Route::get('get_teacher_accounting_type/{id}' , 'getByAjaxController@get_teacher_accounting_type'); // get teacher_accounting_type by teacher id
    });



    // class_rooms Routes   الصفوف الدراسية
    //Route::group(['prefix' => 'class_rooms'] , function (){
    //    Route::get('/' , 'ClassRoomsController@index');
    //    Route::post('/store' , 'ClassRoomsController@store');
    //    Route::get('/edit/{id}' , 'ClassRoomsController@edit');
    //    Route::post('/update/{id}' , 'ClassRoomsController@update');

    //    Route::get('datatable' , 'ClassRoomsController@datatable');
    //});

    
});