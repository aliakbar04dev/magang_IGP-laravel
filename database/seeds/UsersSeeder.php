<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Roles
    	$suRole = Role::where('name', '=', 'su')->first();
		$adminRole = Role::where('name', '=', 'admin')->first();
		$userQcRole = Role::where('name', '=', 'user_qc')->first();
		$userPicaApprovalRole = Role::where('name', '=', 'user_pica_approval')->first();
		$supplierQPRRole = Role::where('name', '=', 'supplier_qpr')->first();
		$userQPRRole = Role::where('name', '=', 'user_qpr_approve')->first();
		$emailQPRRole = Role::where('name', '=', 'user_qpr_email')->first();
		$userRegPpRole = Role::where('name', '=', 'user_pp_reg')->first();
		$userRegPpApproveDivRole = Role::where('name', '=', 'user_pp_reg_approve_div')->first();
		$userRegPpApprovePrcRole = Role::where('name', '=', 'user_pp_reg_approve_prc')->first();
		$userMonitoringOpsRole = Role::where('name', '=', 'user_monitoring_ops')->first();
		$userMtcLpRole = Role::where('name', '=', 'user_mtc_lp')->first();
		$userMtcLpAprPicRole = Role::where('name', '=', 'user_mtc_lp_pic')->first();
		$userMtcLpAprShRole = Role::where('name', '=', 'user_mtc_lp_sh')->first();
		$userMtcDmRole = Role::where('name', '=', 'user_mtc_dm')->first();
		$userMtcDmAprPicRole = Role::where('name', '=', 'user_mtc_dm_pic')->first();
		$userMtcDmAprFmRole = Role::where('name', '=', 'user_mtc_dm_fm')->first();
		$userHrMobilePkRole = Role::where('name', '=', 'user_hr_mobile_pk')->first();
		$userHrMobileGajiRole = Role::where('name', '=', 'user_hr_mobile_gaji')->first();
		$userMtcStockWhsRole = Role::where('name', '=', 'user_mtc_stockwhs')->first();

		if(config('app.env', 'local') !== 'production') {

			// Membuat sample su
			$su = new User();
			$su->name = 'Septian';
			$su->username = 'ian';
			$su->email = 'ian.septian22@gmail.com';
			$su->init_supp = 'ian';
			$su->password = bcrypt('0');
			$su->is_verified = 1;
			$su->picture = 'ian.JPG';
			$su->save();
			$su->attachRole($suRole);

			// Membuat sample admin
			$admin = new User();
			$admin->name = 'Agus P.';
			$admin->username = '08268';
			$admin->email = 'agus.purwanto@igp-astra.co.id';
			$admin->init_supp = '08268';
			$admin->password = bcrypt('08268');
			$admin->is_verified = 1;
			$admin->save();
			$admin->attachRole($adminRole);
			$admin->attachRole($userRegPpRole);
			$admin->attachRole($userMonitoringOpsRole);
			$admin->attachRole($userQcRole);
			$admin->attachRole($userQPRRole);
			$admin->attachRole($emailQPRRole);
			$admin->attachRole($userPicaApprovalRole);
			$admin->attachRole($userMtcLpRole);
			$admin->attachRole($userMtcLpAprPicRole);
			$admin->attachRole($userMtcLpAprShRole);
			$admin->attachRole($userMtcDmRole);
			$admin->attachRole($userMtcDmAprPicRole);
			$admin->attachRole($userMtcDmAprFmRole);
			$admin->attachRole($userHrMobilePkRole);
			$admin->attachRole($userHrMobileGajiRole);
			$admin->attachRole($userMtcStockWhsRole);
			
			// Membuat sample supplier qpr
			$supplierQPR = new User();
			$supplierQPR->name = 'AT INDONESIA PT.';
			$supplierQPR->username = '000936';
			$supplierQPR->email = 'ati@gmail.com';
			$supplierQPR->init_supp = 'ATI';
			$supplierQPR->password = bcrypt('000936');
			$supplierQPR->is_verified = 1;
			$supplierQPR->save();
			$supplierQPR->attachRole($supplierQPRRole);

			// Membuat sample div
			$admin = new User();
			$admin->name = 'YANDI FITRA';
			$admin->username = '02111';
			$admin->email = 'yandi@igp-astra.co.id';
			$admin->init_supp = '02111';
			$admin->password = bcrypt('02111');
			$admin->is_verified = 1;
			$admin->save();
			$admin->attachRole($userRegPpApproveDivRole);

			// Membuat sample prc
			$admin = new User();
			$admin->name = 'ABDUL HARIS';
			$admin->username = '06099';
			$admin->email = 'abdulh@igp-astra.co.id';
			$admin->init_supp = '06099';
			$admin->password = bcrypt('06099');
			$admin->is_verified = 1;
			$admin->save();
			$admin->attachRole($userRegPpApprovePrcRole);
		} else {
			// Membuat sample su
			$su = new User();
			$su->name = 'Septian';
			$su->username = 'ian';
			$su->email = 'ian.septian22@gmail.com';
			$su->init_supp = 'ian';
			$su->password = bcrypt('q.a');
			$su->is_verified = 1;
			$su->picture = 'ian.JPG';
			$su->save();
			$su->attachRole($suRole);
		}
    }
}
