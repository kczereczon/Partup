<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupStoreRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\GroupStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request)
    {
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
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
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
            ->get();

        return $groups;
    }
}
