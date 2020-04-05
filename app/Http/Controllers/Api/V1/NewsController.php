<?php

namespace App\Http\Controllers\Api\V1;

use App\News;
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
    public function store(Request $request)
    {
        $input = $request->validate(
            [
                'title' => 'required|string',
                'message' => 'required|string',
                'group_id' => 'required|exists:groups,id'
            ]
        );

        $news = new News();
        $request->request->add(['teacher_id' => Auth::user()->id]);
        $news = $news->create($request->all());

        $news->owner()->associate($request->teacher_id());
        $news->group()->associate($request->group_id());

        $discordService = new DiscordNotificationService();
        $discordService->generateNewsMessage($news)->send([$news->group->news_webhook]);

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
