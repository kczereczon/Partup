<?php

namespace App\Http\Controllers\Api\V1;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = new Course();
        /** @var Course|Builder|QueryBuilder $courses */
        $courses = $courses
            ->leftJoin('groups', 'groups.id', '=', 'courses.group_id')
            ->where('groups.owner_id', '=', Auth::user()->id)
            ->with('group')
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'teacher_email' => 'email',
            'group_id' => 'exists:groups,id'
        ]);

        /** @var Course|Builder */
        $course = new Course();
        $course = $course->create([
            'name' => $request->name,
            'group_id' => $request->group_id,
        ]);

        // /** @var CourseInvitationService $service */
        // $service = new CourseInvitationService();
        // $service->createInvitation($request->teacher_email, $course);

        return response()->json(['created' => $course], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Course|Builder|QueryBuilder $course */
        $course = Course::find($id);
        $course = $course->delete();

        return response()->json(['deleted' => $course], 200);
    }
}
