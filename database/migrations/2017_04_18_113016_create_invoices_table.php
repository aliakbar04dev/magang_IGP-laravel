<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('app.env', 'local') === 'lokal') {
            
            Schema::create('pp_regs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('no_reg', 20);
                $table->date('tgl_reg');
                $table->string('kd_dept_pembuat', 2);
                $table->string('kd_supp', 10)->nullable();
                $table->string('email_supp', 100)->nullable();
                $table->string('pemakai', 200)->nullable();
                $table->string('untuk', 200)->nullable();
                $table->string('alasan', 200)->nullable();
                $table->string('no_ia_ea', 25)->nullable();
                $table->string('no_ia_ea_revisi', 25)->nullable();
                $table->string('no_ia_ea_urut', 5)->nullable();
                $table->string('no_pp', 15)->nullable();
                $table->char('status_approve', 1)->default('F');
                $table->string('npk_approve_div', 50)->nullable();
                $table->timestamp('tgl_approve_div')->nullable();
                $table->string('npk_approve_prc', 50)->nullable();
                $table->timestamp('tgl_approve_prc')->nullable();
                $table->string('npk_reject', 50)->nullable();
                $table->timestamp('tgl_reject')->nullable();
                $table->string('keterangan', 200)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('npk_approve_div')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('npk_approve_prc')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('npk_reject')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->unique('no_reg');
            });

            Schema::create('pp_reg_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pp_reg_id')->unsigned();
                $table->string('kd_brg', 15);
                $table->string('desc', 200);
                $table->string('nm_brg', 200)->nullable();
                $table->decimal('qty_pp', 25, 2)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('pp_reg_id')->references('id')->on('pp_regs')
                    ->onUpdate('cascade')->onDelete('cascade');
            });

            // Schema::create('qprs', function (Blueprint $table) {
            //     $table->string('issue_no', 30);
            //     $table->date('issue_date')->nullable();
            //     $table->char('plant', 1)->nullable();
            //     $table->string('kd_supp', 10)->nullable();
            //     $table->string('nm_supp', 50)->nullable();
            //     $table->string('representative', 30)->nullable();
            //     $table->string('corp_vendor_approved', 5)->nullable();
            //     $table->string('nmcorp_vendor_apr', 50)->nullable();
            //     $table->string('qc_prepared', 5)->nullable();
            //     $table->string('nm_qc_prepared', 50)->nullable();
            //     $table->string('qc_checked', 5)->nullable();
            //     $table->string('nm_qc_checked', 50)->nullable();
            //     $table->string('qc_approved', 5)->nullable();
            //     $table->string('nm_qc_approved', 50)->nullable();
            //     $table->string('part_no', 30)->nullable();
            //     $table->string('nm_part', 100)->nullable();
            //     $table->string('model', 100)->nullable();
            //     $table->decimal('qty_dpart', 25, 5)->nullable();
            //     $table->decimal('qty_pending', 25, 5)->nullable();
            //     $table->decimal('qty_receive', 25, 5)->nullable();
            //     $table->timestamp('delivered_on')->nullable();
            //     $table->timestamp('occured_on')->nullable();
            //     $table->string('prod_code', 15)->nullable();
            //     $table->string('casting_date', 30)->nullable();
            //     $table->string('cavity_number', 50)->nullable();
            //     $table->decimal('total_prod', 25, 5)->nullable();
            //     $table->decimal('reject_ratio', 25, 5)->nullable();
            //     $table->decimal('q_found_receiv', 15, 5)->nullable();
            //     $table->decimal('q_found_wip_retur', 15, 5)->nullable();
            //     $table->decimal('q_found_wip_reject', 15, 5)->nullable();
            //     $table->decimal('q_found_fg', 15, 5)->nullable();
            //     $table->decimal('q_found_cust', 15, 5)->nullable();
            //     $table->string('problem_history', 30)->nullable();
            //     $table->string('problem', 100)->nullable();
            //     $table->string('sketch', 300)->nullable();
            //     $table->string('possibility_cause', 300)->nullable();
            //     $table->string('disposition', 20)->nullable();
            //     $table->string('rank_quality_problem', 30)->nullable();
            //     $table->string('alamat_content', 1000)->nullable();
            //     $table->timestamp('portal_tgl')->nullable();
            //     $table->string('portal_pic', 5)->nullable();
            //     $table->string('nm_portal_pic', 50)->nullable();
            //     $table->string('portal_pict', 100)->nullable();
            //     $table->timestamp('portal_tgl_terima')->nullable();
            //     $table->string('portal_pic_terima', 200)->nullable();
            //     $table->timestamp('portal_tgl_reject')->nullable();
            //     $table->string('portal_pic_reject', 200)->nullable();
            //     $table->char('portal_st_reject', 1)->nullable();
            //     $table->string('portal_ket_reject', 500)->nullable();
            //     $table->string('lok_file_ori', 300)->nullable();
            //     $table->string('alamat_std', 1000)->nullable();
            //     $table->string('portal_sh_pic', 5)->nullable();
            //     $table->timestamp('portal_sh_tgl')->nullable();
            //     $table->timestamp('portal_sh_tgl_reject')->nullable();
            //     $table->string('portal_sh_pic_reject', 5)->nullable();
            //     $table->string('portal_sh_ket_reject', 500)->nullable();
            //     $table->timestamp('portal_sh_tgl_no')->nullable();
            //     $table->string('portal_sh_pic_no', 5)->nullable();
            //     $table->string('email_1', 300);
            //     $table->timestamp('email_1_tgl')->nullable();
            //     $table->string('email_2', 300);
            //     $table->timestamp('email_2_tgl')->nullable();
            //     $table->string('email_3', 300);
            //     $table->timestamp('email_3_tgl')->nullable();
            //     $table->primary('issue_no');
            // });

            Schema::create('qpr_emails', function (Blueprint $table) {
                $table->increments('id');
                $table->string('kd_supp', 10)->unique();
                $table->string('email_1', 300);
                $table->string('email_2', 300);
                $table->string('email_3', 300);
                $table->string('creaby', 50);
                $table->string('modiby', 50)->nullable();
                $table->timestamps();
                $table->foreign('creaby')->references('username')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
            });
            
            Schema::create('picas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('no_pica', 30)->unique();
                $table->integer('no_revisi')->unsigned();
                $table->date('tgl_pica');
                $table->string('issue_no', 30)->unique();
                $table->string('kd_supp', 10);
                //4. FLOW PROCESS
                $table->string('fp_pict_general', 500)->nullable();
                $table->string('fp_pict_detail', 500)->nullable();
                //5. SUPPLIER ACTION
                $table->string('sa_pict', 500)->nullable();
                //5.A INVESTIGASI OF PROBLEM
                $table->string('iop_tools_subject', 500)->nullable();
                $table->string('iop_tools_pc', 500)->nullable();
                $table->string('iop_tools_std', 500)->nullable();
                $table->string('iop_tools_act', 500)->nullable();
                $table->char('iop_tools_status', 1)->nullable();
                $table->string('iop_mat_subject', 500)->nullable();
                $table->string('iop_mat_pc', 500)->nullable();
                $table->string('iop_mat_std', 500)->nullable();
                $table->string('iop_mat_act', 500)->nullable();
                $table->char('iop_mat_status', 1)->nullable();
                $table->string('iop_man_subject', 500)->nullable();
                $table->string('iop_man_pc', 500)->nullable();
                $table->string('iop_man_std', 500)->nullable();
                $table->string('iop_man_act', 500)->nullable();
                $table->char('iop_man_status', 1)->nullable();
                $table->string('iop_met_subject', 500)->nullable();
                $table->string('iop_met_pc', 500)->nullable();
                $table->string('iop_met_std', 500)->nullable();
                $table->string('iop_met_act', 500)->nullable();
                $table->char('iop_met_status', 1)->nullable();
                $table->string('iop_env_subject', 500)->nullable();
                $table->string('iop_env_pc', 500)->nullable();
                $table->string('iop_env_std', 500)->nullable();
                $table->string('iop_env_act', 500)->nullable();
                $table->char('iop_env_status', 1)->nullable();
                //5.B INTERVIEW & OBSERVASI PENGAMATAN TERHADAP MEMBER
                $table->string('ioptm_pict', 500)->nullable();
                $table->string('ioptm_pk', 500)->nullable();
                $table->string('ioptm_pk_status', 1)->nullable();
                $table->string('ioptm_qk', 500)->nullable();
                $table->string('ioptm_qk_status', 1)->nullable();
                $table->string('ioptm_kp', 500)->nullable();
                $table->string('ioptm_kp_status', 1)->nullable();
                $table->string('ioptm_sr', 500)->nullable();
                $table->string('ioptm_sr_status', 1)->nullable();
                $table->string('ioptm_it', 500)->nullable();
                $table->string('ioptm_it_status', 1)->nullable();
                $table->string('ioptm_jd', 500)->nullable();
                $table->string('ioptm_jd_status', 1)->nullable();
                //5.C HENKATEN PROCESS / CHANGING POINT PROCESS
                $table->string('hp_pict', 500)->nullable();
                //6. ROOTCAUSE ANALYZE
                $table->string('rca_why_occured', 500)->nullable();
                $table->string('rca_pict_occured', 500)->nullable();
                $table->string('rca_why_outflow', 500)->nullable();
                $table->string('rca_pict_outflow', 500)->nullable();
                $table->string('rca_root1', 500)->nullable();
                $table->string('rca_root2', 500)->nullable();
                //7. COUNTERMEASURE OF PROBLEM
                //7.A. TEMPORARY ACTION
                $table->string('cop_temp_action1', 500)->nullable();
                $table->string('cop_temp_action1_pict', 500)->nullable();
                $table->date('cop_temp_action1_date')->nullable();
                $table->string('cop_temp_action1_pic', 50)->nullable();
                $table->string('cop_temp_action2', 500)->nullable();
                $table->string('cop_temp_action2_pict', 500)->nullable();
                $table->date('cop_temp_action2_date')->nullable();
                $table->string('cop_temp_action2_pic', 50)->nullable();
                $table->string('cop_temp_action3', 500)->nullable();
                $table->string('cop_temp_action3_pict', 500)->nullable();
                $table->date('cop_temp_action3_date')->nullable();
                $table->string('cop_temp_action3_pic', 50)->nullable();
                $table->string('cop_temp_action4', 500)->nullable();
                $table->string('cop_temp_action4_pict', 500)->nullable();
                $table->date('cop_temp_action4_date')->nullable();
                $table->string('cop_temp_action4_pic', 50)->nullable();
                $table->string('cop_temp_action5', 500)->nullable();
                $table->string('cop_temp_action5_pict', 500)->nullable();
                $table->date('cop_temp_action5_date')->nullable();
                $table->string('cop_temp_action5_pic', 50)->nullable();
                //7.B. FIX COUNTERMEASURE
                $table->string('cop_fix_action1', 500)->nullable();
                $table->string('cop_fix_action1_pict', 500)->nullable();
                $table->date('cop_fix_action1_date')->nullable();
                $table->string('cop_fix_action1_pic', 50)->nullable();
                $table->string('cop_fix_action2', 500)->nullable();
                $table->string('cop_fix_action2_pict', 500)->nullable();
                $table->date('cop_fix_action2_date')->nullable();
                $table->string('cop_fix_action2_pic', 50)->nullable();
                $table->string('cop_fix_action3', 500)->nullable();
                $table->string('cop_fix_action3_pict', 500)->nullable();
                $table->date('cop_fix_action3_date')->nullable();
                $table->string('cop_fix_action3_pic', 50)->nullable();
                $table->string('cop_fix_action4', 500)->nullable();
                $table->string('cop_fix_action4_pict', 500)->nullable();
                $table->date('cop_fix_action4_date')->nullable();
                $table->string('cop_fix_action4_pic', 50)->nullable();
                $table->string('cop_fix_action5', 500)->nullable();
                $table->string('cop_fix_action5_pict', 500)->nullable();
                $table->date('cop_fix_action5_date')->nullable();
                $table->string('cop_fix_action5_pic', 50)->nullable();
                //8. FLOW PROCESS AFTER IMPROVEMENT
                $table->string('fp_improve_pict', 500)->nullable();
                //9. EVALUATION & FOLLOW UP PROBLEM
                $table->string('evaluation', 500)->nullable();
                $table->string('evaluation_pict', 500)->nullable();
                //10. STANDARDIZATION
                $table->string('std_sop', 1)->nullable();
                $table->string('std_wi', 1)->nullable();
                $table->string('std_qcpc', 1)->nullable();
                $table->string('std_fmea', 1)->nullable();
                $table->string('std_point', 1)->nullable();
                $table->string('std_warning', 1)->nullable();
                $table->string('std_check_sheet', 1)->nullable();
                $table->string('std_others', 1)->nullable();
                //11. YOKOTENKAI
                $table->string('yokotenkai', 500)->nullable();
                //APPROVAL
                $table->timestamp('submit_tgl')->nullable();
                $table->string('submit_pic', 50)->nullable();
                $table->timestamp('approve_tgl')->nullable();
                $table->string('approve_pic', 50)->nullable();
                $table->timestamp('reject_tgl')->nullable();
                $table->string('reject_pic', 50)->nullable();
                $table->string('reject_ket', 500)->nullable();
                $table->char('reject_st', 1)->nullable();
                ///////////////////////////////////////////////
                $table->string('status', 50)->default('DRAFT');
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('submit_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('approve_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('reject_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('issue_no')->references('issue_no')->on('qprs')
                    ->onUpdate('restrict')->onDelete('restrict');
                //$table->unique(['no_pica', 'no_revisi']);
            });

            Schema::create('pica_rejects', function (Blueprint $table) {
                $table->increments('id');
                $table->string('no_pica', 30);
                $table->integer('no_revisi')->unsigned();
                $table->date('tgl_pica');
                $table->string('issue_no', 30);
                $table->string('kd_supp', 10);
                //4. FLOW PROCESS
                $table->string('fp_pict_general', 500)->nullable();
                $table->string('fp_pict_detail', 500)->nullable();
                //5. SUPPLIER ACTION
                $table->string('sa_pict', 500)->nullable();
                //5.A INVESTIGASI OF PROBLEM
                $table->string('iop_tools_subject', 500)->nullable();
                $table->string('iop_tools_pc', 500)->nullable();
                $table->string('iop_tools_std', 500)->nullable();
                $table->string('iop_tools_act', 500)->nullable();
                $table->char('iop_tools_status', 1)->nullable();
                $table->string('iop_mat_subject', 500)->nullable();
                $table->string('iop_mat_pc', 500)->nullable();
                $table->string('iop_mat_std', 500)->nullable();
                $table->string('iop_mat_act', 500)->nullable();
                $table->char('iop_mat_status', 1)->nullable();
                $table->string('iop_man_subject', 500)->nullable();
                $table->string('iop_man_pc', 500)->nullable();
                $table->string('iop_man_std', 500)->nullable();
                $table->string('iop_man_act', 500)->nullable();
                $table->char('iop_man_status', 1)->nullable();
                $table->string('iop_met_subject', 500)->nullable();
                $table->string('iop_met_pc', 500)->nullable();
                $table->string('iop_met_std', 500)->nullable();
                $table->string('iop_met_act', 500)->nullable();
                $table->char('iop_met_status', 1)->nullable();
                $table->string('iop_env_subject', 500)->nullable();
                $table->string('iop_env_pc', 500)->nullable();
                $table->string('iop_env_std', 500)->nullable();
                $table->string('iop_env_act', 500)->nullable();
                $table->char('iop_env_status', 1)->nullable();
                //5.B INTERVIEW & OBSERVASI PENGAMATAN TERHADAP MEMBER
                $table->string('ioptm_pict', 500)->nullable();
                $table->string('ioptm_pk', 500)->nullable();
                $table->string('ioptm_pk_status', 1)->nullable();
                $table->string('ioptm_qk', 500)->nullable();
                $table->string('ioptm_qk_status', 1)->nullable();
                $table->string('ioptm_kp', 500)->nullable();
                $table->string('ioptm_kp_status', 1)->nullable();
                $table->string('ioptm_sr', 500)->nullable();
                $table->string('ioptm_sr_status', 1)->nullable();
                $table->string('ioptm_it', 500)->nullable();
                $table->string('ioptm_it_status', 1)->nullable();
                $table->string('ioptm_jd', 500)->nullable();
                $table->string('ioptm_jd_status', 1)->nullable();
                //5.C HENKATEN PROCESS / CHANGING POINT PROCESS
                $table->string('hp_pict', 500)->nullable();
                //6. ROOTCAUSE ANALYZE
                $table->string('rca_why_occured', 500)->nullable();
                $table->string('rca_pict_occured', 500)->nullable();
                $table->string('rca_why_outflow', 500)->nullable();
                $table->string('rca_pict_outflow', 500)->nullable();
                $table->string('rca_root1', 500)->nullable();
                $table->string('rca_root2', 500)->nullable();
                //7. COUNTERMEASURE OF PROBLEM
                //7.A. TEMPORARY ACTION
                $table->string('cop_temp_action1', 500)->nullable();
                $table->string('cop_temp_action1_pict', 500)->nullable();
                $table->date('cop_temp_action1_date')->nullable();
                $table->string('cop_temp_action1_pic', 50)->nullable();
                $table->string('cop_temp_action2', 500)->nullable();
                $table->string('cop_temp_action2_pict', 500)->nullable();
                $table->date('cop_temp_action2_date')->nullable();
                $table->string('cop_temp_action2_pic', 50)->nullable();
                $table->string('cop_temp_action3', 500)->nullable();
                $table->string('cop_temp_action3_pict', 500)->nullable();
                $table->date('cop_temp_action3_date')->nullable();
                $table->string('cop_temp_action3_pic', 50)->nullable();
                $table->string('cop_temp_action4', 500)->nullable();
                $table->string('cop_temp_action4_pict', 500)->nullable();
                $table->date('cop_temp_action4_date')->nullable();
                $table->string('cop_temp_action4_pic', 50)->nullable();
                $table->string('cop_temp_action5', 500)->nullable();
                $table->string('cop_temp_action5_pict', 500)->nullable();
                $table->date('cop_temp_action5_date')->nullable();
                $table->string('cop_temp_action5_pic', 50)->nullable();
                //7.B. FIX COUNTERMEASURE
                $table->string('cop_fix_action1', 500)->nullable();
                $table->string('cop_fix_action1_pict', 500)->nullable();
                $table->date('cop_fix_action1_date')->nullable();
                $table->string('cop_fix_action1_pic', 50)->nullable();
                $table->string('cop_fix_action2', 500)->nullable();
                $table->string('cop_fix_action2_pict', 500)->nullable();
                $table->date('cop_fix_action2_date')->nullable();
                $table->string('cop_fix_action2_pic', 50)->nullable();
                $table->string('cop_fix_action3', 500)->nullable();
                $table->string('cop_fix_action3_pict', 500)->nullable();
                $table->date('cop_fix_action3_date')->nullable();
                $table->string('cop_fix_action3_pic', 50)->nullable();
                $table->string('cop_fix_action4', 500)->nullable();
                $table->string('cop_fix_action4_pict', 500)->nullable();
                $table->date('cop_fix_action4_date')->nullable();
                $table->string('cop_fix_action4_pic', 50)->nullable();
                $table->string('cop_fix_action5', 500)->nullable();
                $table->string('cop_fix_action5_pict', 500)->nullable();
                $table->date('cop_fix_action5_date')->nullable();
                $table->string('cop_fix_action5_pic', 50)->nullable();
                //8. FLOW PROCESS AFTER IMPROVEMENT
                $table->string('fp_improve_pict', 500)->nullable();
                //9. EVALUATION & FOLLOW UP PROBLEM
                $table->string('evaluation', 500)->nullable();
                $table->string('evaluation_pict', 500)->nullable();
                //10. STANDARDIZATION
                $table->string('std_sop', 1)->nullable();
                $table->string('std_wi', 1)->nullable();
                $table->string('std_qcpc', 1)->nullable();
                $table->string('std_fmea', 1)->nullable();
                $table->string('std_point', 1)->nullable();
                $table->string('std_warning', 1)->nullable();
                $table->string('std_check_sheet', 1)->nullable();
                $table->string('std_others', 1)->nullable();
                //11. YOKOTENKAI
                $table->string('yokotenkai', 500)->nullable();
                //APPROVAL
                $table->timestamp('submit_tgl')->nullable();
                $table->string('submit_pic', 50)->nullable();
                $table->timestamp('approve_tgl')->nullable();
                $table->string('approve_pic', 50)->nullable();
                $table->timestamp('reject_tgl')->nullable();
                $table->string('reject_pic', 50)->nullable();
                $table->string('reject_ket', 500)->nullable();
                $table->char('reject_st', 1)->nullable();
                ///////////////////////////////////////////////
                $table->string('status', 50)->default('DRAFT');
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('submit_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('approve_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('reject_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('issue_no')->references('issue_no')->on('qprs')
                    ->onUpdate('restrict')->onDelete('restrict');
                $table->unique(['no_pica', 'no_revisi']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	/*
        Pindah ke migration tabel users
         */
    }
}
