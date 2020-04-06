<?php

namespace App\Http\Controllers\Api\V1;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Services\DiscordNotificationService as DiscordNotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;

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
        try{
        /** @var Homework|Builder|QueryBuilder */
        $exam = new Exam();
        $exam = $exam->create($request->all());

        $discordService = new DiscordNotificationService();
        $discordService->generateExamMessage($exam)->send([$exam->course->group->exams_webhook]);

        return response()->json(['created' => true], 200);
        }catch(Exception $exception)
        {
            Log::error($exception);
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
