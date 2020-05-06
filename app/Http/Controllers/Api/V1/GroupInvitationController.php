<?php

namespace App\Http\Controllers\Api\V1;

use App\GroupInvitation;
use App\Http\Controllers\Controller;
use App\Services\GroupInvitationService;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupInvitationController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validated = $request->validate(['hash' => 'required|string']);

        /** @var GroupInvitation|Builder $groupInvitation */
        $groupInvitation = new GroupInvitation();
        $groupInvitation = $groupInvitation->where('invite_hash', $validated['hash'])->with(['group', 'group.owner'])->firstOrFail();

        /** @var User|Builder $invitedUser */
        $invitedUser = new User();
        $invitedUser = $invitedUser->where('email', $groupInvitation->email)->first();

        if ($invitedUser) {
            $groupInvitation->user_have_account = true;
        } else {
            $groupInvitation->user_have_account = false;
        }

        return response()->json($groupInvitation, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupInvitation  $groupInvitation
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupInvitation $groupInvitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupInvitation  $groupInvitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupInvitation $groupInvitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupInvitation  $groupInvitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupInvitation $groupInvitation)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        $validated = $request->validate(['hash' => 'required|string']);

        /** @var GroupInvitation|Builder $groupInvitation */
        $groupInvitation = new GroupInvitation();
        $groupInvitation = $groupInvitation->where('invite_hash', $validated['hash'])
            ->whereNull('accepted')
            ->with(['group', 'group.owner'])
            ->firstOrFail();

        /** @var User|Builder $invitedUser */
        $invitedUser = new User();
        $invitedUser = $invitedUser->where('email', $groupInvitation->email)->firstOrFail();

        if (Auth::user()->email == $invitedUser->email) {
            $service = new GroupInvitationService();
            return response()->json(['accepted' => $service->acceptInvite($groupInvitation, $invitedUser)], 200);
        } else {
            throw new Exception("User tried to accept group invitation that doesnt belongs to him", 401);
        }
    }
}
