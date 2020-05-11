<?php

namespace App\Http\Controllers\Api\V1;

use App\News;
use App\Course;
use App\Group;
use App\Http\Controllers\Controller;
use App\Services\DiscordNotificationService as DiscordNotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;

class NewsController extends Controller
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
    public function storeGroup(Request $request)
    {
        $input = $request->validate(
            [
                'title' => 'required|string',
                'message' => 'required|string',
                'group_id' => 'required|exists:groups,id',
            ]
        );

        $group = Group::find($request->group_id);

        if ($group->owner_id == Auth::user()->id) {

            $news = new News();
            $request->request->add(['teacher_id' => Auth::user()->id]);
            $news = $news->create($request->all());

            $discordService = new DiscordNotificationService();
            $discordService->generateGroupNewsMessage($news)->send([$news->group->news_webhook]);

            return response()->json(['created' => true], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only Leaders can create News for group.'], 422);
        }
    }
    public function storeCourse(Request $request)
    {
        $input = $request->validate(
            [
                'title' => 'required|string',
                'message' => 'required|string',
                'course_id' => 'required|exists:courses,id'
            ]
        );
        $create = false;
        $course = Course::find($request->course_id);

        if ($course->teacher_id == Auth::user()->id) {
            $create = true;
        } else {
            $group = Group::find($course->group_id);
            if ($group->owner_id == Auth::user()->id) {
                $create = true;
            }
        }
        if ($create) {
            $news = new News();
            $request->request->add(['teacher_id' => Auth::user()->id]);
            $news = $news->create($request->all());

            $discordService = new DiscordNotificationService();
            $discordService->generateCourseNewsMessage($news)->send([$news->course->group->news_webhook]);

            return response()->json(['created' => true], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only course Leader and Teacher can create News for course.'], 422);
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
    public function updateGroup(Request $request)
    {
        $input = $request->validate(
            [
                'id' => 'required|exists:news,id',
                'title' => 'required|string',
                'message' => 'required|string',
                'group_id' => 'required|exists:groups,id',
            ]
        );
        $news = News::find($request->id);

        if ($news->teacher_id == Auth::user()->id) {
            $news = $news->update($request->all());
            return response()->json(['updated' => true], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only creator of News can edit it.'], 422);
        }
    }


    public function updateCourse(Request $request)
    {
        $input = $request->validate(
            [
                'id' => 'required|exists:news,id',
                'title' => 'required|string',
                'message' => 'required|string',
                'course_id' => 'required|exists:courses,id'
            ]
        );
        $news = News::find($request->id);

        if ($news->teacher_id == Auth::user()->id) {
            $news = $news->update($request->all());
            return response()->json(['created' => true], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only creator of News can edit it.'], 422);
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
        $news = News::find($id);
        if ($news->teacher_id == Auth::user()->id) {
            $news = $news->delete();
            return response()->json(['deleted' => true], 200);
        } else {
            return response()->json(["error"=>'Unauthorized. Only creator of News can delete it.'], 422);
        }
    }
}
