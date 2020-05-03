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
        $group = Group::find($course->group_id);

        if ($course->teacher_id == Auth::user()->id || $group->owner_id == Auth::user()->id) {

            /** @var Homework|Builder|QueryBuilder */
            $exam = new Exam();
            $exam = $exam->create($request->all());

            $discordService = new DiscordNotificationService();
            $discordService->generateExamMessage($exam)->send([$exam->course->group->exams_webhook]);

            return response()->json(['created' => true], 200);
        }else
        {
            return response()->json('Unauthorized to create Exam',401);
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

        $course = Course::find($request->course_id);
        $group = Group::find($course->group_id);

        if ($course->teacher_id == Auth::user()->id || $group->owner_id == Auth::user()->id) {
            $exam = Exam::find($request->id);
            $exam = $exam->update($request->all());
            return response()->json(['updated' => $exam], 200);
        }else
        {
            return response()->json('Unauthorized to edit Exam',401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $group = Group::find($course->group_id);

        if ($course->teacher_id == Auth::user()->id || $group->owner_id == Auth::user()->id) {
            $exam = Exam::find($id);
            $exam = $exam->delete();
            return response()->json(['deleted' => $exam], 200);
        }else
        {
            return response()->json('Unauthorized to delete Exam',401);
        }
    }
}
