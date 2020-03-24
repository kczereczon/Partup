<?php

namespace App\Http\Controllers\Api\V1;

use App\Homework;
use App\Http\Controllers\Controller;
use App\Services\DiscordNotificationService as DiscordNotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;

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

        /** @var Homework|Builder|QueryBuilder */
        $homework = new Homework();
        $homework = $homework->create($request->all());

        $discordService = new DiscordNotificationService();
        $discordService->generateHomeworkMessage($homework)->send([$homework->course->group->homework_webhook]);

        return response()->json(['created' => true], 200);
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
        //
    }
}
