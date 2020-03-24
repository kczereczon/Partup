<?php

namespace Tests\Unit;

use App\Course;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class HomeworkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateHomework()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create(['owner_id' => $user->id]);
        $course = factory(Course::class)->create(['group_id' => $group->id]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->json("POST", "/api/v1/homeworks", [
                "course_id" => $course->id,
                "name" => "test name",
                'description' => "test description",
                "where_send" => "univerity",
                "requirements" => "nothing",
                "deadline" => "25-03-2020"
            ]);

        $response->assertStatus(200, $response->status())->assertJson([
            'created' => true,
        ]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->json("POST", "/api/v1/homeworks", []);

        $response->assertStatus(422, $response->status());
    }
}
