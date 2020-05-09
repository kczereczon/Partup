<?php

namespace App\Http\Controllers\Api\V1;

use App\CourseInvitation;
use Illuminate\Http\Request;
use App\Services\CourseInvitationService;
use App\User;
use App\Group;
use App\Course;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseInvitationController extends Controller
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
     * @param  \App\CourseInvitation  $courseInvitation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validated = $request->validate(['hash' => 'required|string']);

        $courseInvitation = new CourseInvitation();
        $courseInvitation = $courseInvitation
            // ->join('courses','courses.id','=','course_id')
            // ->join('groups','groups.id','=','courses.group_id')
            ->where('invite_hash', $validated['hash'])
            // ->with(['group', 'group.owner'])
            ->firstOrFail();

        $course = new Course();
        $course = $course->findOrFail($courseInvitation->course_id);
        $group = new Group();
        $group = $group->with(['owner'])->findOrFail($course->group_id);

        $invitedUser = new User();
        $invitedUser = $invitedUser->where('email', $courseInvitation->email)->first();

        if ($invitedUser) {
            $courseInvitation->user_have_account = true;
        } else {
            $courseInvitation->user_have_account = false;
        }

        $courseInvitation->course=$course;
        $courseInvitation->group=$group;

        return response()->json($courseInvitation, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseInvitation  $courseInvitation
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseInvitation $courseInvitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseInvitation  $courseInvitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseInvitation $courseInvitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseInvitation  $courseInvitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }

    public function accept(Request $request)
    {
        $validated = $request->validate(['hash' => 'required|string']);

        $courseInvitation = new CourseInvitation();
        $courseInvitation = $courseInvitation->where('invite_hash', $validated['hash'])
            // ->leftJoin('courses', 'courses.course_id', '=', 'course_invitations.course_id')
            // ->leftJoin('groups', 'groups.group_id', '=', 'courses.group_id')
            ->whereNull('accepted')
            // ->with(['groups'])
            ->firstOrFail();

        $course = new Course();
        $course = $course->findOrFail($courseInvitation->course_id);
        $group = new Group();
        $group = $group->with(['owner'])->findOrFail($course->group_id);

        $invitedUser = new User();
        $invitedUser = $invitedUser->where('email', $courseInvitation->email)->firstOrFail();

        if (Auth::user()->email == $invitedUser->email) {
            $service = new CourseInvitationService();
            return response()->json(['accepted' => $service->acceptInvite($courseInvitation, $invitedUser)], 200);
        } else {
            throw new Exception("User tried to accept group invitation that doesnt belongs to him", 401);
        }
    }
}
