<?php

namespace Tests\Unit;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCreateCourse()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create(['owner_id' => $user->id]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->post("/api/v1/course", ['teacher_email' => 'test@gmail.com', 'name' => "test name", 'group_id' => $group->id]);

        $response->assertStatus(200, $response->status())->assertJson([
            'created' => true,
        ]);
    }
}
