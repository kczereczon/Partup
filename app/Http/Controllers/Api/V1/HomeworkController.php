<?php

namespace App\Http\Controllers\Api\V1;

use App\Course;
use App\Homework;
use App\Group;
use App\Http\Controllers\Controller;
use App\Services\DiscordNotificationService as DiscordNotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
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
                'description' => 'required|string',
                'requirements' => 'required|string',
                'deadline' => 'required|date',
                'where_send' => 'required|string',
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
            $homework = new Homework();
            $request->request->add(['teacher_id' => Auth::user()->id]);
            $homework = $homework->create($request->all());

            $discordService = new DiscordNotificationService();
            $discordService->generateHomeworkMessage($homework)->send([$homework->course->group->homework_webhook]);

            return response()->json(['created' => true], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only course Leader and Teacher can create Homeworks.'], 422);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->validate(
            [
                'id' => 'required|exists:homeworks,id',
                'name' => 'required|string',
                'description' => 'required|string',
                'requirements' => 'required|string',
                'deadline' => 'required|date',
                'where_send' => 'required|string',
                'course_id' => 'required|exists:courses,id'
            ]
        );
        $homework = Homework::find($request->id);

        if ($homework->teacher_id == Auth::user()->id) {
            $homework = $homework->update($request->all());
            return response()->json(['updated' => $homework], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only creator of Homework can edit it.'], 422);
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
        $homework = Homework::find($id);
        if ($homework->teacher_id == Auth::user()->id) {
            $homework = $homework->delete();
            return response()->json(['deleted' => $homework], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only creator of Homework can delete it.'], 422);
        }
    }
}
