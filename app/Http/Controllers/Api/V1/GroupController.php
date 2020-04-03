<?php

namespace App\Http\Controllers\Api\V1;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupStoreRequest;
use App\Services\GroupInvitationService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Re  $request
     * @return \Illuminate\Http\Response
     */
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
            ->where('owner_id', $request->user()->id)
            ->whereNull('group_id')
            ->with('subgroups')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($groups, 200);
    }

    public function getAllOwnedGroups(Request $request)
    {
        /** @var Group|Builder $groups*/
        $groups = new Group();

        $groups = $groups
            ->where('owner_id', $request->user()->id)
            ->with('subgroups')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($groups, 200);
    }

    public function inviteUser($id, Request $request)
    {
        $validated = $request->validate(['email' => 'required|email']);

        /** @var Group|Builder $group */
        $group = new Group();
        $group = $group->findOrFail($id);

        //checking that group is created by user
        if ($group->owner_id != Auth::user()->id)
            throw new Exception("User tried to invite person, to group that he don't own.", 401);

        $groupInvitationService = new GroupInvitationService();
        $invitation = $groupInvitationService->createInvitation($validated['email'], $group);

        $sent = $groupInvitationService->sendInvite($invitation);

        return response()->json(["sent" => $sent], 200);
    }
}
