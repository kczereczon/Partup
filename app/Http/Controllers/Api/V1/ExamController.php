<?php

namespace App\Http\Controllers\Api\V1;

use App\Exam;
use App\Course;
use App\Group;
use App\Http\Controllers\Controller;
use App\Services\DiscordNotificationService as DiscordNotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(
            [
                'name' => 'required|string',
                'range_of_knowlage' => 'required|string',
                'description' => 'required|string',
                'place' => 'required|string',
                'time' => 'required|date',
                'course_id' => 'required|exists:courses,id'
            ]
        );

        $course = Course::find($request->course_id);
        $create = false;

        if ($course->teacher_id == Auth::user()->id) {
            $create = true;
        } else {
            $group = Group::find($course->group_id);
            if ($group->owner_id == Auth::user()->id) {
                $create = true;
            }
        }

        if ($create) {
            $exam = new Exam();
            $request->request->add(['teacher_id' => Auth::user()->id]);
            $exam = $exam->create($request->all());

            $discordService = new DiscordNotificationService();
            $discordService->generateExamMessage($exam)->send([$exam->course->group->exams_webhook]);

            return response()->json(['created' => true], 200);
        } else {
            return response()->json('Unauthorized. Only course Teachers and Group Leaders can create Exams.', 401);
        }
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
    public function update(Request $request)
    {
        $input = $request->validate(
            [
                'name' => 'required|string',
                'range_of_knowlage' => 'required|string',
                'description' => 'required|string',
                'place' => 'required|string',
                'time' => 'required|date',
                'course_id' => 'required|exists:courses,id',
                'id' => 'required|exists:exams,id'
            ]
        );
        $exam = Exam::find($request->id);
        $course = Course::find($exam->course_id);
        $update = false;

        if ($course->teacher_id == Auth::user()->id) {
            $update = true;
        } else {
            $group = Group::find($course->group_id);
            if ($group->owner_id == Auth::user()->id) {
                $update = true;
            }
        }

        if ($update) {
            $exam = $exam->update($request->all());
            return response()->json(['updated' => $exam], 200);
        } else {
            return response()->json('Unauthorized. Only course Teachers and Group Leaders can edit Exams.', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $exam = Exam::find($request->id);
        $course = Course::find($exam->course_id);

        $delete = false;

        if ($course->teacher_id == Auth::user()->id) {
            $delete = true;
        } else {
            $group = Group::find($course->group_id);
            if ($group->owner_id == Auth::user()->id) {
                $delete = true;
            }
        }

        if ($delete) {
            $exam = $exam->delete();
            return response()->json(['deleted' => $exam], 200);
        } else {
            return response()->json('Unauthorized. Only course Teachers and Group Leaders can delete Exams.', 401);
        }
    }
}
