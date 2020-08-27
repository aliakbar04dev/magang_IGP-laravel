<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat role su
		$suRole = new Role();
		$suRole->name = "su";
		$suRole->display_name = "Super Administrator";
		$suRole->description = "Role untuk manage all user";
		$suRole->save();

        // Membuat role admin
		$adminRole = new Role();
		$adminRole->name = "admin";
		$adminRole->display_name = "Administrator";
		$adminRole->description = "Role untuk manage user non admin";
		$adminRole->save();

		$supplierQPRRole = new Role();
		$supplierQPRRole->name = "supplier_qpr";
		$supplierQPRRole->display_name = "QPR (Supplier)";
		$supplierQPRRole->description = "Role untuk akses menu QPR khusus supplier";
		$supplierQPRRole->save();

		$userQPRRole = new Role();
		$userQPRRole->name = "user_qpr_approve";
		$userQPRRole->display_name = "QPR - Approval Section";
		$userQPRRole->description = "Role untuk akses menu QPR Approve Section";
		$userQPRRole->save();

		$emailQPRRole = new Role();
		$emailQPRRole->name = "user_qpr_email";
		$emailQPRRole->display_name = "QPR - Email Supplier";
		$emailQPRRole->description = "Role untuk akses menu QPR Email Supplier";
		$emailQPRRole->save();

		// Membuat role user register pp
		$userRegPpRole = new Role();
		$userRegPpRole->name = "user_pp_reg";
		$userRegPpRole->display_name = "Register PP";
		$userRegPpRole->description = "Role untuk Register PP";
		$userRegPpRole->save();

		$userRegPpApproveDivRole = new Role();
		$userRegPpApproveDivRole->name = "user_pp_reg_approve_div";
		$userRegPpApproveDivRole->display_name = "Register PP Approve Div";
		$userRegPpApproveDivRole->description = "Role untuk Register PP Approve Div";
		$userRegPpApproveDivRole->save();

		$userRegPpApprovePrcRole = new Role();
		$userRegPpApprovePrcRole->name = "user_pp_reg_approve_prc";
		$userRegPpApprovePrcRole->display_name = "Register PP Approve PRC";
		$userRegPpApprovePrcRole->description = "Role untuk Register PP Approve PRC";
		$userRegPpApprovePrcRole->save();

		$userMonitoringOpsRole = new Role();
		$userMonitoringOpsRole->name = "user_monitoring_ops";
		$userMonitoringOpsRole->display_name = "Monitoring OPS";
		$userMonitoringOpsRole->description = "Monitoring OPS";
		$userMonitoringOpsRole->save();

		// Membuat role user Qc
		$userPicaApprovalRole = new Role();
		$userPicaApprovalRole->name = "user_pica_approval";
		$userPicaApprovalRole->display_name = "Approval PICA";
		$userPicaApprovalRole->description = "Role untuk akses menu Approval PICA";
		$userPicaApprovalRole->save();

		$userPicaViewRole = new Role();
		$userPicaViewRole->name = "user_pica_view";
		$userPicaViewRole->display_name = "View PICA";
		$userPicaViewRole->description = "Role untuk akses menu View PICA";
		$userPicaViewRole->save();

		$userMtcLpRole = new Role();
		$userMtcLpRole->name = "user_mtc_lp";
		$userMtcLpRole->display_name = "MTC - LP";
		$userMtcLpRole->description = "Role untuk akses menu MTC - Laporan Pekerjaan";
		$userMtcLpRole->save();

		$userMtcLpAprPicRole = new Role();
		$userMtcLpAprPicRole->name = "user_mtc_lp_pic";
		$userMtcLpAprPicRole->display_name = "MTC - LP - PIC";
		$userMtcLpAprPicRole->description = "Role untuk Approve Laporan Pekerjaan - PIC";
		$userMtcLpAprPicRole->save();

		$userMtcLpAprShRole = new Role();
		$userMtcLpAprShRole->name = "user_mtc_lp_sh";
		$userMtcLpAprShRole->display_name = "MTC - LP - Section";
		$userMtcLpAprShRole->description = "Role untuk Approve Laporan Pekerjaan - Section";
		$userMtcLpAprShRole->save();

		$userMtcDmRole = new Role();
		$userMtcDmRole->name = "user_mtc_dm";
		$userMtcDmRole->display_name = "MTC - DM";
		$userMtcDmRole->description = "Role untuk akses menu MTC - Daftar Masalah";
		$userMtcDmRole->save();

		$userMtcDmAprPicRole = new Role();
		$userMtcDmAprPicRole->name = "user_mtc_dm_pic";
		$userMtcDmAprPicRole->display_name = "MTC - DM - PIC";
		$userMtcDmAprPicRole->description = "Role untuk Approve Daftar Masalah - PIC";
		$userMtcDmAprPicRole->save();

		$userMtcDmAprFmRole = new Role();
		$userMtcDmAprFmRole->name = "user_mtc_dm_fm";
		$userMtcDmAprFmRole->display_name = "MTC - DM - Foreman";
		$userMtcDmAprFmRole->description = "Role untuk Approve Daftar Masalah - Foreman";
		$userMtcDmAprFmRole->save();

		$userHrMobilePkRole = new Role();
		$userHrMobilePkRole->name = "user_hr_mobile_pk";
		$userHrMobilePkRole->display_name = "HR - Mobile - PK";
		$userHrMobilePkRole->description = "Role untuk melihat menu HR - Mobile - PK";
		$userHrMobilePkRole->save();

		$userHrMobileGajiRole = new Role();
		$userHrMobileGajiRole->name = "user_hr_mobile_gaji";
		$userHrMobileGajiRole->display_name = "HR - Mobile - Gaji";
		$userHrMobileGajiRole->description = "Role untuk melihat menu HR - Mobile - Gaji";
		$userHrMobileGajiRole->save();

		$karyawanRole = new Role();
		$karyawanRole->name = "karyawan";
		$karyawanRole->display_name = "Karyawan";
		$karyawanRole->description = "Role Karyawan";
		$karyawanRole->save();

		$userMtcOliRole = new Role();
		$userMtcOliRole->name = "user_mtc_oli";
		$userMtcOliRole->display_name = "MTC - Oli";
		$userMtcOliRole->description = "Role untuk akses menu MTC - Pengisian Oli";
		$userMtcOliRole->save();

		$userMtcPlantRole = new Role();
		$userMtcPlantRole->name = "user_mtc_plant";
		$userMtcPlantRole->display_name = "MTC - NPK/Plant";
		$userMtcPlantRole->description = "Role untuk akses menu MTC - NPK/Plant";
		$userMtcPlantRole->save();

		$userMtcStockWhsRole = new Role();
		$userMtcStockWhsRole->name = "user_mtc_stockwhs";
		$userMtcStockWhsRole->display_name = "MTC - Stock Warehouse";
		$userMtcStockWhsRole->description = "Role untuk akses menu MTC - Stock Warehouse";
		$userMtcStockWhsRole->save();
    }
}