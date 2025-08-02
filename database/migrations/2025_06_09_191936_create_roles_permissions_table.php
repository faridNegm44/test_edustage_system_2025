<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            /////////////////////////////////////////// start first  ///////////////////////////////////////////
            /////////////////////////////////////////// start first  ///////////////////////////////////////////
                $table->id();
                $table->string("role_name");
                // academic_years
                $table->tinyInteger("academic_years_create")->default(0);
                $table->tinyInteger("academic_years_update")->default(0);
                $table->tinyInteger("academic_years_view")->default(0);

                // rooms
                $table->tinyInteger("rooms_create")->default(0);
                $table->tinyInteger("rooms_update")->default(0);
                $table->tinyInteger("rooms_view")->default(0);

                // types_of_education
                $table->tinyInteger("types_of_education_create")->default(0);
                $table->tinyInteger("types_of_education_update")->default(0);
                $table->tinyInteger("types_of_education_view")->default(0);

                // nationalities
                $table->tinyInteger("nationalities_create")->default(0);
                $table->tinyInteger("nationalities_update")->default(0);
                $table->tinyInteger("nationalities_view")->default(0);

                // places_of_stay
                $table->tinyInteger("places_of_stay_create")->default(0);
                $table->tinyInteger("places_of_stay_update")->default(0);
                $table->tinyInteger("places_of_stay_view")->default(0);

                // teachers
                $table->tinyInteger("teachers_create")->default(0);
                $table->tinyInteger("teachers_update")->default(0);
                $table->tinyInteger("teachers_view")->default(0);
                $table->tinyInteger("teachers_delete")->default(0);

                // teacher_subjects
                $table->tinyInteger("teacher_subjects_create")->default(0);
                $table->tinyInteger("teacher_subjects_view")->default(0);
                $table->tinyInteger("teacher_subjects_delete")->default(0);

                // partners
                $table->tinyInteger("partners_create")->default(0);
                $table->tinyInteger("partners_update")->default(0);
                $table->tinyInteger("partners_view")->default(0);
                $table->tinyInteger("partners_delete")->default(0);

                // subjects
                $table->tinyInteger("subjects_create")->default(0);
                $table->tinyInteger("subjects_update")->default(0);
                $table->tinyInteger("subjects_view")->default(0);

                // parents
                $table->tinyInteger("parents_create")->default(0);
                $table->tinyInteger("parents_update")->default(0);
                $table->tinyInteger("parents_view")->default(0);
                $table->tinyInteger("parents_delete")->default(0);
                $table->tinyInteger("parents_crm_info")->default(0);
                $table->tinyInteger("parents_crm_print")->default(0);

                // students
                $table->tinyInteger("students_create")->default(0);
                $table->tinyInteger("students_update")->default(0);
                $table->tinyInteger("students_view")->default(0);
                $table->tinyInteger("students_delete")->default(0);

                // students_wishlist
                $table->tinyInteger("students_wishlist_create")->default(0);
                $table->tinyInteger("students_wishlist_view")->default(0);
                $table->tinyInteger("students_wishlist_delete")->default(0);

                // teacher_accounting_type
                $table->tinyInteger("teacher_accounting_type_create")->default(0);
                $table->tinyInteger("teacher_accounting_type_update")->default(0);
                $table->tinyInteger("teacher_accounting_type_view")->default(0);

                // groups
                $table->tinyInteger("groups_create")->default(0);
                $table->tinyInteger("groups_update")->default(0);
                $table->tinyInteger("groups_view")->default(0);
                $table->tinyInteger("groups_delete")->default(0);
                $table->tinyInteger("groups_close")->default(0);
                $table->tinyInteger("groups_show_students")->default(0);

                // groups_sessions
                $table->tinyInteger("groups_sessions_create")->default(0);
                $table->tinyInteger("groups_sessions_update")->default(0);
                $table->tinyInteger("groups_sessions_view")->default(0);
                $table->tinyInteger("groups_sessions_delete")->default(0);
                $table->tinyInteger("groups_sessions_take_attendance")->default(0);

                // financial_categories
                $table->tinyInteger("financial_categories_create")->default(0);
                $table->tinyInteger("financial_categories_update")->default(0);
                $table->tinyInteger("financial_categories_view")->default(0);

                // partners_payments
                $table->tinyInteger("partners_payments_create")->default(0);
                $table->tinyInteger("partners_payments_view")->default(0);

                // wallets
                $table->tinyInteger("wallets_create")->default(0);
                $table->tinyInteger("wallets_update")->default(0);
                $table->tinyInteger("wallets_view")->default(0);

                // crm_columns_name
                $table->tinyInteger("crm_columns_name_create")->default(0);
                $table->tinyInteger("crm_columns_name_update")->default(0);
                $table->tinyInteger("crm_columns_name_view")->default(0);
                $table->tinyInteger("crm_columns_name_delete")->default(0);

                // students_estimates
                $table->tinyInteger("students_estimates_create")->default(0);
                $table->tinyInteger("students_estimates_update")->default(0);
                $table->tinyInteger("students_estimates_view")->default(0);
                $table->tinyInteger("students_estimates_delete")->default(0);
                $table->tinyInteger("students_estimates_student_report")->default(0);
                $table->tinyInteger("students_estimates_groups_report")->default(0);
                $table->tinyInteger("students_estimates_groups_rated_report")->default(0);
                $table->tinyInteger("students_estimates_groups_not_rated_report")->default(0);

                // times
                $table->tinyInteger("times_create")->default(0);
                $table->tinyInteger("times_update")->default(0);
                $table->tinyInteger("times_view")->default(0);
                $table->tinyInteger("times_delete")->default(0);

                // time_table
                $table->tinyInteger("time_table_create")->default(0);
                $table->tinyInteger("time_table_update")->default(0);
                $table->tinyInteger("time_table_view")->default(0);
                $table->tinyInteger("time_table_delete")->default(0);
                $table->tinyInteger("time_table_teacher_report")->default(0);
                $table->tinyInteger("time_table_groups_report")->default(0);
                $table->tinyInteger("time_table_history")->default(0);

                // time_table_ramadan_month
                $table->tinyInteger("time_table_ramadan_month_create")->default(0);
                $table->tinyInteger("time_table_ramadan_month_update")->default(0);
                $table->tinyInteger("time_table_ramadan_month_view")->default(0);
                $table->tinyInteger("time_table_ramadan_month_delete")->default(0);
                $table->tinyInteger("time_table_ramadan_month_teacher_report")->default(0);
                $table->tinyInteger("time_table_ramadan_month_groups_report")->default(0);
                $table->tinyInteger("time_table_ramadan_month_history")->default(0);

                // users
                $table->tinyInteger("users_create")->default(0);
                $table->tinyInteger("users_update")->default(0);
                $table->tinyInteger("users_view")->default(0);
                $table->tinyInteger("users_delete")->default(0);

                // roles_permissions
                $table->tinyInteger("roles_permissions_create")->default(0);
                $table->tinyInteger("roles_permissions_update")->default(0);
                $table->tinyInteger("roles_permissions_view")->default(0);
                $table->tinyInteger("roles_permissions_delete")->default(0);

                // settings
                $table->tinyInteger("settings_update")->default(0);
                $table->tinyInteger("settings_view")->default(0);
                
                $table->timestamps();
            /////////////////////////////////////////// end first  ///////////////////////////////////////////
            /////////////////////////////////////////// end first  ///////////////////////////////////////////
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }
};
