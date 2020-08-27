<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class OthersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

		$yuvie = User::where('username', '=', '30273')->first();
		$yuvie->attachRole($userHrIdpdepRole);

		$yana = User::where('username', '=', '05276')->first();
		$yana->attachRole($userHrIdpdepApprovalHrdRole);
    }
}
