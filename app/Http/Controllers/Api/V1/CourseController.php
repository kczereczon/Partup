<?php

namespace App\Http\Controllers\Api\V1;

use App\Course;
use App\CourseInvitation;
use App\Exam;
use App\Homework;
use App\Group;
use Exception;
use App\Http\Controllers\Controller;
use App\Services\CourseInvitationService;
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
            ->with(['group', 'exams', 'homeworks', 'newses','courseInvitation'])
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        return response()->json($courses, 200);
    }

    //returns a list of courses for students
    //with newses, exams, homeworks valid for that date
    public function getForStudent()
    {
        $courses = new Course();
        /** @var Course|Builder|QueryBuilder $courses */
        $courses = $courses
            ->leftJoin('group_user', 'group_user.group_id', '=', 'courses.group_id')
            ->where('group_user.user_id', '=', Auth::user()->id)
            ->with(['group', 'exams', 'homeworks', 'newses'])
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        return response()->json($courses, 200);
    }
    public function getForStudentDate($date)
    {
        $courses = new Course();
        $date = str_replace("__", "  ", $date);
        /** @var Course|Builder|QueryBuilder $courses */
        $courses = $courses
            ->leftJoin('group_user', 'group_user.group_id', '=', 'courses.group_id')
            ->where('group_user.user_id', '=', Auth::user()->id)
            ->with([
                'group',
                'exams' => function ($query) use ($date) {
                    $query->where('time', '>', $date);
                },
                'homeworks' => function ($query) use ($date) {
                    $query->where('deadline', '>', $date);
                },
                'newses' => function ($query) use ($date) {
                    $query->where('until_when_to_show', '>', $date);
                }
            ])
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        return response()->json($courses, 200);
    }
    public function getForTeacher()
    {
        $coursesTeacher = new Course();
        $coursesTeacher = $coursesTeacher
            ->where('courses.teacher_id', '=', Auth::user()->id)
            ->with(['group', 'exams', 'homeworks', 'newses'])
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        $coursesOwner = new Course();
        $coursesOwner = $coursesOwner
            ->leftJoin('groups', 'groups.id', '=', 'courses.group_id')
            ->where('group.owner_id', '=', Auth::user()->id)
            ->with(['newses'])
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        $courses = $coursesTeacher->merge($coursesOwner);

        return response()->json($courses, 200);
    }
    public function getForTeacherDate($date)
    {
        $coursesTeacher = new Course();
        $date = str_replace("__", "  ", $date);
        $coursesTeacher = $coursesTeacher
            ->where('courses.teacher_id', '=', Auth::user()->id)
            ->with([
                'group',
                'exams' => function ($query) use ($date) {
                    $query->where('time', '>', $date);
                },
                'homeworks' => function ($query) use ($date) {
                    $query->where('deadline', '>', $date);
                },
                'newses' => function ($query) use ($date) {
                    $query->where('until_when_to_show', '>', $date);
                }
            ])
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        $coursesOwner = new Course();
        $coursesOwner = $coursesOwner
            ->leftJoin('groups', 'groups.id', '=', 'courses.group_id')
            ->where('groups.owner_id', '=', Auth::user()->id)
            ->with([
                'group',
                'exams' => function ($query) use ($date) {
                    $query->where('time', '>', $date);
                },
                'homeworks' => function ($query) use ($date) {
                    $query->where('deadline', '>', $date);
                },
                'newses' => function ($query) use ($date) {
                    $query->where('until_when_to_show', '>', $date);
                }
            ])
            ->orderBy('courses.id', 'desc')
            ->get(['courses.*']);

        $courses = $coursesTeacher->merge($coursesOwner);
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
        $course = Course::find($id);
        $course = $course->update($request->all());
        return response()->json(['updated' => $course], 200);
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

    public function getExamsList($id)
    {
        //check if user is in group
        if (true) {
            $exams = Exam::where('course_id', $id)->get();

            return response()->json($exams, 200);
        }
    }
    public function getHomeworksList($id)
    {
        //check if user is in group
        if (true) {
            $homework = Homework::where('course_id', $id)->get();

            return response()->json($homework, 200);
        }
    }

    public function inviteTeacher($id, Request $request)
    {
        $validated = $request->validate(['email' => 'email|required']);

        /** @var Group|Builder $group */
        $course = new Course();
        $course = $course->findOrFail($id);

        /** @var GroupInvitation|Builder $groupInvitation */
        $courseInvitation = new CourseInvitation();
        $courseInvitation = $courseInvitation->where('email','=', $validated['email'])->first();

        //checking that group is created by user
        $group = new Group();
        $group = $group->findOrFail($course->group_id);
        if ($group->owner_id != Auth::user()->id)
            throw new Exception("User tried to invite person, to group that he don't own.", 401);

        $courseInvitationService = new CourseInvitationService();
        $invitation = $courseInvitationService->createInvitation($validated['email'], $course);

        $sent = $courseInvitationService->sendInvite($invitation);

        return response()->json(["sent" => $sent], 200);
    }
}
