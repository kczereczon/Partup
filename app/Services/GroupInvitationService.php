<?php

namespace App\Services;

use App\Group;
use App\GroupInvitation;
use App\GroupUser;
use App\Mail\GroupInvite;
use App\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class GroupInvitationService
{
    /**
     * This method is simple creates invitation for new user.
     *
     * @param mixed $email
     * @param Group $group
     * @return GroupInvitation
     */
    public function createInvitation($email, Group $group): GroupInvitation
    {
        /** @var GroupInvitation|Builder $invitation */
        $invitation = new GroupInvitation();
        $invitation = $invitation->create([
            'group_id' => $group->id,
            'email' => $email,
            'invite_hash' => md5($email.rand(-100, 100))
        ]);

        return $invitation;
    }


    public function sendInvite(GroupInvitation $groupInvitation)
    {
        $link = env("APP_URL") . "/#/group-invite?hash=" . $groupInvitation->invite_hash;
        try {
            Mail::to($groupInvitation)->send(new GroupInvite($link, $groupInvitation->group));
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
        return true;
    }

    public function acceptInvite(GroupInvitation $groupInvitation, User $user)
    {
        try {

            // $group =new Group();
            $group=Group::find($groupInvitation->group->id);
            $groupuser = new GroupUser();
            $groupuser->create(['group_id' => $group->id,'user_id' => Auth::user()->id]);
            while(!is_null($group->group))
            {
                $group=$group->group;
                $groupuser = new GroupUser();
                $groupuser->create(['group_id' => $group->id,'user_id' => Auth::user()->id]);
            }

            // //asigning user only to one group
            // $user->groups()->sync([$groupInvitation->group->id]);

            $groupInvitation->accepted = true;
            $groupInvitation->save();

            return true;
        } catch (Exception $e) {
            Log::error($e);
            return $e;
        }
    }
}
