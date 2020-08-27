<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class PermissionHrdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  //       $viewKpi = new Permission();
		// $viewKpi->name         = 'hrd-kpi-view';
		// $viewKpi->display_name = 'HRD - KPI - View';
		// $viewKpi->description  = 'HRD - KPI - View';
		// $viewKpi->save();

		// $createKpi = new Permission();
		// $createKpi->name         = 'hrd-kpi-create';
		// $createKpi->display_name = 'HRD - KPI - Create';
		// $createKpi->description  = 'HRD - KPI - Create';
		// $createKpi->save();

		// $deleteKpi = new Permission();
		// $deleteKpi->name         = 'hrd-kpi-delete';
		// $deleteKpi->display_name = 'HRD - KPI - Delete';
		// $deleteKpi->description  = 'HRD - KPI - Delete';
		// $deleteKpi->save();

		// $submitKpi = new Permission();
		// $submitKpi->name         = 'hrd-kpi-submit';
		// $submitKpi->display_name = 'HRD - KPI - Submit';
		// $submitKpi->description  = 'HRD - KPI - Submit';
		// $submitKpi->save();

		// $approveKpi = new Permission();
		// $approveKpi->name         = 'hrd-kpi-approve';
		// $approveKpi->display_name = 'HRD - KPI - Approve';
		// $approveKpi->description  = 'HRD - KPI - Approve';
		// $approveKpi->save();

		// $rejectKpi = new Permission();
		// $rejectKpi->name         = 'hrd-kpi-reject';
		// $rejectKpi->display_name = 'HRD - KPI - Reject';
		// $rejectKpi->description  = 'HRD - KPI - Reject';
		// $rejectKpi->save();

		// $approvehrdKpi = new Permission();
		// $approvehrdKpi->name         = 'hrd-kpi-approvehrd';
		// $approvehrdKpi->display_name = 'HRD - KPI - Approve HRD';
		// $approvehrdKpi->description  = 'HRD - KPI - Approve HRD';
		// $approvehrdKpi->save();

		// $rejecthrdKpi = new Permission();
		// $rejecthrdKpi->name         = 'hrd-kpi-rejecthrd';
		// $rejecthrdKpi->display_name = 'HRD - KPI - Reject HRD';
		// $rejecthrdKpi->description  = 'HRD - KPI - Reject HRD';
		// $rejecthrdKpi->save();

		// $userHrKpiRole = new Role();
		// $userHrKpiRole->name = "user_hr_kpi";
		// $userHrKpiRole->display_name = "HR - KPI";
		// $userHrKpiRole->description = "Role untuk melihat menu HR - KPI";
		// $userHrKpiRole->save();

		// $userHrKpiApprovalRole = new Role();
		// $userHrKpiApprovalRole->name = "user_hr_kpi_approval";
		// $userHrKpiApprovalRole->display_name = "HR - KPI - Approval";
		// $userHrKpiApprovalRole->description = "Role untuk melihat menu HR - KPI - Approval";
		// $userHrKpiApprovalRole->save();

		// $userHrKpiApprovalhrdRole = new Role();
		// $userHrKpiApprovalhrdRole->name = "user_hr_kpi_approvalhrd";
		// $userHrKpiApprovalhrdRole->display_name = "HR - KPI - Approval HRD";
		// $userHrKpiApprovalhrdRole->description = "Role untuk melihat menu HR - KPI - Approval HRD";
		// $userHrKpiApprovalhrdRole->save();

		// $userHrKpiRole = Role::where('name', '=', 'user_hr_kpi')->first();
		// $userHrKpiRole->attachPermissions(array($viewKpi, $createKpi, $deleteKpi, $submitKpi));

		// $userHrKpiApprovalRole = Role::where('name', '=', 'user_hr_kpi_approval')->first();
		// $userHrKpiApprovalRole->attachPermissions(array($approveKpi, $rejectKpi));

		// $userHrKpiApprovalhrdRole = Role::where('name', '=', 'user_hr_kpi_approvalhrd')->first();
		// $userHrKpiApprovalhrdRole->attachPermissions(array($approvehrdKpi, $rejecthrdKpi));

		// $viewIdp = new Permission();
		// $viewIdp->name         = 'hrd-idp-view';
		// $viewIdp->display_name = 'HRD - IDP - View';
		// $viewIdp->description  = 'HRD - IDP - View';
		// $viewIdp->save();

		// $createIdp = new Permission();
		// $createIdp->name         = 'hrd-idp-create';
		// $createIdp->display_name = 'HRD - IDP - Create';
		// $createIdp->description  = 'HRD - IDP - Create';
		// $createIdp->save();

		// $deleteIdp = new Permission();
		// $deleteIdp->name         = 'hrd-idp-delete';
		// $deleteIdp->display_name = 'HRD - IDP - Delete';
		// $deleteIdp->description  = 'HRD - IDP - Delete';
		// $deleteIdp->save();

		// $submitIdp = new Permission();
		// $submitIdp->name         = 'hrd-idp-submit';
		// $submitIdp->display_name = 'HRD - IDP - Submit';
		// $submitIdp->description  = 'HRD - IDP - Submit';
		// $submitIdp->save();

		// $approveIdpDiv = new Permission();
		// $approveIdpDiv->name         = 'hrd-idp-approve-div';
		// $approveIdpDiv->display_name = 'HRD - IDP - Approve - DIV';
		// $approveIdpDiv->description  = 'HRD - IDP - Approve - DIV';
		// $approveIdpDiv->save();

		// $rejectIdpDiv = new Permission();
		// $rejectIdpDiv->name         = 'hrd-idp-reject-div';
		// $rejectIdpDiv->display_name = 'HRD - IDP - Reject - DIV';
		// $rejectIdpDiv->description  = 'HRD - IDP - Reject - DIV';
		// $rejectIdpDiv->save();

		// $approveIdpHrd = new Permission();
		// $approveIdpHrd->name         = 'hrd-idp-approve-hrd';
		// $approveIdpHrd->display_name = 'HRD - IDP - Approve - HRD';
		// $approveIdpHrd->description  = 'HRD - IDP - Approve - HRD';
		// $approveIdpHrd->save();

		// $rejectIdpHrd = new Permission();
		// $rejectIdpHrd->name         = 'hrd-idp-reject-hrd';
		// $rejectIdpHrd->display_name = 'HRD - IDP - Reject - HRD';
		// $rejectIdpHrd->description  = 'HRD - IDP - Reject - HRD';
		// $rejectIdpHrd->save();

		// $userHrIdpRole = new Role();
		// $userHrIdpRole->name = "user_hr_idp";
		// $userHrIdpRole->display_name = "HR - IDP";
		// $userHrIdpRole->description = "Role untuk melihat menu HR - IDP";
		// $userHrIdpRole->save();

		// $userHrIdpApprovalDivRole = new Role();
		// $userHrIdpApprovalDivRole->name = "user_hr_idp_approval_div";
		// $userHrIdpApprovalDivRole->display_name = "HR - IDP - Approval - DIV";
		// $userHrIdpApprovalDivRole->description = "Role untuk melihat menu HR - IDP - Approval - DIV";
		// $userHrIdpApprovalDivRole->save();

		// $userHrIdpApprovalHrdRole = new Role();
		// $userHrIdpApprovalHrdRole->name = "user_hr_idp_approval_hrd";
		// $userHrIdpApprovalHrdRole->display_name = "HR - IDP - Approval - HRD";
		// $userHrIdpApprovalHrdRole->description = "Role untuk melihat menu HR - IDP - Approval - HRD";
		// $userHrIdpApprovalHrdRole->save();

		// $userHrIdpRole = Role::where('name', '=', 'user_hr_idp')->first();
		// $userHrIdpRole->attachPermissions(array($viewIdp, $createIdp, $deleteIdp, $submitIdp));

		// $userHrIdpApprovalDivRole = Role::where('name', '=', 'user_hr_idp_approval_div')->first();
		// $userHrIdpApprovalDivRole->attachPermissions(array($approveIdpDiv, $rejectIdpDiv));

		// $userHrIdpApprovalHrdRole = Role::where('name', '=', 'user_hr_idp_approval_hrd')->first();
		// $userHrIdpApprovalHrdRole->attachPermissions(array($approveIdpHrd, $rejectIdpHrd));

		///////////////////////
		$viewIdpdep = new Permission();
		$viewIdpdep->name         = 'hrd-idpdep-view';
		$viewIdpdep->display_name = 'HRD - IDP DEP - View';
		$viewIdpdep->description  = 'HRD - IDP DEP - View';
		$viewIdpdep->save();

		$createIdpdep = new Permission();
		$createIdpdep->name         = 'hrd-idpdep-create';
		$createIdpdep->display_name = 'HRD - IDP DEP - Create';
		$createIdpdep->description  = 'HRD - IDP DEP - Create';
		$createIdpdep->save();

		$deleteIdpdep = new Permission();
		$deleteIdpdep->name         = 'hrd-idpdep-delete';
		$deleteIdpdep->display_name = 'HRD - IDP DEP - Delete';
		$deleteIdpdep->description  = 'HRD - IDP DEP - Delete';
		$deleteIdpdep->save();

		$submitIdpdep = new Permission();
		$submitIdpdep->name         = 'hrd-idpdep-submit';
		$submitIdpdep->display_name = 'HRD - IDP DEP - Submit';
		$submitIdpdep->description  = 'HRD - IDP DEP - Submit';
		$submitIdpdep->save();

		$approveIdpdepHrd = new Permission();
		$approveIdpdepHrd->name         = 'hrd-idpdep-approve-hrd';
		$approveIdpdepHrd->display_name = 'HRD - IDP DEP - Approve - HRD';
		$approveIdpdepHrd->description  = 'HRD - IDP DEP - Approve - HRD';
		$approveIdpdepHrd->save();

		$rejectIdpdepHrd = new Permission();
		$rejectIdpdepHrd->name         = 'hrd-idpdep-reject-hrd';
		$rejectIdpdepHrd->display_name = 'HRD - IDP DEP - Reject - HRD';
		$rejectIdpdepHrd->description  = 'HRD - IDP DEP - Reject - HRD';
		$rejectIdpdepHrd->save();

		$userHrIdpdepRole = new Role();
		$userHrIdpdepRole->name = "user_hr_idpdep";
		$userHrIdpdepRole->display_name = "HR - IDP DEP";
		$userHrIdpdepRole->description = "Role untuk melihat menu HR - IDP DEP";
		$userHrIdpdepRole->save();

		$userHrIdpdepApprovalHrdRole = new Role();
		$userHrIdpdepApprovalHrdRole->name = "user_hr_idpdep_approval_hrd";
		$userHrIdpdepApprovalHrdRole->display_name = "HR - IDP DEP - Approval - HRD";
		$userHrIdpdepApprovalHrdRole->description = "Role untuk melihat menu HR - IDP DEP - Approval - HRD";
		$userHrIdpdepApprovalHrdRole->save();

		$userHrIdpdepRole = Role::where('name', '=', 'user_hr_idpdep')->first();
		$userHrIdpdepRole->attachPermissions(array($viewIdpdep, $createIdpdep, $deleteIdpdep, $submitIdpdep));

		$userHrIdpdepApprovalHrdRole = Role::where('name', '=', 'user_hr_idpdep_approval_hrd')->first();
		$userHrIdpdepApprovalHrdRole->attachPermissions(array($approveIdpdepHrd, $rejectIdpdepHrd));
		///////////////////////
		
		// $yandi = User::where('username', '=', '02111')->first();
		// $yandi->attachRole($userHrIdpRole);

		$yuvie = User::where('username', '=', '30273')->first();
		// $yuvie->attachRole($userHrKpiRole);
		// $yuvie->attachRole($userHrIdpApprovalDivRole);
		$yuvie->attachRole($userHrIdpdepRole);

		// $vch = User::where('username', '=', '17839')->first();
		// $vch->attachRole($userHrKpiApprovalRole);

		$yana = User::where('username', '=', '05276')->first();
		// $yana->attachRole($userHrKpiApprovalhrdRole);
		// $yana->attachRole($userHrIdpApprovalHrdRole);
		$yana->attachRole($userHrIdpdepApprovalHrdRole);
    }
}
