<?php

namespace App\Http\Controllers\Api\V1;

use App\Group;
use App\GroupInvitation;
use App\News;
use App\GroupUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupStoreRequest;
use App\Services\GroupInvitationService;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'string|required',
                'homework_webhook' => 'nullable|url',
                'news_webhook' => 'nullable|url',
                'exam_webhook' => 'nullable|url',
                'owner_id' => 'exists:users,id',
                'group_id' => 'exists:groups,id'
            ]
        );

        /** @var Group|Builder|JsonResponse $group */
        $group = new Group();
        $group->name = $request->get('name');
        $group->homework_webhook = $request->get('homework_webhook');
        $group->news_webhook = $request->get('news_webhook');
        $group->exams_webhook = $request->get('exams_webhook');

        $group->owner()->associate($request->user());

        if ($request->get('group_id')) {
            $group->group()->associate(Group::find($request->get('group_id')));
        }

        return response()->json(['created' => $group->save()], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if ($group->owner_id == Auth::user()->id) {
            $group = $group->update($request->all());
            return response()->json(['updated' => $group], 200);
        } else {
            return response()->json(['message' => "Unautorized."], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if ($group->owner_id == Auth::user()->id) {
            $group = $group->delete();
            return response()->json(['destroyed' => $group], 200);
        } else {
            return response()->json(['message' => "Unautorized."], 401);
        }
    }
    public function destroyIndex($id)
    {
        $group = new Group();

        $group = $group
            ->where('id', $id)
            ->orderBy('id', 'desc')
            ->first();

        if ($group->owner_id == Auth::user()->id) {
            $group = $group->delete();
            return response()->json(['destroyed' => $group], 200);
        } else {
            return response()->json(['message' => "Unautorized."], 401);
        }
    }

    /**
     * This is getting all groupes for current logged user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getForUsers(Request $request)
    {
        /** @var Group|Builder */
        $groups = new Group();

        $groups = $groups
            ->where('owner_id', Auth::user()->id)
            ->whereNull('group_id')
            ->with(['subgroups','groupInvitation'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($groups, 200);
    }

    //returns a array of groups for students
    //with all newses
    public function getForStudent()
    {
        $groups = new Group();
        $groups =$groups
            ->leftJoin('group_user','group_user.group_id','=','groups.id')
            ->where('group_user.user_id',Auth::user()->id)
            ->with('newses')
            ->get();
        return response()->json($groups, 200);
    }

    //returns a array of groups for students
    //with newses, valid for that date
    public function getForStudentDate($date)
    {
        $date=str_replace("__","  ",$date);
        $groups = new Group();
        $groups =$groups
            ->leftJoin('group_user','group_user.group_id','=','groups.id')
            ->where('group_user.user_id',Auth::user()->id)
            ->with(['newses' => function ($query) use ($date){
                $query->where('until_when_to_show','>', $date);
            }])
            ->get();
        return response()->json($groups, 200);
    }

    public function getAllOwnedGroups(Request $request)
    {
        /** @var Group|Builder $groups*/
        $groups = new Group();

        $groups = $groups
            ->where('owner_id', $request->user()->id)
            ->whereNull('group_id')
            ->with(['subgroups','courses'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($groups, 200);
    }

    public function getAllOwnedWithSubgroupsGroups(Request $request)
    {
        /** @var Group|Builder $groups*/
        $groups = new Group();

        $groups = $groups
            ->where('owner_id', $request->user()->id)
            ->with(['subgroups','courses','groupInvitation'])
            ->orderBy('id', 'desc')
            ->get();

        $groups = $groups->mapWithKeys(function($item) {
            return [$item->id => $item];
        });

        return response()->json($groups, 200);
    }

    public function inviteUser($id, Request $request)
    {
        $validated = $request->validate(['email' => 'email|required']);

        /** @var Group|Builder $group */
        $group = new Group();
        $group = $group->findOrFail($id);

        // /** @var GroupInvitation|Builder $groupInvitation */
        // $groupInvitation = new GroupInvitation();
        // $groupInvitation = $groupInvitation->where('email','=', $validated['email'])->first();

        // if($groupInvitation) {
        //     return response()->json('',401);
        // }

        //checking that group is created by user
        if ($group->owner_id != Auth::user()->id)
             return response()->json(["error" => "You are not allowed to invite Students to this Group."], 422);

        $groupInvitationService = new GroupInvitationService();
        $invitation = $groupInvitationService->createInvitation($validated['email'], $group);

        $sent = $groupInvitationService->sendInvite($invitation);

        if($sent) {
            return response()->json(["sent" => $sent], 200);
        } else {
            $invitation->delete();
            return response()->json(["error" => "During sending email error occures."], 500);
        }
    }
    //returns array of news from group
    public function getNewsList($id)
    {
        //check if user is in group
        if(true)
        {
            $news = News::where('group_id',$id)->get();

            return response()->json($news,200);
        }
    }
    public function getGroupInfo($id)
    {
        $group = new Group();

        $group = $group
            ->where('id', $id)
            ->with(['subgroups','groupInvitation'])
            ->orderBy('id', 'desc')
            ->first();

        if ($group->owner_id == Auth::user()->id) {
            return response()->json($group, 200);
        } else {
            return response()->json(401);
        }
    }
    public function updateIndex(Request $request,$id)
    {
        $validated = $request->validate(
            [
                'name' => 'string|required',
            ]
        );

        $group = new Group();

        $group = $group
            ->where('id', $id)
            ->first();

        if ($group->owner_id == Auth::user()->id) {
            $group = $group->update($request->all());
            return response()->json(['updated' => $group], 200);
        } else {
            return response()->json(['message' => "Unautorized."], 401);
        }
    }
}
