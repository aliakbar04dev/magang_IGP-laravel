<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class WorkPermitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $viewEhsWp = new Permission();
		$viewEhsWp->name         = 'ehs-wp-view';
		$viewEhsWp->display_name = 'EHS - WP - View';
		$viewEhsWp->description  = 'EHS - WP - View';
		$viewEhsWp->save();

		$createEhsWp = new Permission();
		$createEhsWp->name         = 'ehs-wp-create';
		$createEhsWp->display_name = 'EHS - WP - Create';
		$createEhsWp->description  = 'EHS - WP - Create';
		$createEhsWp->save();

		$deleteEhsWp = new Permission();
		$deleteEhsWp->name         = 'ehs-wp-delete';
		$deleteEhsWp->display_name = 'EHS - WP - Delete';
		$deleteEhsWp->description  = 'EHS - WP - Delete';
		$deleteEhsWp->save();

		$approvePrcEhsWp = new Permission();
		$approvePrcEhsWp->name         = 'ehs-wp-approve-prc';
		$approvePrcEhsWp->display_name = 'EHS - WP - Approve PRC';
		$approvePrcEhsWp->description  = 'EHS - WP - Approve PRC';
		$approvePrcEhsWp->save();

		$rejectPrcEhsWp = new Permission();
		$rejectPrcEhsWp->name         = 'ehs-wp-reject-prc';
		$rejectPrcEhsWp->display_name = 'EHS - WP - Reject PRC';
		$rejectPrcEhsWp->description  = 'EHS - WP - Reject PRC';
		$rejectPrcEhsWp->save();

		$approveUserEhsWp = new Permission();
		$approveUserEhsWp->name         = 'ehs-wp-approve-user';
		$approveUserEhsWp->display_name = 'EHS - WP - Approve User';
		$approveUserEhsWp->description  = 'EHS - WP - Approve User';
		$approveUserEhsWp->save();

		$rejectUserEhsWp = new Permission();
		$rejectUserEhsWp->name         = 'ehs-wp-reject-user';
		$rejectUserEhsWp->display_name = 'EHS - WP - Reject User';
		$rejectUserEhsWp->description  = 'EHS - WP - Reject User';
		$rejectUserEhsWp->save();

		$approveEhsEhsWp = new Permission();
		$approveEhsEhsWp->name         = 'ehs-wp-approve-ehs';
		$approveEhsEhsWp->display_name = 'EHS - WP - Approve EHS';
		$approveEhsEhsWp->description  = 'EHS - WP - Approve EHS';
		$approveEhsEhsWp->save();

		$rejectEhsEhsWp = new Permission();
		$rejectEhsEhsWp->name         = 'ehs-wp-reject-ehs';
		$rejectEhsEhsWp->display_name = 'EHS - WP - Reject EHS';
		$rejectEhsEhsWp->description  = 'EHS - WP - Reject EHS';
		$rejectEhsEhsWp->save();

		$userEhsWpRole = new Role();
		$userEhsWpRole->name = "user_ehs_wp";
		$userEhsWpRole->display_name = "EHS - WP";
		$userEhsWpRole->description = "Role untuk akses menu EHS - IJIN KERJA";
		$userEhsWpRole->save();
		$userEhsWpRole->attachPermissions(array($viewEhsWp, $createEhsWp, $deleteEhsWp));

		$userEhsWpApprovalPrcRole = new Role();
		$userEhsWpApprovalPrcRole->name = "user_ehs_wp_approval_prc";
		$userEhsWpApprovalPrcRole->display_name = "EHS - WP - Approval - PRC";
		$userEhsWpApprovalPrcRole->description = "Role untuk Approve PRC EHS - IJIN KERJA";
		$userEhsWpApprovalPrcRole->save();
		$userEhsWpApprovalPrcRole->attachPermissions(array($approvePrcEhsWp, $rejectPrcEhsWp));

		$userEhsWpApprovalUserRole = new Role();
		$userEhsWpApprovalUserRole->name = "user_ehs_wp_approval_user";
		$userEhsWpApprovalUserRole->display_name = "EHS - WP - Approval - USER";
		$userEhsWpApprovalUserRole->description = "Role untuk Approve USER EHS - IJIN KERJA";
		$userEhsWpApprovalUserRole->save();
		$userEhsWpApprovalUserRole->attachPermissions(array($approveUserEhsWp, $rejectUserEhsWp));

		$userEhsWpApprovalEhsRole = new Role();
		$userEhsWpApprovalEhsRole->name = "user_ehs_wp_approval_ehs";
		$userEhsWpApprovalEhsRole->display_name = "EHS - WP - Approval - EHS";
		$userEhsWpApprovalEhsRole->description = "Role untuk Approve EHS EHS - IJIN KERJA";
		$userEhsWpApprovalEhsRole->save();
		$userEhsWpApprovalEhsRole->attachPermissions(array($approveEhsEhsWp, $rejectEhsEhsWp));

		if(config('app.env', 'local') !== 'production') {
			$agus = User::where('username', '=', '08268')->first();
			$agus->attachRole($userEhsWpApprovalPrcRole);
			$agus->attachRole($userEhsWpApprovalUserRole);
			$agus->attachRole($userEhsWpApprovalEhsRole);

			$ati = User::where('username', '=', '000936')->first();
			$ati->attachRole($userEhsWpRole);
		}
    }
}
