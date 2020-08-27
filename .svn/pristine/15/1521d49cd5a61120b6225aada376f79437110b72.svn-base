<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission 
		$viewAdmin = new Permission();
		$viewAdmin->name         = 'admin-view';
		$viewAdmin->display_name = 'Admins - View';
		$viewAdmin->description  = 'Admins - View';
		$viewAdmin->save();

		// Permission 
		$createAdmin = new Permission();
		$createAdmin->name         = 'admin-create';
		$createAdmin->display_name = 'Admins - Create';
		$createAdmin->description  = 'Admins - Create';
		$createAdmin->save();

		// Permission 
		$editAdmin = new Permission();
		$editAdmin->name         = 'admin-edit';
		$editAdmin->display_name = 'Admins - Edit';
		$editAdmin->description  = 'Admins - Edit';
		$editAdmin->save();

		// Permission 
		$deleteAdmin = new Permission();
		$deleteAdmin->name         = 'admin-delete';
		$deleteAdmin->display_name = 'Admins - Delete';
		$deleteAdmin->description  = 'Admins - Delete';
		$deleteAdmin->save();

		// Permission 
		$viewUser = new Permission();
		$viewUser->name         = 'user-view';
		$viewUser->display_name = 'Users - View';
		$viewUser->description  = 'Users - View';
		$viewUser->save();

		// Permission 
		$createUser = new Permission();
		$createUser->name         = 'user-create';
		$createUser->display_name = 'Users - Create';
		$createUser->description  = 'Users - Create';
		$createUser->save();

		// Permission 
		$editUser = new Permission();
		$editUser->name         = 'user-edit';
		$editUser->display_name = 'Users - Edit';
		$editUser->description  = 'Users - Edit';
		$editUser->save();

		// Permission 
		$deleteUser = new Permission();
		$deleteUser->name         = 'user-delete';
		$deleteUser->display_name = 'Users - Delete';
		$deleteUser->description  = 'Users - Delete';
		$deleteUser->save();

		$viewQpr = new Permission();
		$viewQpr->name         = 'qpr-view';
		$viewQpr->display_name = 'QPR - View';
		$viewQpr->description  = 'QPR - View';
		$viewQpr->save();

		$approveQpr = new Permission();
		$approveQpr->name         = 'qpr-approve';
		$approveQpr->display_name = 'QPR - Approve';
		$approveQpr->description  = 'QPR - Approve';
		$approveQpr->save();

		$rejectQpr = new Permission();
		$rejectQpr->name         = 'qpr-reject';
		$rejectQpr->display_name = 'QPR - Reject';
		$rejectQpr->description  = 'QPR - Reject';
		$rejectQpr->save();

		$emailQpr = new Permission();
		$emailQpr->name         = 'qpr-email';
		$emailQpr->display_name = 'QPR - Email Supplier';
		$emailQpr->description  = 'QPR - Email Supplier';
		$emailQpr->save();

		$viewPica = new Permission();
		$viewPica->name         = 'pica-view';
		$viewPica->display_name = 'PICA - View';
		$viewPica->description  = 'PICA - View';
		$viewPica->save();

		$createPica = new Permission();
		$createPica->name         = 'pica-create';
		$createPica->display_name = 'PICA - Create';
		$createPica->description  = 'PICA - Create';
		$createPica->save();

		$deletePica = new Permission();
		$deletePica->name         = 'pica-delete';
		$deletePica->display_name = 'PICA - Delete';
		$deletePica->description  = 'PICA - Delete';
		$deletePica->save();

		$submitPica = new Permission();
		$submitPica->name         = 'pica-submit';
		$submitPica->display_name = 'PICA - Submit';
		$submitPica->description  = 'PICA - Submit';
		$submitPica->save();

		$approvePica = new Permission();
		$approvePica->name         = 'pica-approve';
		$approvePica->display_name = 'PICA - Approve';
		$approvePica->description  = 'PICA - Approve';
		$approvePica->save();

		$rejectPica = new Permission();
		$rejectPica->name         = 'pica-reject';
		$rejectPica->display_name = 'PICA - Reject';
		$rejectPica->description  = 'PICA - Reject';
		$rejectPica->save();

		$suRole = Role::where('name', '=', 'su')->first();
		$suRole->attachPermissions(array($viewAdmin, $createAdmin, $editAdmin, $deleteAdmin));

		$adminRole = Role::where('name', '=', 'admin')->first();
		$adminRole->attachPermissions(array($viewUser, $createUser, $editUser, $deleteUser));

		$supplierQPRRole = Role::where('name', '=', 'supplier_qpr')->first();
		$supplierQPRRole->attachPermissions(array($viewQpr, $approveQpr, $rejectQpr, $viewPica, $createPica, $deletePica, $submitPica));

		$userQPRRole = Role::where('name', '=', 'user_qpr_approve')->first();
		$userQPRRole->attachPermissions(array($viewQpr, $approveQpr, $rejectQpr));

		$emailQPRRole = Role::where('name', '=', 'user_qpr_email')->first();
		$emailQPRRole->attachPermissions(array($emailQpr));

		$userPicaApprovalRole = Role::where('name', '=', 'user_pica_approval')->first();
		$userPicaApprovalRole->attachPermissions(array($approvePica, $rejectPica));

		$userPicaViewRole = Role::where('name', '=', 'user_pica_view')->first();
		$userPicaViewRole->attachPermissions(array($viewPica));

		$ppregview = new Permission();
		$ppregview->name         = 'pp-reg-view';
		$ppregview->display_name = 'PP Reg View';
		$ppregview->description  = 'PP Reg View';
		$ppregview->save();

		$ppregcreate = new Permission();
		$ppregcreate->name         = 'pp-reg-create';
		$ppregcreate->display_name = 'PP Reg Create';
		$ppregcreate->description  = 'PP Reg Create';
		$ppregcreate->save();

		$ppregedit = new Permission();
		$ppregedit->name         = 'pp-reg-edit';
		$ppregedit->display_name = 'PP Reg Edit';
		$ppregedit->description  = 'PP Reg Edit';
		$ppregedit->save();

		$ppregdelete = new Permission();
		$ppregdelete->name         = 'pp-reg-delete';
		$ppregdelete->display_name = 'PP Reg Delete';
		$ppregdelete->description  = 'PP Reg Delete';
		$ppregdelete->save();

		$ppregapprovediv = new Permission();
		$ppregapprovediv->name         = 'pp-reg-approve-div';
		$ppregapprovediv->display_name = 'PP Reg Approve Div Head';
		$ppregapprovediv->description  = 'PP Reg Approve Div Head';
		$ppregapprovediv->save();

		$ppregapproveprc = new Permission();
		$ppregapproveprc->name         = 'pp-reg-approve-prc';
		$ppregapproveprc->display_name = 'PP Reg Approve Purchasing';
		$ppregapproveprc->description  = 'PP Reg Approve Purchasing';
		$ppregapproveprc->save();

		$userRegPpRole = Role::where('name', '=', 'user_pp_reg')->first();
		$userRegPpRole->attachPermissions(array($ppregview, $ppregcreate, $ppregedit, $ppregdelete));

		$userRegPpApproveDivRole = Role::where('name', '=', 'user_pp_reg_approve_div')->first();
		$userRegPpApproveDivRole->attachPermissions(array($ppregapprovediv));

		$userRegPpApprovePrcRole = Role::where('name', '=', 'user_pp_reg_approve_prc')->first();
		$userRegPpApprovePrcRole->attachPermissions(array($ppregapproveprc));

		$monitoringops = new Permission();
		$monitoringops->name         = 'monitoring-ops';
		$monitoringops->display_name = 'Monitoring OPS';
		$monitoringops->description  = 'Monitoring OPS';
		$monitoringops->save();

		$userMonitoringOpsRole = Role::where('name', '=', 'user_monitoring_ops')->first();
		$userMonitoringOpsRole->attachPermissions(array($monitoringops));

		$viewLp = new Permission();
		$viewLp->name         = 'mtc-lp-view';
		$viewLp->display_name = 'MTC - LP - View';
		$viewLp->description  = 'MTC - LP - View';
		$viewLp->save();

		$createLp = new Permission();
		$createLp->name         = 'mtc-lp-create';
		$createLp->display_name = 'MTC - LP - Create';
		$createLp->description  = 'MTC - LP - Create';
		$createLp->save();

		$deleteLp = new Permission();
		$deleteLp->name         = 'mtc-lp-delete';
		$deleteLp->display_name = 'MTC - LP - Delete';
		$deleteLp->description  = 'MTC - LP - Delete';
		$deleteLp->save();

		$userMtcLpRole = Role::where('name', '=', 'user_mtc_lp')->first();
		$userMtcLpRole->attachPermissions(array($viewLp, $createLp, $deleteLp));

		$aprLpPic = new Permission();
		$aprLpPic->name         = 'mtc-apr-pic-lp';
		$aprLpPic->display_name = 'MTC - LP - Approve - PIC';
		$aprLpPic->description  = 'MTC - LP - Approve - PIC';
		$aprLpPic->save();

		$userMtcLpAprPicRole = Role::where('name', '=', 'user_mtc_lp_pic')->first();
		$userMtcLpAprPicRole->attachPermissions(array($aprLpPic));

		$aprLpSh = new Permission();
		$aprLpSh->name         = 'mtc-apr-sh-lp';
		$aprLpSh->display_name = 'MTC - LP - Approve - Section';
		$aprLpSh->description  = 'MTC - LP - Approve - Section';
		$aprLpSh->save();

		$userMtcLpAprShRole = Role::where('name', '=', 'user_mtc_lp_sh')->first();
		$userMtcLpAprShRole->attachPermissions(array($aprLpSh));

		$viewDm = new Permission();
		$viewDm->name         = 'mtc-dm-view';
		$viewDm->display_name = 'MTC - DM - View';
		$viewDm->description  = 'MTC - DM - View';
		$viewDm->save();

		$createDm = new Permission();
		$createDm->name         = 'mtc-dm-create';
		$createDm->display_name = 'MTC - DM - Create';
		$createDm->description  = 'MTC - DM - Create';
		$createDm->save();

		$deleteDm = new Permission();
		$deleteDm->name         = 'mtc-dm-delete';
		$deleteDm->display_name = 'MTC - DM - Delete';
		$deleteDm->description  = 'MTC - DM - Delete';
		$deleteDm->save();

		$userMtcDmRole = Role::where('name', '=', 'user_mtc_dm')->first();
		$userMtcDmRole->attachPermissions(array($viewDm, $createDm, $deleteDm));

		$aprDmPic = new Permission();
		$aprDmPic->name         = 'mtc-apr-pic-dm';
		$aprDmPic->display_name = 'MTC - DM - Approve - PIC';
		$aprDmPic->description  = 'MTC - DM - Approve - PIC';
		$aprDmPic->save();

		$userMtcDmAprPicRole = Role::where('name', '=', 'user_mtc_dm_pic')->first();
		$userMtcDmAprPicRole->attachPermissions(array($aprDmPic));

		$aprDmFm = new Permission();
		$aprDmFm->name         = 'mtc-apr-fm-dm';
		$aprDmFm->display_name = 'MTC - DM - Approve - Foreman';
		$aprDmFm->description  = 'MTC - DM - Approve - Foreman';
		$aprDmFm->save();

		$userMtcDmAprFmRole = Role::where('name', '=', 'user_mtc_dm_fm')->first();
		$userMtcDmAprFmRole->attachPermissions(array($aprDmFm));

		$viewHrMobilePk = new Permission();
		$viewHrMobilePk->name         = 'hr-mobile-pk-view';
		$viewHrMobilePk->display_name = 'HR - Mobile - PK - View';
		$viewHrMobilePk->description  = 'HR - Mobile - PK - View';
		$viewHrMobilePk->save();

		$userHrMobilePkRole = Role::where('name', '=', 'user_hr_mobile_pk')->first();
		$userHrMobilePkRole->attachPermissions(array($viewHrMobilePk));

		$viewHrMobileGaji = new Permission();
		$viewHrMobileGaji->name         = 'hr-mobile-gaji-view';
		$viewHrMobileGaji->display_name = 'HR - Mobile - Gaji - View';
		$viewHrMobileGaji->description  = 'HR - Mobile - Gaji - View';
		$viewHrMobileGaji->save();

		$userHrMobileGajiRole = Role::where('name', '=', 'user_hr_mobile_gaji')->first();
		$userHrMobileGajiRole->attachPermissions(array($viewHrMobileGaji));

		$viewOli = new Permission();
		$viewOli->name         = 'mtc-oli-view';
		$viewOli->display_name = 'MTC - Oli - View';
		$viewOli->description  = 'MTC - Oli - View';
		$viewOli->save();

		$createOli = new Permission();
		$createOli->name         = 'mtc-oli-create';
		$createOli->display_name = 'MTC - Oli - Create';
		$createOli->description  = 'MTC - Oli - Create';
		$createOli->save();

		$deleteOli = new Permission();
		$deleteOli->name         = 'mtc-oli-delete';
		$deleteOli->display_name = 'MTC - Oli - Delete';
		$deleteOli->description  = 'MTC - Oli - Delete';
		$deleteOli->save();

		$userMtcOliRole = Role::where('name', '=', 'user_mtc_oli')->first();
		$userMtcOliRole->attachPermissions(array($viewOli, $createOli, $deleteOli));

		$viewPlant = new Permission();
		$viewPlant->name         = 'mtc-plant-view';
		$viewPlant->display_name = 'MTC - NPK/Plant - View';
		$viewPlant->description  = 'MTC - NPK/Plant - View';
		$viewPlant->save();

		$createPlant = new Permission();
		$createPlant->name         = 'mtc-plant-create';
		$createPlant->display_name = 'MTC - NPK/Plant - Create';
		$createPlant->description  = 'MTC - NPK/Plant - Create';
		$createPlant->save();

		$deletePlant = new Permission();
		$deletePlant->name         = 'mtc-plant-delete';
		$deletePlant->display_name = 'MTC - NPK/Plant - Delete';
		$deletePlant->description  = 'MTC - NPK/Plant - Delete';
		$deletePlant->save();

		$userMtcPlantRole = Role::where('name', '=', 'user_mtc_plant')->first();
		$userMtcPlantRole->attachPermissions(array($viewPlant, $createPlant, $deletePlant));

		$viewStockWhs = new Permission();
		$viewStockWhs->name         = 'mtc-stockwhs-view';
		$viewStockWhs->display_name = 'MTC - Stock Warehouse - View';
		$viewStockWhs->description  = 'MTC - Stock Warehouse - View';
		$viewStockWhs->save();

		$userMtcStockWhsRole = Role::where('name', '=', 'user_mtc_stockwhs')->first();
		$userMtcStockWhsRole->attachPermissions(array($viewStockWhs));
    }
}
